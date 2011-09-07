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
	foreach($myuser['School'] as $s){
		if($s['id'] == $school['id']){
			$heart_class = 'heart';
			break;
		}
	}

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