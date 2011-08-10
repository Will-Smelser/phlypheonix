<?php
class Sale extends AppModel {
	var $name = 'Sale';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'sales_products',
			'foreignKey' => 'sale_id',
			'associationForeignKey' => 'product_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	var $hasMany = array('Saleuser');

}
