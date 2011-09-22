<?php 


//setup default information
//all fields
$fields = array(
	'bill_name', 'bill_line_1', 'bill_line_2','bill_city', 'bill_state', 'bill_zip',
	'ship_name', 'ship_line_1', 'ship_line_2','ship_city', 'ship_state', 'ship_zip',
	'card_number', 'card_exp_mm', 'card_exp_yy', 'card_cvv'
);
$fieldData = array();
$errorClass = array();
foreach($fields as $fname){
	//for form values
	switch($fname){
		default:
			$fieldData[$fname] = (isset($post[$fname])) ? $post[$fname] : ''; 
		break;
		case 'bill_name':
		case 'ship_name':
			$fieldData[$fname] = (isset($post[$fname])) ? $post[$fname] : 
				$myuser['User']['fname'] . ' ' . $myuser['User']['lname'];
		break;
	}
	//for error
	$errorClass[$fname] = (isset($errors[$fname])) ? 'error' : '';
	
}
//debug($errorClass);
//debug($errors);
?>
<div id="receipt-wrapper">

<?php if(isset($errors) && count($errors) > 0){ ?>
	<div id="error-console" class="border-rad-med error">
	<?php 
		foreach($errors as $error){
			echo "<div><span class='ename'>{$error->getDisplayName()}</span><span class='emsg'>{$error->getMsg()}</span></div>\n";
		}
	?>
	</div>
<?php } ?>

<?php echo $this->element('layouts/lightbg_top'); ?>
<table id="receipt-table">
<tr class="header">
	<th class="border-rad-left">Name
	<th style="text-align:right">Qty.
	<th style="text-align:right;">Unit Price
	<th class="border-rad-right" style="text-align:right;">Ext. Price
<?php 

foreach($before as $entry){
	$name = $entry->name;
	$unit = cartUtils::formatMoneyUS($entry->priceUnit);
	$qty  = $entry->qty;
	$tot  = cartUtils::formatMoneyUS($entry->priceUnit * $qty);
	
	echo "<tr><td>$name<td class='qty'>$qty<td class='unit'>$unit<td class='total'>$tot\n";
	
	$cartEntry = $ccart->getProduct($entry->id);
	$colorId = $cartEntry->uniques['color'];
	$sizeId  = $cartEntry->uniques['size'];
	$color = $colors[$colorId];
	$size  = $sizes[$sizeId];
	
	echo "<tr class='no-hover'><td class='product-details' colspan='2' align='left'><span class='color'><b>color:</b> $color</span><span class='size'><b>size:</b> $size</span><td><td>&nbsp;";
}

$subtotal = cartUtils::formatMoneyUS($subtotal);

$taxes = ($this->params['action'] == 'index') ? 'TBD' : cartUtils::formatMoneyUS($taxes); 

echo "<tr class='no-hover'><td colspan='3' class='sub'>Subtotal<td class='sub total'>$subtotal\n";
echo "<tr class='no-hover'><td colspan='3' class='tax'>Taxes<td class='tax total'>$taxes\n";

echo '<tr class="no-hover"><td colspan="4">&nbsp;'."\n";

foreach($after as $entry){
	$name = $entry->name;
	$unit = cartUtils::formatMoneyUS($entry->priceUnit);
	$qty  = $entry->qty;
	$tot  = cartUtils::formatMoneyUS($entry->priceUnit * $qty);
	
	echo "<tr><td>$name<td class='qty'>$qty<td class='unit'>$unit<td class='total'>$tot\n";
}

$total = cartUtils::formatMoneyUS($total);
echo "<tr class='no-hover'><td colspan='3' style='text-align:right' class='grand'>Total<td class='grand total'>$total\n";

?>
</table>
<?php echo $this->element('layouts/lightbg_bottom'); ?>

<?php echo $this->element('layouts/lightbg_top'); ?>
	<div style="padding:3px">
		<div class="title">
			Add a Coupon / Discount
		</div>
		<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2">
		<div>
			<span>Coupon Code</span><br/>
			<input type="text" name="coupon" id="coupon" class="line" value="" />
			<span style="padding-left:5px;"></span><input type="submit" class="btn" value="Add" /></span>
		</div>
	</div>
<?php echo $this->element('layouts/lightbg_bottom'); ?>
</div>


<div id="details-wrapper">
	<?php
	if($this->params['action'] == 'index'){ 
		echo $this->element('checkout/index',array('errorClass'=>$errorClass,'fieldData'=>$fieldData));
	}else{
		echo $this->element('checkout/finalize',array('errorClass'=>$errorClass,'fieldData'=>$fieldData));
	} 
	?>
</div>
<div class="clear:both"></div>

<script language="javascript">
//hide and show the ship to address box

$('#billing-cbox').click(function(){
	if($(this).attr('checked')){
		$('#billing-wrapper').slideUp();
	} else {
		$('#billing-wrapper').slideDown();
	}
});


//bind additional cart stuff
$(document).ready(function(){
	if($('#billing-cbox').attr('checked')) $('#billing-wrapper').slideUp();
	
	setTimeout(function(){
		window.cart.updateCallback = function(){
			document.location.href = '/checkout/index';
		};
	},1000);

	setTimeout(function(){
		window.cart.deleteCallback = function(){
			document.location.href = '/checkout/index';
		};
	},1000);
	
});


</script>