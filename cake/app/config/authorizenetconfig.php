<?php
$config = array('authorizenetconfig');
$config['authorizenetconfig'] = array();

$config['authorizenetconfig']['lib'] = APP_PATH . 'libs' . DS . 'authnet'; //the path to authnet library

//developer data
//$config['authorizenetconfig']['login'] = '3D5e7Me7M';
//$config['authorizenetconfig']['key'] = '6V9ZG9F98e4geSzh';

//actual data
$config['authorizenetconfig']['login'] = '3H6y29cAx';
$config['authorizenetconfig']['key'] = '9puRNN76qCM42g4n';
$config['authorizenetconfig']['server'] = 'https://test.authorize.net/gateway/transact.dll';

$config['authorizenetconfig']['sandbox'] = false; //set to true for testing mode

$config['authorizenetconfig']['recurring']['refId'] = 'flyfoenix';
$config['authorizenetconfig']['recurring']['name'] = 'flyfoenix';

$config['authorizenetconfig']['regex']['card'] = '/^[0-9]{12,16}$/';
$config['authorizenetconfig']['regex']['ccv'] = '/^[0-9]{3}$/';



?>