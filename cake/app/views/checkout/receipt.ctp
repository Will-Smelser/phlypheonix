<?php echo $this->element('layouts/lightbg_top');?>

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
	
	$color= $details[$entry->pdetail]['color'];
	$size= $details[$entry->pdetail]['size'];
	echo "<tr class='no-hover'><td class='product-details' colspan='2' align='left'><span class='color'><b>color:</b> $color</span><span class='size'><b>size:</b> $size</span><td><td>&nbsp;";
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