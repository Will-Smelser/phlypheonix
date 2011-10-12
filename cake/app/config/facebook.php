<?php

$config['facebook.apiId'] = '257750490911384';
$config['facebook.apiKey'] = '84e630cd11126bb02a789170030e125c';
$config['facebook.apiSecret'] = '295eca8e729918cd1ebb2c37316999d9';

/**
 * Save facebook /me info to database
 * Requires setup of model and database table `mfacebook`
 */
$config['facebook.saveFBdata'] = true;

/**
 * Can be a huge security risk.  This will look in
 * user database for email that matches, and if they
 * have a facebook_id of 0, it will log them in and
 * put there facebook_id to the matched user
 * @var boolean
 */
$config['facebook.useFBemailToLogin'] = true;

/**
 * Send errors to AuthFlash
 * @var boolean
 */
$config['facebook.userSessionFlashErrors'] = false;

/**
 * Send user Email Confirmation
 * @var boolean
 */
$config['facebook.sendNewUserEmail'] = true;

$config['facebook.fromEmail'] = 'Admin <admin@'.$_SERVER['SERVER_NAME'].'>';

/**
 * Will perform facebook replacements on this string as well
 * @see $config['facebook.emailMsgBody']
 * @var string
 */
$config['facebook.emailMsgTitle'] = 'Thanks for joining the community.';

/**
 * This will go through and replace any occurance of
 * %[facebook_key] with the facebook user's value
 *    -example: print "Welcome John Doe!"
 *    		Welcome %user_name %last_name!
 * also the following replacements:
 *    %generatedPassword
 *    
 * @var string
 */
$config['facebook.emailMsgBody'] = <<<STR
%first_name,

Thank you for joining our community.  Your username and password
were automatically generated.  Below are the details:
	
email: &email
password: &birthdate

Sincerely,
   Admin
STR;

/*
 * Variable names which will be available in Views
 */

$config['facebook.var.appId'] = 'FACEBOOK_APP_ID'; 

/**
 * The facebook session data
 * @var array
 */
$config['facebook.var.session'] = 'FACEBOOK_APP_SESSION';

/**
 * Wether user is currenlt logged into facebook
 * @var boolean
 */
$config['facebook.var.loggedIn'] = 'FACEBOOK_APP_LOGGED_IN';

/**
 * Login URL
 * @var string
 */
$config['facebook.var.urlLogin'] = 'FACEBOOK_APP_URL_LOGIN';

/**
 * Logout URL
 * @var string
 */
$config['facebook.var.urlLogout'] = 'FACEBOOK_APP_URL_LOGOUT';

/**
 * The Facebook user data...aka $facebook->api('/me') results
 * @var array
 */
$config['facebook.var.fbUser'] = 'FACEBOOK_USER';

/**
 * The user fields as they are defined in your Users table
 * @var array
 */
$config['facebook.UserFields'] = array('id'=>'id','username'=>'email','password'=>'password','password_confirm'=>'password_confirm','email'=>'email','facebook_id'=>'facebook_id');
$config['facebook.UserModel'] = 'User'; //not implamented, currently mode for user must be 'User'

/**
 * The facebook fields as they are defined in your Facebooks table
 * @see $config['facebook.saveFBdata'] This must be set to true for this to matter
 * @var array
 */
$config['facebook.FacebookFields'] = array('id'=>'id','user_id'=>'user_id','user_facebook_id'=>'user_facebook_id','data'=>'data');
$config['facebook.FacebookModel'] = 'Mfacebook';

/**
 * Auth component mapping
 */
$config['facebook.AuthMapping'] = array('username' => 'email', 'password' => 'password');

/**
 * If the Auth->login->redirect is not set, then component will forward to this url
 */
$config['facebook.afterlogin.forward'] = 'http://www.flyfoenix.com/shop/findschool';
$config['facebook.afterregister.forward'] = 'http://www.flyfoenix.com/shop/main';
?>