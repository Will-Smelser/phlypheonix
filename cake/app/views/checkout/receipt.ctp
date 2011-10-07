<?php echo $this->element('layouts/lightbg_top');?>
<?php ?>
<?php 

$info = array(
	'bill_name'=>$receipt->billTo->name,
	'bill_line_1'=>$receipt->billTo->line1,
	'bill_line_2'=>$receipt->billTo->line2,
	'bill_city'=>$receipt->billTo->city,
	'bill_state'=>$receipt->billTo->state,
	'bill_zip'=>$receipt->billTo->zip,

	'ship_name'=>$receipt->shipTo->name,
	'ship_line_1'=>$receipt->shipTo->line1,
	'ship_line_2'=>$receipt->shipTo->line2,
	'ship_city'=>$receipt->shipTo->city,
	'ship_state'=>$receipt->shipTo->state,
	'ship_zip'=>$receipt->shipTo->zip,

); 

?>
	<div style="float:left">
	<div class="title">
		Billing Information
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2">
	<p><?php echo $info['bill_name']; ?></p>
	<p><?php echo $info['bill_line_1']; ?></p>
	<?php if(strlen($info['bill_line_2']) > 0) {?>
		<p><?php echo $info['bill_line_2']; ?></p>
	<?php } ?>
	<p><?php echo $info['bill_city']; ?>, <?php echo $info['bill_state']; ?> <?php echo $info['bill_zip']; ?></p>
	</div>
	<div style="float:right">
	<div class="title">
		Shipping Information
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2">
	<p><?php echo $info['ship_name']; ?></p>
	<p><?php echo $info['ship_line_1']; ?></p>
	<?php if(strlen($info['ship_line_2']) > 0) {?>
		<p><?php echo $info['ship_line_2']; ?></p>
	<?php } ?>
	<p><?php echo $info['ship_city']; ?>, <?php echo $info['ship_state']; ?> <?php echo $info['ship_zip']; ?></p>
	</div>
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

	if($entry->type->toString() == 'product'){
		$color= $details[$entry->pdetail]['color'];
		$size= $details[$entry->pdetail]['size'];
		echo "<tr class='no-hover'><td class='product-details' colspan='2' align='left'><span class='color'><b>color:</b> $color</span><span class='size'><b>size:</b> $size</span><td><td>&nbsp;";
	}
}


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