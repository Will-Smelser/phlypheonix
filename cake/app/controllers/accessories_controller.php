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
	
function addAllImages(){
		//color id to color name match
		$colors = array(
			4=>'/\-rdgy/i',  //red grey
			6=>'/\-rybl/i', //blue and white
			8=>'/\-dkrd/i',  //dark get and white
			9=>'/\-bkrd/i',  //black and red
			10=>'/\-bkyw/i',   //black and yellow
			11=>'/\-btor/i',  //burnt orange and white
			12=>'/\-gryw/i',  //green and yellow
			14=>'/\-mror/i',   //maroon and orange
			15=>'/\-mryw/i',   //maroon and yellow
			16=>'/\-nvor/i',   //navy blue and orange
			17=>'/\-nvrd/i',   //navy blue and red
			18=>'/\-nvyw/i',   //navy blue and yellow
			21=>'/\-pryw/i',   //purple and yellow
			22=>'/\-rybl/i',   //royal blue and white
			23=>'/\-ryor/i',   //royal blue and orange
			
			7=>'/\-rd/i',  //red and white
			13=>'/\-mr/i',   //maroon and white
			19=>'/\-or/i',   //orange and white
			20=>'/\-bk/i',   //blakc and white
		);
		
		$size = 5; //the "none" size
		$actor = 5;//the "none" actor
		
		
		$imgDir = WWW_ROOT . 'img' . DS . 'products' . DS . 'stadium_stompers' . DS;
		
		$products = array(
			13=>'BCOZ',
			17=>'SIP',
			16=>'HW',
			18=>'STEM',
			19=>'LUNCH',
			20=>'TUB',
			21=>'UMB'
		);
		
		$sql = 'INSERT INTO `pimages` (product_id,actor_id,color_id,size_id,image) VALUES ';
		$sql2= 'INSERT INTO `pdetails` (product_id,size_id,color_id,inventory,sku_vendor,sku,counter) VALUES ';
		
		//cycle through by product and build sql;
		foreach($products as $pid=>$folder){
			foreach(scandir($imgDir . $folder) as $image){
				$path = "/img/products/stadium_stompers/$folder/$image";
				$colorId = null;
				//find the color id
				foreach($colors as $cid=>$regex){
					if(preg_match($regex,$image)){
						//debug($regex . ' -- '.$image);
						$colorId = $cid * 1;
						//debug($colorId);
						//break;
						$sql .= "($pid, $actor, $colorId, $size, '$path'), ";
						
						$sku = str_ireplace('.jpg','',$image);
						$sql2.= "($pid, $size, $colorId, 5, '$sku', '$sku', 0), ";
						break;
					}
				}
				
			}
		}
		
		//build all the swatches
		$sql3 = 'INSERT INTO `pdetails` (product_id,size_id,color_id,inventory,sku_vendor,sku,counter) VALUES ';
		foreach($colors as $cid=>$regex){
			$sql3 .= "(9,$size,$cid,0,'swatch-$cid','swatch-$cid',0), ";
		}
		
		debug($sql);
		debug($sql2);
		debug($sql3);
	}
}