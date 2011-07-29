<?php
class AppController extends Controller {
	var $components = array('Session','Acl', 'Auth','Cookie');
	var $uses = array('UsersSecurity');
	
	function beforeFilter() {
    	//have to manually start session for things to work properly
    	session_start();
		
    	//override the Auth component
    	$this->Auth->fields = array(
    		'username'=>'email',
    		'password'=>'password'
    	);
    	
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
    	
    	//Configure AuthComponent
        $this->Auth->authorize = 'actions';
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index');
        
        $this->secureUserSession();
	}
	
function secureUserSession(){
    	$userid = $this->Session->read('Auth.User.id');
    	$security = $this->UsersSecurity->find(array('user_id'=>$userid));
    	$ssid = $security['UsersSecurity']['ssid'];
    	
    	//If the session ids do not match...logout
    	if($ssid != $this->Session->id() && $this->Session->read('Auth.User.id')){
    		            
            $this->Session->setFlash('Another user logged in with your identity.  You have been logged out!');
            $this->Auth->logout();
            
    	}
          
    }
    
    //tweaked Auth component to have a callback
    function after_login_hook($valid){
    	
    	$userid = $this->Session->read('Auth.User.id');

    	$this->UsersSecurity->set('user_id',$userid);
    	$this->UsersSecurity->set('ssid',$this->Session->id());
    	$this->UsersSecurity->save(
					array(	
							'id'=>$userid,
							'user_id'=>$userid,
							'ssid'=>$this->Session->id()
					));
					
    }
    
    /**
     * Custom hook added into Auth component
     */
    function before_login_hook(){
    	
    }
}