<?php
class Credit extends AppModel {
	var $name = 'Credit';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserPurchases' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sale' => array(
			'className' => 'Sale',
			'foreignKey' => 'sale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * Maximum allowed credit amount
	 * @var float
	 */
	var $max = 25.00;
	
	public function addCredit($amount=0, $purchases_id, $user_id, $sale_id, $order_id=null){
		if($amount == 0) return true;
		if($amount > $this->max) return false;
		
		$data = array(
			'Credit'=>array(
				'user_id'=>$user_id,
				'user_id_purchases'=>$purchases_id,
				'sale_id'=>$sale_id,
				'order_id_optional'=>$order_id,
				'amount'=>$amount
			)
		);
		
		return $this->save($data);
	}
	
	public function getCredits($userId){
		return $this->find('all',array('conditions'=>'Credit.user_id = '.$userId,'order'=>'Credit.amount DESC'));
	}
	
	/**
	 * 
	 * Reduce credits for a specified user
	 * @param unknown_type $userId
	 * @param unknown_type $amount
	 * @param unknown_type $currentCredits This should be the result of calling getCredits()
	 * @return Returns the query result on error (false) or the amount that failed to be reducted
	 * @see getCredits()
	 */
	public function reduceCreditsByAmount($userId, $amount, &$currentCredits = null) {
		if($currentCredits == null) {
			$currentCredits = $this->getCredits($userId);
		}
		
		//iterate the credits...should be ASC order
		$update = null;
		$delete = array();
		foreach($currentCredits as $entry){
			$creditAmount = $entry['Credit']['amount'];
			
			$reduceTo = 0;
			
			//credits is greater than amount to reduce by
			if(($creditAmount - $amount) > 0) {
				$update = $entry['Credit']['id'];
				$reduceTo = $creditAmount - $amount;
				$amount = 0;
			} else {
				array_push($delete,$entry['Credit']['id']);
				$amount -= $creditAmount;
			}
			
			//possible to try and reduce credit by more than
			//what the user has, this kicks us out before
			//a user can owe
			if($amount <= 0) break;
			
		}
		//update a credit to the new amount
		if($update !== null){
			$this->id = $entry['Credit']['id'];
			$result = $this->saveField('amount',$reduceTo);
			if(!$result) {
				return $result;
			}
		}
		
		//update all necesarry credits to zero
		if(count($delete) > 0) {
			$sql = "UPDATE `credits` SET `amount` = 0.00 WHERE `id` IN (".implode(',',$delete).")";
			$result = $this->query($sql);
			if(!$result) {
				return $result;
			}
		}
		
		//0 or the amount that could not be reduced
		return $amount;
	}
}
