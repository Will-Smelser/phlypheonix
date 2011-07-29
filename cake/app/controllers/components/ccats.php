<?php
class CcatsComponent extends Object 
{ 

    function getCatRec($parent,&$data){
    	$resultData = array();
    	$resultList  = array();
    	
    	foreach($data as $row){
    		if($row['cats']['parent'] == $parent && !in_array($row['cats']['id'],$resultList)){
    			//echo $row['cats']['id'] . ' - ';
    			//add this to results
    			//array_push($resultData,$row['cats']);
    			$resultData[$row['cats']['id']] = $row['cats'];
    			//array_push($resultList,$row['cats']['id']);
    			$resultList[$row['cats']['id']] = $row['cats']['id'];
    			
    			//get and children of this element
    			$temp = $this->_getCatRec($row['cats']['id'],$data);
    			
    			foreach($temp['list'] as $key=>$info){
    				$resultList[$key] = $info;
    			}
    			foreach($temp['data'] as $key=>$info){
    				$resultData[$key] = $info;
    			}
    			//$resultList = array_merge($resultList,$temp['list']);
    			//$resultData = array_merge($resultData,$temp['data']);
    		}
    	}
    	return array('list'=>$resultList,'data'=>$resultData);
    }
    
    function htmlSelect(&$obj, $delimiter='/', $id='', $name='', $class='', &$table=array()){
    	$tree = $obj->generatetreelist();
    	
    	$html = "<select id='$id' $name='$name' class='$class'>\n";
    	
    	$depth = 0;
    	$parent = '';
    	$prevdepth = 0;
    	foreach($tree as $id=>$node){
    		$name = trim($node,'_');
    		$curdepth = strlen($node) - strlen($name);
    		
    		if(is_int($name) && key_exists($name,$table)){
    			$name = $table[$name];
    		}
    		//echo $node.'<br/>';
    		//echo "$node -- $curdepth -- $prevdepth<br/>";
    		
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
    		$html .= "<option value='$id'>$parent</option>\n";
    		
    		$prevdepth = $curdepth;
    	}
    	return $html;
    }
    
    /**
     * Create an associateve array for Cake Form Options using generatetreelist()
     * @param $obj Object Reference to Cake Model to use
     * @param $delimiter string The delimiter to use for name
     * @param $table Array An array representing the table with key=>name incase your Model doesnt have a good name field
     * @param $tableField The field name in your table to access as the name
     * @return array
     */
    function assocArray(&$obj, $delimiter='/', &$table=array(), $tableField='name'){
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
     * Change a cake Model table into a flat table using idField as key
     * @param $Model String The Model name to pull from cake Model table
     * @param $idField string/Integer The field name to use as table key
     * @param $data Array The cake Model table
     * @return array
     */
    function cakeTableToArray($Model, $idField, $data){
    	$return = array();
    	foreach($data as $row=>$info){
    		if(isset($info[$Model]) && key_exists($idField,$info[$Model])){
    			$return[$info[$Model][$idField]] = $info[$Model];
    		}
    	}
    	return $return;
    }
}
?>