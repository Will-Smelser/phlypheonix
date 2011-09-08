<?php 

//get first color
reset($colors);
reset($swatches);
$firstColor = current($colors);
$colorId = $firstColor[0]['Color']['id'];

$firstSwatch = $swatches[$colorId][0];

?>

<div id="swatches-wrapper" style="display:none;">
	<div>
		<span class="title">Select a Pattern</span>
	</div>
	
	<?php 
	//debug($school);
	//debug($images[$firstSwatch['Product']['id']]);
	foreach($images[$firstSwatch['Product']['id']] as $entry){
		$absImg = WWW_ROOT . str_replace('/',DS,$entry['image']);
		$dims = $this->Sizer->resizeConstrainX($absImg, 100, 100);
		
		echo "<div class='swatch-wrap' style='padding:5px'>
		<a href='/accessories/index/{$school['School']['id']}/{$sex}/{$entry['color_id']}'>
			<img height='{$dims[1]}' width='{$dims[0]}' src='{$entry['image']}' /></a><br/>
			<span class='nine' style='text-align:center;padding:5px;'>{$entry['name']}</span>	
		</div>";
	} 
	
	?>
</div>