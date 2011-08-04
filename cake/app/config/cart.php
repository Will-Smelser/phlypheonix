<?php
$config = array('cart');
$config['cart'] = array();

$config['cart']['product']['model'] = 'Product';
$config['cart']['product']['key'] = 'id';
$config['cart']['namespace'] = 'Cart';
$config['cart']['product']['priceRoute'] = 'Product.price_retail';

?>