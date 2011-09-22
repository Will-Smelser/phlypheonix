<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Captcha','Email','Cfacebook','Session');
	var $uses = array('User','School','Prompt','Mfacebook','Referer');
	var $helpers = array('Session','Form', 'Html','Javascript','Hfacebook');
	
	
	function beforeFilter() {
	    parent::beforeFilter(); 

	    $this->Auth->allow(array('register','register_ajax','recover','recover_complete','captcha_image','login','logout','referred'));
		
		$this->set('schools',$this->School->find('all',array('order'=>'name ASC')));

		//set the lastposted data
		if(isset($this->data) && isset($this->data['User']['email'])) {
			$this->set('postemail',$this->data['User']['email']);
			$this->set('postbirthdate',$this->data['User']['birthdate']);
			
			if(isset($this->data['User']['school'])) {
				$this->set('postsex',$this->data['User']['sex']);
				$this->set('postschool',$this->data['School']['id']);
			}
		} else if($this->Session->read('registerData')) {
			$data = $this->Session->read('registerData');
			
			$this->set('postemail',$data['User']['email']);
			$this->set('postbirthdate',$data['User']['birthdate']);
			
			if(isset($data['User']['school'])) {
				$this->set('postsex',$data['User']['sex']);
				$this->set('postschool',$data['School']['id']);
			}
		} 
	}
	
	function referred($userid){
		
		if(!$this->User->findById($userid)){
			$this->redirect('/users/login/bad_referer');
		} else {
			$this->Session->write('Referer.id',$userid);
			$this->redirect('/users/login');
		}
	}
	
	function add_school($id){
		$this->layout = 'ajax';
		if(!isset($this->myuser['School'])){
			echo "{'result':false}";
			exit;
		}
		
		$id = $id * 1;
		
		//couldnt get cake HABTM to work
		$ids = array();
		foreach($this->myuser['School'] as $s){
			array_push($ids, $s['id']);
		}
		
		$result = false;
		if(!in_array($id,$ids)){
			$sql = "INSERT INTO `users_schools` (user_id,school_id) VALUES ({$this->Session->read('Auth.User.id')},$id)";
			$result = ($this->User->query($sql)) ? 'true' : 'false';
		} else {
			$result = 'true';
		}
		
		
		echo "{\"result\":$result}";
		exit;
	}
	
	function remove_school($id){
		$this->layout = 'ajax';
		if(!isset($this->myuser['School'])){
			echo "{'result':false}";
			exit;
		}
		
		$id = $id * 1;
		
		$sql = "DELETE FROM `users_schools` WHERE `user_id`={$this->Session->read('Auth.User.id')} AND `school_id` = $id LIMIT 1";
		$result = ($this->User->query($sql)) ? 'true' : 'false';
		
		echo "{\"result\":$result}";
		exit;
	}
	
	function index() {
		if (!$this->Session->read('Auth.User') && !Configure::read('config.testing')) {
			$this->redirect(array('action'=>'login'));
			return;
		}
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function login($err=null){
		
		$this->layout = 'landing'; 
		
		//force logged-in users to shop
		if($this->Auth->user()){
			$this->redirect(array('controller'=>'shop','action'=>'main'));
		}
		
		//if there was a login error from register or login
		if(!empty($err)) {
			$error = new MyError($err);
			$this->set('error',$error->getJson());
			return;
		}
		
		//AuthComponent does not encrypt password by default if the you are not
		//using "username" as the identifier.
		if(!empty($this->data)) {
			//look for user
			if(!$this->User->checkEmailExists($this->data)){
				$error = new MyError('no_user');
				$this->set('error',$error->getJson());
				return;
			}
			
			//encrypt password
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['birthdate']);
			
			//login the user
			if($this->Auth->login($this->data)){
				
				//handle the remember me
				if (empty($this->data['User']['remember_me']))  
		        {  
		            $this->RememberMe->delete();
		            return;  
		        } else {
		        	$this->RememberMe->remember(  
		                    $this->data['User']['email'],  
		                    $this->data['User']['password']  
		                );
		        }
		        
				//user is logged in, forward to the shop
				$this->redirect(array('controller'=>'shop','action'=>'main'));
				return;
			} else {
				$error = new MyError('bad_password');
				$this->set('error',$error->getJson());
				return;
			}
		} 
		
		$error = new MyError('no_error');
        $this->set('error',$error->getJson());
        
        //$this->redirect($this->Auth->redirect());
	}
	
	function logout(){
		$this->layout = 'dynamic';
		$title = '/img/header/thankyou.png';
		$classWidth = 'width-small';
		$this->set(compact('title','classWidth'));
		
		$this->Session->delete('registerData');
		$this->Session->setFlash('Good-Bye');
		$this->RememberMe->delete();
		
		//lets make sure we are good
		$this->Cookie->destroy();
		$this->Session->destroy();
		        
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			
			//set the password
			if(empty($this->data['User']['password'])) {
				$this->data['User']['password'] == AuthComponent::password($this->data['User']['birthdate']);
			}
			
			$this->User->create();
			
			//overide the forms group_id
			$this->data['User']['group_id'] = $this->User->defaultGroupId;
			$this->data['User']['school_id'] = (isset($this->data['School']['School'][0])) ? $this->data['School']['School'][0] : 0;
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->User->Group->find('list');
		$schools = $this->School->find('list');
		$this->set(compact('groups','schools'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			//set password to hashed birthdate
			if(empty($this->data['User']['password']) ||
				$this->data['User']['password'] == AuthComponent::password(null)
			) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['birthdate']);
			} 
			
			//set the default school
			$this->data['User']['school_id'] = (isset($this->data['School']['School'][0])) ? $this->data['School']['School'][0] : 0;
			 
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			$this->data['User']['password'] = null;
			$this->data['User']['birthdate'] = date('m/d/Y',$this->data['User']['birthdate']);
		}
		
		$schools = $this->School->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups','schools'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function register() {
		$this->Auth->logout();
		
		if (!empty($this->data)) {
			
			//make register data available in session for the login page
			$this->Session->write('registerData',$this->data);
			
			$error = $this->checkUserData($this->data,true);
			
			//there was an error
			if($error !== true){
				$action = 'login/'.$error->getName();
				$this->redirect(array('action'=>$action));
			}
			
			//set the password
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['birthdate']);
			
			//set birthdate to unix timestamp
			$this->data['User']['birthdate'] = strtotime($this->data['User']['birthdate']);
			
			//setup some other data
			$this->data['User']['facebook_id'] = 0;
			$this->data['User']['active'] = 1;
			$this->data['User']['group_id'] = Configure::read('userconfig.default.group'); //2 is a customer
			$this->data['User']['school_id'] = (isset($this->data['School']['School'][0])) ? $this->data['School']['School'][0] : 0;
			
			$this->User->create();
			
			if ($this->User->save($this->data,array('validate'=>false))) {
				$this->Auth->login($this->data); // autologin
				
				//save the referal
				try{  //using mysql db information to prevent duplicates, so errors on input are possible
					$referer = $this->Session->read('Referer.id');
					if(!empty($referer)){
						$userid = $this->User->id;
						$this->Referer->save(array('referer_user_id'=>$referer,'user_id'=>$userid));
					}
				}catch(Exception $e){
					//do nothing
				}
				
				//add the remember me
				if(isset($this->data['User']['remember_me'])){
					$this->RememberMe->remember
	                (  
	                    $this->data['User']['email'],  
	                    $this->data['User']['password']  
	                ); 
				}
				
				$this->redirect(array('controller'=>'shop','action'=>'main'));
			} else {
				$this->redirect(array('action'=>'login/user_failed'));
			}
			
		} else {
			$this->redirect(array('action'=>'login/nodata'));
		}
	}
	
	function register_ajax() {
		$this->layout = 'ajax';
		
		if(!empty($this->data)){
			$error = $this->checkUserData($this->data, true);
		} else {
			$error = new MyError('no_error');
		}
		
		echo $error->getJSON();
	}
	
	function recover(){
		
		if (!empty($this->data)) {
			if( $this->Captcha->check($this->data['User']['captcha']) ){
				$info = $this->User->findByEmail($this->data['User']['email']);
								
				if(!$info){
					$this->Session->setFlash('Failed to locate user');
				}else{
					$email = $info['User']['email'];
					$password = $info['User']['birthdate'];
					
					
					
					$this->Email->from    = 'Recovery <help@flyfoenix.com>';
					$this->Email->to      = '<'.$info['User']['email'].'>';
					$this->Email->subject = 'Your Password';
					$this->Email->send("Below is your information.\n\nusername: {$username}\npassword: $password \n\nSincerely,\n\tFlyFoenix.com");
					
					$this->redirect(array('controller'=>'Users','action'=>'recover_complete'));
					
				}
			}else{
				$this->Session->setFlash('Incorrect Captcha Entry');
			}
		}
	}
	
	function recover_complete(){
	
	}
	
	function captcha_image() 
    { 
        $this->Captcha->image(); 
    }
       
    //silent AJAX handlers
    function ajax_check_user_data(){
    	$this->layout = 'ajax';
    	$this->render('ajax');
    	
    	if (!empty($this->data)) {
    		$error = $this->checkUserData();
    		$error->print_json();
    		
    	} else {
    		$error = new errorInfo();
    		$error->addErrorData($error->errorRepsonse());
    		$error->print_json();
		}
    }

	function validateLogin($data) { 
        $user = $this->find(array('email' => $data['User']['email'], 'birthdate' => strtotime($data['User']['birthdate'])), array('id', 'username'));
        return (empty($user) == false) ? $user['User'] : false; 
    }
    
    private function checkUserData($data,$registering=false){
    	
    	//check the email
    	if(!$this->User->checkEmail($data)){
    		return ($registering) ? new MyError('reg_email') : new MyError('email');
    	}
    	
    	//check email aleady exists
    	if($this->User->checkEmailExists($data)){
    		return new MyError('emailexist');
    	}
    	
    	//check birthdate
    	if(!$this->User->checkBirthdate($data)){
    		return ($registering) ? new MyError('reg_bad_birthdate') : new MyError('bad_birthdate');
    	}
    	
    	//check sex
    	if(!$this->User->checkSex($data)){
    		return new MyError('bad_sex');
    	}

    	return true;
    }
       
    
    
}
class MyError {
	var $name = null;
	var $info = null; //type of errorTypes
	
	public function MyError($name) {
		$this->name = $name;
		$this->info = errorTypes::getType($name);
	}
	public function getName() {
		return $this->name;
	}
	public function getDOMid() {
		return $this->info['id'];
	}
	public function getMsg() {
		return $this->info['msg'];
	}
	public function getJson() {
		return json_encode($this->info);
	}
	
}
class errorTypes {
	public static function getType($name) {
		
			switch($name) {
			case 'reg_email':
				return array(
					'msg'=>Configure::read('error.msg.email_bad'),
					'id'=>'email',
					'context'=>'register'
				);
			case 'email':
				return array(
					'msg'=>Configure::read('error.msg.email_bad'),
					'id'=>'email2',
					'context'=>'login'
				);
			case 'emailexist':
				return array(
					'msg'=>Configure::read('error.msg.email_exist'),
					'id'=>'email',
					'context'=>'register'
				);
			case 'no_user':
				return array(
					'msg'=>Configure::read('error.msg.no_user'),
					'id'=>'email2',
					'context'=>'login'
				);
			case 'bad_password':
				return array(
					'msg'=>Configure::read('error.msg.bad_password'),
					'id'=>'birthdate2',
					'context'=>'login'
				);
			case 'user_failed':
				return array(
					'msg'=>Configure::read('error.msg.user_failed'),
					'id'=>'error-general',
					'context'=>'register'
				);
			case 'bad_birthdate':
				return array(
					'msg'=>Configure::read('error.msg.bad_birthdate'),
					'id'=>'birthdate2',
					'context'=>'login'
				);
			case 'reg_bad_birthdate':
				return array(
					'msg'=>Configure::read('error.msg.bad_birthdate'),
					'id'=>'birthdate',
					'context'=>'register'
				);
			case 'nodata':
				return array(
					'msg'=>'No user data submitted.',
					'id'=>'error-general',
					'context'=>'unknown'
				);
			case 'bad_sex':
				return array(
					'msg'=>Configure::read('error.msg.bad_sex'),
					'id'=>'gender',
					'context'=>'register'
				);
			case 'none':
			case 'no_error':
				return array(
					'msg' => 'success',
					'id' => 'N/A',
					'context' => 'none'
				);
			case 'bad_referer':
				return array(
					'msg' => Configure::read('error.msg.bad_referer'),
					'id'=>'error-general',
					'context'=>'none'
				);
			default:
				return array(
					'msg'=>'Unknown Error',
					'id'=>'error-general',
					'context'=>'unknown'
				);
		}
	}
}


?>