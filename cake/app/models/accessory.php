<?php
class Accessory extends AppModel {
	
	var $useTable = false;
		
	function getData($school,$sex,$color=null){
		
		
		$sql = "SELECT `Product`.*, `Color`.* FROM `schools` AS `School` " . 
				"LEFT JOIN `schools_colors` AS `SchoolsColor` ON (`School`.`id` = `SchoolsColor`.`school_id`) " .
				"LEFT JOIN `colors` AS `Color` ON (`SchoolsColor`.`color_id` = `Color`.`id`) " .
				"LEFT JOIN `pdetails` AS `Pdetail` ON (`Pdetail`.`color_id` = `SchoolsColor`.`color_id`) " .
				"LEFT JOIN `products` AS `Product` ON (`Pdetail`.`product_id` = `Product`.`id`) " .
				//"LEFT JOIN `pimages` AS `Pimage` ON (`Color`.`id` = `Pimage`.`color_id`) " .
				"WHERE (`School`.`id` = $school AND `Product`.`sex` = '$sex' AND `Product`.`controller` = 'accessories') ";//OR " .
				//"`Product`.`name` LIKE '%swatch%' "; 
		//if(empty($color)){
			//$sql .= "GROUP BY `Product`.`id` ";
			$sql .= "GROUP BY `Pdetail`.`color_id`,`Product`.`id` ";
			$sql .= "ORDER BY `Color`.`id` ASC ";
		/*} else {
			$sql .= "AND `Color`.`id` = $color ";
			$sql .= "GROUP BY `Product`.`id` ";
		}
		return $this->query($sql);
		*/
		//debug($color);
		$result = $this->query($sql);
		//debug($sql);
		//sort by the color putting color at front
		
		if(!empty($result) && !empty($color)){
			$temp = array();
			$swatch = array();
			foreach($result as $key=>$entry){
				if($entry['Color']['id'] == $color ){
					//debug("MADE IT");
					array_push($temp,$entry);
					unset($result[$key]);
					//break;
				} elseif(preg_match('/swatch/i',$entry['Product']['name'])){
					array_push($swatch,$entry);
					
				}
			}
			//$result = array_merge($temp, $result);
			$result = $temp;
			$result = array_merge($result,$swatch);
		}
		
		//debug($result);
		return $result;
	}
	
	function aggregateData(&$data, &$swatches, &$colors, &$pids, &$cids){
		$primaryColor = $data[0]['Color']['id'];
		foreach($data as $key=>$entry){
			$colorid = $entry['Color']['id'];
			array_push($cids, $colorid);
			
			//we want all swatches
			if(preg_match('/swatch/i',$entry['Product']['name'])){
				if(!key_exists($colorid,$swatches)){
					$swatches[$colorid] = array();
				}
				if(!key_exists($colorid,$colors)){
					$colors[$colorid] = array();
				}
				array_push($swatches[$colorid],$entry);
				array_push($pids, $entry['Product']['id']);
				array_push($colors[$colorid],$entry);
				
			//only products that have the right color
			} else if($colorid == $primaryColor){
				if(!key_exists($colorid,$colors)){
					$colors[$colorid] = array();
				}
				array_push($colors[$colorid],$entry);
				array_push($pids, $entry['Product']['id']);
			}
			
		}
	}
	
	function aggregateImages(&$pids, &$cids){
		$images = array();
		
		$sql = 'SELECT * FROM `pimages` AS `Pimage` WHERE `product_id` IN ('.implode(',',$pids).') AND `color_id` IN ('.implode(',',$cids).')';
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($result)){
			if(!array_key_exists($row['product_id'],$images)){
				$images[$row['product_id']] = array();
				$images[$row['product_id']][0] = $row;
			}else{
				array_push($images[$row['product_id']], $row);
			}
		}
		return $images;
	}
	
	function getPdetails(&$Pdetail, &$pids){
		$pdetails =  $Pdetail->find('all',array(
			'conditions'=>'Pdetail.product_id IN ('.implode(',',$pids).')',
		));
		
		//cleanup the pdetails
		foreach($pdetails as $key=>$entry){
			unset($pdetails[$key]['Product']);
		}
		
		return $pdetails;
	}
	
	
}
?>