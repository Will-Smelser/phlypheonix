<?php
class Cooky extends AppModel {
	var $name = 'Cooky';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'UsersSecurities' => array(
			'className' => 'UsersSecurities',
			'foreignKey' => 'users_securities_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>