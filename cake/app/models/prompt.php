<?php
class Prompt extends AppModel {
	var $name = 'Prompt';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'users_prompts',
			'foreignKey' => 'prompt_id',
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
	
	function removeUserPrompt($id = 0) {
		$clean = $id * 1;
		
		if($clean  == $id) {
			$sql = "DELETE FROM `users_prompts` WHERE `id` = $clean LIMIT 1";
			$this->query($sql);
		}
		return;
	}
	
	function cleanUpPrompts(){
		$time = time();
		$sql = "DELETE FROM `users_prompts` WHERE `prompt_id` IN (SELECT `id` FROM `prompts` WHERE `ends` < $time)";
		$this->query($sql);
	}
	
	function addToAll($id){
		$clean = $id * 1;
		
		if($clean == $id){
			$sql = "INSERT INTO `users_prompts` (`user_id`,`prompt_id`) (SELECT `id`, $id AS `prompt_id` FROM `users`)";
			return ($this->query($sql));
		}
		return false;
	}
	
	function addFirstTimeUserPrompt($userid){
		$sql = "INSERT INTO `users_prompts` (`user_id`,`prompt_id`) VALUES ($userid, 1)";
		return ($this->query($sql));
	}

}
