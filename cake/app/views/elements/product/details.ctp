<?php 

/**
 * $product
 * $index What product image is this
 */

$bustText = (strtolower($product['Product']['sex']) == 'f') ? 'BUST' : 'CHEST';

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
    
<span id="description" class="two">
	COLOR:  <?php echo $product['Pimage'][$index]['Color']['name']; ?><br/>
    SHIRT SIZE: <?php echo $product['Pimage'][$index]['Size']['display']; ?><br />
    HEIGHT:  <?php echo $product['Pimage'][$index]['Actor']['height']; ?><br/>
    WEIGHT: <?php echo $product['Pimage'][$index]['Actor']['weight']; ?><br/>
    WAIST: <?php echo $product['Pimage'][$index]['Actor']['waist']; ?><br/>
    <?php echo $bustText; ?> SIZE: <?php echo $product['Pimage'][$index]['Actor']['bust']; ?><br/>
    <a href="#" class="whitelink">SIZING CHART</a></span>
    <img id="grayline" src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" alt="grayline" />
    <div id="size" class="three">SIZE: 
    <select name="size" size="1">
    <?php 
    	foreach($product['Pdetail'] as $p) {
    		$disable = (!$presale && $p['inventory'] <= 0) ? 'disabled' : '';
    ?>
    	<option value="<?php echo $p['Size']['id']; ?>" <?php echo $disable; ?>><?php echo $p['Size']['display']; ?></option>
    <?php } ?>
    </select>
    </div>
    <div id="quantity" class="three">QUANTITY:
    <input name="quantity" size="2" value="1" type="text" />
	</div>
</span>

<input id="addtocart" class="one" name="addtocart" type="button" value="&nbsp;Add to Cart&nbsp;" />