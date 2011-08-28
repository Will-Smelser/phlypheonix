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
		$this->redirect(array('controller' => 'shop', 'action' => 'shop'));
	}
	
	//no school for user
	function school(){
		
	}
	
	//there was no sale for schools
	function nosale() {
		
	}
	
	//remove a prompt for the user
	function prompt($promptId=null) {
		if(empty($promptId)){
			return;
		}
	}
	
	//main page for shopping
	function main ($school=null, $sex=null, $sale = null, $product = null) {
		
		if($sale == null) {
			$saleData = $this->Sale->find('all',array('condition'=>array('Sale.ends >= ' . time()) ));
		} else {
			$saleData = $this->Sale->find('all',$sale);
		}
		
		//build product list bases on all sales
		$plist = "";
		foreach($saleData as $entry) {
			foreach($entry['Product'] as $p) {
				$plist.= $p['id'].',';
			}
		}
		$plist = rtrim($plist,',');
		
		$productData = $this->Product->find('all',array('condition'=>'Product.id IN ('.$plist.')'));
		
		
		//$this->addUserSaleEndDate($saleId, $productId);
	}
	
	private function addUserSaleEndDate($saleId, $productId) {
		//logged in user
		if($this->Auth->user('id')) {
			//check if we already have the sale information
			
		}
	}

}
