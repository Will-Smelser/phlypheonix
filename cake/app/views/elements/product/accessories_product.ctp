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
		<span class="price" class="six"><?php echo $price; ?></span><br/>
		<input id="<?php echo $DOMbtnId; ?>" class="three pbutton" name="viewproduct" type="button" value="<?php echo $btnText; ?>" />
	</div>
</div><!-- End pdetails -->
