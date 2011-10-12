<?php
class School extends AppModel {
	var $name = 'School';
	var $displayField = 'name';
	var $order = 'long ASC';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'school_id',
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


	var $hasAndBelongsToMany = array(
		'Color' => array(
			'className' => 'Color',
			'joinTable' => 'schools_colors',
			'foreignKey' => 'school_id',
			'associationForeignKey' => 'color_id',
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
	
	function getSchoolsWithSale(){
		$sql = "SELECT `School`.* FROM `sales` 
			LEFT JOIN `sales_products` 
				ON sales.id = sales_products.sale_id 
			LEFT JOIN `products`
				ON `products`.id = sales_products.product_id
			LEFT JOIN `schools` AS `School`
				ON products.school_id = `School`.id 
			WHERE 
				sales.starts <= UNIX_TIMESTAMP() AND 
				sales.ends >= UNIX_TIMESTAMP() AND 
				sales.active = 1 
			GROUP BY `School`.id ORDER BY `School`.".$this->order;
		return $this->query($sql);
	}

}
