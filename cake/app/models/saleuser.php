<?php
class Saleuser extends AppModel {
	var $name = 'Saleuser';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sale' => array(
			'className' => 'Sale',
			'foreignKey' => 'sale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function addUserSaleEndDate(&$myuser, $saleId) {
		
		$data['Saleuser'] = array(
			'user_id' => $myuser['User']['id'],
			'sale_id' => $saleId
		);

		//switch off the debug, DB protect against multiple entries,
		//which throws MYSQL error when in debug mode
		$debug = Configure::read('debug');
		Configure::write('debug',0);
		
		$this->create();
		$result = $this->save($data);
		
		if($result) {
			$myuser['Saleuser'] = $result;
		}
		
		Configure::write('debug',$debug);
	}
}
