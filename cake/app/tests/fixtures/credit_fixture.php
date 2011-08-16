<?php
/* Credit Fixture generated on: 2011-08-16 13:21:19 : 1313515279 */
class CreditFixture extends CakeTestFixture {
	var $name = 'Credit';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'user_id_purchases' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'sale_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'order_id_optional' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => false, 'default' => NULL, 'length' => '4,2'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => array('user_id', 'user_id_purchases', 'sale_id'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'user_id_purchases' => 1,
			'sale_id' => 1,
			'order_id_optional' => 1,
			'amount' => 1,
			'created' => '2011-08-16 13:21:19'
		),
	);
}
