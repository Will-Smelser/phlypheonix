<?php
$btn = 'buynow_';
$i=0;




//get first color
reset($colors);
reset($swatches);
$firstColor = current($colors);
$colorId = $firstColor[0]['Color']['id'];

$firstSwatch = $swatches[$colorId][0];


//get the image
$img = null;
foreach($images[$firstSwatch['Product']['id']] as $imageColors){
	if($colorId == $imageColors['color_id']){
		$img = $imageColors['image'];
		$name = $imageColors['name'];
	}
}

echo $this->element('product/accessories_product',
	array(
		'name'=>'Current Pattern',
		'image'=>$img,
		'price'=>$name,
		'DOMbtnId'=>'swatch_btn',
		'btnText'=>'View Another Color',
		'productClass'=>'swatch_image',
		'productId'=>$firstSwatch['Product']['id'],
		'colorId'=>$colorId,
		'sex'=>$sex
	)
);


foreach($firstColor as $entry){
	if(!preg_match('/swatch/i',$entry['Product']['name'])){
		$pid = $entry['Product']['id'];
		
		//get the image
		$img = null;
		foreach($images[$pid] as $imageColors){
			if($colorId == $imageColors['color_id']){
				$img = $imageColors['image'];
			}
		}
	
		echo $this->element('product/accessories_product',
			array(
				'name'=>$entry['Product']['name'],
				'image'=>$img,
				'price'=>'Sale&nbsp;$'.$entry['Product']['price_buynow'],
				'DOMbtnId'=>$btn . $i,
				'btnText'=>'View Product',
				'productClass'=>'acc_image',
				'productId'=>$entry['Product']['id'],
				'colorId'=>$colorId,
				'sex'=>$sex
			)
		);
		$i++;
	}
}


?>