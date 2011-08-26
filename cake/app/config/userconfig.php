<?php
$config = array('userconfig');
$config['userconfig']['msg'] = array();

$config['userconfig']['regex']['birthdate'] = '/[0-1][0-9]\/[0-3][0-9]\/[1-9][0-9]{3}/';
$config['userconfig']['regex']['password'] = '/[\!\@\#\$\_\-\w\d]+/';
$config['userconfig']['regex']['email'] = '/^([(\\@)A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';

$config['userconfig']['username']['minlen'] = 4;
$config['userconfig']['username']['maxlen'] = 15;
$config['userconfig']['password']['minlen'] = 7;
$config['userconfig']['password']['maxlen'] = 15;

$config['userconfig']['default']['group'] = 2;

?>