<?php
class Tracking extends AppModel {
	var $name = 'Tracking';
	
	function addEntry(&$Session, &$params, $Ccart, $userid){
		
		$ignore = array(
			'users/getimage'
		);
		
		$url = $params['url']['url'];
		
		//bail if this is a url to not record
		if(in_array($url,$ignore)) return;
		
		$ssid = session_id();
		$refer = ($Session->check('Referer.id')) ? $Session->read('Referer.id') : null;
		
		$cart = serialize($Ccart);
		
		$data = array();
		$data['Tracking'] = array(
			'session' => $ssid,
			'referer_id' => $refer,
			'user_id' => $userid,
			'url' => $url,
			'cart' => $cart
		);
		
		$this->save($data);
		return;
	}
	
	/*
	 * Remove all single page views...
	 * This makes sense since a real user should load more than a single page
	 */
	function cleanup(){
		$sql = 'DELETE FROM `trackings` WHERE id IN (SELECT id FROM `trackings_counts` WHERE cnt = 1)';
		return $this->query($sql);
	}
	
	
	function getBaseData($start=0,$finish=30,$sortOn='total_time',$sortDir='DESC', $filter='1'){
		$sql = "SELECT * FROM `trackings_base_data2` WHERE $filter ORDER BY $sortOn $sortDir LIMIT $start, $finish";
		
		return $this->query($sql);
	}
	
	function getBaseDataRecordCount(){
		$sql = 'SELECT COUNT(*) AS `count` FROM `trackings_base_data2`';
		$result = $this->query($sql);
		return $result[0][0]['count'];
	}
	
	function getDetailsBySession($ssid){
		$sql= 'SELECT * FROM `trackings` WHERE `session` = "'.$ssid.'" ORDER BY `created` ASC';
		return $this->query($sql);
	}
	
	function getDetailsByUserid($userid){
		$sql= 'SELECT * FROM `trackings` WHERE `user_id` = "'.$userid.'" ORDER BY `created` ASC';
		return $this->query($sql);
	}
	
}
?>