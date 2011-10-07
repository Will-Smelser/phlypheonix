<?php echo $this->element('layouts/lightbg_top'); ?>
<div class="title">Orders</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2" /><br/>
<?php 
	if(count($orders)>0){
		foreach($orders as $o){
			$date = date('m/d/Y',strtotime($o['Order']['created']));
			$id = $o['Order']['id'];
			echo "<a style='display:inline-block;padding:3px 0px;' href='/checkout/receipt/$id'>Order# {$id} on $date</a><br/>";
		}
	} else {
		echo "<p>No Orders</p>";
	}
?>
<br/>
<div class="title">Coupons</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2">
<?php 

	if(count($coupons) > 0){
		?>
		<table>
		<tr><th>Coupon Code<th>Name<th>Amount<th>Active<th>Expires
		<?php
		foreach($coupons as $c){
			$expires = date('m/d/Y',$c['Coupon']['expires']);
			$code = $c['Coupon']['key'];
			$amt = $c['Coupon']['amt'];
			$name=$c['Coupon']['name'];
			$open = ($c['Coupon']['open'] == 0) ? 'false' : 'true';
			echo "<tr><td align='middle'>$code<td align='middle'>$name<td align='middle'>$amt<td align='middle'>$open<td align='middle'>$expires\n";
		?>
		</table>
		<?php 
		}
	} else {
		echo "<p>No Coupons</p>";
	}

?>
<br/>
<div class="title">Links</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2">
<a style='display:inline-block;padding:3px 0px;' href="/pages/terms">Terms of Use</a><br/>
<a style='display:inline-block;padding:3px 0px;' href="/pages/privacy">Privacy Policy</a><br/>
<a style='display:inline-block;padding:3px 0px;' href="/pages/return">Return Policy</a>


<?php echo $this->element('layouts/lightbg_bottom'); ?>