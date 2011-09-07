<?php
$btn = 'buynow_';
$i=0;




//get first color
reset($colors);
reset($swatches);
$firstColor = current($colors);
$colorId = $firstColor[0]['Color']['id'];

$firstSwatch = $swatches[$colorId][0];

echo $this->element('product/accessories_product',
	array(
		'name'=>'Viewing:&nbsp;'.$images[$firstSwatch['Product']['id']][0]['name'],
		'image'=>$images[$firstSwatch['Product']['id']][0]['image'],
		'price'=>$firstSwatch['Product']['desc'],
		'DOMbtnId'=>'swatch_btn',
		'btnText'=>'View Another Color'
	)
);


foreach($firstColor as $entry){
	$pid = $entry['Product']['id'];
	echo $this->element('product/accessories_product',
		array(
			'name'=>$entry['Product']['name'],
			'image'=>$images[$pid][0]['image'],
			'price'=>'Sale&nbsp;$'.$entry['Product']['price_buynow'],
			'DOMbtnId'=>$btn . $i,
			'btnText'=>'View Product'
		)
	);
	$i++;
}

?>