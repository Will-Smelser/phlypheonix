<?php 

/**
 * $product
 * $school
 * $myuser
 * $sale
 */

	//calculate number of days, minutes, seconds
	$now  = time();
	$unix = (!isset($sale['Sale']['UserSaleEnds'])) ? time() - 72*3600 : $sale['Sale']['UserSaleEnds'];
	
	$diff = $unix - $now;
	
	$days = $diff / ( 3600 * 24 );
	$hours = ($days - floor($days)) * 24;
	$minutes = ($hours - floor($hours)) * 60;

	$days = floor($days);
	$hours = floor($hours);
	$minutes = floor($minutes);
	
	
	$gender = (strtolower($product['Product']['sex']) == 'f') ? 'female' : 'male';
	$gopsite= (strtolower($product['Product']['sex']) == 'f') ? 'M' : 'F';
	$glink = "/shop/main/{$school['id']}/$gopsite";
	
	

?>
<div id="bodyHeader">
  <img id="mfg-logo" src="<?php echo $product['Manufacturer']['image']; ?>" alt="<?php echo $product['Manufacturer']['name']?>" />
  <img id="buynowtag" class="qtip" src="<?php echo $product['Product']['pricetag']; ?>" alt="Member only price <?php echo $product['Product']['price_member']; ?>" />
  <span id="counter" class="one"><?php echo "{$days}d {$hours}h {$minutes}m"; ?></span>
  
  <?php echo $this->element('selector',array('glink'=>$glink,'gender'=>$gender,'myuser'=>$myuser,'school'=>$school,'schoolName'=>$product['School']['long'],'schoolLogo'=>$product['School']['logo_small'])); ?>
 
</div><!-- End Body Header -->