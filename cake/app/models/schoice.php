<?php
class Schoice extends AppModel {
	var $name = 'Schoice';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Size' => array(
			'className' => 'Size',
			'foreignKey' => 'size_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
