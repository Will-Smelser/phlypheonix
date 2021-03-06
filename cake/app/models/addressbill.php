<?php
class Addressbill extends AppModel {
	var $name = 'Addressbill';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Uinfo' => array(
			'className' => 'Uinfo',
			'foreignKey' => 'addressbill_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
