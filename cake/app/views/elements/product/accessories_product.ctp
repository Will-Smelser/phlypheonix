<?php 
/**
 * $name
 * $image
 * $price
 * $DOMbtnId
 * $btnText
 * $productClass
 * $productId
 * $colorId
 * $sex
 * $pattributeId
 */

//abs url
$img = WWW_ROOT . str_replace('\\','/',$image);

//resize the image
$height = 126;

$sizes = $this->Sizer->resizeConstrainY($img, 126, 120);
?>

<div class="imgwrapper"><!-- Begin Fixed Width Wrapper for Images -->
 	
 	<div class="pname" class="nine"><?php echo $name; ?></div>
    <img id="product-<?php echo $productId; ?>_color-<?php echo $colorId; ?>_sex-<?php echo $sex; ?>" class="two <?php echo $productClass; ?>" src="<?php echo $image ?>" width="<?php echo $sizes[0]; ?>" height="<?php echo $sizes[1]; ?>" />
	
	<div class="pdetails"><!-- Begin wrapper to center product details -->
		<form method="post" action="/cart/addProductNoAjax" >
		<span class="price" class="six"><?php echo $price; ?></span><br/>
		<input type="hidden" name="product" value="<?php echo $productId; ?>" />
		<input type="hidden" name="quantity" value="1" />
		<input type="hidden" name="size" value="<?php echo $pdetail[0]['size_id']; ?>" />
		<input type="hidden" name="color" value="<?php echo $pdetail[0]['color_id']; ?>" />
		<input type="hidden" name="returnUrl" value="/<?php echo $this->params['url']['url']; ?>" />
		<noscript>
			<input class="btn three pbutton" name="product" type="submit" value="<?php echo $btnText; ?>" />
		</noscript>
		<input id="<?php echo$DOMbtnId?>" type="button" class="btn three pbutton view_detail_btn" name="product" value="View Item" style="display:none" />
		<script language="javascript">$('#<?php echo $DOMbtnId;?>').show();</script>
		</form>
	</div>
</div><!-- End pdetails -->
