<?php
class RememberMeComponent extends Object  
{  
    var $components = array('Auth', 'Cookie');  
    var $controller = null;  
  
    /** 
     * Cookie retention period. 
     * 
     * Can be 'never' or and strtotime value supported by php
     * @var string 
     */  
    var $period = 'never'; 
    var $cookieName = 'User';  
  
    function startup(&$controller)  
    {  
        $this->controller =& $controller;  
    }  
  
    function remember($username, $password)  
    {  
    	//possible that auth doesnt auto hash a password
    	if(strlen($password) < 25) {
    		$password = AuthComponent::password($password);
    	}
    	
        $cookie = array();  
        $cookie[$this->Auth->fields['username']] = $username;  
        $cookie[$this->Auth->fields['password']] = $password;  
  
        $this->writeCookie($cookie);
    }  
  
    function writeCookie($cookie){
    	if($this->period == 'never') {
	       $this->Cookie->write(  
	             $this->cookieName,  
	             $cookie,  
	             true
	        );  
        } else {
        	$this->Cookie->write(  
	             $this->cookieName,  
	             $cookie,  
	             true, 
	             $this->period  
	        );
        }
    }
    
    function check()  
    {  
        $cookie = $this->Cookie->read($this->cookieName);  
  
        if (!is_array($cookie) || $this->Auth->user())  
            return;  
  
        if ($this->Auth->login($cookie))  
        {  
        	$this->writeCookie($cookie);
        }  
        else  
        {  
            $this->delete();  
        }  
    }  
  
    function delete()  
    {  
        $this->Cookie->delete($this->cookieName);  
    }  
}
?>