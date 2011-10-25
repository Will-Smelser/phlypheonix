<?php
class ManagerController extends AppController {
	
	var $name = 'Manager';
	var $components = array();
	var $uses = array('Manufacturer','School','Actor','Product','Size','Color','Pattribute','Pimage','Pdetail','Pstyle');
	var $helpers = array('Sizer');
	
	function index($result=null, $context=null){
		if($result && !empty($result)){
			$this->Session->setFlash('New product saved.  Success.');
		} elseif(!$result && !empty($result)) {
			$this->Session->setFlash('Error. '.$context);
		}
		
	}
	
	
	
	function productAdd(){
		$mfgs = $this->Manufacturer->find('list');
		$actors = $this->Actor->find('list');
		$products = $this->Product->find('list');
		$sizes = $this->Size->find('list',array('order'=>array('name ASC')));
		$colors = $this->Color->find('list');
		$pattrs = $this->Pattribute->find('list');
		$pimage = $this->Pimage->find('list');
		$schools = $this->School->find('list');
		$pstyles = $this->Pstyle->find('list',array('fields'=>array('id','name')));
		$pstyles2 = $this->Pstyle->find('list',array('fields'=>array('id','desc')));
		
		$this->set(compact('mfgs','actors','products','sizes','colors','pattrs','pimages','schools','pstyles','pstyles2'));
	}
	
	function productSave(){
		$this->layout = 'ajax';
		
		//first lets add a product
		if(!$this->Product->save($_POST['Product'])){
			//error
			echo '{result:false,context:"product"}';
			return;
		}
		
		$pid = $this->Product->id;
		
		//Pattributes
		if(isset($_POST['Pattribute']['Pattribute'])){
			$ids = array();
			foreach($_POST['Pattribute']['Pattribute'] as $attr){
				$img = $this->fixImageUrl($attr['image'],'attribute',array($pid),array($_POST['extra']['school'],$_POST['extra']['sex']));
				if(!$img){
					echo '{result:false,context:"pattribute"}';
					return;
				}											

				$name = $attr['name'];
				$desc = $attr['desc'];
				
				$sql = "INSERT INTO `pattributes` (name,image,description) VALUES ('$name','$img','$desc')";
				$this->Pattribute->query($sql);
				array_push($ids, mysql_insert_id());
			}
			
			if(mysql_error()){
					//error
					echo '{result:false,context:"pattribute"}';
					return;
			}
			//save the attributes to products relationship
			$sql = 'INSERT INTO `products_pattributes` (product_id,pattribute_id) VALUES ';
			foreach($ids as $id){
				$sql .= "($pid,$id),";
			}
			$sql = rtrim($sql,',');
			
			$this->Pattribute->query($sql);
			
			if(mysql_error()){
					//error
					echo '{result:false,context:"pattribute"}';
					return;
			}
		}
		
		//pimages
		$ptemp = array();
		foreach($_POST['Pimages']['Pimages'] as $pimage){
			$img = $this->fixImageUrl($pimage['image'],'product',array($pid,str_replace(' ','-',$pimage['name'])),array($_POST['extra']['school'],$_POST['extra']['sex']));
			if(!$img){
				echo '{result:false,context:"pattribute"}';
				return;
			}
				
			$temp = $pimage;
			$temp['image'] = $img;
			$temp['product_id'] = $pid;
			
			array_push($ptemp,$temp);
			
		}
		if(!$this->Pimage->saveAll($ptemp)){
			//error
			echo '{result:false,context:"pimages"}';
			return;
		}
		
		//pdetails
		//$ptemp = array();
		$sql = "INSERT INTO `pdetails` (product_id, size_id, color_id, inventory, sku_vendor, sku, counter) VALUES ";
		foreach($_POST['Pdetail']['Pdetail'] as $detail){
			//$temp = $detail;
			//$temp['product_id'] = $pid;
			//array_push($ptemp,$temp);
			$sql .= "({$pid},{$detail['size_id']},{$detail['color_id']},{$detail['inventory']},'{$detail['sku_vendor']}','{$detail['sku']}',{$detail['counter']}),";
		}
		$sql = rtrim($sql,',');
		$this->Pdetail->query($sql);
		if(mysql_error()){
		//if(!$this->Pdetail->saveAll(array('Pdetails'=>$ptemp))){
			//error
			echo '{result:false,context:"pdetail"}';
			return;
		}
		
		echo '{result:true,context:"none"}';
	}
	private function fixImageUrl($image,$type,$pieces,$subdir=array()){
		//debug(compact('image','type','pieces','subdir'));
		$image = preg_replace('/\/manager\/getimage\/(feature|product)\//i','',$image);
		$parts = explode('/',$image);
		$img = implode('_',$pieces) . '_' . array_pop($parts);
		
		
		$durl = $surl = '';
		if($type=='product'){
			$temp = '';
			if(!empty($subdir)){
				foreach($subdir as $tdir){
					$temp.=$tdir . '/';
					$dir = WWW_ROOT . str_replace('/',DS,'/img/products/'.$temp);
					if(!file_exists($dir)) mkdir($dir);	
				}
			}
			$surl = '/img/products/uploads/' . $image;
			$durl = '/img/products/' . $temp  . $img;
		} else {
			//make the subdirectories
			$temp = '';
			if(!empty($subdir)){
				foreach($subdir as $tdir){
					$temp.=$tdir . '/';
					$dir = WWW_ROOT . str_replace('/',DS,'/img/attributes/'.$temp);
					if(!file_exists($dir)) mkdir($dir);	
				}
			}
			
			$surl = '/img/attributes/uploads/' . $image;
			$durl = '/img/attributes/' . $temp . $img;
		}
		
		//move image to new dest
		try{
			rename(WWW_ROOT . str_replace('/',DS,ltrim($surl,'/')),WWW_ROOT . str_replace('/',DS,ltrim($durl,'/')));
		}catch(Exception $e){
			return false;
		}
		
		return $durl;
	}
	function getimage($type,$encodedFile){
		$this->layout='ajax';
		
		if($type == 'product'){
			$file = WWW_ROOT . DS . 'img' . DS . 'products' . DS . 'uploads' . DS . urldecode($encodedFile);
		}else{
			$file = WWW_ROOT . DS . 'img' . DS . 'attributes' . DS . 'uploads' . DS . urldecode($encodedFile);
		}
		
		$fileInfo = pathinfo($file);
		
		//This will set our output to 45% of the original size 
		 $size = 0.1; 
		 
		 // This sets it to a .jpg, but you can change this to png or gif 
		 header('Content-type: image/jpeg'); 
		 
		 // Setting the resize parameters
		 list($width, $height) = getimagesize($file); 
		 $modwidth = $width * $size; 
		 $modheight = $height * $size; 
		 
		 // Creating the Canvas 
		 $tn= imagecreatetruecolor($modwidth, $modheight); 
		 $source = imagecreatefromjpeg($file); 
		 
		 // Resizing our image to fit the canvas 
		 imagecopyresized($tn, $source, 0, 0, 0, 0, $modwidth, $modheight, $width, $height); 
		 
		 imagejpeg($tn);
		return;
	}
}

?>