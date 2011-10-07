<?php
class Coupon extends AppModel {
	var $name = 'Coupon';
	var $displayField = 'type';  
	
	function saveCoupon($userid,$amt,$name='Coupon',$refer=null,$type='fixed'){
		return $this->save(array('Coupon'=>array('user_id'=>$userid,'amt'=>$amt,'type'=>$type,'refer_id'=>$refer)));
	}
	
	function parseCouponCode($coupon){
		$coupon = substr($coupon, Configure::read('config.coupon.prefix_len'));
		return (empty($coupon)) ? -1 : $coupon;
	}
	
	function createLeadingCode(){
		//ascii character ranges
		$upper = array(65,90);
		$lower = array(97,122);
		$dig = array(48,57);
		
		$str = '';
		for($i=0;$i<Configure::read('config.coupon.prefix_len');$i++){
			$choose = rand(0,2);
			if($choose == 0){
				$str .= chr(rand($upper[0],$upper[1]));
			}elseif($choose == 1){
				$str .= chr(rand($lower[0],$lower[1]));
			}else{
				$str .= chr(rand($dig[0],$dig[1]));
			}
		}
		return $str;
		
	}
}
