<?php
class AccessoriesController extends AppController {
	
	var $name = 'Accessories';
	var $uses = array('School','Product','Color','Pimage');
	var $helpers = array('Sizer');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'accessories';
		//$this->layout = 'default';
	}
	
	function index($school,$sex=null){
		$school = $school * 1;
		
		$sex = (strtolower($sex) == 'm') ? 'M' : 'F';
		
		$sql = "SELECT `Product`.*, `Color`.* FROM `schools` AS `School` " . 
				"LEFT JOIN `schools_colors` AS `SchoolsColor` ON (`School`.`id` = `SchoolsColor`.`school_id`) " .
				"LEFT JOIN `colors` AS `Color` ON (`SchoolsColor`.`color_id` = `Color`.`id`) " .
				"LEFT JOIN `pdetails` AS `Pdetail` ON (`Pdetail`.`color_id` = `SchoolsColor`.`color_id`) " .
				"LEFT JOIN `products` AS `Product` ON (`Pdetail`.`product_id` = `Product`.`id`) " .
				//"LEFT JOIN `pimages` AS `Pimage` ON (`Color`.`id` = `Pimage`.`color_id`) " .
				"WHERE `School`.`id` = $school AND `Product`.`sex` = '$sex' AND `Product`.`controller` = 'accessories' " . 
				"GROUP BY `Product`.`id` " . 
				"ORDER BY `Color`.`id` ASC ";
		
		$data = $this->School->query($sql);
		//debug($sql);
		//debug($data);
		
		$school = $this->School->findById($school);
		$schools = $this->School->find('all',array('recursive'=>0));
		
		//filter the products by color...look for the swatch
		$colors = array();
		$swatches = array();
		$cids = array();
		$pids = array();
		foreach($data as $entry){
			$colorid = $entry['Color']['id'];
			
			if(preg_match('/swatch/i',$entry['Product']['name'])){
				if(!key_exists($colorid,$swatches)){
					$swatches[$colorid] = array();
				}
				array_push($swatches[$colorid],$entry);
			} else {
				
				array_push($cids, $colorid);
				if(!key_exists($colorid,$colors)){
					$colors[$colorid] = array();
				}
				array_push($colors[$colorid],$entry);
			}
			array_push($pids, $entry['Product']['id']);
		}
		//debug($swatches);
		//debug($colors);
		
		//get the images
		//$images[product_id] = array(Pimage entry)
		$sql = 'SELECT * FROM `Pimages` AS `Pimage` WHERE `product_id` IN ('.implode(',',$pids).') AND `color_id` IN ('.implode(',',$cids).')';
		$result = mysql_query($sql);
		$images = array();
		while($row = mysql_fetch_assoc($result)){
			if(!array_key_exists($row['product_id'],$images)){
				$images[$row['product_id']] = array();
				$images[$row['product_id']][0] = $row;
			}else{
				array_push($images[$row['product_id']], $row);
			}
		}
		//debug($images);
		
		
		
		//debug($school);
		$this->set(compact('data','school','schools','sex','colors','swatches','images'));
		
		//debug($this->myuser);
	}
}