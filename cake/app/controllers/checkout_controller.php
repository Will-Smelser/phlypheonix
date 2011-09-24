<?php

class CheckoutController extends AppController {
	var $name = 'Checkout';
	var $components = array('Ccart','Receipt','Email','Session');
	var $uses = array('Size', 'Color','School','Order','Pdetail');
	var $helpers = array('Hfacebook','Sizer');
	
	var $receipt = null;
	
	function beforeFilter() {
		parent::beforeFilter();
		
		$schools = $this->School->find('all',array('recursive'=>0,'order'=>array('name ASC')));
		$this->set('schools',$schools);
	}
	
	public function noproducts(){
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-small');
		
		
	}
	
	public function index($errName=null){
		
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-xlarge');
		
		//first lest just fix the post data
		if(isset($_POST['billing-cbox'])){
			$_POST['ship_name'] = $_POST['bill_name'];
			$_POST['ship_line_1'] = $_POST['bill_line_1'];
			$_POST['ship_line_2'] = $_POST['bill_line_2'];
			$_POST['ship_city'] = $_POST['bill_city'];
			$_POST['ship_state'] = $_POST['bill_state'];
			$_POST['ship_zip'] = $_POST['bill_zip'];
		}
		
		$post = array();
		//coming from finalize page or first time here
		if(count($_POST) == 0){
			$post = $this->Session->read('Checkout.info');
			$this->data = $post;
			
			$errors = $this->checkInventoryLevels();
			if(!empty($errName)) array_push($errors,new MyError($errName));
			
		//coming from index with posted data
		} else {
			$post = $_POST;
			$this->data = $post;
			$this->Session->write('Checkout.info',$post);
			
			$errors = $this->checkFormBasic();
			$errors = array_merge($errors,$this->checkInventoryLevels());
			if(count($errors) == 0 ){
				$this->redirect('/checkout/finalize');
			}
		}
		
		$this->receipt = $this->Receipt->receipt;
		
		$this->receipt->setTaxRate(0);
		
		$this->addAllCartProducts();
		
		$tax = $this->receipt->sumOfTaxableEntries();
		
		$before = $this->receipt->getBeforeSubEntries();
		
		$shipping = $this->getShipping();
		//$this->receipt->addEntry('product', $e->uniques['id'], $e->getUniqueId(),$pdetail, $e->qty, $name, $e->getUnitPrice(), $desc,null);
		$this->receipt->addEntry('shipping',98, 0, 0, 1, 'Shipping',$shipping, 'Shipping',null);
		
		$subtotal = $this->receipt->getSubTotal();
		$after = $this->receipt->getAfterSubEntries();
		
		$this->receipt->addEntry('tax', 99, 0, 0, 1, 'Tax', $tax, 'tax total');
		$taxes = $this->receipt->getTaxesTotaled();
		
		$total = $this->receipt->getTotal();
		
		$sizes = $this->Size->find('list',array('fields' => array('display')));
		$colors = $this->Color->find('list');
		
		$this->set(compact('before','subtotal','after','taxes','total','sizes','colors','errors'));
		$this->set('ccart',$this->Ccart);
		
		//set the post variables
		$this->set('post',$post);
		
	}
	function finalize($error=null,$msg=null){
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-xlarge');
		
		$errors = array();
		if(!empty($error)){
			$error = new MyError($error);
			if(!empty($msg)){
				$error->setMsg(urldecode($msg));
			}
			array_push($errors,$error);
		}
		
		//coming from this page
		if(count($_POST) > 0){
			$this->data = $_POST;
			
			$errors = $this->checkFormCredit();	
			
			if(count($errors) == 0){
				$this->Session->write('Checkout.ccinfo',$this->data);
				$this->redirect('/checkout/process');
				return;
			}
			
			$temp = $_POST;
			$temp['card_number'] = '';
			$this->Session->write('Checkout.ccinfo',$temp);
		//first time here or from index
		} else {
			$this->data = $this->Session->read('Checkout.ccinfo');
		}
		
		$info = $this->Session->read('Checkout.info');
	
		if(empty($info)){
			$this->redirect('/checkout/index/no_user_info');
		}
		
		$this->set('errors',$errors);
		$this->set('post',$this->data);
		
		$this->receipt = $this->Receipt->receipt;
		
		if($info['ship_state'] == 'NC'){
			$this->receipt->setTaxRate(0.075);
		} else {
			$this->receipt->setTaxRate(0);
		}
		
		$this->addAllCartProducts();
		
		$tax = $this->receipt->sumOfTaxableEntries();
		
		$before = $this->receipt->getBeforeSubEntries();
		
		$shipping = $this->getShipping();
		//$this->receipt->addEntry('product', $e->uniques['id'], $e->getUniqueId(),$pdetail, $e->qty, $name, $e->getUnitPrice(), $desc,null);
		$this->receipt->addEntry('shipping',98, 0, 0, 1, 'Shipping',$shipping, 'Shipping',null);
		
		$subtotal = $this->receipt->getSubTotal();
		$after = $this->receipt->getAfterSubEntries();
		
		$this->receipt->addEntry('tax', 99, 0, 0, 1, 'Tax', $tax, 'tax total');
		$taxes = $this->receipt->getTaxesTotaled();
		
		$total = $this->receipt->getTotal();
		
		$sizes = $this->Size->find('list',array('fields' => array('display')));
		$colors = $this->Color->find('list');
		
		$this->set(compact('info','before','subtotal','after','taxes','total','sizes','colors','errors'));
		$this->set('ccart',$this->Ccart);
		
		$this->render('index');
		
		return;
	}
	function process(){
		$t1 = $this->Session->read('Checkout.info');
		$t2 = $this->Session->read('Checkout.ccinfo');
		
		if(empty($t1)){
			$this->redirect('/checkout/index/no_user_info');
			return;
		} elseif(empty($t2)){
			$this->redirect('/checkout/finalize/no_credit_info');
		}
		$this->data = array_merge($t1,$t2);
		
		//if the cart is empty
		if(count($this->Ccart->getContents()) == 0){
			$this->redirect('/checkout/finalize/no_products');
			return;
		}
		
		$errors = $this->checkFormCredit();

		if(count($errors) > 0){
			$temp = current($errors);
			$this->redirect('/checkout/finalize/'.$temp->getName());
			return;
		}
		
		//create the receipt
		$this->receipt = $this->Receipt->receipt;
		if($this->data['ship_state'] == 'NC'){
			$this->receipt->setTaxRate(0.075);
		} else {
			$this->receipt->setTaxRate(0);
		}
		$this->addAllCartProducts();
		$shipping = $this->getShipping();
		$this->receipt->addEntry('shipping',98, 0, 0, 1, 'Shipping',$shipping, 'Shipping',null);
		$tax = $this->receipt->sumOfTaxableEntries();
		$this->receipt->addEntry('tax', 99, 0, 0, 1, 'Tax', $tax, 'tax total');
		
		//check inventory
		if(count($this->checkInventoryLevels()) > 0){
			$this->redirect('/checkout/index');
		}
		
		//attempt to process the card
		$response = $this->processCard();
		
		//clear the credit card data from session
		$this->Session->delete('Checkout.ccinfo');
		
		//success
		if($response['RESULT']==0){
			//save the receipt to the db
			//$this->index() should have been called during the processCard() call
			//this builds the receipt
			
			$this->Ccart->emptyCart();
			
			$data['Order'] = array(
				'user_id'=>$this->myuser['User']['id'],
				'tax'=>$this->receipt->sumOfTaxableEntries(),
				'shipping'=>$this->getShipping(),
				'handling'=>0.00,
				'total'=>$this->receipt->getTotal(),
				'receipt'=>serialize($this->receipt)
			);
			
			//success on the save
			if($this->Order->save($data)){
				//build the products data
				$sql = 'INSERT INTO `oinfos` (`order_id`,`pdetail_id`,`quantity`,`unitprice`) VALUES ';
				foreach($this->receipt->getContentsByType(array('product')) as $p){
					$sql .= "({$this->Order->id},{$p->pdetail},{$p->qty},{$p->priceUnit}),";
				}
				$sql = rtrim($sql,',');
				
				if(!$this->Order->query($sql)){
					$this->logFailure();
				}
			
				
				//reduce inventory
				foreach($this->receipt->getContentsByType(array('product')) as $p){
					$qty = $p->qty * 1;
					$pdetailId = $p->pdetail * 1;
					if($qty > 0 && $pdetailId > 0){
						$sql = "Update `pdetails` SET `inventory` = (`inventory` - $qty) WHERE `id` = $pdetailId LIMIT 1";
						$this->Pdetail->query($sql);
					}
				}
				
				$this->redirect('/checkout/complete/'.$this->Order->id);
			
			//failure
			} else {
				$this->logFailure();
				
				$this->redirect('/checkout/error/');
			}
			
		//error
		} else {
			
			$this->redirect('/checkout/finalize/credit_card_failure/'.urlencode($response['RESPMSG']));
			return;
		}
	}
	public function complete($orderId){
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-xlarge');
		
		$this->set('orderId',$orderId);
	}
	public function receipt($orderId){
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-xlarge');
		
		$data = $this->Order->find('first',array('conditions'=>array('Order.id'=>$orderId)));
		$errors = array();
		try{
			$this->receipt = unserialize($data['Order']['receipt']);
		}	
		catch(Exception $e){
			$this->redirect('/checkout/error/receipt_error');
		}
		
		if(!is_object($this->receipt)){
			$this->redirect('/checkout/error/receipt_error');
		}
		
		$tax = $this->receipt->sumOfTaxableEntries();
		$before = $this->receipt->getBeforeSubEntries();
		$after = $this->receipt->getAfterSubEntries();
		$total = $this->receipt->getTotal();
		
		//$this->layout = 'default';
		
		$pdetailIds = array();
		foreach($before as $e){
			if(!empty($e->pdetail)){
				array_push($pdetailIds, $e->pdetail);
			}
		}
		
		$details = array();
		if(count($pdetailIds) > 0){
			
			$info = $this->Pdetail->find('all',array(
						'conditions'=>array('Pdetail.id IN ('.implode(',',$pdetailIds).')'),
			));
			
			foreach($before as $e){
				//dont have enough product
				$color = 'Unknown';
				$size  = 'Unknown';
				$count = 'Unknown';
				
				foreach($info as $entry){
					//debug($entry);
					if($e->pdetail == $entry['Pdetail']['id']){
						$color = $entry['Color']['name'];
						$size  = $entry['Size']['display'];
						
						$details[$e->pdetail]['color'] = $color;
						$details[$e->pdetail]['size'] = $size;
					}
				}
			}
		}
				
		$this->set(compact('tax','before','after','total','details'));
	}
	
	private function getShipping(){
		return 3.95 + $this->receipt->getTotalCount(array('product'));
	}
	private function addAllCartProducts(){
		$this->receipt->reset();
		$entries = $this->Ccart->getContents();
		
		//cycle the cart entries
		foreach($entries as $e){
			$info = $e->getInfo();
			$name = $info['Product']['name'];
			$desc = $info['Product']['desc'];
			$pdetail = $e->uniques['pdetail'];
			$this->receipt->addEntry('product', $e->uniques['id'], $e->getUniqueId(),$pdetail, $e->qty, $name, $e->getUnitPrice(), $desc,null);
		}
	}
	
	private function checkFormBasic(){
		
		$error = array();
		
		//first check all bill data
		if(empty($this->data['bill_name'])) $error['bill_name'] = new MyError('no_bill_name');
		if(empty($this->data['bill_line_1'])) $error['bill_line_1'] = new MyError('no_bill_line_1');
		if(empty($this->data['bill_city'])) $error['bill_city'] = new MyError('no_bill_city');
		if(empty($this->data['bill_state'])) $error['bill_state'] = new MyError('no_bill_state');
		if(empty($this->data['bill_zip'])) $error['bill_zip'] = new MyError('no_bill_zip');
		if(!preg_match('/[0-9]{5}/',$this->data['bill_zip'])) $error['bill_zip'] = new MyError('invlid_zip_code');
		
		//shipping infor if different than billing
		if(empty($this->data['billing-cbox'])){
			if(empty($this->data['ship_name'])) $error['ship_name'] = new MyError('no_ship_name');
			if(empty($this->data['ship_line_1'])) $error['ship_line_1'] = new MyError('no_ship_line_1');
			if(empty($this->data['ship_city'])) $error['ship_city'] = new MyError('no_ship_city');
			if(empty($this->data['ship_state'])) $error['ship_state'] = new MyError('no_ship_state');
			if(empty($this->data['ship_zip'])) $error['ship_zip'] = new MyError('no_ship_zip');
			if(!preg_match('/[0-9]{5}/',$this->data['ship_zip'])) $error['ship_zip'] = new MyError('invlid_zip_code');
		}

		return $error;
	}
	
	private function checkFormCredit(){
		$error = array();
		
		//credit card information
		if(empty($this->data['card_number'])) $error['card_number'] = new MyError('no_card_number');
		if(empty($this->data['card_exp_mm'])) $error['card_exp_mm'] = new MyError('no_card_month');
		if(empty($this->data['card_exp_yy'])) $error['card_exp_yy'] = new MyError('no_card_year');
		if(empty($this->data['card_cvv'])) $error['card_cvv'] = new MyError('no_card_cvv');
		
		if(strtotime("{$this->data['card_exp_mm']}/01/{$this->data['card_exp_yy']}") < time()){
			$error['card_exp_mm'] = new MyError('bad_expiration');
			$error['card_exp_yy'] = new MyError('bad_expiration');
		}		

		return $error;
	}
	private function checkInventoryLevels(){
		$errors = array();
		
		//check inventory levels
		$pdetailIds = array();
		$entries = $this->Ccart->getContents();
		
		foreach($entries as $e){
			if(!empty($e->uniques['pdetail'])){
				array_push($pdetailIds, $e->uniques['pdetail']);
			}
		}
		
		if(count($pdetailIds) > 0){
			
			$info = $this->Pdetail->find('all',array(
						'conditions'=>array('Pdetail.id IN ('.implode(',',$pdetailIds).')'),
			));
			
			foreach($entries as $e){
				//dont have enough product
				$color = 'Unknown';
				$size  = 'Unknown';
				$count = 'Unknown';
				foreach($info as $entry){
					//debug($entry);
					if($e->uniques['pdetail'] == $entry['Pdetail']['id']){
						$color = $entry['Color']['name'];
						$size  = $entry['Size']['display'];
						$count = $entry['Pdetail']['inventory'];
					}
				}
				if($count < $e->qty){	
					$error = new MyError('inventory_level');
					$error->setMsg('Sorry, Inventory too low for "'.$entry['Product']['name'].
							'".<br/><span class="eline2">Available inventory (size: '.$size.', color: '.$color.') is <b>'.
							$count.'</b>.</span>');
					array_push($errors, $error);
				}
			}
		} else {
			array_push($errors,new MyError('no_products'));
		}
		return $errors;
	}
	
	function error($error){
		$this->layout = 'dynamic';
		$this->set('title','/img/header/attention.png');
		$this->set('classWidth','width-small');
		
		$errors = array(new MyError($error));
		$this->set('errors',$errors);
	}
	private function processCard(){
		//build the receipt
		$total = $this->receipt->getTotal();
		
		//get list of prouct ids from order
		$products = '';
		$del = '';
		foreach($this->receipt->getContentsByType(array('product')) as $entry){
			$products .= $del . $entry->id;
			$del = '-*-';
		}
		
		App::import('Lib','class_paypal');
		
		try{
			//NEW METHOD USING CURL
			$txn = new PayflowTransaction();
					
			$txn->environment = 'test'; //test or live
			
			//set up user/pass etc...
			$txn->PARTNER = 'verisign';
			$txn->USER = 'fcpackage';
			$txn->PWD = 'will1480';
			$txn->VENDOR = 'fcpackage';
			
			$txn->TENDER = 'C'; //sets to a cc transaction
			$txn->ACCT = $this->data['card_number']; //cc number
			$txn->TRXTYPE = 'S'; //txn type: sale
			
			$txn->COMMENT1 = 'FlyFoenix.com transaction';
			$txn->COMMENT2 = $products;
			
			$txn->AMT = $total*1.00; //amount: 1 dollar
			$txn->EXPDATE = $this->data['card_exp_mm'] . $this->data['card_exp_yy']; //4 digit expiration date
			
			$txn->COUNTRY = 'US';
			
			$result = $txn->process();
		}
		catch( TransactionDataException $tde ) {
			$msg = 'bad transaction data ' . $tde->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( InvalidCredentialsException $e ) {
			$msg = 'Invalid credentials';
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( InvalidResponseCodeException $irc ) {
			$msg = 'bad response code: ' . $irc->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( AVSException $avse ) {
			$msg = 'AVS error: ' . $avse->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( CVV2Exception $cvve ) {
			$msg = 'CVV2 error: ' . $cvve->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( FraudProtectionException $fpe ) {
			$msg = 'Fraud Protection error: ' . $fpe->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		catch( Exception $e ) {
			$msg = $e->getMessage();
			$this->redirect('/checkout/finalize/credit_processing_error/'.urlencode($msg));
		}
		
		return $result;
		
	}
	
	private function logFailure(){
		$this->log(date("D M j G:i:s T Y") . ' - Failed to Save order info - serialized receipt: '.serialize($this->receipt),'checkout');
				
		$this->Email->from    = 'FlyFoenix <admin@flyfoenix.com>';
		$this->Email->to      = 'Will Smelser <willsmelser@gmail.com>';
		$this->Email->subject = 'Error on customer checkout';
		$this->Email->send("Failed to save for user({$this->myuser['User']['id']},{$this->myuser['User']['email']}) on ".date("D M j G:i:s T Y"));
	}
}

class MyError {
	var $name = null;
	var $info = null; //type of errorTypes
	
	public function MyError($name) {
		$this->name = $name;
		$this->info = errorTypes::getType($name);
	}
	public function getName() {
		return $this->name;
	}
	public function getDisplayName(){
		return $this->info['name'];
	}
	public function getDOMid() {
		return $this->info['id'];
	}
	public function getMsg() {
		return $this->info['msg'];
	}
	public function setMsg($msg){
		$this->info['msg'] = $msg;
	}
	public function getJson() {
		return json_encode($this->info);
	}
	
}
class errorTypes {
	public static function getType($name) {
		$temp = str_replace('no_','',$name);
		$temp = str_replace('_',' ',$temp);
				
		switch($name) {
			case 'no_bill_name':
			case 'no_bill_line_1':
			case 'no_bill_city':
			case 'no_bill_state':
			case 'no_bill_zip':
			case 'no_ship_name':
			case 'no_ship_line_1':
			case 'no_ship_city':
			case 'no_ship_state':
			case 'no_ship_zip':
			case 'no_card_number':
			case 'no_card_month':
			case 'no_card_year':
			case 'no_card_cvv':
				return array(
					'msg'=>'Cannot be empty.',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'invlid_zip_code':
				return array(
					'msg'=>'Invalid zip code given.',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'bad_expiration':
				return array(
					'msg'=>'Invalid Expiration Date.',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'credit_card_failure':
				return array(
					'msg'=>'There was an issue processing the transaction.',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'inventory_level':
				return array(
					'msg'=>'Not enough inventory.',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'no_products':
				return array(
					'msg'=>'Please add items to your cart.  <br><span class="eline2">Use the find school button at upper right hand corner to locate a sale.</span>',
					'id'=>$name,
					'context'=>'checkout',
					'name'=>ucwords($temp)
				);
			case 'receipt_error':
				return array(
					'msg'=>'Unable to generate a receipt.',
					'id'=>$name,
					'context'=>'receipt',
					'name'=>ucwords($temp)
				);
			case 'no_user_info':
				return array(
					'msg'=>'No user data was available. <br/><span class="eline2">Please re-enter your information.</span>',
					'id'=>$name,
					'context'=>'receipt',
					'name'=>ucwords($temp)
				);
			case 'no_credit_info':
				return array(
					'msg'=>'No credit card data was available. <br/><span class="eline2">Please re-enter your information.</span>',
					'id'=>$name,
					'context'=>'receipt',
					'name'=>ucwords($temp)
				);
			case 'credit_processing_error':
				return array(
					'msg'=>'Error processing card.  Credit gateway failure.',
					'id'=>$name,
					'context'=>'receipt',
					'name'=>ucwords($temp)
				);
			default:
				return array(
					'msg'=>'Unknown Error',
					'id'=>'error-general',
					'context'=>'unknown',
					'name'=>'Unknown Error'
				);
		}
	}
}
class FuseException extends Exception{
	
}
?>