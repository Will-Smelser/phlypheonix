<?php 

/**
 * $product
 * $index
 */

?>

<div id="mainphoto">
      <img src="<?php echo $product['Pimage'][$index]['image']; ?>" width="351" height="401" />
      <span class="three" id="productname">
      	<?php echo $product['Pimage'][$index]['Product']['name']; ?> 
      </span>
</div><!-- End Main Photo -->