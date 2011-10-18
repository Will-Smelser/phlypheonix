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
	var $uses = array('User','Product', 'Pdetail', 'Sale', 'Saleuser', 'School','Accessory');
	//var $components = array('AuthorizeNet');
	//var $components = array('Cfacebook');
	var $helpers = array('Hfacebook','Sizer');

	function beforeFilter() {
	    parent::beforeFilter();

	    $this->layout = 'shop';
	    
	    $this->Auth->allow('*');
	}

	function index() {
		$this->redirect(array('controller' => 'shop', 'action' => 'landing'));
	}


	private function addCarouselImages(){
		$this->loadModel('Pimage');
		//get 50 random images out of last 200 entries
        $pimages = $this->Pimage->find('list',array('limit'=>200,'conditions'=>array('name'=>'front'),'fields'=>array('image'),'order'=>array('id DESC')));
        $temp = array();
        $temp2= array();
        foreach($pimages as $key=>$entry){
        	array_push($temp, urlencode($entry));
        }
        //filter only 50
        $i = 0;
        while($i < 500 && count($temp2) < 50){
        	$rand = rand(0, count($temp));
        	array_push($temp2,array_slice($temp, $rand, 1));
        	$i++;
        }
        $this->set('pimages',$temp2);
	}
	//no school for user or could not find the school
	function noschool($info='user'){

		$this->layout = 'dynamic';
		$classWidth = 'width-small';

		$title = '/img/noschool/flyfoenix_noschool_comingsoon.png';

		$this->set(compact('title','classWidth'));
		$this->set('schools',$this->School->find('all'));

		//no school for current user
		if($info == 'user'){

		//could not find the school
		} else if($info=='locate') {

		//should not go here
		} else {

		}
	}

	function findschool($info='user'){
		$this->layout = 'dynamic';
		$classWidth = 'width-small';

		$title = '/img/header/selectschool.png';

		$this->set(compact('title','classWidth'));
		$this->set('schools',$this->School->find('all'));
	}

	//there was no sale for schools
	function nosale() {
		$this->layout = 'dynamic';
		$classWidth = 'width-small';

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

		$this->set(compact('schools','title','classWidth'));
	}

	function expiredsale($saleId=null,$userid=null,$school=null,$sex=null){
		$this->layout = 'dynamic';
		$title = '/img/header/expired.png';
		$classWidth = 'width-medium';
		$this->set(compact('title','classWidth'));

		$shopUrl = "/shop/main/$school/$sex/$saleId";

		$extendToken = md5(time());
		$this->Session->write('expiredsale.token',$extendToken);

		$sale = $saleId;

		$this->set(compact('sale','school','sex','extendToken','shopUrl'));

		//$this->set('schools',$this->School->find('all'));
		$this->set('schools',$this->School->getSchoolsWithSale());

		//sex
		if(empty($sex)) $sex = $this->myuser['User']['sex'];
		
		//no informaiton on what sale were looking for
		//really should not end up here
		if(empty($saleId)){
			$this->redirect('nosale');
		//give user chance to share with friends to extend the sale
		} else {
			$sale = $this->Sale->findById($saleId);
			
			$sale = $this->filterSaleBySex($sale,$sex);
			
			if(empty($sale['Product'])){
				$this->redirect('nosale');
			}
			
			$ids = array();
			foreach($sale['Product'] as $entry){
				array_push($ids, $entry['id']);
			}

			if(count($ids) == 0){
				$this->redirect('nosale');
			}
			
			$images = $this->Product->Pimage->find('list',array(
				'fields' => array(
					'name','image','id'
				),
				'conditions'=>array(
					'Pimage.product_id IN (' . implode(',',$ids) . ')',
				),
				'order'=>array('id ASC')
			));
			
			$temp = array();
			$shareImage = null; 
			foreach($images as $id=>$arr){
				$name = key($arr);
				$img = current($arr);
				
				if(preg_match('/front/i',$name) && empty($shareImage)){
					$shareImage = $img;
				}
				$temp[$id] = $img;
			}
			
			$this->set('images',$temp);
			$this->set('shareImage',$shareImage);

		}
	}

	function extendtime($sale,$token=null){
		$this->layout = 'ajax';
		//if($token != $this->Session->read('expiredsale.token')) return;

		//just easier to use sql
		$sale = $sale * 1; //prevent injection
		$time = time() - Configure::read('config.sales.length') + (24 * 3600); //only add 24 hours
		$userid = $this->myuser['User']['id'];
		$sql = "UPDATE `saleusers` SET created = $time WHERE `sale_id` = $sale AND `user_id` = $userid LIMIT 1";
		$this->User->query($sql);

		$this->render('ajax');
	}

	function extendtime2($sale,$school=null){
		$sale = $sale * 1; //prevent injection
		$time = time() - Configure::read('config.sales.length') + (24 * 3600); //only add 24 hours
		$userid = $this->myuser['User']['id'];
		$sql = "UPDATE `saleusers` SET created = $time WHERE `sale_id` = $sale AND `user_id` = $userid LIMIT 1";
		$this->User->query($sql);

		if(!empty($school)){
			$this->redirect("/shop/main/$school");
		} else {
			$this->redirect("/shop/main");
		}
		return;
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
		
		$shareImage = null;
		foreach($product['Pimage'] as $entry){
			if(preg_match('/front/i',$entry['name'])){
				$shareImage = $entry['image'];
				//$shareImage = 'http://www.flyfoenix.com/img/referral.jpg';
				break;
			}
		}
		
		$this->set(compact('school','sex','sale','product','imageIndex','shareImage'));
	}

	function view($product=null){
		//$this->layout = 'default';
		$this->layout = 'dynamic';
		$title = '/img/header/memberpricing.png';
		$classWidth = 'width-medium';
		$this->set(compact('title','classWidth'));
		
		//debug($_POST);
		
		//get the product data
		//no school given, default to osu
		if(empty($product) && !isset($_POST['product'])){
			$product = $this->Product->find('first',array('conditions'=>array('school_id'=>1)));
			//debug(__LINE__);
			$this->redirect('/shop/view/'.$product['Product']['id']);
			
		//posted from forst the school to load
		} elseif(empty($product) && isset($_POST['product'])) {
			$product = $this->Product->findById($_POST['product']);
			
			$this->redirect('/shop/view/'.$product['Product']['id']);
			
		//url gave us a school
		} else{
			$product = $this->Product->findById($product);	
		}
		
		//find all other products for this sex and sale
		$psex = $product['Product']['sex'];
		$sale = $product['Sale'][0]['id'];
		$saleData = $this->Sale->findById($sale);
		
		//find all accessories as well
		$accessories = $this->getAccessories($psex,$product['School']['Color'][0]['id']);
		//cleanup uneeded data
		unset($accessories['swatches']);
		unset($accessories['swatch']);
		
		//find all pics for the images above
		$pids = array();
		foreach($saleData['Product'] as $p){array_push($pids,$p['id']);}
		//$images = $this->Product->query('SELECT product_id,image FROM pimages AS Pimage WHERE product_id IN ('.implode(',',$pids).') AND name LIKE "%front%"');
		//debug($images);exit;
		$images = $this->Product->Pimage->find('list',
			array('conditions'=>array('product_id IN ('.implode(',',$pids).')','name LIKE "%front%"'),'fields'=>array('product_id','image')));
		
		//navigation for schools
		//gotta get a list of sales and their schools
		$sql = 'SELECT `School`.*,`Sale`.*,`Product`.id FROM `sales` AS `Sale` ' .

				'LEFT JOIN `sales_products` ON `Sale`.`id` = `sales_products`.`sale_id` ' .
				'LEFT JOIN `products` AS `Product` ON `sales_products`.`product_id` = `Product`.`id` '.
				'LEFT JOIN `schools` AS `School` ON `Product`.school_id = `School`.id ' .

				'WHERE `Sale`.`starts` <= UNIX_TIMESTAMP() ' .
				'AND `Sale`.`ends` >= UNIX_TIMESTAMP() ' . 
				'AND `Sale`.`active` = 1 ' .
				'GROUP BY `School`.id ' .
				'ORDER BY `School`.`long` ASC';

		$schools = $this->Sale->query($sql);
		
		//non-essential variable, but keeps quiet errors
		$imageIndex = 0;
		
		//css files
		$cssFiles = array('/css/viewsingle.css');
		
		//bottom js scripts
		$jsFilesBottom = array('/js/jquery.miozoom.js','/js/viewsingle.js');
		
		$shareImage = null;
		foreach($product['Pimage'] as $entry){
			if(preg_match('/front/i',$entry['name'])){
				$shareImage = $entry['image'];
				//$shareImage = 'http://www.flyfoenix.com/img/referral.jpg';
				break;
			}
		}
		
		$this->set(compact('product','imageIndex','jsFilesBottom','cssFiles','saleData','images','accessories','schools','shareImage'));
		
		$this->set('loggedin',false);
	}
	
	//TODO implament expired display
	//main page for shopping
	//imageIndex is the product image to show
	function main ($school=null, $sex=null, $sale = null, $product = null, $expired=false) {
		
		//can be submitted from no javascript find school form or landing form
		if(isset($_POST['school-id'])){
			$school = $_POST['school-id'];
			$this->Session->write('Anonymous.school',$school);
		}
		
		if(isset($_POST['sex'])){
			$sex = $_POST['sex'];
			$this->Session->write('Anonymous.sex',$sex);
		}
		
		//$this->layout = 'default';
		$imageIndex = 0;

		//fix data if needed
		$this->fixVars($product, $school, $sex, $sale, $expired);

		$products = $this->getProductsDetails($sale);

		//get left and right products
		$productRight= array();
		$this->getPagination($products,$product,$productRight, $index);

		$this->Saleuser->addUserSaleEndDate($this->myuser, $sale['Sale']['id']);

		$this->addSaleEnds($this->myuser, $sale);

		//check the found sale has not expired for the user
		//$sale['Sale']['UserSaleEnds']  is added to $sale in addSaleEnds call
		if($sale['Sale']['UserSaleEnds'] < time() && !Configure::read('config.testing')) {
			$this->redirect(array('action'=>'expiredsale/'.$sale['Sale']['id'].'/'.$this->myuser['User']['id'].'/'.$school['id'].'/'.$sex));
		}

		$mfgs = $this->Product->Manufacturer->find('list',array('fields'=>array('id','image')));
		$products = array_merge(array($product['Product']), $productRight);

		//lets remove the first time here stuff
		$this->User->Prompt->removeFirstTimePrompt($this->myuser['User']['id']);
		
		//determine the color for the current school
		$sql = 'SELECT school_id, color_id FROM `schools_colors` WHERE school_id = ' . $school['id'] . ' ORDER BY `id` ASC';
		$schoolColors = $this->Product->query($sql);

		//build navigation links for no-javascript
		$currentLink = "/shop/main/{$school['id']}/$sex/{$sale['Sale']['id']}/{$products[0]['id']}"; 
		if(!$this->Session->check('shop.nav.sale') 
			|| $this->Session->read('shop.nav.sale') != $sale['Sale']['id']){
			$temp = array();
			foreach($products as $p){
				$link = "/shop/main/{$school['id']}/$sex/{$sale['Sale']['id']}/{$p['id']}";
				array_push($temp, $link);
			}
			$this->Session->write('shop.nav.links',$temp);
			$this->Session->write('shop.nav.sale',$sale['Sale']['id']);
		} 
		$found = false;
		$prev = $next = array();
		foreach($this->Session->read('shop.nav.links') as $link){
			if($link == $currentLink){
				$found = true;
			}else if(!$found){
				array_push($prev, $link);
			} else {
				array_push($next, $link);
			}
		}
		$nextLink = (isset($next[0])) ? $next[0] : "/accessories/index/{$school['id']}/$sex";
		$prevLink = (isset($prev[0])) ? $prev[0] : '#';
		$this->Session->write('shop.nav.next',$nextLink);
		$this->Session->write('shop.nav.prev',$prevLink);
		$this->Session->write('shop.nav.curr',$currentLink);
		$this->set(compact('nextLink','prevLink','currentLink'));

		foreach($products as $k=>$p) {
			$products[$k]['mfgimage'] = $mfgs[$products[$k]['manufacturer_id']];
			foreach($p as $key=>$entry){
				if(!in_array($key,array('id','pricetag'))){
					unset($products[$k][$key]);
				}
			}
		}

		//$schools = $this->School->find('all',array('recursive'=>0));
		$schools = $this->School->getSchoolsWithSale();
		$fbcommentId = "{$school['id']}-{$sex}-{$sale['Sale']['id']}-{$product['Product']['id']}";

		$shareImage = null;
		foreach($product['Pimage'] as $entry){
			if(preg_match('/front/i',$entry['name'])){
				$shareImage = $entry['image'];
				//$shareImage = 'http://www.flyfoenix.com/img/referral.jpg';
				break;
			}
		}
		
		$this->set(compact('school','schools','sex','sale','product','products','productRight','imageIndex','fbcommentId','schoolColors','shareImage'));

		//accessories
		$adata = (!empty($schoolColors)) ? $this->getAccessories($sex,$schoolColors[0]['schools_colors']['color_id']) : array();

		//add any flash messages
		$flash = (strlen($this->Session->read('Message.flash.message')) > 0) ? $this->Session->read('Message.flash.message') : '';
		
		//delete the flash message
		$this->Session->delete('Message.flash');
		
		//if the user is not logged in, then prompt them with the login
		$showFirstTime = false;
		if(!$this->Auth->user() && !$this->Session->check('Anonymous.firstpage')){
			App::import('Component','Cfacebook');
			$Cfacebook = new CfacebookComponent();
			$this->Cfacebook = $Cfacebook->initialize(&$this);
			
			
			$showFirstTime = true;
			$this->Session->write('Anonymous.firstpage',true);
			
			$email = '';
			$registering = false;
			if($this->Session->check('registerData')){
				$registering = true;
				$postdata = $this->Session->read('registerData');
				$email = (isset($postdata['User']['email'])) ? $postdata['User']['email'] : '';
				$sex = (isset($postdata['User']['sex'])) ? $postdata['User']['sex'] : $sex;
				$school['id'] = (isset($postdata['School']['School']['id'])) ? $postdata['School']['School']['id'] : $school['id']; 	
			}
			
			$register = "
			
			<div class='big title' style='color:#333'>Pernsonalized Shopping</div>
			<p>FlyFoenix can remember your preferences for when your return.
			</p>
			
			<form id='register-pop' method='post' action='/users/register'>
				
				
				<div id='fb1' style='float:right;text-align:right;'>
          			<span style='font-size:12px;padding-right:4px'>Save w/ Facebook</span><br />
          			
			        <input id='fb-reg' style='padding-left:45px;background-position: left -60px;' type='button' value='Save ' class='big green btn fb_button' />
			        
          		</div><!-- End fb1 -->
				
          		 <div style='float:right;font-size:12px;padding:25px 10px 0px 10px'><i>- OR -</i></div>
          		
          		<div style='float:right'>
				<span style='font-size:12px'>&nbsp;</span><br />
				<input type='submit' class='big green btn' value='Save' />
				</div>
          		
				<input id='reg-sale' type='hidden' value='$sale' name='data[Sale][Sale][id]' />
				<input id='reg-school' type='hidden' value='{$school['id']}' name='data[School][School][id]' />
				<input id='reg-sex' type='hidden' value='$sex' name='data[User][sex]' />
				
				<div style='display:inline-block;position:relative;top:5px'>
				<span style='font-size:12px;'>Email</span><br/>
				<input id='email' type='text' style='width:150px;background-color:#FFF' class='input' name='data[User][email]' value='$email' />
				</div>
				
			</form>
			
			";
			
			if(!$this->Session->check('Anonymous.school')){
				$mselected = (strtolower($sex) == 'm') ? 'checked' : '';
				$fselected = (strtolower($sex) != 'm') ? 'checked' : '';
				
				$html = "
				<div id='reg-wrapper' style='position:relative;width:400px;height:140px;overflow:hidden;'>
					<div id='reg-inner-wrapper' style='position:relative;left:0px;width:900px'>
						<div id='reg-school-wrapper' style='width:400px;position:absolute;left:0px;top:0px;'>
						<div class='big title' style='color:#333'>Your preferred School and Gender?</div>
						<p>
						<span class='six'>Gender&nbsp;&nbsp;</span><br />
						<label for='reg-male'><input name='sex' id='reg-male' type='radio' value='M' $mselected />&nbsp;&nbsp;Male</label>&nbsp;&nbsp;&nbsp;&nbsp; 
						<label for='reg-female'><input name='sex' id='reg-female' type='radio' value='F' $fselected />&nbsp;&nbsp;Female</label>
						</p>
						<!-- The onclick is set in shop layout //-->
						<input id='reg-cont' type='button' value='Continue' class='big green btn' style='float:right;margin-top:10px' />
						<p>
							<span class='six'>School&nbsp;&nbsp;</span><br />
			        		<select class='' name='school-id'  style='width:200px;background-color:#FFF'>
								";
				//make school select options
				foreach($schools as $s){
					$selected = ($s['School']['id'] == $school['id']) ? 'selected' : '';
					$html .= "<option value='{$s['School']['id']}' $selected >{$s['School']['long']}</option>";
				}
				$html .= "</select>
						</p>
						</div>
						
						<div id='reg-user-wrapper' style='width:400px;position:absolute;left:410px;top:0px;padding:0px;'>
						$register
						</div>
					</div>
				</div>
				";
				$flash .= $html;
			} else {
				$flash .= $register;
			}
			
		}
		$breaks = array("\r\n", "\n", "\r", "\t");
		$flash = str_replace($breaks,'',$flash);
		$flash = str_replace('\'','\\\'',$flash);
		
		
		//set the data
		$this->set(compact('adata','colors','swatches','images','pdetails','flash','showFirstTime'));
		
	}	

	/**
	 * Will return all products that are accessories.
	 * in addition will return the swatches.
	 */
	private function getAccessories($sex,$color){
		$data = $this->Product->find('list',
			array(
				'conditions'=>array('controller'=>'accessories','sex'=>$sex)
			)
		);

		if(empty($data)){
			return null;
		}

		$swatch = array();
		foreach($data as $key=>$entry){
			$info = $this->Accessory->getProduct($key,$color);

			if(preg_match('/swatch/i',$info['Product']['name'])){
				$swatch = $info;
				unset($data[$key]);
			} elseif(!empty($info)) {
				$data[$key] = $info;
			} else {
				unset($data[$key]);
			}

		}

		//add the image for the swatch
		$sproducts = $this->Product->find('list',array(
			'conditions'=>array(
				'name LIKE '=>'%swatch%'
			)
		));
		//get all the swatch images
		$swatches = $this->Product->Pimage->find('all',array(
			'conditions'=>array('product_id IN ('.implode(array_keys($sproducts),',').')')
		));

		return array('swatches'=>$swatches,'swatch'=>$swatch,'products'=>$data);
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
		} else if(strtoupper($sex) == 'M' || strtoupper($sex == 'F')) {
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
				//'AND `Product`.`sex` = "'.$sex.'" LIMIT 1';


			$saleData = $this->Sale->query($sql);
			
			//prevent recursion
			if(!empty($saleData)){
				if(strtolower($saleData[0]['Product']['sex']) != strtolower($sex)){
					$temp = (strtolower($sex) == 'm') ? 'men.' : 'women.';
					$this->Session->setFlash('<img src="/img/icons/error.png" />&nbsp;Could not locate a sale for '.$temp);
				}
				$this->redirect("/shop/main/{$school['id']}/{$saleData[0]['Product']['sex']}/{$saleData[0]['Sale']['id']}");
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
				//filter out other sex
				$saleData = $this->filterSaleBySex($saleData,$sex);
				
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
	
	private function filterSaleBySex($saleData, $sex){
		if(empty($saleData['Product'])) return $saleData;
		
		//filter out other sex
		$temp['Sale'] = $saleData['Sale'];
		$temp['Product'] = array();
		foreach($saleData['Product'] as $key=>$data){
			if(strtolower($data['sex']) == strtolower($sex)){
				array_push($temp['Product'],$data);
			} 
		}
		return $temp;
	}
}