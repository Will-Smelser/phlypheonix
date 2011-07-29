<?php
class Group extends AppModel {
	var $name = 'Group';
	
	var $actsAs = array('Acl' => array('type'=>'requester'));
	 
	function parentNode() {
	    return null;
	}
	
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Cannot be empty ',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'permission'=>array(
			'rule' => array('checkPermissions'),
			'message' => 'Must select one or more permission(s)',
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $hasMany = array('User');

	function checkPermissions($check){	
		return !empty($this->data['Group']['permission']);
	}
	
	function saveAcl($data){

		if(empty($data['Group']['permission'])) return;
		
		App::import('Component', 'Acl');
    	$acl = new AclComponent();
		
		foreach($data['Group']['permission'] as $val){
			$acl->allow($data['Group']['name'], $val);
		}
		return;
	}
	function clearAcl($groupAlias, $data){
		App::import('Component', 'Acl');
    	$acl = new AclComponent();
    	
		foreach($data as $val){
			$acl->deny($groupAlias, $val);
		}
		return;
	}
}
?>