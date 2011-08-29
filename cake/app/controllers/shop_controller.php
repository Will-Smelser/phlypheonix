<?php

/**
 * 
 * Format for URLs
 * 
 * /shop/f/school.id/sex/
 * /shop/f/school.id/sex/sale.id
 * /shop/f/school.id/sex/sale.id/product.id
 *
 * @author Will Smelser
 *
 */
class ShopController extends AppController {

	var $name = 'Shop';
	var $uses = array('Product', 'Pdetail', 'Sale', 'School', 'User', 'Prompt', 'Order');
	var $components = array('AuthorizeNet');
	
	function beforeFilter() {
	    parent::beforeFilter();
	    
	    $this->layout = 'shop';

	}
	
	function index() {
		$this->redirect(array('controller' => 'shop', 'action' => 'main'));
	}
	
	//no school for user or could not find the school
	function noschool($info='user'){
		//no school for current user
		if($info == 'user'){
			
		//could not find the school
		} else {
			
		}
	}
		
	//there was no sale for schools
	function nosale() {
		
	}
	
	//main page for shopping
	function main ($school=null, $sex=null, $sale = null, $product = null) {
		
		$school   = $this->getSchool($school);
		$sex      = $this->getSex($sex);
		$saleData = $this->getSale($sale, $sex, $school);
		
		$this->addUserSaleEndDate($saleData['Sale']['id']);
	}
	
	private function addUserSaleEndDate($saleId) {
		$data['Saleuser'] = array(
			'user_id' => $this->myuser['User']['id'],
			'sale_id' => $saleId
		);

		Configure::write('debug',0);
		
		$this->Sale->Saleuser->create();
		$this->Sale->Saleuser->save($data);
		
		Configure::write('debug',1);
		
		
	}
	
	private function mainInit($school=null, $sex=null, $sale = null, $product = null) {
		//first we need a aschoo, nobody should be at 'main' without a school
		if($school == null) {
			
		}
	}
	private function getSchool($schoolId) {
		
		//specific school is requested
		if(!empty($schoolId)){
			
			//check if the user has the school data already
			foreach($this->myuser['School'] as $s) {
				//this is the school we are looking for
				if($s['id'] == $schoolId){
					return $s;
				}
			}
			
			//if here, then we need to query the school
			$school = $this->School->findById($schoolId);
			
			//failed query for school
			if(!$school) {
				$this->redirect(array('action'=>'noschool/locate'));
				return false;
			} else {
				return $school['School'];
			}
		//no school and user does not have a school
		} else if(empty($schoolId) && count($this->myuser['School']) == 0){
			$this->redirect(array('action'=>'noschool/user'));
			
		//user has a school -- should have a favorite then
		}else if(count($this->myuser['School']) > 0){
			$favorite = $this->myuser['User']['school_id'];
			
			//cycle schools looking for favorite
			foreach($this->myuser['School'] as $s) {
				//this is the school we are looking for
				if($s['id'] == $favorite){
					return $s;
				}
			}
			
			//lets update the favorite school
			$this->User->updateSchoolFavorite($this->myuser,$this->myuser['School'][0]['id']); 
			
			//no favorite found, lets just return the first school
			return $this->myuser['School'][0];
			
			
		//user has school and no specific school requested
		} else {
			$this->redirect(array('action'=>'noschool/locate'));
		}
		
	}
	
	/**
	 * Attempt to fix the sex if necessary
	 *
	 * @param unknown_type $sex
	 */
	private function getSex($sex){
		if(!empty($this->myuser['User']['sex']) && empty($sex)) {
			return $this->myuser['User']['sex'];
		}else if(empty($sex)) {
			return 'F';
		} else {
			return $sex;
		}
	}
	
	/**
	 * Forwards users to correct url based on their input
	 * 
	 * @param unknown_type $sale
	 * @param unknown_type $sex
	 * @param unknown_type $school
	 */
	private function getSale($sale, &$sex, &$school) {
		
		//we dont have a sale id to lookup on
		if(empty($sale)) {
			//first check if user has any sales already available to them
			$ids = array();
			if(count($this->myuser['Saleuser']) > 0){
				
				foreach($this->myuser['Saleuser'] as $sale) {
					array_push($ids, $sale['id']);
				}
				
				//lookup the sale id's
				$usales = $this->Sale->find('all',array(
					'conditions'=>array(
						'Sale.id IN ('.implode(',',$ids).')',
						'Sale.ends >= '.time(),
						'Sale.starts <= '.time(),
					)
				));
				
				//try and match sex		
				foreach($usales as $s) {
					if($s['Product'][0]['sex'] == $sex && $s['Product'][0]['school_id'] == $school['id']) {
						$this->redirect(array('action'=>"main/{$school['id']}/{$s['Product'][0]['sex']}/{$s['Sale']['id']}"));
						return;
					} 
				}
				
			}
				
			//could not match on users current sales
			$order = ($sex == 'M') ? 'DESC' : 'ASC'; //sort by sex
			
			//sql
			$sql = 'SELECT * FROM `sales` AS `Sale` LEFT JOIN `sales_products` ON `Sale`.`id` = `sales_products`.`sale_id` '.
				'LEFT JOIN `products` AS `Product` ON `sales_products`.`product_id` = `Product`.`id` '.
				'WHERE `Product`.`school_id` = ' . $school['id'] . ' AND `Sale`.`starts` <= ' . time() . ' ' .
					'AND `Sale`.`ends` >= ' . time() . ' ' .
				'ORDER BY `Product`.`sex` '.$order . ' LIMIT 1';
			
			
			$saleData = $this->Sale->query($sql);
			
			//prevent recursion
			if(!empty($saleData)){
				$this->redirect(array('action'=>"main/{$school['id']}/{$saleData[0]['Product']['sex']}/{$saleData[0]['Sale']['id']}"));
			}
				
			
		} else {
			$saleData = $this->Sale->find('first',array(
				'conditions'=>array(
					'Sale.id = '.$sale,
					'Sale.ends >= '.time(),
					'Sale.starts <= '.time(), 
				)
			));
			
			if(!empty($saleData)){
				if($saleData['Product'][0]['sex'] == $sex){
					return $saleData;
				} else {
					$this->redirect(array('action'=>"main/{$school['id']}/{$saleData['Product'][0]['sex']}/{$sale}"));
				}
			}
		}
		
		//no luck jus send to error page
		$this->redirect(array('action'=>'nosale'));
		return false;
	}
}
