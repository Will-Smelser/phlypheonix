<?php 
/**
 * $name
 * $image
 * $price
 * $DOMbtnId
 * $btnText
 */

//abs url
$img = WWW_ROOT . str_replace('\\','/',$image);

//resize the image
$height = 126;

$sizes = $this->Sizer->resizeConstrainY($img, 126, 120);
?>

<div id="imgwrapper"><!-- Begin Fixed Width Wrapper for Images -->
 	
 	<span id="pname" class="nine"><?php echo $name; ?></span>
    <img class="two" src="<?php echo $image ?>" width="<?php echo $sizes[0]; ?>" height="<?php echo $sizes[1]; ?>" />
	
	<div id="pdetails"><!-- Begin wrapper to center product details -->
		<span id="price" class="six"><?php echo $price; ?></span><br/>
		<input id="<?php echo $DOMbtnId; ?>" class="three" name="viewproduct" type="button" value="<?php echo $btnText; ?>" />
	</div>
</div><!-- End pdetails -->
