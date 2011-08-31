<?php

$config['config']['maintenance'] = false;
$config['config']['coming_soon'] = false;
$config['config']['testing'] = true;

//false = do not allow purchase when no inventory
$config['config']['inventory']['allowpresale'] = false;

$config['config']['sales']['length'] = 72; //hours

/* image directories */
$config['config']['image']['product'] = 'img' . DS . 'products' . DS;
$config['config']['image']['attr'] = 'img' . DS . 'attributes' .DS;
$config['config']['image']['pricetag'] = 'img' . DS . 'pricetag' .DS;
$config['config']['image']['mfg'] = 'img' . DS . 'manufacturers' . DS; 
$config['config']['image']['school']['small'] = 'img' . DS . 'schools' . DS . 'small' . DS;
$config['config']['image']['school']['large'] = 'img' . DS . 'schools' . DS . 'large' . DS;
$config['config']['image']['school']['mascot'] = 'img' . DS . 'schools' . DS . 'mascot' . DS;
$config['config']['image']['school']['background'] = 'img' . DS . 'schools' . DS . 'background' . DS;


//ignore
$config['config']['sales']['length'] = $config['config']['sales']['length'] * 3600;

?>