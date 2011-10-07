<?php 

/**
 * $product
 * $index
 */

?>

<div class="mainphoto">
	<?php 
	foreach($product['Pimage'] as $key=>$p){
		if(preg_match('/front/i',$p['name'])){
			$index = $key;
		}
	}
	?>
      <img src="<?php echo $product['Pimage'][$index]['image']; ?>" width="351" height="401" />
      <span class="three" id="productname">
      	<?php echo $product['Pimage'][$index]['Product']['name']; ?> 
      </span>
      <div class="attribute-detail" style="" ></div>
</div><!-- End Main Photo -->