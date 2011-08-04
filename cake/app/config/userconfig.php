<?php
$config = array('userconfig');
$config['userconfig']['msg'] = array();

$config['userconfig']['regex']['username'] = '/[\!\@\#\$\_\-\w\d]+/';
$config['userconfig']['regex']['password'] = '/[\!\@\#\$\_\-\w\d]+/';
$config['userconfig']['regex']['email'] = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';

$config['userconfig']['username']['minlen'] = 4;
$config['userconfig']['username']['maxlen'] = 15;
$config['userconfig']['password']['minlen'] = 7;
$config['userconfig']['password']['maxlen'] = 15;

?>