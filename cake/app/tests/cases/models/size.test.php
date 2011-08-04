<?php
/* Size Test cases generated on: 2011-08-03 19:55:39 : 1312415739*/
App::import('Model', 'Size');

class SizeTestCase extends CakeTestCase {
	var $fixtures = array('app.size', 'app.pdetail', 'app.product', 'app.oinfo', 'app.pimage', 'app.actor', 'app.pattribute', 'app.products_pattribute');

	function startTest() {
		$this->Size =& ClassRegistry::init('Size');
	}

	function endTest() {
		unset($this->Size);
		ClassRegistry::flush();
	}

}
