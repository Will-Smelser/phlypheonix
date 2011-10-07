<?php 

/**
 * $pimage
 */

$bustText = (strtolower($sex) == 'f') ? 'Bust' : 'Chest';

?>

	<span class="title">Product</span>
	
	<table class="product-details left" >
		<tr>
			<th>Color</th>
			<th>Size</th>
		</tr>
		<tr>
			<td><?php echo $pimage['Color']['name']; ?></td>
			<td><?php echo $pimage['Size']['display']; ?></td>
		</tr>
	</table>
	
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" alt="grayline" />
	<div class="actor-stats">
	<span  class="title">Model</span>
	<table class="product-details right">
		<tr>
			<th>Height</th>
			<th>Weight</th>
			<th>Waist</th>
			<th><?php echo $bustText; ?></th>
		</tr>
		<tr>
			<td><?php echo $pimage['Actor']['height']; ?></td>
			<td><?php echo $pimage['Actor']['weight']; ?></td>
			<td><?php echo $pimage['Actor']['waist']; ?></td>
			<td><?php echo $pimage['Actor']['bust']; ?></td>
		</tr>
	</table>
    </div>
    <a href="#" class="whitelink chart" onclick="showSizeChart();">SIZING CHART</a>