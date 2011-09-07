<?php
class CartController extends AppController {
	
	var $uses = array('Product', 'Size', 'Color');
	var $components = array('Ccart');
	
	function beforeFilter(){
		$this->layout = 'ajax';
		$this->render('ajax');
		
		$this->Auth->allow('*');
	}
	
	function addProduct($productId, $qty, $size, $color){
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size),$qty);
		$this->Ccart->add($entry);
	}
	
	function removeProduct($productId, $qty, $size, $color){
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size),$qty);
		$this->Ccart->remove($entry);
	}
	function removeAll($id){
		$this->Ccart->removeAll($id);
	}
	function update(){
		foreach($_POST as $id=>$qty){
			if($qty > 0){
				$this->Ccart->updateQty($id, $qty);
			} else {
				$this->Ccart->removeAll($id);
			}
		}
	}
	function emptyCart(){
		$this->Ccart->emptyCart();
	}
	
	function index(){
		
		
		$sizes = $this->Size->find('list',array('fields' => array('display')));
		$colors = $this->Color->find('list');
		$content = $this->Ccart->content;
		
		$this->set(compact('sizes','colors','content'));
		
		$this->render('index');
	}
	
	function ajaxGetItems(){
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