<?php
class User extends AppModel {
	
	var $name = 'User';
	var $belongsTo = array('Group');
	var $hasOne = array(
		'UsersSecurity'=>array(
			'className'=>'UsersSecurity',
			'foreignKey'=>'user_id',
			'dependent'=>true
		)
	);
	
	var $actsAs = array('Acl' => array('type' => 'requester'));
	
	var $defaultGroupId = 2;
	 
	function parentNode() {
	    if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
	    } else {
	    	$groupId = $this->field('group_id');
	    }
	    if (!$groupId) {
			return null;
	    } else {
	        return array('Group' => array('id' => $groupId));
	    }
	}
	function bindNode($user) {
    	return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
	
	
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('checkEmail'),
				'message' => 'Invalid Email',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' =>array(
				'rule' => array('isUnique'),
				'message'=>'Email already being used',
				
			),
		),
		'birthdate'=>array(
			'check'=>array(
				'rule'=>array('checkBirthdate'),
				'message'=>'Invalid birthdate given.'
			),
			'convertToUnix'=>array(
				'rule'=>array('dateToUnix'),
				'message'=>''
			)
		),
		'password'=>array(
			'rule'=>'notEmpty',
			'message'=>'Invalid password was given.'
		),
		'sex'=> array(
			'rule'=>array('checkSex'),
			'message'=>'Invalid sex given.'
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active' => array(
			'default'=>true,
			'boolean' => array(
				'rule' => array('boolean'),
				
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	); 
    	
	function checkEmail($data) {
		if(!empty($this->data)){
			$data = $this->data; 
		}
		$email = $data['User']['email'];
		$temp = preg_replace(Configure::read('userconfig.regex.email'),'',$email);
		//debug((strlen($temp) == 0 && strlen($email) != 0));
		return (strlen($temp) == 0 && strlen($email) != 0);
	}
	function checkBirthdate($data) {
		if(!empty($this->data)){
			$data = $this->data; 
		}
		$date = explode('/',$data['User']['birthdate']);
		list($mm,$dd,$yy) = $date;
		return (checkdate($mm,$dd,$yy));
	}
	function checkSex($data) {
		if(!empty($this->data)){
			$data = $this->data; 
		}
		$sex = strtolower($data['User']['sex']);
		return ($sex == 'm' || $sex == 'f');
	}
	function checkEmailExists($data) {
		if(!empty($this->data)){
			$data = $this->data; 
		}
		return ($this->find('first', array('conditions'=>'User.email = "'.$data['User']['email'].'"')));
	}
	function dateToUnix($data) {
		$this->data['User']['birthdate'] = strtotime($this->data['User']['birthdate']);
		return true;
	}
	
}
?>