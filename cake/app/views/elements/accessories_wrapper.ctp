<?php 
/**
 * $inventory
 * 
 */

?>
<div id="tooltip-product" style="display:none;">
	<div>
		<span class="title">Product Photo</span>
	</div>
	
	<div style="text-align:center">
	<img style="margin-top:5px;margin-bottom:5px;" src="" width="260" height="297" id="target-image" />
	</div>
	
	<div id="inventory" style="display:none;">
	    <span class="one">Inventory:  <span id="inventory-wrapper"></span></span>
	</div>
	    
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
	
	<div>
		<span class="title">Product Description</span>
	</div>
	<span id="description-wrapper" class="two">
		
	</span>
    

	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
    
    <div class="size-qty-wrapper">
    	<input id="input-product" type="hidden" value="" />
    	<input id="input-color" type="hidden" value="" />
	    
	    <div class="size" >
	    	<span class="three" ">Size/Option</span><br/>
	    <select id="input-size" name="size" size="1">
	    
	    </select>
	    </div>
	    
	    <div class="quantity">
	    	<span  class="three">Quantity</span><br/>
	    	<input class="input-quantity" id="input-quantity" name="quantity" size="2" value="1" type="text" />
		</div>
	    <div style="clear:both;"></div>
	</div>
	
	<input id="add-cart" class="add-to-cart one" style="float:right" name="addtocart" type="button" value="&nbsp;Add to Cart&nbsp;" />
</div>
