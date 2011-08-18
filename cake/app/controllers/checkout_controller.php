<?php
class CheckoutController extends AppController {
	
	var $components = array('Receipt');
	
	var $receipt = null;
	
	public function index(){
		$this->receipt = $this->Receipt->receipt;
		
		$this->receipt->setTaxRate(.07);
		
		$this->receipt->addEntry('product', 1, 'test', 1.55, 'some description', 2.25);
		$this->receipt->addEntry('product', 2, 'test', 1.05, 'some description2', 2.25);
		$this->receipt->addEntry('product', 3, 'test', 5.50, 'some description3', 2.25);
		
		$this->receipt->addEntry('coupon', 99, 'a coupon', -5.00, 'some discount', 2.00 );
		
		$tax = $this->receipt->sumOfTaxableEntries();
		$this->receipt->addEntry('tax', 99, 'the tax', $tax, 'tax total');
		
		debug($this->receipt);
		//debug($this->receipt->)
		debug($this->receipt->getBeforeSubEntries());
		debug($this->receipt->getAfterSubEntries());
		exit;
	}
	
}

?>