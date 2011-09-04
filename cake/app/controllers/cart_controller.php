<?php
class CartController extends AppController {
	
	var $uses = array();
	var $components = array('Ccart');
	
	function beforeFilter(){
		$this->layout = 'ajax';
		$this->render('ajax');
	}
	
	function addProduct($productId, $qty, $size, $color){
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size),$qty);
		$this->Ccart->add($entry);
	}
	
	function removeProduct($productId, $qty, $size, $color){
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size),$qty);
		$this->Ccart->remove($entry);
	}
	
	function emptyCart(){
		$this->Ccart->emptyCart();
	}
	
	function getItems(){
		$items = array();
		
		foreach($this->Ccart->content as $cartEntry){
			$temp=array(
				'type'=>$cartEntry::$type, 
				'qty'=>$cartEntry->qty,
				'detail'=>$cartEntry->details
			);
			foreach($cartEntry->uniques as $key=>$val){
				$temp[$key] = $val;
			}
			array_push($items, $temp);
		}
		echo json_encode($items);
	}
	
	private function createEntry($type, $uniques){
		switch($type){
			case 'product':
				return new ProductEntry($uniques);
			case 'accessory':
				return new AccessoryEntry($uniques);
				break;
		}
	}
}