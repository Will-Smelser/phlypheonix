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
    	<?php foreach($product['Pimage'] as $key=>$p){
    			if(preg_match('/front/i',$p['name'])){
    	?>
        	<div class="thumb-wrapper">
        	<a class="gallery-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>" target="_blank">
        		<img  src="<?php echo $p['image']; 	?>" width="77" height="88" />
        	</a>
        	</div>
        		<?php 
        		unset($product['Pimage'][$key]);
        		break;
    			}
         } ?>
        <?php foreach($product['Pimage'] as $p){ ?>
        	<div class="thumb-wrapper">
        	<a class="gallery-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>" target="_blank">
        		<img  src="<?php echo $p['image']; 	?>" width="77" height="88" />
        	</a>
        	</div>
        <?php } ?>
</div><!-- End Thumbnails -->