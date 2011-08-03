<?php
class Uinfo extends AppModel {
	var $name = 'Uinfo';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Addressbill' => array(
			'className' => 'Addressbill',
			'foreignKey' => 'addressbill_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Addressship' => array(
			'className' => 'Addressship',
			'foreignKey' => 'addressship_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
