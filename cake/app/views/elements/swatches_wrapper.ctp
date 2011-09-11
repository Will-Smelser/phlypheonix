<?php 

//reset the array
reset($colors);
reset($swatches);

?>

<div id="swatches-wrapper" style="display:none;">
	<div>
		<span class="title">Select a Pattern</span>
	</div>
	
	<?php 
	//build the swatch list
	foreach($swatches as $entry){
		$productId = $entry[0]['Product']['id'];
		$name = $entry[0]['Product']['name'];
	
		$imageData = $images[$productId][0];
		
		$absImg = WWW_ROOT . str_replace('/',DS,$imageData['image']);
		$dims = $this->Sizer->resizeConstrainX($absImg, 100, 100);
		
		echo "<div class='swatch-wrap' style='padding:5px'>
		<a href='/accessories/index/{$school['School']['id']}/{$sex}/{$imageData['color_id']}'>
			<img height='{$dims[1]}' width='{$dims[0]}' src='{$imageData['image']}' /></a><br/>
			<span class='nine' style='text-align:center;padding:5px;'>{$name}</span>	
		</div>";
	} 
	
	?>
</div>