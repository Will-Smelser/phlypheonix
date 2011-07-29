<?php

class AclsetupComponent extends Object 
{ 
	/**
	 * Fix alias entry for group
	 * @return unknown_type
	 */
	function addGroupAlias(&$thisRef){
		$sql = "UPDATE `aros` SET `alias` = (SELECT `groups`.`name` FROM `groups` WHERE `aros`.`foreign_key` = `groups`.`id`) WHERE `model` = 'Group'";
		$thisRef->Group->query($sql);
	}
	
	function addUserAlias(&$thisRef){
		$sql = "UPDATE `aros` SET `alias` = (SELECT `users`.`name` FROM `users` WHERE `aros`.`foreign_key` = `users`.`id`) WHERE `model` = 'User'";
		$thisRef->Group->query($sql);
	}
	
	function allowGroup($groupAlias, $controller){
		//$this->Acl->allow($aroAlias, $acoAlias);
		$this->Acl->allow($groupAlias, $controller);
	}
	
	function denyGroup($groupAlias, $controller){
		//$this->Acl->allow($aroAlias, $acoAlias);
		$this->Acl->deny($groupAlias, $controller);
	}
	
	function allowUser($userAlias, $controller){
		$this->Acl->allow($userAlias, $controller);
	}
	
	function denyUser($userAlias, $controller){
		$this->Acl->deny($userAlias, $controller);
	}
	
	function getAcoGroupChildren(&$thisRef, $groupAlias){
		$result = array();
		
		if(!$thisRef->Acl->Aro->node($groupAlias)) return $result;
		
		$acoTbl = $thisRef->Acl->Aco->Children();
		$acoTbl = $this->_cakeTableToArray('Aco','id',$acoTbl);
        $acoTree = $this->_assocArray($thisRef->Acl->Aco,'/',$acoTbl,'alias');
        
        $highestController = '';
        
        foreach($acoTree as $controller){
        	if($thisRef->Acl->check($groupAlias,$controller)){
        		
        		//initialize highestController
        		if(empty($highestController)){
        			$highestController = $controller;
        		}
        		
        		$prevController = explode('/',$highestController);
        		$curController = explode('/',$controller);
        		

        		if(!in_array($highestController,$result)){
        			array_push($result,$controller);
        		}
        		//went up
        		elseif(count($curController) < count($prevController)){
        			$highestController = $controller;
        			echo $highestController . '<br/>';
        			array_push($result,$controller);
        		//same depth
        		}elseif(count($curController) == count($prevController)){
        			if($highestController != $controller){
        				array_push($result,$controller);
        			}
        		//deeper
        		}else{
        			$temp = str_replace('/','\/',$highestController);
        			if(!preg_match("/^($temp)/",$controller)){
        				array_push($result,$controller);
        			}
        		}
        		
        	}
        }
        return $result;
	}
    /**
     * Change a cake Model table into a flat table using idField as key
     * @param $Model String The Model name to pull from cake Model table
     * @param $idField string/Integer The field name to use as table key
     * @param $data Array The cake Model table
     * @return array
     */
    function _cakeTableToArray($Model, $idField, $data){
    	$return = array();
    	foreach($data as $row=>$info){
    		if(isset($info[$Model]) && key_exists($idField,$info[$Model])){
    			$return[$info[$Model][$idField]] = $info[$Model];
    		}
    	}
    	return $return;
    }
    function _assocArray(&$obj, $delimiter='/', &$table=array(), $tableField='name'){
    	$tree = $obj->generatetreelist();
    	
    	$return = array();
    	
    	$depth = 0;
    	$parent = '';
    	$prevdepth = 0;
    	foreach($tree as $id=>$node){
    		$name = trim($node,'_');
    		$curdepth = strlen($node) - strlen($name);
    		
    		if($name*1 == $name && key_exists($name,$table)){
    			$name = $table[$name][$tableField];
    		}
    		
    		//going up in the tree
    		if($curdepth < $prevdepth){
    			$temp = explode($delimiter, $parent);
    			for($i=0;$i<=$prevdepth;$i++){
    				array_pop($temp);
    			}
    			$parent = implode($delimiter,$temp) . $delimiter;
    		//at same level
    		}elseif($curdepth == $prevdepth){
    			$temp = explode($delimiter, $parent);
    			array_pop($temp);
    			array_pop($temp);
    			$parent = implode($delimiter,$temp) . $delimiter;
    		}
    		
    		$parent = ltrim($parent,$delimiter);
    		
    		$parent .= $name.$delimiter;
    		
    		$temp = rtrim($parent,'/');
    		
    		$return[$temp] = $temp;
    		
    		$prevdepth = $curdepth;
    	}
    	return $return;
    }
	
	/**
	 * Rebuild the Acl based on the current controllers in the application
	 *
	 * @return void
	 */
    function buildAcl(&$thisRef) {
        $log = array();
 		
        $aco =& $thisRef->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id; 
            $log[] = 'Created Aco node for controllers';
        } else {
            $root = $root[0];
        }   
 
        App::import('Core', 'File');
        $Controllers = Configure::listObjects('controller');
        $appIndex = array_search('App', $Controllers);
        if ($appIndex !== false ) {
            unset($Controllers[$appIndex]);
        }
        $baseMethods = get_class_methods('Controller');
        $baseMethods[] = 'buildAcl';
 
        // look at each controller in app/controllers
        foreach ($Controllers as $ctrlName) {
            App::import('Controller', $ctrlName);
            $ctrlclass = $ctrlName . 'Controller';
            $methods = get_class_methods($ctrlclass);
 
            // find / make controller node
            $controllerNode = $aco->node('controllers/'.$ctrlName);
            if (!$controllerNode) {
                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Created Aco node for '.$ctrlName;
            } else {
                $controllerNode = $controllerNode[0];
            }
 
            //clean the methods. to remove those in Controller and private actions.
            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
                $methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
                if (!$methodNode) {
                    $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                    $methodNode = $aco->save();
                    $log[] = 'Created Aco node for '. $method;
                }
            }
        }
        debug($log);
    }
}
 ?>