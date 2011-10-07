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
 * $schoolId
 * $colors
 */

//abs url
$img = WWW_ROOT . str_replace('\\','/',$image);

//resize the image
$height = 126;

$sizes = $this->Sizer->resizeConstrainY($img, 126, 100);
?>

<div class="imgwrapper" ><!-- Begin Fixed Width Wrapper for Images -->
 	<div class="pname" class="nine"><?php echo $name; ?></div>
 	<div style="height:<?php echo $sizes[1]; ?>px">
    <img id="swatch-image" class="two <?php echo $productClass; ?>" src="<?php echo $image ?>" width="<?php echo $sizes[0]; ?>" height="<?php echo $sizes[1]; ?>" />
	</div>
	
	<div class="pdetails"><!-- Begin wrapper to center product details -->
		
		<form method="post" action="/accessories/index/<?php echo $schoolId.'/'.$sex.'/'.$colorId?>">
		<input type="hidden" id="swatch_sex" value="<?php echo $sex; ?>" />
		<select name="swatch_color" id="swatch_color">
		<?php 
		foreach($swatches as $s){
			$selected = ($s['Color']['id'] == $colorId) ? 'selected' : '';
			echo "\t\t\t<option value='{$s['Color']['id']}' $selected>{$s['Color']['name']}</option>\n";	
		}
		?>
		</select>
		<br/>
		<noscript> 
		<input type="submit" value="Select Color" class="btn three pbutton" />
		</noscript>
		</form>
		<?php if(isset($ajax) && $ajax){ ?>
		<div id="swatch-btn-wrapper" style="display:none;">
			<input id="swatch-btn-change" type="button" class="btn three pbutton" value="Change Color" />
		</div>
		<script lanuage="javascript">$('#swatch-btn-wrapper').show();</script>
		<?php } ?>
	</div>
</div><!-- End pdetails -->

