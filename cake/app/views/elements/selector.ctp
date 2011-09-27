<?php 

/**
 * $glink - the geneder like
 * $gender - male or femail
 * $school - A list of this schools details
 * $schoolName - The long school name
 * $schoolLogo - The small logo
 * $myuser - The standard myuser
 */

	$heart_class = 'heart-no';
	$heart_image = '/img/ajax/heart_small.png';
	
	foreach($myuser['School'] as $s){
		if($s['id'] == $school['id']){
			$heart_class = 'heart';
			$heart_image = '/img/ajax/heart_small_red.png';
			break;
		}
	}
	
	$curUrl = '/'.$this->params['url']['url'];
	$noAjaxUrl = '/users/';
	$noAjaxUrl .= ($heart_class == 'heart') ? 'remove_school': 'add_school'; 
	$noAjaxUrl .= '/'.$school['id'];
?>
 
 <div id="selector">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    	<a href="<?php echo $glink; ?>">
    		<img class="qtip" id="gender" src="/img/productpresentation/flyfoenix_product_presentation_<?php echo $gender; ?>.png" width="52" height="19" alt="gender" />
    	</a>
    </td>
    <td><img id="logoschool" src="<?php echo $schoolLogo; ?>" alt="<?php echo $schoolName; ?>" /></td>
    <td>
    	<table width=15px border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
              	<noscript><a href="/cart/view"></noscript>
              	<img id="cart" src="/img/productpresentation/flyfoenix_product_presentation_cart.png" width="14" height="13" alt="cart" />
              	<noscript></a></noscript>
              </td>
            </tr>
            <tr>
              <td>
              	<noscript>
              		<form method="POST" action="<?php echo $noAjaxUrl; ?>">
              		<input type="hidden" name="returnUrl" value="<?php echo $curUrl; ?>" />
              		<input type="image" width="14" height="13" src="<?php echo $heart_image?>" title="Add/Remove School" style="border:none;padding:0px;margin:5px 0px 0px 5px;background:transparent;" value=" "></a>
              		</form>
              	</noscript>
              	<div style="display:none;" id="heart-wrap">
              		<a title="Add/Remove School"  id="favorite" class="<?php echo $heart_class; ?>"></a>
              	</div>
              	<script type="text/javascript">$('#heart-wrap').show();</script>
              	</td>
            </tr>
            <tr>
              <td>
              	<noscript><a href="/shop/findschool"></noscript>
              		<img class="qtip" id="search" src="/img/productpresentation/flyfoenix_product_presentation_search.png" width="16" height="15" alt="search" /></a>
              	<noscript></a></noscript>
              	</td>
            </tr>
          </table>
        </td>
  </tr>
  </table>
	
  </div>