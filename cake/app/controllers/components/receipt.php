<?php
class ReceiptComponent extends Object {
	
	var $controller = null;
	var $receipt = null;
	
	function initialize(&$controller){
		$this->controller = $controller;
		$this->receipt = new Receipt();	
	}
	
}

class Receipt {
	
	/**
	 * An a array of ReceiptEntryTypes.toString() as keys
	 */
	private $entries = array();
	
	/**
	 * Tracks total taxes as we add entries
	 */
	private $taxes;
	
	/**
	 * Tacks subtotal as we add products
	 */
	private $subtotal;
	
	/**
	 * Tax rate to use.  It may be a good idea
	 * to move this into entries so you can have tax
	 * rate by entry instead of global
	 */
	var $taxRate = 0.0;
	
	/**
	 * Holds the shipTo address. 
	 */
	var $shipTo = null;
	
	/**
	 * Holds the billTo adddress.
	 */
	var $billTo = null;
	
	/**
	 * Initializes $entries
	 */
	function Receipt() {
		//initialize the products entries
		foreach(ReceiptEntryTypes::$validTypes as $name=>$type) {
			$this->entries[$name] = array();
		}
	}
	
	function reset(){
		$this->Receipt();
	}
	
	/**
	 * Wrapper for setting the shipTo
	 */
	function setShipTo(Address $address) {
		$this->shipTo = $address;
	}
	
	/**
	 * Wrapper for setting the billTo
	 */
	function setBillTo(Address $address) {
		$this->billTo = $address;
	}
	
	/**
	 * Wrapper for setting tax rate
	 * 
	 * Work around
	 */
	function setTaxRate($rate=0.0){
		$this->taxRate = $rate;
	}
	
	/**
	 * Add an entry
	 * @param $type String The entry type
	 * @param $id Varient The unique id of the product or entry
	 * @param $priceUnit The unit price to use for calcs
	 * @param $desc (optional) The description of the entry
	 * @param $priceRetail (optional) The retail price
	 */
	function addEntry($typeStr, $id, $pdetail, $qty, $name, $priceUnit, $desc = null, $priceRetail = null) {
		$type = new ReceiptEntryTypes($typeStr);
		$entry = new ReceiptEntry($type, $id, $pdetail, $qty, $name, $priceUnit, $desc, $priceRetail);
		
		//add the entry
		array_push($this->entries[$typeStr], $entry);
		
		//track taxes
		if($type->isTaxable()){
			$this->taxes += $entry->priceUnit * $this->taxRate * $entry->qty;
		}
		
		//track the subtotal
		if($type->beforeSub()) {
			//echo "{$this->subtotal} += {$entry->priceUnit}<br/>";
			$this->subtotal += $entry->priceUnit * $entry->qty;
		}
	}
	
	function sumOfTaxableEntries() {
		$sum = 0.00;
		foreach($this->getTaxEntries() as $entry) {
			$sum += ($entry->priceUnit * $this->taxRate * $entry->qty);
		}
		return $sum;
	}
	
	/**
	 * Get all taxable entries
	 */
	function getTaxEntries() {
		return $this->iterate('isTaxable', true);
	}
	
	/**
	 * get all before subtotal entries
	 */
	function getBeforeSubEntries(){
		return $this->iterate('beforeSub', true);
	}
	
	/**
	 * get all after subtotal entries
	 */
	function getAfterSubEntries(){
		return $this->iterate('beforeSub', false);
	}
	
	/**
	 * Get total of taxes
	 */
	function getTaxesTotaled(){
		return $this->taxes;
	}
	
	/**
	 * Private method used for iterations
	 * @param $entryTypeFunc string A string representaiton of the ReceiptEntryType function to be called
	 * @param $compareTo bool This value is compared to the result of the entryTypeFunc with '=='
	 * @return Array(ReceiptEntry)
	 */
	private function iterate($entryTypeFunc, $compareTo = true){
		$result = array();
		foreach($this->entries as $entryType) {
			foreach($entryType as $entry) {
				if($entry->type->$entryTypeFunc() == $compareTo){
					array_push($result,$entry);
				}
			}
		}
		return $result;
	}
	
	/**
	 * get the subtotal
	 */
	function getSubTotal(){
		return $this->subtotal;
	}
	
	/**
	 * get the total
	 */
	function getTotal() {
		$total = 0.00;
		foreach($this->entries as $entryType) {
			foreach($entryType as $entry) {
				$total += $entry->priceUnit * $entry->qty;
			}
		}
		return $total;
	}
	
	function getTotalCount($types=array()){
		$cnt = 0;
		foreach($types as $type){
			foreach($this->entries[$type] as $entry){
				$cnt += $entry->qty;
			}
		}
		return $cnt;
	}
	
	function getContentsByType($types=array()){
		$result = array();
		foreach($types as $type){
			foreach($this->entries[$type] as $entry){
				array_push($result, $entry);
			}
		}
		return $result;
	}
}
class receiptEntryTypes {
	//factor is not used...thinking of all entries would have positive values, and use factor=-1|1 for
	//calculation purposes
	public static $validTypes = array(
		'product'=>array('beforeSub' => true, 'taxable' => true, 'factor'=>1),
		'shipping'=>array('beforeSub' => false, 'taxable' => false, 'factor'=>1),
		'discount'=>array('beforeSub' => true, 'taxable' => false, 'factor'=>1),
		'coupon'=>array('beforeSub' => true, 'taxable' => false, 'factor'=>1),
		'tax'=>array('beforeSub' => false, 'taxable' => false, 'factor'=>1)
	);
	
	/**
	 * Holds a string representing what type this is
	 */
	var $type;
	
	/**
	 * Constructor
	 */
	function receiptEntryTypes($validType=null){
		
		$this->type = (array_key_exists ($validType, self::$validTypes)) ? $validType : 'product';
		return $this->type;
	}
	
	/**
	 * Get the string value of this type
	 */
	function toString(){
		return $this->type;
	}
	
	/**
	 * Return true if this is taxable entry, false otherwise
	 */
	function isTaxable(){
		return receiptEntryTypes::$validTypes[$this->type]['taxable'];
	}
	
	/**
	 * Does this entry go before subtotal or after
	 */
	function beforeSub() {
		return receiptEntryTypes::$validTypes[$this->type]['beforeSub'];
	}
	
}
class ReceiptEntry {
	
	var $id;
	var $productId;
	var $pdetail;
	var $qty;
	var $name;
	var $desc;
	var $priceUnit;
	var $priceRetail;
	var $type; //(receiptEntryTypes)
	
	function ReceiptEntry(receiptEntryTypes $type, $productId, $id, $pdetail, $qty, $name, $priceUnit, $desc = null, $priceRetail = null, $taxable=true) {
		
		$this->productId = $productId;
		$this->id = $id;
		$this->qty = $qty;
		$this->name = $name;
		$this->pdetail = $pdetail;
		$this->priceUnit = $priceUnit;
		$this->desc = $desc;
		$this->priceRetail = $priceRetail;
		
		$this->type = $type;
	}
}

class Address{
	
	var $name;
	var $line1;
	var $line2;
	var $city;
	var $state;
	var $zip;
	var $country;
	
	function Address($name, $line1, $line2, $city, $state, $zip, $country = 'USA') {
		
		$this->name = $name;
		$this->line1 = $line1;
		$this->line2 = $line2;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->country = $country;
	}
	
	public function getHtml() {
$str = <<<STR
	<div class="address-name">{$this->name}</div>
	<div class="address-line">{$this->line1}</div>
	<div class="address-line">{$this->line2}</div>
	<div class="address-line">{$this->city}, {$this->state} {$this->zip}</div>
STR;
		return $str;
	}
}