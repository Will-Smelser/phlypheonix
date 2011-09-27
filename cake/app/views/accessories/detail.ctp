<?php 

$img = $data['Pimage'][0]['image'];
$desc = $data['Product']['desc'];
$pid = $data['Product']['id'];
$cid = $data['Pimage'][0]['color_id'];

$psizes = array();
foreach($data['Pdetail'] as $detail){
	//array_push($psizes,$sizes[$detail['size_id']]);
	$psizes[$detail['size_id']] = $sizes[$detail['size_id']];
}

$imgAbs = WWW_ROOT . ltrim(str_replace('/',DS,$img),DS);
$sizes = $this->Sizer->resizeConstrain($imgAbs, 260, 290);

?>
	<div>
		<span class="title">Product Photo</span>
	</div>
	
	<div style="text-align:center">
	<img style="margin-top:5px;margin-bottom:5px;" src="<?php echo $img; ?>" width="<?php echo $sizes[0]; ?>" height="<?php echo $sizes[1]?>" />
	</div>
	
	<!-- 
	<div class="inventory" style="display:none;">
	    <span class="one">Inventory:  <span class="inventory-wrapper"><?php //echo $inv; ?></span></span>
	</div>
	-->
	    
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
	
	<div >
		<span class="title">Product Description</span>
	</div>
	
	<div class="desc-wrapper">
		<span class="description-wrapper two">
			<?php echo $desc; ?>
		</span>
	</div>    

	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
    
    <div class="size-qty-wrapper">
    	<input class="input-product" type="hidden" value="<?php echo $pid; ?>" />
    	<input class="input-color" type="hidden" value="<?php echo $cid; ?>" />
	    
	    <div class="size" >
	    	<span class="three">Size/Option</span><br/>
	    <select class="input-size" name="size" size="1">
	    	<?php 
	    	foreach($psizes as $id=>$name){ 
	    		echo "<option value='{$id}'>{$name}</option>";
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
	
	<input id="qtip-add-to-cart" class="add-to-cart one" style="float:right" name="addtocart" type="button" value="&nbsp;Add to Cart&nbsp;" />