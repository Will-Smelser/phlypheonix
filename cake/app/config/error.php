<?php
$config = array('error');
$config['error']['msg'] = array();


//USER
$config['error']['msg']['username_taken'] = 'Username already exists.';
$config['error']['msg']['username_badchar'] = 'Invalid characters (Only !@#$_- or Alphanumeric Characters).';
$config['error']['msg']['username_length'] = 'Invalid Username.  Must be between 4-15 characters.';

$config['error']['msg']['email_bad'] = 'Invalid email address.';
$config['error']['msg']['email_exist'] = 'Email already exists.';

$config['error']['msg']['password_length'] = 'Invalid password length.  Must be between 7-15 characters.';
$config['error']['msg']['password_badchar'] = 'Invalid characters (Only !@#$_- or Alphanumeric Characters).';

$config['error']['msg']['passconfirm'] = 'Passwords did not match';

$config['error']['msg']['bad_birthdate'] = 'Invalid birthdate';

$config['error']['msg']['bad_sex'] = 'Please select M or F';


//AUTH
$config['error']['msg']['bad_product'] = 'Unknown Error.  Try refreshing the page.';
$config['error']['msg']['user_failed'] = 'An unknown error occurred while attempting to create your acount.  Please try again.';
$config['error']['msg']['bad_card'] = 'Invalid card number.';
$config['error']['msg']['bad_ccv'] = 'Invalid CCV.  Should be the 3 digit code on back of card.';
$config['error']['msg']['bad_exp'] = 'Ivalid expiration date.  Must be a date in the future.';

//GENERAL
$config['error']['msg']['unknown'] = 'Unknown Error.  Try refreshing the page.';
?>