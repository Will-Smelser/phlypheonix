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
	
	$heart_class = 'heart-no';
	foreach($myuser['School'] as $s){
		if($s['id'] == $school['id']){
			$heart_class = 'heart';
			break;
		}
	}

?>
<div id="bodyHeader">
  <img id="mfg-logo" src="<?php echo $product['Manufacturer']['image']; ?>" alt="<?php echo $product['Manufacturer']['name']?>" />
  <img id="buynowtag" class="qtip" src="<?php echo $product['Product']['pricetag']; ?>" alt="Member only price <?php echo $product['Product']['price_member']; ?>" />
  <span id="counter" class="one"><?php echo "{$days}d {$hours}h {$minutes}m"; ?></span>
  
  
  <div id="selector">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    	<a href="<?php echo $glink; ?>">
    		<img class="qtip" id="gender" src="/img/productpresentation/flyfoenix_product_presentation_<?php echo $gender; ?>.png" width="52" height="19" alt="gender" />
    	</a>
    </td>
    <td><img id="logoschool" src="<?php echo $product['School']['logo_small']; ?>" alt="<?php echo $product['School']['long']; ?>" /></td>
    <td>
    	<table width=15px border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><a href="#"><img id="cart" src="/img/productpresentation/flyfoenix_product_presentation_cart.png" width="14" height="13" alt="cart" /></a></td>
            </tr>
            <tr>
              <td><a href="#" title="Add/Remove School"  id="favorite" class="<?php echo $heart_class; ?>"></a></td>
            </tr>
            <tr>
              <td><a href="#"><img class="qtip" id="search" src="/img/productpresentation/flyfoenix_product_presentation_search.png" width="16" height="15" alt="search" /></a></td>
            </tr>
          </table>
        </td>
  </tr>
  </table>
	
  </div>
</div><!-- End Body Header -->