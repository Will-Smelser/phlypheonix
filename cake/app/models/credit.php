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
				'order_id_optional'=>$order_id
			)
		);
		
		return $this->Credit->save($data);
	}
	
	public function getCredits($userId){
		return $this->Credit->find('all',array('conditions'=>'Credit.user_id = '.$userId,'order'=>'Credit.amount ASC'));
	}
	
	/**
	 * 
	 * Reduce credits for a specified user
	 * @param unknown_type $userId
	 * @param unknown_type $amount
	 * @param unknown_type $currentCredits This should be the result of calling getCredits()
	 * @see getCredits()
	 */
	public function reduceCreditsByAmount($userId, $amount, &$currentCredits = null) {
		if($currentCredits == null) {
			$currentCredits = $this->getCredits($userId);
		}
		
		//iterate the credits...should be ASC order
		$update = null;
		$delete = array();
		foreach($currentCredits['Credit'] as $entry){
			$creditAmount = $entry['amount'];
			
			$reduceTo = 0;
			if(($creditAmount - $amount) > 0) {
				$update = $entry['id'];
				$reduceTo = $creditAmount - $amount;
			} else {
				array_push($delete,$entry['id'])
				$amount -= $creditAmount;
			}
			
			//possible to try and reduce credit by more than
			//what the user has, this kicks us out before
			//a user can owe
			if($amount < 0) break;
			
		}
		//update a credit to the new amount
		if($update !== null){
			$this->Credit->id = $entry['id'];
			$result = $this->Credit->saveField('amount',$reduceTo);
			if(!$result) {
				return $result;
			}
		}
		
		//update all necesarry credits to zero
		if(count($delete) > 0) {
			$sql = "UPDATE `credits` SET `amount` = 0.00 WHERE `id` IN (".implode(',',$delete).")";
			$result = $this->Credit->query($sql);
			if(!$result) {
				return $result;
			}
		}
		
		return true;
	}
}
