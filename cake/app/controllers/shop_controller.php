<?php

/**
 * 
 * Format for URLs
 * 
 * /shop/school.id/sex/
 * /shop/school.id/sex/sale.id
 * /shop/school.id/sex/sale.id/product.id
 *
 * @author Will Smelser
 *
 */
class ShopController extends AppController {

	var $name = 'Shop';
	var $uses = array('Product', 'Sale', 'School', 'User', 'Order');
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	}
	
	private function addUserSaleEndDate($productId, $saleId) {
		//logged in user
		if($this->Auth->user('id')) {
			//check if we already have the sale information
			
		}
	}

}
