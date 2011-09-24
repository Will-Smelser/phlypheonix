<?php 

function shortName($name){
	$len = 50;
	if(strlen($name) > $len-3){
		return substr($name,0,$len) . '...';
	} else {
		return $name;
	}
}

?>
<div id="cart-wrapper">
<form id="cart-form" method="POST" action="/cart/updateAll">
<table>
	<tr>
		<th>&nbsp;</th>
		<th class='cart-one'>Qty.</th>
		<th class='cart-two'>Description</th>
		<th class='cart-three'>Unit Price</th>

<?php 
//debug($content);
$total = 0.00;
foreach($content as $cartEntry){
	echo "\n\t<tr><td>";
	
	echo "<a href=\"/cart/removeAll/{$cartEntry->id}/noajax\" class='cart-trash' ><img src='/img/icons/trash.png' /></a>";
	echo "<td><input class='qty' type='text' name='entry_{$cartEntry->id}' value='{$cartEntry->qty}' />";
	
	if($cartEntry->getType() == 'product'){
		
		$total += $cartEntry->getTotal();
		
		$colorId = $cartEntry->uniques['color'];
		$sizeId  = $cartEntry->uniques['size'];
		
		$color = $colors[$colorId];
		$size  = $sizes[$sizeId];
		
		$name = shortName($cartEntry->info['Product']['desc']);
		$price = cartUtils::formatMoneyUS($cartEntry->getUnitPrice());
		
		echo "<td>$name<td align='right'>$price";
		
		//must always have this additional row
		echo "<tr><td class='cart-details' colspan='3' align='right'><span><b>color:</b> $color</span><span><b>size:</b> $size</span><td><td>&nbsp;";
	} elseif($cartEntry->getType() == 'accessory'){
		
	}
}
$total = cartUtils::formatMoneyUS($total);
echo "\n<tr><td colspan='4' class='cart-total' align='right' class='cart-total'>$total</td></tr>";

?>
</table>
<input id="cart-update" type="submit" value="Update" class="checkout one" />
</form>

</div>