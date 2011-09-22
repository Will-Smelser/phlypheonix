<?php
class Oinfo extends AppModel {
	var $name = 'Oinfo';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pdetail' => array(
			'className' => 'Pdetail',
			'foreignKey' => 'pdetail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
