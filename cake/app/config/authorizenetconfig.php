<?php
$config = array('authorizenetconfig');
$config['authorizenetconfig'] = array();

$config['authorizenetconfig']['lib'] = APP_PATH . 'libs' . DS . 'authnet'; //the path to authnet library

$config['authorizenetconfig']['login'] = '3D5e7Me7M';
$config['authorizenetconfig']['key'] = '6V9ZG9F98e4geSzh';
$config['authorizenetconfig']['server'] = 'https://test.authorize.net/gateway/transact.dll';

$config['authorizenetconfig']['sandbox'] = true; //set to true for testing mode

$config['authorizenetconfig']['recurring']['refId'] = 'jason-metier';
$config['authorizenetconfig']['recurring']['name'] = 'jason-metier';

$config['authorizenetconfig']['regex']['card'] = '/^[0-9]{12,16}$/';
$config['authorizenetconfig']['regex']['ccv'] = '/^[0-9]{3}$/';



?>