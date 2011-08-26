<?php
class AppController extends Controller {
	var $components = array('Session','Acl', 'Auth','Cookie','Cart','RememberMe');
	
	function beforeFilter() {
    	//have to manually start session for things to work properly
    	//session_start();
    	
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
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'shop', 'action' => 'main');
		
		//login by cookie
		$this->RememberMe->check();
    	
    	$loggedin = ($this->Auth->user('id') != false);
		$this->set('loggedin',$loggedin);
    	
		if(!$loggedin && 
				!(
					strtolower($this->params['action']) == 'login' &&
					strtolower($this->params['controller']) == 'users'
				)
				&&
				!(
					strtolower($this->params['action']) == 'register' &&
					strtolower($this->params['controller']) == 'users'
				)
				&&
				!(
					strtolower($this->params['action']) == 'register_ajax' &&
					strtolower($this->params['controller']) == 'users'
				)&&
				!(Configure::read('config.testing')
				)
		){
			$this->redirect(array('controller'=>'users','action'=>'login'));
			return;
		}
		
    	//just temp for site setup
    	if($this->params['controller'] == 'pages') {
    		$this->layout = 'basic' . DS . 'basic';
    	}
    	
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
    		/*
    		//check if this is login attemt
    		$loggingin = (
    			($this->params['controller'] == 'users' && $this->params['action'] == 'login')
    			|| ($this->params['controller'] == 'users' && $this->params['action'] == 'logout')
    		);
    		
	    	if(    !$loggingin
	    		&& Configure::read('config.maintenance') 
	    		&& $this->Session->read('Auth.User.group_id') != 1
	    		&& !(
	    			$this->params['controller'] == 'customer'
	    			&& $this->params['action'] == 'maintenance'
	    			)
	    	)
	    	{
	    		$this->redirect(array('controller' => 'customer', 'action' => 'maintenance'));
	    		
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
	    		$this->redirect(array('controller' => 'customer', 'action' => 'coming_soon'));	
	    	}
	    	*/
    	}
    	
        //$this->secureUserSession();
	}
	
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
    
    
}