<?php 
/**
 * $product
 */

	$x = 77;
	$h = 88;
	
	function(){
		
		
	}

?>

<div id="thumbnails">
    	<div id="thumbtext" class="two">More Photos</div>
        <?php foreach($product['Pimage'] as $p){ ?>
        	<div class="thumb-wrapper">
        	<a class="gallery-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>" target="_blank">
        		<img  src="<?php echo $p['image']; 	?>" width="77" height="88" />
        	</a>
        	</div>
        <?php } ?>
</div><!-- End Thumbnails -->