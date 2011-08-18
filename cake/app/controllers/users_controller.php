<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Captcha','Email','AuthorizeNet','Session','Cfacebook');
	var $uses = array('User','School');
	var $helpers = array('Session','Form', 'Html','Javascript','Hfacebook');
	
	
	function beforeFilter() {
	    parent::beforeFilter(); 
	    
	    $this->Auth->allow(array(/*'register','register_complete',*/'recover','recover_complete','captcha_image','login','logout','sign_up','error_create'));
	    
	    //user data
		$user = $this->Auth->user();
		$user = $this->User->read(null, $user['User']['id']);
		$this->myuser = $user;
		$this->set('myuser',$this->myuser);
		
		$loggedin = ($this->Auth->user('id') != false);
		$this->set('loggedin',$loggedin);
		
	}
	
	function index() {
		if (!$this->Session->read('Auth.User')) {
			$this->redirect(array('action'=>'login'));
			return;
		}
		
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function login(){
		$this->layout = 'landing';
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			
		}
	}
	
	function test($id=0){
		//$this->Cart->emptyCart();
		
		$this->Cart->add(1,5);
		//$this->Cart->remove(1,2);
		$temp = $this->Cart->getProductUnitPrice(1);
		debug(CartUtils::formatMoneyUS($temp));
		debug($this->Cart->getContents());
	}
	
	function logout(){
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			
			//set the password
			if(empty($this->data['User']['password'])) {
				$this->data['User']['password'] == $this->data['User']['birthdate'];
			}
			
			$this->User->create();
			
			//overide the forms group_id
			$this->data['User']['group_id'] = $this->User->defaultGroupId;
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->User->Group->find('list');
		$schools = $this->School->find('list');
		$this->set(compact('groups','schools'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			
			//set password to hashed birthdate
			if(empty($this->data['User']['pass'])) {
				$this->data['User']['password'] == $this->data['User']['birthdate'];
			} 
			
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			$this->data['User']['password'] = null;
			$this->data['User']['birthdate'] = date('m/d/Y',$this->data['User']['birthdate']);
		}
		$schools = $this->School->find('list');
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups','schools'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function register() {
		
		
		$this->Auth->logout();
		if (!empty($this->data)) {
			
			//set the password
			if(empty($this->data['User']['password'])) {
				$this->data['user']['password'] == md5($this->data['User']['birthdate']);
			}
			
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Auth->login($this->data); // autologin
				$this->redirect(array('action'=>'register_complete'));
			} // fi
		} 
	}
	function register_complete() {
		
	}
	
	function recover(){
		
		
		if (!empty($this->data)) {
			if( $this->Captcha->check($this->data['User']['captcha']) ){
				$info = $this->User->findByEmail($this->data['User']['username']);
				
				if(!$info){
					$info = $this->User->findByUsername($this->data['User']['username']);
				}
				
				if(!$info){
					$this->Session->setFlash('Failed to locate user');
				}else{
					$username = $info['User']['username'];
					$password = $this->User->generatePassword();
					
					if($this->User->save(array('id'=>$info['User']['id'],'password'=>AuthComponent::password($password),'password_confirm'=>$password))){
					
						$this->Email->from    = 'Recovery <help@thestarplayer.com>';
						$this->Email->to      = '<'.$info['User']['email'].'>';
						$this->Email->subject = 'Password Reset Request';
						$this->Email->send($out1."Your password has been reset.  Below is your information.  It is recomended you change your password.\n\nusername: {$username}\npassword: $password");
						
						$this->redirect(array('controller'=>'Users','action'=>'recover_complete'));
					}else{
						$this->Session->setFlash('An error occurred.  Please try again.');
					}
				}
			}else{
				$this->Session->setFlash('Incorrect Captcha Entry');
			}
		}
	}
	
	function recover_complete(){
	
	}
	
	function captcha_image() 
    { 
        $this->Captcha->image(); 
    }
    
    function sign_up() {

    }
    
    
    
    function error_create() {
    	$this->Session->setFlash('Error creating your account.');
    }
    
	function ajax_signup_process() {
		$this->layout = 'ajax';
    	$this->render('ajax');
		
    	if (!empty($this->data)) {
    		//set the user_group
    		$this->data['User']['group_id'] = $this->User->defaultGroupId;
    		$this->data['User']['active'] = true;
    		
    		//check that the user info is ok
    		$error = $this->checkUserData();
    		if(!$error->result) {
    			$error->print_json();
    			exit;
    		}
    		
	    	//handle the transaction first
	    	//get billing information
	    	extract($this->buildAuthorizeNetData());
	    	
	    	
	    	//set the users name
	    	$this->data['User']['name'] = $fname . ' ' . $lname;
	    	
	    	
	    	if(!isset($pinfo['id']) || !isset($pinfo['amount']) || !isset($pinfo['recurring'])) {
	    		$error = new errorInfo();
	    		$error->result = false;
	    		$error->addErrorData($this->errorRepsonse('general',Configure::read('error.msg.bad_product'),false));
				$error->print_json();
				exit;	
	    	}
	    	
	    	$prodcutid = $pinfo['id'];
	    	$recurring = $pinfo['recurring'];
	    	$amount = $pinfo['amount'];
	    	
	    	$this->data['Product']['productid'] = $productid;
	    	$this->data['Product']['amount'] = $amount;
	    	$this->data['Product']['description'] = $pinfo['name'];
	    	
			//process or make recurring billing
			if($recurring) {
				//set the end date 100 years into future
				$this->data['Product']['end'] = 100*365*24*60*60 + time();
				
				$unit = $pinfo['unit'];
				$start = date('Y-m-d');
				
				//add some data
				$this->AuthorizeNet->ARBcreate();
				$this->AuthorizeNet->ARBsetField('billToAddress',$address);
				$this->AuthorizeNet->ARBsetField('billToCity',$city);
				$this->AuthorizeNet->ARBsetField('billToState',$state);
				$this->AuthorizeNet->ARBsetField('billToZip',$zip);
				$this->AuthorizeNet->ARBsetField('billToCountry',$country);
				
				//process the ARB
				$result = $this->AuthorizeNet->ARBprocess(
					$this->data['User']['username'],
					$this->data['User']['username'] . '-' . time(),
					$unit,
					$pinfo['cycle'],
					$start,
					$amount,
					$amount,
					$card,
					$exp,
					$ccv,
					$fname,
					$lname
				);
				
				$error = new errorInfo();//reset error
				
				//result was a success...create user
				if($result['result']) {
					//gotta fix the subscription to not have credit card number stored
					$this->AuthorizeNet->ARBsetField('creditCardCardNumber',$this->AuthorizeNet->utils->cardLast4($card));
					
					//add the id for user info
					$this->data['Product']['recurringid'] = $result['subscriptionId'];
					$this->data['Product']['authdata'] = serialize($this->AuthorizeNet->ARBsubscrition);
					
					$error->result = true;
					
					//create the user
					$this->User->create();
					if (!$this->User->save($this->data)) {
						$error->addErrorData($error->errorRepsonse('user_failed'));
						$this->emailUserCreateError($this->AuthorizeNet->getLastRawResponse());
					} else {
						//login the user
						$this->Auth->login($this->data);
						
						//save the product info
						$this->data['Product']['user_id'] = $this->Auth->user('id');
						$this->User->Product->save($this->data);
						
					}
					$error->print_json();
					
				} else {
					$error->result = false;
					$error->addErrorData($error->errorRepsonse('error-general-credit', $result['msg'],false));
					$error->print_json();
				}
			//single payment	
			} else {
				
				$this->AuthorizeNet->AIMcreate();
				$this->AuthorizeNet->AIMsetField('country',$country);
				$result = $this->AuthorizeNet->AIMprocess(
					$amount,
					$card,
					$exp,
					$pinfo['name'],
					array(
						'first_name' => $fname,
			    		'last_name'  => $lname,
			    		'address' => $address,
						'city' => $city,
			    		'state'   => $state,
			    		'zip'     => $zip
					)
				);
				//debug($this->AuthorizeNet->getLastRawResponse());
				if($result['result']) {
					//add raw data
					$this->data['Product']['authdata'] = $this->AuthorizeNet->getLastRawResponse();
					
					//get the end date
					$this->data['Product']['ends'] = $this->getEndDate($pinfo['cycle'], $pinfo['unit']);
				
					//create the user
					$this->User->create();
					if (!$this->User->save($this->data)) {
							$result['result'] = true;
							$result['error'] = 1;
							$result['msg'] = 'Your card has been processed.  However, there was an error in creating the account.  
							Technical support has been contacted to resolve the issue.';
							
							$this->emailUserCreateError($this->AuthorizeNet->getLastRawResponse());
					} else {
						//login
						$this->Auth->login($this->data);
						
						//save the product info
						$this->data['Product']['user_id'] = $this->Auth->user('id');
						$this->User->Product->save($this->data);
					}
				}
				echo json_encode($result);
			}
    	} else {
    		$temp = array(
    			'result'=>false,
    			'msg'=>'No data received.',
    		);
    		echo json_encode($temp);
    	}
	}
    
    //silent AJAX handlers
    function ajax_check_user_data(){
    	$this->layout = 'ajax';
    	$this->render('ajax');
    	
    	if (!empty($this->data)) {
    		$error = $this->checkUserData();
    		$error->print_json();
    		
    	} else {
    		$error = new errorInfo();
    		$error->addErrorData($error->errorRepsonse());
    		$error->print_json();
		}
    }

	function validateLogin($data) { 
        $user = $this->find(array('email' => $data['User']['email'], 'birthdate' => strtotime($data['User']['birthdate'])), array('id', 'username'));
        debug($user); 
        return (empty($user) == false) ? $user['User'] : false; 
    }
    
    private function checkUserData() {
    	
    	$error = new errorInfo();

    	//check all the user data
   		$userexist = ($this->User->checkUserNameExists($this->data) === false) ? true : false;
   		$emailexist = ($this->User->checkEmailExists($this->data) === false) ? true : false;
   		$userchars = ($this->User->checkUserNameChars($this->data));
   		$userlen   = ($this->User->checkUsernameLength($this->data,
   			Configure::read('userconfig.username.minlen'), Configure::read('userconfig.username.maxlen')));
   		
   		$email = ($this->User->checkEmail($this->data));
   		
   		$passchars = ($this->User->checkPasswordChars($this->data));
		$passconf = ($this->User->validateConfirmPassword($this->data));
		$passlen = ($this->User->validatePasswordLength($this->data,
			Configure::read('userconfig.password.minlen'),Configure::read('userconfig.password.maxlen')));
		
		//everything is good
		if($userexist && $userchars && $userlen
			&& $passconf && $passlen && $passchars
			&& $email && $emailexist
		) {
			$error->result = true;	
		} else {
			$etypes = compact(
				'userexist','userchars','userlen','email','passchars','passconf','passlen','emailexist'
			
			);
			$data = array();
			
			//assemble messages
			foreach($etypes as $key=>$val) {
				$error->addErrorData($error->errorRepsonse($key,'',$val));
			}
			$error->result = false;
			
		}
		return $error;
    }
    
    private function buildAuthorizeNetData() {
    	$fname = $this->data['User']['firstname'];
	    $lname = $this->data['User']['lastname'];
	    $address = $this->data['User']['address'];
	    $city = $this->data['User']['city'];
	    $zip = $this->data['User']['zip'];
		$country = ($this->data['User']['country']);
		$state = ($country == 'US') ? $this->data['User']['state']['us'] : $this->data['User']['state']['nonus'];
	    
	    //credit card info
	    $pinfo = null;
	    $productid = $this->data['User']['productid'];
	    $amount = null;
	    $recurring = (isset($this->data['User']['recurring']));
	    $card = $this->data['User']['cardnumber'];
	    $exp = $this->data['User']['expmonth'] . $this->data['User']['expyear'];
	    $exp = $this->AuthorizeNet->utils->fixExpLength($exp);
	    $ccv = $this->data['User']['ccv'];
	    	
	    //get product
	    $validProducts = Configure::read('siteconfig.checkout.products');
	    foreach($validProducts as $product) {
	    	if($product['id'] == $productid) {
	    		$pinfo = $product;
	    		break;
	    	}
	    }
	    $return = compact('fname','lname','address','city','state','zip','country','productid','amount','recurring','card','exp','ccv');
	    $return['pinfo'] = $pinfo;
	    
	    return $return;
    }
    
    private function emailUserCreateError($info) {
    	$this->Email->from    = 'Error <Error@jason-metier.com>';
		$this->Email->to      = Configure::read('siteconfig.techsupport');
		$this->Email->subject = 'Error with creating an account';
		$this->Email->send($this->data . "\n\n========================\n\n".$info);
    }
    
    private function emailUserCreated($username, $password ) {
    	$username = $data['User']['username'];
    	$pass = $data['User']['password_confirm'];
    	
$body = <<<STR
Thank you for joining.  Below is your account information and a receipt for your billing.
STR;
    }
    
    private function receiptSingle($userId){
    	
    }
    
    private function receiptRecurring($userId) {
    	$data =$this->User->Products->find('first',array('conditions'=>'User.id = '.$userId,'order'=>'Products.created DESC') );
    	$productid = $data['Product']['productid'];
    	$pinfo = Configure::read('siteconfig.checkout.products.'.$productid);
    	
    	//debug($data);
    	
    	$name = $data['User']['name'];
    	$prodDesc = $pinfo['name'];
    	
    	if(empty($data['User']['Product']['authdata'])) {
    		return "No Data";
    	}
    	
    	//have to make sure php knows about the class we are about to unserialize
    	$this->AuthorizeNet->ARBcreate();
    	$subscription = unserialize($data['User']['Product']['subscription']);
    	
    	$amount = $subscription->amount;
    	$cycle = $subscription->intervalUnit;
    	$length = $subscription->intervalLength;
    	$start = $subscription->startDate;
    	$card = $subscription->creditCardCardNumber;
    	
    	$fname = $subscription->billToFirstName;
    	$lname = $subscription->billToLastName;
    	$address = $subscription->billToAddress;
    	$city = $subscription->billToCity;
    	$postal = $subscription->billToZip;
    	$state = $subscription->billToState;
    	$country = $subscription->billToCountry;
    	
    	if($subscription->totalOccurrences == 9999){
    		$ends = '';
    	} else {
    		$ends = '<li>Billed for ' . $subscription->totalOccurrences . ' ' . $cycle . '</li>';
    	}
    	
$str = <<<STR
	<h1 class="f-accented2 f-bigger f-red">Billing Info</h1>
	<ul>
		<li>$fname $lname</li>
		<li>$address</li>
		<li>$city</li>
		<li>$postal</li>
		<li>$country</li>
		<li>$state</li>
	</ul>
	<h1 class="f-accented2 f-bigger f-red">Product Billing</h1>
	<ul>
		<li>$prodDesc</li>
		<li>$amount</li>
		<li>Billed every $length $cycle</li>
		$ends
		<li>Billed to $card</li>
	</ul>
STR;
    	
    return $str;
    	
    }
    
    private function getEndDate($cycle, $unit) {
    	switch($unit){
    		case 'months':
    		case 'month':
				$length = 31;
    			break;
    		case 'days':
    		case 'day':
    			$length = 1;
    			break;
    		case 'year':
    		case 'years':
    			$length = 365;
    			break;
    		case 'week':
    		case 'weeks':
    			$length = 7;
    			break;
    	}
    	return $cycle * $length * 24 * 60 * 60 + time();
    }
    
    private function getProductData($pId) {
    	$products = Configure::read('siteconfig.checkout.products');
    	foreach($products as $p) {
    		if ($p['id'] == $pId){
    			return $p;
    		}
    	}
    }
}
class errorInfo {
	var $result = false;
	var $data = array();
	
	public function print_json(){
		echo json_encode(array('result'=>$this->result,'data'=>$this->data));
	}
	public function addErrorData($data) {
		$key = key($data);
		if(!isset($this->data[$key])) {
			$this->data[$key] = array();
		}
		foreach($data[$key] as $entry) {
			array_push($this->data[$key],$entry);
		}
		
	}
	public function errorRepsonse($error, $msg='', $val=false) {
    	$msg = (empty($msg)) ? Configure::read('error.msg.unknown') : $msg;
    	$result = array();
    	$result[$error] = array();
		switch($error) {
			case 'userexist':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.username_taken'),
					'result'=>$val,
					'id'=>'error-username'
				));
				break;
			case 'userchars':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.username_badchar'),
					'result'=>$val,
					'id'=>'error-username'
				));
				break;
			case 'userlen':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.username_length'),
					'result'=>$val,
					'id'=>'error-username'
				));
				break;
			case 'email':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.email_bad'),
					'result'=>$val,
					'id'=>'error-email'
				));
				break;
			case 'emailexist':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.email_exist'),
					'result'=>$val,
					'id'=>'error-email'
				));
				break;
			case 'passchars':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.password_badchar'),
					'result'=>$val,
					'id'=>'error-password'
				));
				break;
			case 'passconf':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.passconfirm'),
					'result'=>$val,
					'id'=>'error-password'
				));
				break;
			case 'passlen':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.password_length'),
					'result'=>$val,
					'id'=>'error-password'
				));
				break;
			case 'user_failed':
				array_push($result[$error],array(
					'msg'=>Configure::read('error.msg.user_failed'),
					'result'=>$val,
					'id'=>'error-general-credit'
				));
				break;
			default:
				array_push($result[$error],array(
					'msg'=>$msg,
					'result'=>false,
					'id'=>'error-general'
				));
				break;
		}
		return $result;
			
    }
}



?>