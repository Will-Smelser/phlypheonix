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
		var $me = array();
		
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
		
			if($controller->params['action'] != 'login') {
				return;
			}
			
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
			
			try{
				//create facebook object
				$this->facebook = new Facebook(array(
				  'appId'  => $this->apiId,
				  'secret' => $this->apiSecret,
				  'cookie' => true,
				));
				
				
			
				//$this->session = $this->getSession();
				$this->fbuser = $this->getMe();
			
				//this also stores some vars
				$this->login();
			
			//API failures include oAuth and Curl errors
			//need to redirect to login page if user is not logged in
			}catch(FacebookApiException $e){
				var_dump($e);
				//$this->controller->set('test',array('API ERROR'=>$e->getResult()));
				//return;
			}catch(Exception $e) {
				//$this->controller->set('test',array('UNKNOWN ERROR'=>$e));
			}
			
			//make available for view
			$this->controller->set(Configure::read('facebook.var.appId'),$this->apiId); 
			$this->controller->set(Configure::read('facebook.var.session'),$this->session);
			$this->controller->set(Configure::read('facebook.var.loggedIn'),$this->fbLoggedIn);
			$this->controller->set(Configure::read('facebook.var.urlLogin'),$this->loginUrl);
			$this->controller->set(Configure::read('facebook.var.urlLogout'),$this->logoutUrl);
			$this->controller->set(Configure::read('facebook.var.fbUser'),$this->fbuser['id']);
			
			if(count($this->error) > 0 && Configure::read('facebook.userSessionFlashErrors')){
				$this->controller->Session->setFlash(implode('.<br/>',$this->error));
			}
			
			
		}
		
		function login(){
			
			//check if user is logged into fb
			$fblogin = $this->checkUserLoggedIn();
			//debug($fblogin);
			
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
			
			$this->controller->set('test',array('facebook'=>$fblogin,'cake'=>$cakelogin,'token'=>$this->facebook->getAccessToken(),'fbid'=>$this->fbuser,'fbuser'=>$this->fbuser));
			
			//Logged into facebook but not into system
			if( $fblogin && !$cakelogin ) {

				$user_record = null;
				
				//do we have access to facebook email?
				if( isset($this->fbuser['email']) ){
					//see if user is in database already
					$user_record = $this->controller->User->find('first', array( 
	                     'conditions' => array('OR'=>array($fieldFacebook_id => $this->fbuser['id'],$fieldEmail => $this->fbuser['email'])) 
	                 ));
	                 
	            //look based on facebook id
				}else{
					//see if user is in database already
					$user_record = $this->controller->User->find('first', array( 
	                     'conditions' => array(array($fieldFacebook_id => $this->fbuser['id'])), 
	                     'contain' => array() 
	                 ));					
				}
                 
                //user did not exist, lets create one 
                if(empty($user_record)) {
					
                	//build user data
                	$password = $this->fbuser['birthday'];
                	
                	//build remainder of user ifnormation
                	$user_record['User'][$fieldUsername] = $this->fbuser['email']; 
                    $user_record['User'][$fieldFacebook_id] = $this->fbuser['id'];  
                    $user_record['User'][$fieldPasswordConfirm] =  $password;
                    $user_record['User'][$fieldPassword] = AuthComponent::password($password);
                    $user_record['User']['fname'] = $this->fbuser['first_name'];
                    $user_record['User']['lname'] = $this->fbuser['last_name'];
                    $user_record['User']['sex'] = strtoupper($this->fbuser['gender']);
                    $user_record['User']['group_id'] = Configure::read('userconfig.default.group');
                    $user_record['User']['birthdate'] = strtotime($this->fbuser['birthday']);
                    $user_record['User']['active'] = 1;
                    
                    //add to facebook userdata...used by the email method
                    $this->fbuser['generatedPassword'] = $password;
					                  
                    //Create the User 
                    if($this->controller->User->save($user_record,array('validate'=>false))){ 
                        
                        //send user email
                        if( Configure::read('facebook.sendNewUserEmail') && isset($this->fbuser['email']) ){
                        	$this->sendNewUserEmail();
                        }
               			                        
                        // login user
                        $this->controller->Auth->login($user_record); 
                        
                        //save facebook
                        if($saveToFacebookModel){
                        	$this->saveMeData($this->fbuser['id'], $this->controller->User->id, $this->getMe());
                        }
                    }else{
                    	array_push($this->error,'Failed to create user');
                    }
                
                //found user by email
                }elseif( isset($this->fbuser['email']) && isset($user_record['User'][$fieldEmail] ) && Configure::read('facebook.useFBemailToLogin') ){
                	
                	//the facebook email and user email match
                	if($user_record['User'][$fieldEmail] == $this->fbuser['email']){
 						              		
                		//user does not have a facebook id
                		if( empty($user_record['User'][$fieldFacebook_id]) ){
                			
                			//skip validation
                			$save_options = array( 'validate' => false); 
                			
                			//update the facebook_id
                			$user_record['User'][$fieldFacebook_id] = $this->fbuser['id'];
                			$this->controller->User->save($user_record, $save_options);
                		}
                			
                	}
                	
                	$this->controller->Auth->login($user_record);
                	
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
	                     'conditions' => array('User.'.$fieldId => $user['User']['id']),
	                 ));
            	
            	//build user data
            	$user['User'][$fieldUsername] = $user_record['User'][$fieldUsername];
            	$user['User'][$fieldEmail] = $user_record['User'][$fieldEmail];
				$user['User'][$fieldFacebook_id] = $this->fbuser['id'];
				
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
					if( Configure::read('facebook.sendNewUserEmail') ) {
						$this->sendNewUserEmail();
					}
				}
				
				$this->controller->User->save($user, $save_options);
				
				if($saveToFacebookModel){
					$this->saveMeData($this->fbuser['id'], $user['User'][$fieldId],$this->getMe());
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
			$facebook_record[$fields['id']] = $data[$model][$fields['id']];
		}
		
		return $this->controller->{$model}->save($facebook_record, array( 'validate' => false));
		
	}		
	function checkUserLoggedIn(){
		$result = false;
		$me = null;
		
		if($this->fbuser == null) {
			try {
			   	$uid = $this->facebook->getUser();
			   	
			   	$me = $this->getMe();
				if ($me) {
					$this->fbuser = $me;
					$this->logoutUrl = $this->facebook->getLogoutUrl();
				} else {
					$this->loginUrl = $this->facebook->getLoginUrl();
				}
			} catch (FacebookApiException $e) {
					
		   		error_log($e);
			}
			$result = ($me) ? true : false;
			
			
			$this->fbLoggedIn = $result;
			return $result;
		} else {
			return true;
		}

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
			if($this->getUser()) {
				$me = $this->FB_apiTokened('/me');
				$this->controller->Session->write('Facebook.me',$me);
			}
		}
		
		return $me;
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
      	$body  = $this->stringReplaceWithCake($body);
      	
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
    
    private function stringReplaceWithCake($str,$data=null) {
    	if($data == null) {
    		$data = $this->controller->Auth->user();
    	}
    	
    	foreach($data['User'] as $key=>$value){
    		if($key=='birthdate'){
    			$value = date('m/d/Y',$value);
    		}
    		$str = str_replace('&'.$key,$value,$str);
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
		return (isset($this->fbuser['birthdate'])) ? $this->fbuser['birthdate'] : time();
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