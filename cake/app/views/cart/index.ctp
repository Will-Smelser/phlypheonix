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
<form id="cart-form">
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
	
	echo "<a onclick='window.cart.removeAll(\"/cart/removeAll/{$cartEntry->id}\",this)' class='cart-trash' id='/cart/removeAll/{$cartEntry->id}' ><img src='/img/icons/trash.png' /></a>";
	echo "<td><input class='qty' type='text' name='{$cartEntry->id}' value='{$cartEntry->qty}' />";
	
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
		echo "<tr><td class='cart-details' colspan='3' align='right'><b>color:</b> $color</span><span><b>size:</b> $size</span><td><td>&nbsp;";
	} elseif($cartEntry->getType() == 'accessory'){
		
	}
}
$total = cartUtils::formatMoneyUS($total);
echo "\n<tr><td colspan='4' class='cart-total' align='right' class='cart-total'>$total</td></tr>";

?>
</table>
</form>

<input id="cart-update" type="button" value="Update" class="checkout one" onclick="window.cart.update()" />
</div>