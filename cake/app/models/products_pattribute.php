<?php
class ProductsPattribute extends AppModel {
	var $name = 'ProductsPattribute';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pattribute' => array(
			'className' => 'Pattribute',
			'foreignKey' => 'pattribute_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
