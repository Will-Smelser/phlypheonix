<?php 
/**
 * $product
 */
?>
<div id="uniquefeatures">
    	
    	<div style="padding-left:20px;">
    	<?php foreach($product['Pattribute'] as $p){ ?> 
        <div class="feature-wrapper">
        	<a class="feature-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>">
        	<img src="<?php echo $p['image']; ?>" title="" width="77" height="88" />
        	</a>
        	<div class="attribute-info" style="display:none;"><?php echo $p['description'];?></div>
        </div>
        <?php } ?>
        </div>
</div><!-- End Unique Features -->