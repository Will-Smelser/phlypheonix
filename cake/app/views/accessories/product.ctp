<?php 
echo $this->element('product/accessories_product',
	array(
		'name'=>$data['Product']['name'],
		'image'=>$data['Pimage'][0]['image'],
		'price'=>'Sale&nbsp;$'.$data['Product']['price_buynow'],
		'DOMbtnId'=>time(),
		'btnText'=>'View Product',
		'productClass'=>'acc_image',
		'productId'=>$data['Product']['id'],
		'colorId'=>$data['Color'][0]['id'],
		'sex'=>$data['Product']['sex']
	)
);
?>