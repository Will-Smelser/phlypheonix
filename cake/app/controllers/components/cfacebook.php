<?php
/**
 * This component will attempt to add user to Auth system if
 * the user is logged into facebook
 * 
 * @requires User, Auth
 * 
 * @definition
 * 		User Model must have the following fields:
 * 			username string
 * 			password string
 * 			email string
 * 			facebook_id integer
 * 
 * @information
 * 		Facebook can restrict email address, so if this is required, you may have issues
 * 		Currently the email will be ignored and user will be created without email if none
 * 		none available from facebook.  If your model requires email, this may be an issue.
 * 
 * @author Will Smelser
 *
 */
class CfacebookComponent extends Object  {
		/**
		 * Set int the app/config/facebook.php file
		 * @var unknown_type
		 */
		var $apiId = '';
		var $apiKey = '';
		var $apiSecret = '';
		
		/**
		 * The reference to controller which called this component
		 * @var unknown_type
		 */
		var $controller;
		
		/**
		 * The facebook object
		 * @var object
		 */
		var $facebook;
		
		/**
		 * Holds the cookie/session facebook info
		 * @var unknown_type
		 */
		var $session = array();
		
		/**
		 * Holds the URL vars
		 * @var unknown_type
		 */
		var $loginUrl = '';
		var $logoutUrl = '';
		
		/**
		 * Wether or not valid FB user
		 * @var unknown_type
		 */
		var $fbLoggedIn = false;
		
		/**
		 * If user is logged in this is the $facebook->api('/me') results
		 * @var unknown_type
		 */
		var $fbuser = array();
		
		/**
		 * Tracks errors and sets them to the flash
		 * @var unknown_type
		 */
		var $error = array();
		
		
		/**
		 * This is called before the beforeFilter
		 * @param $controller
		 * @return unknown_type
		 */
		function initialize(&$controller){
			Configure::load('facebook');
			
			//load the facebook class from facebook
			App::import('Lib','facebook/facebook');
			
			//set the params
			$this->apiId = Configure::read('facebook.apiId');
			$this->apiKey = Configure::read('facebook.apiKey');
			$this->apiSecret = Configure::read('facebook.apiSecret');
			
			//$this->config = $config;
			
			$this->controller =& $controller;
						
			//setup Auth compenent
			$this->controller->Auth->fields = Configure::read('facebook.AuthMapping');
			
			//create facebook object
			$this->facebook = new Facebook(array(
			  'appId'  => $this->apiId,
			  'secret' => $this->apiSecret,
			  'cookie' => true,
			));
			
			$this->session = $this->facebook->getSession();
			
			//this also stores some vars
			$this->login();
			
			//make available for view
			$this->controller->set(Configure::read('facebook.var.appId'),$this->apiId); 
			$this->controller->set(Configure::read('facebook.var.session'),$this->session);
			$this->controller->set(Configure::read('facebook.var.loggedIn'),$this->fbLoggedIn);
			$this->controller->set(Configure::read('facebook.var.urlLogin'),$this->loginUrl);
			$this->controller->set(Configure::read('facebook.var.urlLogout'),$this->logoutUrl);
			$this->controller->set(Configure::read('facebook.var.fbUser'),$this->fbuser);
			
			if(count($this->error) > 0 && Configure::read('facebook.userSessionFlashErrors')){
				$this->controller->Session->setFlash(implode('.<br/>',$this->error));
			}
		}
		
		function login(){
			//check if user is logged into fb
			$fblogin = $this->checkUserLoggedIn();
			
			//check cake login
			$cakelogin = ($this->controller->Auth->User()) ? true : false;
			
			//setup user fields
			$fields = Configure::read('facebook.UserFields');
			$fieldId = $fields['id'];
			$fieldPassword = $fields['password'];
			$fieldEmail = $fields['email'];
			$fieldUsername = $fields['username'];
			$fieldFacebook_id = $fields['facebook_id'];
			$fieldPasswordConfirm = $fields['password_confirm'];
			
			//save to facebook model
			$saveToFacebookModel = Configure::read('facebook.saveFBdata');
			
			
			//Logged into facebook but not into system
			if( $fblogin && !$cakelogin ) {
				
				//do we have access to facebook email?
				if( isset($this->fbuser['email']) ){
					//see if user is in database already
					$user_record = $this->controller->User->find('first', array( 
	                     'conditions' => array('OR'=>array($fieldFacebook_id => $this->session['uid'],$fieldEmail => $this->fbuser['email'])), 
	                     'contain' => array() 
	                 ));
	            //look based on facebook email
				}else{
					//see if user is in database already
					$user_record = $this->controller->User->find('first', array( 
	                     'conditions' => array(array($fieldFacebook_id => $this->session['uid'])), 
	                     'contain' => array() 
	                 ));					
				}
                 
                //user did not exist, lets create one 
                if(empty($user_record)) {

                	//skip validation
                	$save_options = array( 'validate' => false); 
					
                	//build user data
                	$password = $this->generatePassword();
					
                	//if we have access to facebook email
                	if( isset($this->fbuser['email']) ){
                		$user_record['User'][$fieldEmail] = $this->fbuser['email'];
                	}
                	
                	//build remainder of user ifnormation
                	$user_record['User'][$fieldUsername] = $this->session['uid']; 
                    $user_record['User'][$fieldFacebook_id] = $this->session['uid'];  
                    $user_record['User'][$fieldPasswordConfirm] =  $password;
                    $user_record['User'][$fieldPassword] = AuthComponent::password($password);
                    
                    //add to facebook userdata...used by the email method
                    $this->fbuser['generatedPassword'] = $password;
                    $this->fbuser['username'] = $user['User'][$fieldUsername];
					
                    //Create the User 
                    if($this->controller->User->save($user_record, $save_options)){ 
                        
                        //send user email
                        if( $this->config['facebook.sendNewUserEmail'] && isset($this->fbuser['email']) ){
                        	$this->sendNewUserEmail();
                        }
                        
                        // login user
                        $this->controller->Auth->login($user_record); 
                        
                        //save facebook
                        if($saveToFacebookModel){
                        	$this->saveMeData($this->session['uid'], $this->controller->User->id, $this->getMe());
                        }
                    }else{
                    	array_push($this->error,'Failed to create user');
                    }
                
                //found user by email
                }elseif( isset($this->fbuser['email']) && isset($user_record['User'][$fieldEmail] ) && $this->config['facebook.useFBemailToLogin'] ){
                	
                	//the facebook email and user email match
                	if($user_record['User'][$fieldEmail] == $this->fbuser['email']){
                		
                		//user does not have a facebook id
                		if($user_record['User'][$fieldFacebook_id] == 0 ){
                			//skip validation
                			$save_options = array( 'validate' => false); 
                			
                			//update the facebook_id
                			$user_record['User'][$fieldFacebook_id] = $this->session['uid'];
                			$this->controller->User->save($user_record, $save_options);
                		}
                			
                	}
                }
                
                //login user
                $this->controller->Auth->login($user_record);
            //need to make sure we have the user facebook id in DB, if not add it
            }elseif( $cakelogin && $fblogin ){
            	//skip validation
            	$save_options = array( 'validate' => false); 
            	
            	$user = $this->controller->Auth->user();
            	
            	//see if user is in database already
				$user_record = $this->controller->User->find('first', array( 
	                     'conditions' => array($fieldId => $user['User']['id']), 
	                     'contain' => array() 
	                 ));
	                 
	            
            	//var_dump($user_record);
            	
            	//build user data
            	$user['User'][$fieldUsername] = $user_record['User'][$fieldUsername];
            	$user['User'][$fieldEmail] = $user_record['User'][$fieldEmail];
				$user['User'][$fieldFacebook_id] = $this->session['uid'];
				
				//also check that email
				if( (!isset($user['User'][$fieldEmail]) && isset($this->fbuser['email'])) || empty($user['User'][$fieldEmail]) ){
					$user['User'][$fieldEmail] = $this->fbuser['email'];
				}

				if( $user_record['User'][$fieldPassword] == '' ){
					$password = $this->generatePassword();
					$user['User'][$fieldPassword] = AuthComponent::password( $password );
					$this->fbuser['generatedPassword'] = $password;
					$this->fbuser['username'] = $user['User'][$fieldUsername];
					
					//not really a new user, but we have reset a password, so we need to send them something
					if( $this->config['facebook.sendNewUserEmail'] ) {
						$this->sendNewUserEmail();
					}
				}
				
				$this->controller->User->save($user, $save_options);
				
				if($saveToFacebookModel){
					$this->saveMeData($this->session['uid'], $user['User'][$fieldId],$this->getMe());
				}
            }
		}
	
	/**
	 * @requires
	 *    Must have your facebook model available
	 * @param $fbId string The facebook id of the user
	 * @param $userId int The id of the user
	 * @param $meData array An array of user data to be serialized
	 * @return unknown_type
	 */
	function saveMeData($fbId,$userId,$meData){
		$model  = Configure::read('facebook.FacebookModel');
		
		$fields = Configure::read('facebook.FacebookFields');
		$userFields = Configure::read('facebook.UserFields');
		
		$facebook_record[$fields['user_id']] = $userId;
		$facebook_record[$fields['user_facebook_id']] = $fbId;
		$facebook_record[$fields['data']] = serialize($meData);
		
		//lets check if the data already exists based on user_id
		$data = $this->controller->{$model}->findByUserId($userId);
		
		if($data){
			$facebook_record[$fields['id']] = $data[strtolower($model)][$fields['id']];
		}
		
		return $this->controller->{$model}->save($facebook_record, array( 'validate' => false));
		
	}		
	function checkUserLoggedIn(){
		$result = false;
		$me = null;
		
		if($this->session){
			try {
		    	$uid = $this->facebook->getUser();
		    	$me = $this->getMe();

				if ($me) {
					$this->fbuser = $me;
					$this->logoutUrl = $this->facebook->getLogoutUrl();
				} else {
  					$$this->loginUrl = $this->facebook->getLoginUrl();
				}
			} catch (FacebookApiException $e) {
		   		error_log($e);
			}
			$result = ($me) ? true : false;
		}
		
		$this->fbLoggedIn = $result;
		
		return $result;
	}
	/**
	 * @requires
	 *   $this->session must be set
	 *   $this->session['
	 * @return unknown_type
	 */
	function getMe(){
		$me = $this->controller->Session->read('Facebook.me');
		if(!$me){
			$me = $this->FB_apiTokened('/me');
			$this->controller->Session->write('Facebook.me',$me);
		}
		
		return $me;
	}
	function getSession(){
		return $this->facebook->getSession();
	}
		
	function getUser(){
		return $this->facebook->getUser();
	}
		
	
    function sendNewUserEmail(){
      	//bail if no email address
      	if(!isset($this->fbuser['email'])) return;
    	
    	App::import('Component','Email');
      	      	
    	$this->controller->Email->to = $this->fbuser['first_name'].' '.$this->fbuser['last_name'].' <'.$this->fbuser['email'].'>';
      	$this->controller->Email->from = Configure::read('facebook.fromEmail');
      	$this->controller->Email->subject = $this->stringReplaceWithFacebook(Configure::read('facebook.emailMsgTitle'));
      	
      	$body  = $this->stringReplaceWithFacebook(Configure::read('facebook.emailMsgBody'));
      	
      	$this->controller->Email->send($body);
    }
    private function stringReplaceWithFacebook($str,$data=null){
    	//initialize data
    	if($data == null){
    		$data = $this->fbuser;
    	}
    	
    	//do replace..uses recursion
    	foreach($data as $key=>$val){
    		if(is_array($val)){
    			$str = $this->stringReplaceWithFacebook($str,$val);
    		}else{
    			$str = str_replace('%'.$key,$val,$str);
    		}
    	}
    	
    	return $str;
    }
	private function generatePassword(){
		/*
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		
		$rand = rand(8,15);
		
		$pass = '';
		
		for($i=0;$i<=$rand;$i++){
			$newrand = rand(0,61);
			$pass .= $chars[$newrand];
		}
		return $pass;
		*/
		return $this->fbuser['birthdate']
	}
	/**
	 * 
	 * Below here will be all Facebook Object wrapped elements
	 * 
	 */
	
	public function FB_apiTokened($urlPart){
		$token  = $this->facebook->getAccessToken();
		$urlPart .= '?token='.$token;
		return $this->facebook->api($urlPart);
	}	
}
?>