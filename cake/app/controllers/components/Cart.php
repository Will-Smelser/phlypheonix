<?php
class CartComponent extends Object {
	var $namespace;
	var $modelName;
	var $modelKey;
	
	var $amtRoute;
	
	var $controller;
	var $model;
	var $session;
	
	var $content = array();
	
	function initialize(&$controller){
		$this->controller =& $controller;
		
		$this->modelName = Configure::read('cart.product.model');
		$this->modelKey  = Configure::read('cart.product.key');
		$this->namespace = Configure::read('cart.namespace');
		
		//save reference to model
		if(empty($this->controller->{$this->modelName})){
			$this->model =& ClassRegistry::init($this->modelName);
		}
		
		//load the cake session component
		if(!empty($this->controller->Session)) {
			$this->session =& $this->controller->Session;
			
		} else {
			App::import('Component', 'Session');
			$this->session =& new SessionComponent();
		}
		
		//initialize session
		if(!$this->session->check($this->namespace)) {
			$this->session->write($this->namespace,&$this->content);
			
		} else {
			$this->content =& $this->session->read($this->namespace);
		}
		
	}
	
	function add($productId, $qty) {

		//no product exists
		if(!$this->checkProductInCart($productId)) {
			
			//find the product
			$condition = array('condition'=>"{$this->modelName}.{$this->modelKey} = $productId");
			$info = $this->model->find('first',$condition);
			
			//no product found
			if(empty($info)) {
				return 0;
			}
			
			//create a new entry and add to cart
			$entry = new CartEntry($productId, $qty, $info);
			$this->content[$productId] = $entry;
			
			$this->updateSession();
			
			return $qty;
		
		//product exists already
		} else {
			
			//update the quantitly
			$this->content[$productId]->qty += $qty;
			
			$this->updateSession();
			
			return $this->content[$productId]->qty;
			
		}
	}
	
	function remove($productId, $qty) {
		
		if($this->checkProductInCart($productId)) {

			$entry = $this->content[$productId];
						
			if($entry->qty <= $qty) {
				unset($this->content[$productId]);
			} else {
				$this->content[$productId]->qty -= $qty; 
			}
		}
		$this->updateSession();
		return true;
	}
	
	
	
	function emptyCart() {
		$this->content = array();
		$this->updateSession();
	}
	
	function getContents() {
		return $this->content;
	}
	
	/**
	 * Requires that the product has already been added.
	 * 
	 * @param unknown_type $productId
	 */
	public function getProduct($productId) {
		return $this->content[$productId];
	}

	function getProductUnitPrice($prodcutId, $route=null){
		
		return $this->getProduct($prodcutId)->getUnitPrice($route);
	}
	
	function getProductTotal($productId, $route=null) {
		return $this->getProduct($productId)->getTotal($route);
	}
	
	/**
	 * Check if the product already exists
	 * 
	 * @param unknown_type $productId
	 */
	public function checkProductInCart($productId) {
		return (isset($this->content[$productId]));
	}
	
	private function updateSession() {
		$this->session->write($this->namespace,$this->content);
	}
}

class CartEntry {
	var $productId; //products id
	var $qty; //the quantity
	var $info; //the Model Info on product
	
	function CartEntry($productId, $qty, $info){
		
			$this->productId = $productId;
			$this->qty = $qty;
			$this->info = $info;
	}
	
	function getUnitPrice($route = null) {
		
		$parts = ($route == null) ? explode('.',Configure::read('cart.product.priceRoute')) : $route;
		
		$result = $this->info;
		foreach($parts as $key) {
			$result = $result[$key];
		}
		
		return $result;
	}
	
	function getTotal($route=null) {
		return $this->getUnitPrice($route) * $this->qty;
	}
	
	function getInfo() {
		return $this->info;
	}
}

class CartUtils {
	static function formatMoneyUS($amount) {
		return '$'.str_pad(number_format($amount,2),8," ",STR_PAD_LEFT);
	}
	static function formatMoneyEU($amount) {
		return '£'.str_pad(number_format($amount,2),8," ",STR_PAD_LEFT);
	}
}

?>