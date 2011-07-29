<?php
/**
 * 
 * This is just a CAKE component to wrap the methods of Authorize.net SDK for php
 * 1) Requires you have put the SDK into your APP/libs/ directory
 * 2) Requires you have properly setup the authorizenetconfig.php file and placed into APP/config directory
 * 3) Requires you have bootstrapped the config file.  Meaning you must add the folling line to your
 *       APP/config/bootstrap.php file - "Configure::load('authorizenetconfig');"
 * 4) Make sure your cake controller is referencing this component by adding this into the controller:
 *       "var $components = array('AuthorizeNet');"
 * 
 * ==============
 * = How to use = 
 * ==============
 * First you must call a create method (ARBcreate() or AIMcreate()).  So for a 1 time transaction 
 * I would add to my controller the follwing line in the appropriate action method
 * $this->AuthorizeNet->AIMcreate();
 * 
 * Then you want to add any custom field data by calling a setField method(AIMsetField or ARBsetField).  So for a 1 time 
 * transaction I would add to my controller the follwing line in the appropriate action method
 * $this->AuthorizeNet->AIMsetField('custom_field_or_standard_field', 'some value');
 *     see the guide for information
 * 
 * Now you can run your transaction.  Just call process method (ARBprocess() or AIMprocess()).  Just pass in the paramaters
 * given and your done.  This is done by addding to my controller the follwing line in the appropriate action method:
 * $this->AuthorizeNet->AIMprocess();
 * 
 * 
 * @author Will Smelser
 *
 */
class AuthorizeNetComponent extends Object 
{ 
    var $controller;  //reference to the controller
    
    var $AIM;  //holds the AIM object for AIM processing
    var $ARB;  //holde the ARB object for ARB processing
    var $ARBsubscrition;  //holds the subscription data needed for ARM processing
    
    var $response; //holds raw responses
    
    var $url; //the url to communicate with....not used
    var $login; //login.  Set in the config file
    var $key;   //key.  Set in the config file
    var $lib;   //the file path to the lib directory where SDK is located
    
    var $utils; //used to access some static utility functions
    
    /**
     * Initialize some values
     */
    function AuthorizeNetComponent() {
    	//$this->url = Configure::read('authorizenetconfig.server');
    	$this->login = Configure::read('authorizenetconfig.login');
    	$this->key = Configure::read('authorizenetconfig.key');
    	$this->lib = Configure::read('authorizenetconfig.lib');
		$this->utils = new AuthUtilities();
    }
    
    function beforeRender(&$controller, $settings=array()){
    	$this->controller =& $controller;
    }
    
    function AIMcreate() {
    	require($this->lib . '/lib/shared/AuthorizeNetRequest.php');
    	require($this->lib . '/lib/shared/AuthorizeNetResponse.php');
    	require($this->lib . '/lib/AuthorizeNetAIM.php');
    	
    	
    	$this->AIM = new AuthorizeNetAIM($this->login, $this->key);
    	$this->AIM->setSandbox(Configure::read('authorizenetconfig.sandbox'));
    }
    
    /**
     * Process a single transaction - Default is Authenticate and Capture
     * 
     * @param string $amount The amount to charge
     * @param string $card The card number
     * @param string $exp The expiration date MMYY
     * @param string $desc Description of the transaction
     * @param string $type What kind of transaction to perform
     * 		AUTH_CAPTURE | AUTH_ONLY | PRIOR_AUTH_CAPTURE | CAPTURE_ONLY | CREDIT | VOID
     * @param string $method
     * @param string $info
     * 
     * @requires createAIM() has been called
     */
    function AIMprocess(
    	$amount = '19.99',
    	$card   = '4111111111111111',
    	$exp    = '0120',
    	$desc   = 'Sample Transaction',
    	$info   = array(
    		'first_name' => 'John',
    		'last_name'  => 'Doe',
    		'address' => '1234 Street',
    		'city' => 'Columbus',
    		'state'   => 'WA',
    		'zip'     => '98004'	
    	),
    	$type   = 'AUTH_CAPTURE',
    	$method = 'CC'
    ) {
    	
    	
    	$this->AIM->setField('first_name',$info['first_name']);
    	$this->AIM->setField('last_name',$info['last_name']);
    	$this->AIM->setField('address',$info['address']);
    	$this->AIM->setField('city',$info['city']);
    	$this->AIM->setField('state',$info['state']);
    	$this->AIM->setField('zip',$info['zip']);
    	$this->AIM->setField('method',$method);
    	$this->AIM->setField('type',$type);
    	$this->AIM->setField('description',$desc);
    	$this->AIM->setField('login',$this->login);
    	$this->AIM->setField('tran_key',$this->key);
    	$this->AIM->setField('exp_date',$exp);
    	$this->AIM->setField('card_num',$card);
    	$this->AIM->setField('amount',$amount);
    	
    	$response = $this->AIM->authorizeAndCapture();
    	$this->response = $response;
    	
    	$result = $declined = $error = $held = false;
    	switch($response->response_code) {
    		case AuthorizeNetResponse::APPROVED:
    			$result = true;
    			break;
    		case AuthorizeNetResponse::DECLINED:
    			$declined = true;
    			break;
    		case AuthorizeNetResponse::ERROR:
    			$error = true;
    			break;
    		case AuthorizeNetResponse::HELD:
    			$held = true;
    			break;
    	}
    	
    	$msg = $response->response_reason_text;
    	
    	return array(
    		'result'=>$result,
    		'declined'=>$declined,
    		'error'=>$error,
    		'held'=>$held,
    		'msg'=>$msg
    	); 
    }
    
    /**
     * Add a custom field for the data
     * 
     * @param unknown_type $key
     * @param unknown_type $value
     */
    function AIMsetField($key, $value) {
    	$this->AIM->setCustomField($key,$value);
    }
    
    /**
     * Process commans save their process to the $this->repsonse variable.
     * This method will give a cake debug output of that value
     */
    function getLastRawResponse() {
    	ob_start();
    	debug($this->response);
    	$content = ob_get_contents();
    	ob_end_clean();
    	return $content;
    }
    
    function ARBcreate() {
    	require($this->lib . DS . 'lib' . DS . 'shared' .DS . 'AuthorizeNetTypes.php');
    	require($this->lib . DS . 'lib' . DS . 'shared' .DS . 'AuthorizeNetRequest.php');
    	require($this->lib . DS . 'lib' . DS . 'shared' .DS . 'AuthorizeNetResponse.php');
    	require($this->lib . DS . 'lib' . DS . 'shared' .DS . 'AuthorizeNetXMLResponse.php');
    	require($this->lib . DS . 'lib' . DS . 'AuthorizeNetARB.php');
		
    	$this->ARB = new AuthorizeNetARB($this->login, $this->key);
    	$this->ARBsubscrition = new AuthorizeNet_Subscription();
    	
    	$this->ARB->setSandbox(Configure::read('authorizenetconfig.sandbox'));
    }
        
    /**
     * Reset the default blank subscription to some other subscrition.
     * 
     * @param AuthorizeNet_Subscription $subscription
     */
    function ARBsetSubscription($subscription) {
    	$this->ARBsubscrition = $subscription;
    }
    
    /**
     * Set a key value pair for the subscription.
     * 
     * @param string $key
     * @param string $value
     * @see AuthoizeNetTypes.php -> AuthorizeNet_Subscription
     */
    function ARBsetField($key, $value) {
    	$this->ARBsubscrition->$key = $value;
    }
    
    /**
     * create an arb transaction.  This is setup for using credit cards.  ARB does support
     * checking account payments and other types.
     * 
     * @param string $customerId  The customer's id
     * @param string $orderInvoiceNumber An invoice number
     * @param string $unit months|days
     * @param string $length if $unit = days then 0-31; if $unit = months then 0-12
     * @param string $startDate Date to start the sale
     * @param string $amount Amount for recurring billing
     * @param string $trialAmount If there is a trial period, then the trial period amount
     * @param string $cardNumber The credit card number of customer
     * @param string $expirationDate
     * @param string $cardCode
     * @param string $firstName
     * @param string $lastName
     * @param string $totalOccurrences Optional - 9999
     * @param string $trialOccurrences Optional - 0
     * 
     * @return array (boolean) 'result'=>true if success, 
     * 		(string) 'msg'=> error message or good message, (integer) 'subscriptionId'=> The subscription id used by Authoriznet
     */
    function ARBprocess(
    	$customerId = 'customers_id', //unique id
    	$orderInvoiceNumber = '5',
    	$unit = 'months',
    	$length = '1',
    	$startDate = '2011-07-22', //YYYY-MM-DD
    	$amount = "19.99",
    	$trialAmount = "19.99",
    	$cardNumber = "4111111111111111",
    	$expirationDate = "01/14",
    	$cardCode = '123',
    	$firstName = "John",
    	$lastName = "Doe",
    	
    	$totalOccurrences = "9999",
    	$trialOccurrences = "0"
    ) {
    	$this->ARBsetField('orderInvoiceNumber', $orderInvoiceNumber);
    	$this->ARBsetField('customerId', $customerId);
    	$this->ARBsetField('name', 'test');
    	$this->ARBsetField('intervalUnit', $unit);
    	$this->ARBsetField('intervalLength', $length);
    	$this->ARBsetField('startDate', $startDate);
    	$this->ARBsetField('amount', $amount);
    	$this->ARBsetField('creditCardCardNumber', $cardNumber);
    	$this->ARBsetField('creditCardExpirationDate', $expirationDate);
    	$this->ARBsetField('creditCardCardCode', $cardCode);
    	$this->ARBsetField('billToFirstName', $firstName);
    	$this->ARBsetField('billToLastName', $lastName);
    	$this->ARBsetField('totalOccurrences', $totalOccurrences);
    	$this->ARBsetField('trialOccurrences', $trialOccurrences);
    	$this->ARBsetField('trialAmount', $trialAmount);
    	
    	$response = $this->ARB->createSubscription($this->ARBsubscrition);
    	$this->response = $response;
    	
    	$res = ($response->xml->messages->resultCode == 'Ok') ? true : false;
    	$msg = (string) $response->xml->messages->message->text;
    	$id = (string) $response->xml->subscriptionId;
    	
    	return array(
    		'result'=>$res,
    		'msg'=>$msg,
    		'subscriptionId'=>$id
    	);
    }
    
    /**
     * Returns an object with publicly accessable values
     * 
     * @param integer $id
     * @return AuthorizeNet_Subscription
     * @see AuthorizeNetTypes.php -> AuthorizeNet_Subscription 
     */
    function ARBgetSubscription($id) {
    	return $this->ARB->getSubscriptionStatus($id);
    }
    
    /**
     * Updatethe subscription
     * 
     * @param int $subscriptionId
 	 * @return array (boolean) 'result'=>true if success, 
     * 		(string) 'msg'=> error message or good message, (string) 'status'=> The subscription status
     * 
     * @definition status = expired | suspended | canceled | terminated
     */
    function ARBupdateSubscription($subscriptionId, $subscription) {
    	$response = $this->ARB->updateSubscription($subscriptionId, $subscription);
    	
    	$res = ($response->xml->messages->resultCode == 'Ok') ? true : false;
    	$msg = (string) $response->xml->messages->message->text;
    	$status = (string) $response->xml->Status;
    	
    	return array(
    		'result'=>$res,
    		'msg'=>$msg,
    		'status'=>$status
    	);
    }
    
    /**
     * Cancel a subscription
     * 
     * @param integer $subscriptionId
     * @return array (boolean) 'result'=>true if success, 
     * 		(string) 'msg'=> error message or good message, (string) 'status'=> The subscription status
     * 
     * @definition status = expired | suspended | canceled | terminated
     */
    function ARBcancelSubscription($subscriptionId) {
    	$response = $this->ARB->cancelSubscription($subscriptionId);

    	$res = ($response->xml->messages->resultCode == 'Ok') ? true : false;
    	$msg = (string) $response->xml->messages->message->text;
    	$status = (string) $response->xml->Status;
    	
    	return array(
    		'result'=>$res,
    		'msg'=>$msg,
    		'status'=>$status
    	);
    }
}

class AuthUtilities {
	static function checkValidExp($mmyy) {
		if(strlen($mmyy) != 4) {
			return false;
		}
		$mm = $mmyy[0] . $mmyy[1];
		$yy = $mmyy[2] . $mmyy[3];
		
		return 	checkdate($mm, 1, "20" . $yy); //this will only work for next 89 years :)
	}
	
	static function fixExpLength($mmyy) {
		return (strlen($mmyy) < 4) ? '0' . $mmyy : $mmyy;
	}
	
	static function cardLast4($cardNumber) {
		return 'XXXXXXXXXXXX' . substr($cardNumber, -4);
	}
}
