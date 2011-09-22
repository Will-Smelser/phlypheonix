<div id="accessories-tool-tips" style="display: none;">
<?php 
/**
 * $inventory
 * 
 */

//debug($colors);
//debug($images);
//debug($pdetails);

reset($colors);
$start = current($colors);

foreach($start as $entry){
	
	$Product = $entry['Product'];
	$Color = $entry['Color'];
	
	if(!preg_match('/swatch/i',$Product['name'])){
			
	//get the image and size
	$img = null;
	foreach($images[$Product['id']] as $imageColors){
		if($Color['id'] == $imageColors['color_id']){
			$img = $imageColors['image'];
		}
	}
	$imgAbs = WWW_ROOT . ltrim(str_replace('/',DS,$img),DS);
	$sizes = $this->Sizer->resizeConstrain($imgAbs, 260, 290);
	
	//get the Sizes
	$inv = 0;
	$psizes = array();
	foreach($pdetails as $p){
		if($p['Pdetail']['product_id'] == $Product['id'] && $Color['id'] == $p['Pdetail']['color_id']){
			array_push($psizes, $p['Size']);
			$inv += $p['Pdetail']['inventory'];
		}
	}
	
?>
<div class="tooltip" id="tooltip-product-<?php echo $Product['id']; ?>" >
	<div>
		<span class="title">Product Photo</span>
	</div>
	
	<div style="text-align:center">
	<img style="margin-top:5px;margin-bottom:5px;" src="<?php echo $img; ?>" width="<?php echo $sizes[0]; ?>" height="<?php echo $sizes[1]?>" />
	</div>
	
	<div class="inventory" style="display:none;">
	    <span class="one">Inventory:  <span class="inventory-wrapper"><?php echo $inv; ?></span></span>
	</div>
	    
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
	
	<div>
		<span class="title">Product Description</span>
	</div>
	<span class="description-wrapper two">
		<?php echo $Product['desc']; ?>
	</span>
    

	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
    
    <div class="size-qty-wrapper">
    	<input class="input-product" type="hidden" value="<?php echo $Product['id']; ?>" />
    	<input class="input-color" type="hidden" value="<?php echo $Color['id']; ?>" />
	    
	    <div class="size" >
	    	<span class="three" ">Size/Option</span><br/>
	    <select class="input-size" name="size" size="1">
	    	<?php 
	    	foreach($psizes as $s){ 
	    		echo "<option value='{$s['id']}'>{$s['display']}</option>";
	    	}
	    	?>
	    </select>
	    </div>
	    
	    <div class="quantity">
	    	<span  class="three">Quantity</span><br/>
	    	<input class="input-quantity" name="quantity" size="2" value="1" type="text" />
		</div>
	    <div style="clear:both;"></div>
	</div>
	
	<input class="add-to-cart one" style="float:right" name="addtocart" type="button" value="&nbsp;Add to Cart&nbsp;" />
</div>
<?php 
	}
}
?>
</div>