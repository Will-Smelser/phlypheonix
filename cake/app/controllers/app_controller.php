<?php
class AppController extends Controller {
	var $components = array('Session',/*'Acl',*/ 'Auth','Cookie');
	
	function beforeFilter() {
    	//have to manually start session for things to work properly
    	session_start();
		
    	$this->layout = 'basic' . DS . 'basic';
    	
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
	}
}