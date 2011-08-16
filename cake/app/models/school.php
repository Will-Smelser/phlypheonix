<?php
class School extends AppModel {
	var $name = 'School';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'users_schools',
			'foreignKey' => 'school_id',
			'associationForeignKey' => 'user_id',
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

}
