<?php
class AppController extends Controller {
	var $components = array('Ccart','Session','Acl', 'Auth','Cookie','RememberMe','Cprompt');
	
	var $uses = array('Tracking');
	
	var $myuser; //logged in users data
	
	function beforeFilter() {
		
		if (Configure::read('config.testing')) {
    		$this->Auth->allow('*');	
    	}
		    	
    	//coming soon or maintenance
    	if(
    		(
    			Configure::read('config.maintenance') ||
    			Configure::read('config.coming_soon')
    		) 
    		
    	){
    		
    		//check if this is login attemt
    		$loggingin = (
    			($this->params['controller'] == 'users' && $this->params['action'] == 'login')
    			|| ($this->params['controller'] == 'users' && $this->params['action'] == 'logout')
    		);
 
	    	if(    !$loggingin
	    		&& Configure::read('config.maintenance') 
	    		&& $this->Session->read('Auth.User.group_id') != 1
	    		&& !(
	    			$this->params['controller'] == 'pages'
	    			&& $this->params['action'] == 'maintenance'
	    			)
	    	)
	    	{
	    		
	    		$this->redirect(array('controller' => 'pages', 'action' => 'maintenance'));
	    		
	    	} else if (
	    	    !$loggingin
	    		&& !Configure::read('config.maintenance')
	    		&&  Configure::read('config.coming_soon')
	    		&& $this->Session->read('Auth.User.group_id') != 1
	    		&& !(
	    			$this->params['controller'] == 'customer'
	    			&& $this->params['action'] == 'coming_soon'
	    			)
	    		) 
	    	{
	    		$this->redirect(array('controller' => 'pages', 'action' => 'coming_soon'));	
	    	}
	    	
    	}
    	
		
		
		if($this->params['action'] == 'logout'){
			session_set_cookie_params(0); 
			@session_start();
			session_regenerate_id(true);
		} else {
	    	//have to manually start session for things to work properly
			@session_start();
		}
		
    	
		//protocal
		$protocal = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
		$this->set('protocal',$protocal);
		
    	//override the Auth component
    	$this->Auth->fields = array(
    		'username'=>'email',
    		'password'=>'password'
    	);
    	
    	//Configure AuthComponent
    	$this->Auth->autoRedirect = false;
        $this->Auth->authorize = 'actions';
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'landing');
        //$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'logout');
        $this->Auth->loginRedirect = array('controller' => 'shop', 'action' => 'main');
		
		
		//logout the user
		if( $this->params['controller'] == 'users' && $this->params['action'] == 'logout'){
			$this->Auth->logout();
			$this->Session->delete('registerData');
			$this->Session->setFlash('Good-Bye');
			$this->RememberMe->delete();

			//lets make sure we are good
			$this->Cookie->destroy();
			$this->Session->destroy();

		} else {
			//login by cookie
			$this->RememberMe->check();
		}
		
		
		//user data
		$auth = $this->Auth->user();
		$user = array();
		if(!ClassRegistry::isKeySet('User')){
			$this->loadModel('User');
		} else {
			$this->User = ClassRegistry::init('User');
		}
		
		if($auth != false){
			$user = $this->User->read(null, $auth['User']['id']);	
		//not logged in, use anonymous user
		} else {
			$user = $this->User->findByEmail('anonymous@flyfoenix.com');
			$user['Saleuser'] = array();
			
			//add session info
			if($this->Session->check('Anonymous.sex')){
				$user['User']['sex'] = $this->Session->read('Anonymous.sex');
			}
			if($this->Session->check('Anonymous.school')){
				$user['User']['school_id'] = $this->Session->read('Anonymous.school');
			}
		}
		
		
		$this->myuser = $user;
		$this->set('myuser',$this->myuser);
		
    	$loggedin = ($auth != false);
		$this->set('loggedin',$loggedin);
		
		//setup the prompts
		$this->Cprompt->addDbPrompts();
		$this->Cprompt->setPrompt();
		
    	//just temp for site setup
    	if($this->params['controller'] == 'pages') {
    		$this->layout = 'basic' . DS . 'basic';
    	}
    	
    	//store data
    	$userid = ($loggedin) ? $this->myuser['User']['id'] : null;
    	$this->Tracking->addEntry(&$this->Session, &$this->params, &$this->Ccart, $userid);
    	
        //$this->secureUserSession();
	}
	
	/**
	 * Will only allow 1 person per login via the session id
	 */
	function secureUserSession(){
		/*
    	$userid = $this->Session->read('Auth.User.id');
    	$security = $this->UsersSecurity->find(array('user_id'=>$userid));
    	$ssid = $security['UsersSecurity']['ssid'];
    	
    	//If the session ids do not match...logout
    	if($ssid != $this->Session->id() && $this->Session->read('Auth.User.id')){
    		            
            $this->Session->setFlash('Another user logged in with your identity.  You have been logged out!');
            $this->Auth->logout();
            
    	}*/
          
    }
    
    //tweaked Auth component to have a callback
    function after_login_hook($valid){
    	return true;
    	
    	/*
    	$userid = $this->Session->read('Auth.User.id');

    	//first delete this users info
    	$this->UsersSecurity->delete($userid);
		
		//delete the users ssid
		$infoBySession = $this->UsersSecurity->findBySsid($this->Session->id());
		$this->UsersSecurity->delete($infoBySession['UsersSecurity']['id']);
					
		$this->UsersSecurity->set('user_id',$userid);
    	$this->UsersSecurity->set('ssid',$this->Session->id());
    	$this->UsersSecurity->save(
					array(	
							'id'=>$userid,
							'user_id'=>$userid,
							'ssid'=>$this->Session->id()
					));
		*/
					
    }
    
    /**
     * Custom hook added into Auth component
     */
    function before_login_hook(){
    	return true;
    }
    
    private function handlePrompts(){
    	//bail if no user info
    	if(empty($this->myuser)){
    		return false;
    	}
    	
    	//bail if no prompts
    	if(empty($this->myuser['Prompt'])){
    		return false;
    	}
    	
    	//set the prompt variables
    	$controller = $this->params['controller'];
    	$action = $this->params['action'];
    	
    	//cycle the prompts
    	$showprompt = array();
    	$prompts = $this->myuser['Prompt'];
    	
    	foreach($prompts as $p){
    		//check if there is a valid prompt
    		if(
    			(
    				$p['controller'] == $controller &&
    				$p['action'] == $action
    			)
    			||
    			(
    				$p['controller'] == $controller &&
    				$p['action'] == '*'
    			)
    			||
    			(
    				$p['controller'] == '*' &&
    				$p['action'] == '*'
    			)
    		){
    			if($p['ends'] > time())
    				$showprompt[$p['UsersPrompt']['id']] = $p['name'];
    		}
    	}
    	//make available for the view
    	$this->set('prompts',$showprompt);    	
    }
    
    
}