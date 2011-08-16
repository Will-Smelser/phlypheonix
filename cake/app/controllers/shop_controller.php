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
	var $uses = array('Product', 'Pdetail', 'Sale', 'School', 'User', 'Order');
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	}
	
	function index() {
		$this->redirect(array('controller' => 'shop', 'action' => 'f'));
	}
	
	function f ($school=null, $sex=null, $sale = null, $product = null) {
		
		$userData = $this->User->find(null,$this->Auth->user('User.id'));
		
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
		
		
		$this->addUserSaleEndDate($saleId, $productId);
	}
	
	private function addUserSaleEndDate($saleId, $productId) {
		//logged in user
		if($this->Auth->user('id')) {
			//check if we already have the sale information
			debug('');
		}
	}

}
