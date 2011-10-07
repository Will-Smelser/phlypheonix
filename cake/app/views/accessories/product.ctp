<?php 

echo $this->element('product/accessories_product',
	array(
		'name'=>$data['Product']['name'],
		'image'=>$data['Pimage'][0]['image'],
		'price'=>'Sale&nbsp;$'.$data['Product']['price_buynow'],
		'DOMbtnId'=>'btn_'.$data['Product']['id'],
		'btnText'=>'View Item',
		'productClass'=>'acc_image',
		'productId'=>$data['Product']['id'],
		'colorId'=>$data['Color'][0]['id'],
		'sex'=>$data['Product']['sex'],
		'pdetail'=>$data['Pdetail']
	)
);

?>