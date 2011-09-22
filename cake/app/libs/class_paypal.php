<?php

class PayFlowTransaction {

 const HTTP_RESPONSE_OK = 200;
 const KEY_MAP_ARRAY = 'map';
 
 public $data;
 public $headers = array();
 public $gateway_retries = 3;
 public $gateway_retry_wait = 5; //seconds
 public $environment = 'test';
 
 public $vps_timeout = 45;
 public $curl_timeout = 90;
 
 public $gateway_url_live = 'https://payflowpro.paypal.com';
 public $gateway_url_devel = 'https://pilot-payflowpro.paypal.com';
 

 public $avs_addr_required = 0;
 public $avs_zip_required = 0;
 public $cvv2_required = 0;
 public $fraud_protection = false;
 
 public $raw_response;
 //public $response;
 public $response_arr = array();
 
 public $txn_successful = null;
 public $raw_result;
 
 public $debug = false;
 
 public function __construct() {
  
  $this->load_config();
  
  
 }
 
 public function load_config() {
  
  if ( defined('PAYFLOWPRO_USER') ) {
   $this->data['USER'] = constant('PAYFLOWPRO_USER');
  }
  
  if ( defined('PAYFLOWPRO_PWD') ) {
   $this->data['PWD'] = constant('PAYFLOWPRO_PWD');
  }

  if ( defined('PAYFLOWPRO_PARTNER') ) {
   $this->data['PARTNER'] = constant('PAYFLOWPRO_PARTNER');
  }
  
  if ( defined('PAYFLOWPRO_VENDOR') ) { 
   $this->data['VENDOR'] = constant('PAYFLOWPRO_VENDOR');
  }
  else {
   if ( isset($this->data['USER']) ) {
    $this->data['VENDOR'] = $this->data['USER'];
   }
   else {
    $this->data['VENDOR'] = null;
   }
  }
  
 }
 
 public function __set( $key, $val ) {
  
  $this->data[$key] = $val;
  
 }
 
 public function __get( $key ) {
  
  if ( isset($this->data[$key]) ) {
   return $this->data[$key];
  }
  
  return null;
 }
 
 public function get_gateway_url() {
  
  if ( strtolower($this->environment) == 'live' ) {
   return $this->gateway_url_live;
  }
  else {
   return $this->gateway_url_devel;
  }
  
 }
 
 public function get_data_string() {
  
  $query = array();

  if ( !isset($this->data['VENDOR']) || !$this->data['VENDOR'] ) {
 $this->data['VENDOR'] = $this->data['USER'];
  }

  
  foreach ( $this->data as $key => $value) {
   
   if ( $this->debug ) {
    echo "{$key} = {$value}
";
   }
   
   $query[] = strtoupper($key) . '[' .strlen($value).']='.$value;
  }
  
  return implode('&', $query);
  
 }

 public function before_send_transaction() {
  
  $this->txn_successful = false;
  $this->raw_response = null; //reset raw result
  $this->response_arr = array();
 } 
 
 public function reset() {
  
  $this->txn_successful = null;
  $this->raw_response = null; //reset raw result
  $this->response_arr = array();
  $this->data = array();
  $this->load_config();
 } 
 
 
 public function send_transaction() {
  
  try { 
   
   $this->before_send_transaction();
    
   $data_string = $this->get_data_string();
   
      $headers[] = "Content-Type: text/namevalue"; //or text/xml if using XMLPay.
      $headers[] = "Content-Length: " . strlen ($data_string);  // Length of data to be passed 
      $headers[] = "X-VPS-Timeout: {$this->vps_timeout}";
      $headers[] = "X-VPS-Request-ID:" . uniqid(rand(), true);
   $headers[] = "X-VPS-VIT-Client-Type: PHP/cURL";          // What you are using
   
   $headers = array_merge( $headers, $this->headers );
 
   if ( $this->debug ) {
    echo  __METHOD__ . ' Sending: ' . $data_string . '
';
   }
 
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->get_gateway_url() );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
      curl_setopt($ch, CURLOPT_HEADER, 1);                // tells curl to include headers in response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // return into a variable
      curl_setopt($ch, CURLOPT_TIMEOUT, 90);              // times out after 90 secs
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        // this line makes it work under https
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);        //adding POST data
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);       //verifies ssl certificate
      curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);       //forces closure of connection when done
      curl_setopt($ch, CURLOPT_POST, 1);          //data sent as POST
 
   $i = 0;
 
      while ($i++ <= $this->gateway_retries) {
          
          $result = curl_exec($ch);
          $headers = curl_getinfo($ch);
 
          if (array_key_exists('http_code', $headers) && $headers['http_code'] != self::HTTP_RESPONSE_OK) {
              sleep($this->gateway_retry_wait);  // Let's wait to see if its a temporary network issue.
          }
          else  {
              // we got a good response, drop out of loop.
              break;
          }
      }  

      if ( !array_key_exists('http_code', $headers) || $headers['http_code'] != self::HTTP_RESPONSE_OK ) {
    throw new InvalidResponseCodeException;
      }

   $this->raw_response = $result;
   
   $result = strstr($result, "RESULT");
   
   $ret = array();

      foreach(explode('&',$result) as $val){
      	$parts = explode('=',$val);
      	$ret[$parts[0]] = $parts[1];
      }
      
   return $ret;
  }
  catch( Exception $e ) {
   @curl_close($ch);
   throw $e;
  }
 }
 
 public function response_handler( $response_arr ) {

  try { 
      $result_code = $response_arr['RESULT']; // get the result code to validate.
  
   if ( $this->debug ) {
    echo __METHOD__ . ' response=' . print_r( $response_arr, true) . '
';
    echo __METHOD__ . ' RESULT=' . $result_code . '
';
   }
   
   if ( $result_code == 0 ) {

    //
    // Even on zero, still check AVS
    //
          
          if ( $this->avs_addr_required ) {
     $err_msg = "Your billing (street) information does not match.";
           
           if ( isset($response_arr['AVSADDR'])) {
                if ($response_arr['AVSADDR'] != "Y") {
              throw new AVSException( $err_msg  );
                }
              }
              else {
               if ( $this->avs_addr_required == 2 ) {
              throw new AVSException( $err_msg );
               }
              }
          }
  
    if ( $this->avs_zip_required ) {
  
              $err_msg = "Your billing (zip) information does not match. Please re-enter.";
  
           if (isset($nvpArray['AVSZIP'])) {
               if ($nvpArray['AVSZIP'] != "Y") {
       throw new AVSException( $err_msg );
               }
              }
              else {
               if ( $this->avs_zip_required == 2 ) {
              throw new AVSException( $err_msg );
               }
               
              }
          }
          
          if ( $this->require_cvv2_match ) {
  
     $err_msg = "Your card code is invalid. Please re-enter.";
           
           if ( array_key_exists('CVV2MATCH', $response_arr) ) {
               if ($response_arr['CVV2MATCH'] != "Y") {
                   throw new CVV2Exception( $err_msg );
               }
              }
              else {
               if ( $this->require_cvv2_match == 2 ) {
              throw new CVV2Exception( $err_msg );
               }
              }
          }
  
    //
    // Return code was 0 and no AVS exceptions raised
    //
    $this->txn_successful = true;
    
   //parse_str($this->raw_response, $this->response_arr);
    //return $this->response_arr;
    return $response_arr;
      }
      else if ($result_code == 1 || $result_code == 26) {
    throw new InvalidCredentialsException( "Invalid API Credentials" );
      }
      else if ($result_code == 12) {
          // Hard decline from bank.
          throw new TransactionDataException( "Your transaction was declined." );
      }
      else if ($result_code == 13) {
          // Voice authorization required.
          throw new TransactionDataException ("Your Transaction is pending. Contact Customer Service to complete your order.");
      }
      else if ($result_code == 23 || $result_code == 24) {
          // Issue with credit card number or expiration date.
         $msg = 'Invalid credit card information: ' . $response_arr['RESPMSG'];
         throw new TransactionDataException ($msg);
      }
  
      // Using the Fraud Protection Service.
      // This portion of code would be is you are using the Fraud Protection Service, this is for US merchants only.
      if ( $this->fraud_protection ) {
  
          if ($result_code == 125) {
              // 125 = Fraud Filters set to Decline.
              throw new FraudProtectionException ( "Your Transaction has been declined. Contact Customer Service to place your order." );
          }
          else if ($result_code == 126) {
              throw new FraudProtectionException ( "Your Transaction is Under Review. We will notify you via e-mail if accepted." );
          }
          else if ($result_code == 127) {
     throw new FraudProtectionException ( "Your Transaction is Under Review. We will notify you via e-mail if accepted." );
          }
      }
      
      //
      // Throw generic response
      //
      throw new FuseException( $response_arr['RESPMSG'] );
      
      
  }
  catch( Exception $e ) {
  	return $response_arr;
   throw $e;
  }
 } 

 public function process() {
 
  try { 
   return $this->response_handler($this->send_transaction());
  }
  catch( Exception $e ) {
   throw $e;
  }
 
 }

 public function apply_associative_array( $arr, $options = array() ) {
  
  try { 
   
   $map_array = array();
     
   if ( isset($options[self::KEY_MAP_ARRAY]) ) {
    $map_array = $options[self::KEY_MAP_ARRAY];
   }
  
   foreach( $arr as $cur_key => $val ) {

    if( isset($map_array[$cur_key]) ) {
     $cur_key = $map_array[$cur_key];
    }
    else {
     if ( isset($options['require_map']) && $options['require_map'] ) {
      continue;
     }
    }
    
    $this->data[strtoupper($cur_key)] = $val;
   
   }
  }
  catch( Exception $e ) {
   throw $e;
  }
  
 }
 public function deleteVar($varstr){
 	try{
 		eval('unset($this->'.$varstr.')');
 	}
 	catch(Exception $e){
 		throw $e;
 	}
 }
 
 
}


class InvalidCredentialsException extends Exception {
 
}

class GatewayException extends Exception {
 
}

class InvalidResponseCodeException extends GatewayException {
 
}


class TransactionDataException extends Exception {
 
} 

class AVSException extends TransactionDataException {
 
}

class CVV2Exception extends TransactionDataException {
 
}

class FraudProtectionException extends Exception {

}
?>
