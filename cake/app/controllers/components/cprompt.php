<?php
class CpromptComponent extends Object {
	var $controller;
	var $prompts = array();
	var $data = array();
	
	function initialize(&$controller){
		$this->controller =& $controller;	
	}
	
	function addDbPrompts(){
    	//bail if no user info
    	if(empty($this->controller->myuser)){
    		return false;
    	}
    	
    	//bail if no prompts
    	if(empty($this->controller->myuser['Prompt'])){
    		return false;
    	}
    	
    	//set the prompt variables
    	$controller = $this->controller->params['controller'];
    	$action = $this->controller->params['action'];
    	
    	//cycle the prompts
    	$prompts = $this->controller->myuser['Prompt'];
    	
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
    				$this->addPrompt($p['UsersPrompt']['id'], $p['name']);
    		}
    	}   	
    }
    
    function addPrompt($id, $name, $data = array()){
    	$this->prompts[$id] = $name;
    	if(!empty($data)){
    		$this->data[$id] = $data;
    	}
    }
    
    function setPrompt(){
    	$this->controller->set('cprompts',$this->prompts);
    	$this->controller->set('cpdata',$this->data);
    }
}