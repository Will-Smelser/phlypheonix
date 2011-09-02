<?php 

/**
 * $product
 * $index What product image is this
 */

//allow out of inventory sales
$presale = Configure::read('config.inventory.allowpresale');

//calculate inventory
$inventory = 0;
foreach($product['Pdetail'] as $p){
	$inventory += $p['inventory'];
}

?>

<div id="inventory">
    <span class="one">Inventory:  <?php echo $inventory; ?></span>
</div>
    
<img id="grayline" src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" alt="grayline" />

<span id="description" class="two">
	<?php echo $product['Product']['desc']; ?>
</span>
    
<img id="grayline" src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" alt="grayline" />
    
    <div class="product-detail-wrapper">
    <?php
    	echo '<div style="display:block">'.$this->element('/product/image_details',array('pimage'=>$product['Pimage'][0],'sex'=>$product['Product']['sex'])).'</div>';
		for($i=1; $i < count($product['Pimage']); $i++){
			echo '<div style="display:none">'.$this->element('/product/image_details',array('pimage'=>$product['Pimage'][$i],'sex'=>$product['Product']['sex'])).'</div>';
    	} 
    ?>
	</div>

    <img id="grayline" src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" alt="grayline" />
    
    <div id="size" >
    	<span class="three" ">Size</span><br/>
    <select name="size" size="1">
    <?php 
    	foreach($product['Pdetail'] as $p) {
    		$disable = (!$presale && $p['inventory'] <= 0) ? 'disabled' : '';
    ?>
    	<option value="<?php echo $p['Size']['id']; ?>" <?php echo $disable; ?>><?php echo $p['Size']['display']; ?></option>
    <?php } ?>
    </select>
    </div>
    <div id="quantity">
    	<span  class="three">Quantity</span><br/>
    	<input name="quantity" size="2" value="1" type="text" />
	</div>
</span>

<input id="addtocart" class="one" name="addtocart" type="button" value="&nbsp;Add to Cart&nbsp;" />