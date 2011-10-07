<?php
class CartController extends AppController {
	var $name = "Cart";
	var $uses = array('Product', 'Size', 'Color', 'Pdetail');
	var $components = array('Session');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->layout = 'ajax';
		$this->render('ajax');
		
		//$this->Auth->allow('*');
	}
	
	function addProduct($productId, $qty, $size, $color){
		$this->layout = 'default';
		if(!$this->cleanInts($qty, $size, $color)) return;
		$this->layout = 'default';
		//lookup the pdetail
		$pdetail = $this->Pdetail->find('first',array(
							'conditions'=>array(
								'product_id'=>$productId,
								'size_id'=>$size,
								'color_id'=>$color
							),
							'recursive'=>0
					)
		);
		
		if(empty($pdetail)){
			return 0;
		}
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size,'pdetail'=>$pdetail['Pdetail']['id']),$qty);
		
		$this->Ccart->add($entry);
		
		return $entry->qty;
	}
	function addProductNoAjax(){
		$size = intval($_POST['size']);
		$color = intval($_POST['color']);
		$qty = intval($_POST['quantity']);
		$product = intval($_POST['product']);
		
		$this->addProduct($product,$qty,$size,$color);
		
		$this->Session->setFlash('Added product(s).');
		
		$this->redirect($_POST['returnUrl']);
	}
	function removeProduct($productId, $qty, $size, $color){
		if(!$this->cleanInts($qty, $size, $color)) return;
		$entry = new ProductEntry(array('id'=>$productId,'color'=>$color,'size'=>$size),$qty);
		$this->Ccart->remove($entry);
	}
	function removeAll($id,$noajax=null){
		$this->Ccart->removeAll($id);
		if(!empty($noajax)){
			$this->redirect('/cart/view');
		}
	}
	function updateAll(){
		foreach($_POST as $entry=>$val){
			if(preg_match('/^(entry)/i',$entry)){
				$cartId = str_replace('entry_','',$entry);
				$this->Ccart->updateQty($cartId,$val);
			}
		}
		$this->redirect('/cart/view');
	}
	function update(){
		foreach($_POST as $id=>$qty){
			if(!$this->cleanInts($qty)) return;
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
	
	function view(){
		//$this->layout = 'default';
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-medium');
		
		$sizes = $this->Size->find('list',array('fields' => array('display')));
		$colors = $this->Color->find('list');
		$content = $this->Ccart->content;
		
		
		$this->set(compact('sizes','colors','content'));
		
		$this->render('view');
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
	
	private function cleanInts(){
		foreach(func_get_args() as $entry){
			if($entry * 1 == 0 && $entry != 0) return false;
		}
		return true;
	}
}