<?php 
/**
 * $product
 */
?>
<div id="uniquefeatures">
    	<span id="uftext"class="two">Unique Features</span>
    	<?php foreach($product['Pattribute'] as $p){ ?> 
        <img class="one" src="<?php echo $p['image']; ?>" title="<?php echo $p['description']; ?>" width="77" height="88" />
        <?php } ?>
</div><!-- End Unique Features -->