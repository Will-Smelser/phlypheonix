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
		$refer = ($Session->check('Referer.id')) ? null : $Session->read('Referer.id');
		$cart = serialize($Ccart);
		
		$data = array();
		$data['Tracking'] = array(
			'session' => $ssid,
			'refer_id' => $refer,
			'user_id' => $userid,
			'url' => $url,
			'cart' => $cart
		);
		
		$this->save($data);
		return;
	}
}
?>