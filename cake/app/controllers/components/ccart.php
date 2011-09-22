<?php
class CcartComponent extends Object {
	
	var $amtRoute;
	
	var $controller;
	var $session;
	
	var $content = array();
	
	function initialize(&$controller){
		$this->controller =& $controller;
		$this->namespace = Configure::read('cart.namespace');
		
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
	
	function add($cartEntry) {
		
		$id = $cartEntry->id;
		
		//no product exists
		if(!$this->checkProductInCart($id)) {
			
			$cartEntry->setProductInfo();
			$this->content[$id] = $cartEntry;
			
			$this->updateSession();
			
			return $this->content[$id]->qty;
		
		//product exists already
		} else {
			
			//update the quantitly
			$this->content[$id]->qty += $cartEntry->qty;
			
			$this->updateSession();
			
			return $this->content[$id]->qty;
			
		}
	}
	function updateQty($id, $qty){
		$this->content[$id]->qty = $qty;
	}
	function remove($cartEntry) {
		
		$id = $cartEntry->id;
		
		if($this->checkProductInCart($id)) {

			$entry = $this->content[$id];
						
			if($entry->qty <= $cartEntry->qty) {
				unset($this->content[$id]);
			} else {
				$this->content[$id]->qty -= $cartEntry->qty;
			}
		}
		$this->updateSession();
		return true;
	}
	function removeAll($id){
		unset($this->content[$id]);
		$this->updateSession();
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
	 * @param unknown_type $id Use the static method CartEntry::makeUniqueId
	 */
	public function getProduct($id) {
		return $this->content[$id];
	}

	function getProductUnitPrice($id, $route=null){
		
		return $this->getProduct($id)->getUnitPrice($route);
	}
	
	function getProductTotal($id, $route=null) {
		return $this->getProduct($id)->getTotal($route);
	}
	
	/**
	 * Check if the product already exists
	 * 
	 * @param unknown_type $productId
	 */
	public function checkProductInCart($id) {
		return (isset($this->content[$id]));
	}
	
	private function updateSession() {
		$this->session->write($this->namespace,$this->content);
	}
}
class CartEntry{
	public static $delimeter = '-';
	public static $type;
	
	var $id;
	var $qty;
	var $desc;
	
	var $uniques = array(
		'id'=>null,
	);
	var $details = array();
	
	var $info;
	
	var $model; //reference to the model
	var $modelName;
	var $modelKey;
	var $priceRoute;
	var $uniqueRoutes = array();
	
	/**
	 * Constructor
	 * @param Array An array of unique fields for this cart entry
	 */
	function CartEntry($uniques=array('id'=>1),$qty){
		
		foreach($uniques as $key=>$val){
			$this->uniques[$key] = $val;
		}
		
		$this->id = $this->makeUniqueId($uniques);
		$this->qty = $qty;
	}
	function setProductInfo(){
		//save reference to model
		$this->model =& ClassRegistry::init($this->modelName);
		
		//find the product
		$condition = array('conditions'=>"{$this->modelName}.{$this->modelKey} = {$this->uniques['id']}");
		$this->info = $this->model->find('first',$condition);
		
		foreach($this->uniqueRoutes as $field => $route){
			$parts = explode('.',$route);
			$result = $this->info;
			foreach($parts as $key){
				$result = $result[$key];
			}
			$this->details[$field] = $result;
		}
	}
	function getUnitPrice($route = null) {
		
		$parts = ($route == null) ? explode('.',$this->priceRoute) : explode('.', $route);
		
		$result = $this->info;
		
		foreach($parts as $key) {
			$result = $result[$key];
		}
		
		return $result;
	}
	function getUniqueId(){
		return $this->id;
	}
	function getTotal($route=null) {
		return $this->getUnitPrice($route) * $this->qty;
	}
	
	function getInfo() {
		return $this->info;
	}
	/*
	 * Must override this in extended classes
	 */
	public static function makeUniqueId($uniques){
		$unique = array();
		foreach($uniques as $val){
			array_push($unique, $val);
		}
		return self::$type . self::$delimeter . implode(self::$delimeter,$unique);
	}
	function getType(){
		$vars = get_class_vars(get_class($this));
		return $vars['type'];
	}
}
class ProductEntry extends CartEntry {
	public static $type = 'product';
	
	var $uniques = array(
		'id'=>null,
		'color'=>null,
		'size'=>null,
		'pdetail'=>null
	);
	
	var $details = array();
	
	var $modelName = 'Product';
	var $modelKey = 'id';
	var $priceRoute = 'Product.price_retail';
	var $descRoute = 'Product.name';
	var $uniqueRoutes = array(
		//'color'=>'Color.name',
		//'size'=>'Size.display'
	);
	
	public static function makeUniqueId($uniques){
		$unique = array();
		foreach($uniques as $val){
			array_push($unique, $val);
		}
		return self::$type . self::$delimeter . implode(self::$delimeter,$unique);
	}
}
class AccessoryEntry extends cartEntry {
	public static $type = 'accessory';
	
	var $uniques = array(
		'id'=>null,
		'color'=>null
	);
	
	var $modelName = 'Accessory';
	var $modelKey = 'id';
	var $priceRout = 'Accessory.price_retail';
	
	public static function makeUniqueId($uniques){
		$unique = array();
		foreach($uniques as $val){
			array_push($unique, $val);
		}
		return self::$type . self::$delimeter . implode(self::$delimeter,$unique);
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