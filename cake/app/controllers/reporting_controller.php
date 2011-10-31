<?php
class ReportingController extends AppController{
	
	var $uses = array('tracking');
	var $components = array('Ccart');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('*');
		
	}
	
	public function index($page=0,$sortOn='total_time',$sortDir = 'ASC',$filterType=null,$inputs=null){
		$filter = 1;
		$filterType = (isset($_POST['filter'])) ? $_POST['filter'] : $filterType;
		$posted = isset($_POST['filter']);
		
		//convert to URL and forward to correct url
		if($posted){
			$inputs = '';
			switch($filterType){
				default:
				case 'none':
					break;
				case 'date':
					$inputs = strtotime($_POST['date-from']) .'|'. strtotime($_POST['date-to']);
					break;
				case 'facebook':
					$inputs = $_POST['f-equate']; 
					break;
				case 'referer':
					$inputs = $_POST['r-equate'];
					break;
				case 'count':
					$inputs = $_POST['c-from'] . '|' . $_POST['c-to'];
					break;
			}
			$this->redirect("/reporting/index/$page/$sortOn/$sortDir/$filterType/$inputs");
			return;
		}
		
		if(!empty($filterType)){
			$parts = explode('|',$inputs);
			switch($filterType){
				default:
				case 'none':
					break;
				case 'date':
					
					$from = $parts[0];
					$to = $parts[1];
					
					$filter = " UNIX_TIMESTAMP(first_time) >= {$from} AND UNIX_TIMESTAMP(last_time) <= {$to} ";
					break;
				case 'facebook':
					$filter = " facebook_id $inputs '' ";
					break;
				case 'referer':
					$filter = " referer_id $inputs '' ";
					break;
				case 'count':
					$from = $parts[0];
					$to = $parts[1];
					$filter = " count >= {$from} AND count <= {$to} ";
					break;
			}
		}
		
		
		$count = 100;
		
		$start = $count * $page;
		
		$result = $this->Tracking->getBaseData($start,$count,$sortOn,$sortDir,$filter);
		$total  = $this->Tracking->getBaseDataRecordCount();
		$pages  = ceil($total/$count);
		
		$this->set(compact('result','page','pages','total','sortOn','sortDir','filterType','inputs'));
	}
	
	public function timeline($userid=0,$ssid=0){
		//lookup by userid
		if($userid != '0'){
			$data = $this->Tracking->getDetailsByUserid($userid);
		//lookup by session
		} else {
			$data = $this->Tracking->getDetailsBySession($ssid);
		}
		
		$this->loadModel('School');
		$schools = $this->School->find('list',array('fields'=>array('id','long')));
		
		//fix the cart and alter data
		foreach($data as $key=>$entry){
			//create cart html
			$cart = unserialize($entry['trackings']['cart']);
			
			$html = '<table><tr><th>Product Id</th><th>Qty</th><th>Unit Price</th>';
			foreach($cart->getContents() as $e){
				$price = cartUtils::formatMoneyUS($e->getUnitPrice());
				$html .= "<tr><td>{$e->id}<td>{$e->qty}<td>{$price}\n";
			}
			
			$html .= '</table>';
			$data[$key]['trackings']['cart'] = $html;
			
			//determine the school
			if(preg_match('/shop\/main/',$entry['trackings']['url'])){
				$parts = explode('/',$entry['trackings']['url']);
				
				$data[$key]['trackings']['school'] = (isset($parts[2])) ? $schools[$parts[2]] : ' - ';
			}else{
				$data[$key]['trackings']['school'] = ' - ';
			}
		}

		$this->set(compact('data'));
	}
}
?>