<?php
class Color extends AppModel {
	var $name = 'Color';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Pdetail' => array(
			'className' => 'Pdetail',
			'foreignKey' => 'color_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Pimage' => array(
			'className' => 'Pimage',
			'foreignKey' => 'color_id',
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
		'School' => array(
			'className' => 'School',
			'joinTable' => 'schools_colors',
			'foreignKey' => 'color_id',
			'associationForeignKey' => 'school_id',
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
	
	function getSchoolColors($schoolId){
		return $this->find('all',array('conditions'=>array('school_id'=>$schoolId)));
	}

}
