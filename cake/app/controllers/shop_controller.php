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
	var $uses = array('User','Product', 'Pdetail', 'Sale', 'School','Accessory');
	var $components = array('AuthorizeNet');
	var $helpers = array('Hfacebook','Sizer');
	
	function beforeFilter() {
	    parent::beforeFilter();
	    
	    $this->layout = 'shop';
	}
	
	function index() {
		$this->redirect(array('controller' => 'shop', 'action' => 'main'));
	}
	
	//no school for user or could not find the school
	function noschool($info='user'){
		
		$this->layout = 'dynamic';
		
		$title = '/img/noschool/flyfoenix_noschool_comingsoon.png';
		
		$this->set('title',$title);
		$this->set('schools',$this->School->find('all',array('order'=>'name ASC')));
		
		//no school for current user
		if($info == 'user'){
			
		//could not find the school
		} else if($info=='locate') {
			
		//should not go here
		} else {
			
		}
	}
		
	//there was no sale for schools
	function nosale() {
		$this->layout = 'dynamic';
		
		//gotta get a list of sales and their schools
		$sql = 'SELECT `School`.*,`Sale`.* FROM `sales` AS `Sale` ' .
				
				'LEFT JOIN `sales_products` ON `Sale`.`id` = `sales_products`.`sale_id` ' .
				'LEFT JOIN `products` AS `Product` ON `sales_products`.`product_id` = `Product`.`id` '.
				'LEFT JOIN `schools` AS `School` ON `Product`.school_id = `School`.id ' .
				
				'WHERE `Sale`.`starts` <= ' . time() . ' ' .
				'AND `Sale`.`ends` >= ' . time() . ' ' . 
				'AND `Sale`.`active` = 1 ' .
				'GROUP BY `School`.id ' .
				'ORDER BY `School`.`name` ASC';
		
		$schools = $this->Sale->query($sql);
		
		$title = '/img/noschool/flyfoenix_noschool_comingsoon.png';				
		
		$this->set(compact('schools','title'));
	}
	
	function expiredsale($saleId=null){
		//no informaiton on what sale were looking for
		//really should not end up here
		if(empty($saleId)){
			
		//give user chance to share with friends to extend the sale
		} else {
			
		}
	}
	
	//no product available
	function noproduct(){
		
	}
	
	//the viewer dynamically loads pages from this
	function product($school=null, $sex=null, $sale = null, $product = null){
		$imageIndex = 0;
		
		$this->layout = 'ajax';
		
		//fix data if needed
		$this->fixVars($product, $school, $sex, $sale, $expired);
		
		$productRight = array();
		$products = $this->getProductsDetails($sale);
		$this->getPagination($products,$product,$productRight, $index);
		
		$this->set(compact('school','sex','sale','product','imageIndex'));
	}
	
	//TODO implament expired display
	//main page for shopping
	//imageIndex is the product image to show
	function main ($school=null, $sex=null, $sale = null, $product = null, $expired=false) {
		//$this->layout = 'default';
		$imageIndex = 0;
		
		//fix data if needed
		$this->fixVars($product, $school, $sex, $sale, $expired);
		
		$products = $this->getProductsDetails($sale);
		
		//get left and right products
		$productRight= array();
		$this->getPagination($products,$product,$productRight, $index);
		
		$this->Sale->Saleuser->addUserSaleEndDate($this->myuser, $sale['Sale']['id']);

		$this->addSaleEnds($this->myuser, $sale);
		
		//check the found sale has not expired for the user
		//$sale['Sale']['UserSaleEnds']  is added to $sale in addSaleEnds call
		if($sale['Sale']['UserSaleEnds'] < time() && !Configure::read('config.testing')) {
			$this->redirect(array('action'=>'expiredsale/'.$sale['Sale']['id']));
		}
		
		$mfgs = $this->Product->Manufacturer->find('list',array('fields'=>array('id','image')));
		$products = array_merge(array($product['Product']), $productRight);
		
		foreach($products as $k=>$p) {
			$products[$k]['mfgimage'] = $mfgs[$products[$k]['manufacturer_id']];
			foreach($p as $key=>$entry){
				if(!in_array($key,array('id','pricetag'))){
					unset($products[$k][$key]);
				}
			}
		}
		
		$schools = $this->School->find('all',array('recursive'=>0));
		$fbcommentId = "{$school['id']}-{$sex}-{$sale['Sale']['id']}-{$product['Product']['id']}";
		
		$this->set(compact('school','schools','sex','sale','product','products','productRight','imageIndex','fbcommentId'));
		
		//used for accessories portion
		$data = $this->Accessory->getData($school['id'],$sex);
		
		//filter the products by color...look for the swatch
		$colors = array();
		$swatches = array();
		$cids = array();
		$pids = array();
		$pdetails = array();
		$images = array();
		if(!empty($data)){
			
			$this->Accessory->aggregateData($data, $swatches, $colors, $pids, $cids);
			$images = $this->Accessory->aggregateImages($pids, $cids);
			$pdetails = $this->Accessory->getPdetails($this->Product->Pdetail,$pids);
			
			
		}
		
		//set the data
		$this->set(compact('data','colors','swatches','images','pdetails'));
	}	
	
	private function fixVars(&$product, &$school, &$sex, &$sale, &$expired){
		
		//fix data if needed
		$school   = $this->getSchool($school);
		$sex      = $this->getSex($sex);
		$sale     = $this->getSale($sale, $sex, $school);
		$product  = $this->getProduct($product, $sale, $sex, $school);
	}
	
	//set the pagination and move detailed product data into $product
	private function getPagination($products,&$product,&$productRight, &$index){
		$id = $product['id'];
		$temp = null;
		
		
		foreach($products as $p) {
			if($p['Product']['id'] == $id){
				$temp = $p;
			} else {
				array_push($productRight, $p['Product']);
			}
		}
		
		$product = $temp;
		
		return;
	}
	
	private function addSaleEnds(&$myuser, &$sale) {
		
		foreach($myuser['Saleuser'] as $entry) {

			if($entry['sale_id'] == $sale['Sale']['id']){
				$time = Configure::read('config.sales.length') + $entry['created'];
				$sale['Sale']['UserSaleEnds'] = $time;
				return;
			}
		}
	}
	
	private function getProductsDetails(&$sale){
		$ids = array();
		foreach($sale['Product'] as $p){
			array_push($ids, $p['id']);
		}
		$result = $this->Product->find('all',array('conditions'=>array('Product.id IN ('.implode(',',$ids).')')));
		if(!$result) {
			$this->redirect(array('action'=>'noproduct'));
		}
				
		return $result;
	}
	
	/**
	 * Attempt to figure out what school to load if none was given
	 * 
	 * @param integer $schoolId The id of the school or null
	 */
	private function getSchool($schoolId) {
		
		//facebook users dont get a school, so we have to do this
		if(!isset($this->myuser['School'])){
			$this->myuser['School'] = array();
		}
		
		//specific school is requested
		if(!empty($schoolId)){
			
			//check if the user has the school data already
			foreach($this->myuser['School'] as $s) {
				//this is the school we are looking for
				if($s['id'] == $schoolId){
					return $s;
				}
			}
			
			//if here, then we need to query the school
			$school = $this->School->findById($schoolId);
			
			//failed query for school
			if(!$school) {
				$this->redirect(array('action'=>'noschool/locate'));
				return false;
			} else {
				return $school['School'];
			}
		//no school and user does not have a school
		} else if(empty($schoolId) && count($this->myuser['School']) == 0){
			$this->redirect(array('action'=>'noschool/user'));
			
		//user has a school -- should have a favorite then
		}else if(count($this->myuser['School']) > 0){
			$favorite = $this->myuser['User']['school_id'];
			
			//cycle schools looking for favorite
			foreach($this->myuser['School'] as $s) {
				//this is the school we are looking for
				if($s['id'] == $favorite){
					return $s;
				}
			}
			
			//lets update the favorite school
			$this->User->updateSchoolFavorite($this->myuser,$this->myuser['School'][0]['id']); 
			
			//no favorite found, lets just return the first school
			return $this->myuser['School'][0];
			
			
		//user has school and no specific school requested
		} else {
			$this->redirect(array('action'=>'noschool/locate'));
		}
		
	}
	
	/**
	 * Attempt to fix the sex if necessary
	 *
	 * @param unknown_type $sex
	 */
	private function getSex($sex){
		//no sex given, but user does have sex
		if(!empty($this->myuser['User']['sex']) && empty($sex)) {
			return $this->myuser['User']['sex'];
		//valid sex
		} else if($sex == 'M' || $sex == 'F') {
			return $sex;
		//default to F
		} else {
			return 'F';
		}
	}
	
	/**
	 * Forwards users to correct url based on their input, or just gets the valid
	 * sale data.
	 * 
	 * @param integer $saleId The sale id to lookup
	 * @param character $sex valid reference to sex
	 * @param object $school An array representing the school model
	 */
	private function getSale($saleId, &$sex, &$school) {
		
		//we dont have a sale id to lookup on
		if(empty($saleId)) {
			//first check if user has any sales already available to them
			$ids = array();
			if(count($this->myuser['Saleuser']) > 0){
				
				foreach($this->myuser['Saleuser'] as $suser) {
					array_push($ids, $suser['id']);
				}
				
				//lookup the sale ids
				$usales = $this->Sale->find('all',array(
					'conditions'=>array(
						'Sale.id IN ('.implode(',',$ids).')',
						'Sale.ends >= '.time(),
						'Sale.starts <= '.time(),
						'Sale.active = 1',
					)
				));
				
				//try and match sex		
				foreach($usales as $s) {
					if($s['Product'][0]['sex'] == $sex && $s['Product'][0]['school_id'] == $school['id']) {
						//redirect to fully qualified url
						$this->redirect(array('action'=>"main/{$school['id']}/{$s['Product'][0]['sex']}/{$s['Sale']['id']}"));
						return;
					} 
				}
				
			}
				
			//could not match on users current sales
			$order = ($sex == 'M') ? 'DESC' : 'ASC'; //sort by sex
			
			//sql to find valid sales for the given school
			$sql = 'SELECT * FROM `sales` AS `Sale` LEFT JOIN `sales_products` ON `Sale`.`id` = `sales_products`.`sale_id` '.
				'LEFT JOIN `products` AS `Product` ON `sales_products`.`product_id` = `Product`.`id` '.
				'WHERE `Product`.`school_id` = ' . $school['id'] . ' AND `Sale`.`starts` <= ' . time() . ' ' .
					'AND `Sale`.`ends` >= ' . time() . ' AND `Sale`.`active` = 1 ' .
				'ORDER BY `Product`.`sex` '.$order . ' LIMIT 1';
			
			
			$saleData = $this->Sale->query($sql);
			
			//prevent recursion
			if(!empty($saleData)){
				$this->redirect(array('action'=>"main/{$school['id']}/{$saleData[0]['Product']['sex']}/{$saleData[0]['Sale']['id']}"));
			}
				
		//lookup the requested sale
		} else {
			$saleData = $this->Sale->find('first',array(
				'conditions'=>array(
					'Sale.id = '.$saleId,
					'Sale.ends >= '.time(),
					'Sale.starts <= '.time(),
					'Sale.active = 1',
				)
			));
			
			if(!empty($saleData)){
				//verify the sex requested matched
				if($saleData['Product'][0]['sex'] == $sex){
					return $saleData;
				//sex did not match...redirect to fully qualified url
				} else {
					$this->redirect(array('action'=>"main/{$school['id']}/{$saleData['Product'][0]['sex']}/{$saleId}"));
				}
			}
		}
		
		//no luck just send to error page
		$this->redirect(array('action'=>'nosale'));
		return false;
	}
	
	//get the product
	private function getProduct($product, &$sale, &$sex, &$school){
		//no product given
		if(empty($product)) {
			if(count($sale['Product']) > 0) {
				return $sale['Product'][0];
			}
		//product number requested
		} else {
			//look for this product
			foreach($sale['Product'] as $p) {
				if($p['id'] == $product) {
					return $p;
				}
			}
			//forward to first product
			$this->redirect(array('action'=>"main/{$school['id']}/{$sex}/{$sale['Sale']['id']}/{$sale['Product'][0]['id']}"));
			return;
		}
		//no product found
		$this->redirect(array('action'=>'noproduct'));
		return;
	}
}
