<?php
class AccessoriesController extends AppController {
	
	var $name = 'Accessories';
	var $uses = array('School','Product','Color','Pimage','Accessory');
	var $helpers = array('Sizer');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'accessories';
		//$this->layout = 'default';
	}
	
	function index($school, $sex=null, $color = null){
		$school = $school * 1;
		$color = $color * 1;
		
		if(empty($school)){
			$this->redirect('no_school');
		}
		
		$sex = (strtolower($sex) == 'm') ? 'M' : 'F';
		
		$data = $this->Accessory->getData($school,$sex,$color);
		
		if(empty($data)){
			$this->redirect('no_products');
		}
		
		$school = $this->School->findById($school);
		$schools = $this->School->find('all',array('recursive'=>0));
		
		//filter the products by color...look for the swatch
		$colors = array();
		$swatches = array();
		$cids = array();
		$pids = array();
		
		$this->Accessory->aggregateData($data, $swatches, $colors, $pids, $cids);
		$images = $this->Accessory->aggregateImages($pids, $cids);
		$pdetails = $this->Accessory->getPdetails($this->Product->Pdetail,$pids);
		
		//set the data
		$this->set(compact('data','school','schools','sex','colors','swatches','images','pdetails'));
		
	}
	
	function no_school(){
		$sex = $this->myuser['User']['sex'];
		$school = $this->myuser['User']['school_id'];
		
		if($school == 0){
			$this->redirect(array('action'=>'shop','controller'=>'noschool'));
		}
		$schools = $this->School->find('all',array('recursive'=>0));
		$school = $this->School->findById($school);
		
		if(empty($school)){
			$this->redirect(array('action'=>'shop','controller'=>'noschool'));
		}
		
		$swatches = array();
		$products = array();
		$colors = array();
		$pdetails = array();
		$this->set(compact('school','sex','schools','swatches','products','colors','pdetails'));
	}
	
	function no_products(){
		
		$sex = $this->myuser['User']['sex'];
		$school = $this->School->findById($this->myuser['User']['school_id']);
		$schools = $this->School->find('all',array('recursive'=>0));
		$swatches = array();
		$products = array();
		$colors = array();
		$pdetails = array();
		$this->set(compact('school','sex','schools','swatches','products','colors','pdetails'));
	}
}