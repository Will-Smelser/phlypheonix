<?php 
$states = array(
			'AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming"
);

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
<?php if(isset($good) && count($good) > 0){ ?>
	<div id="good-console" class="border-rad-med good">
	<?php 
		foreach($good as $error){
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
//$taxes = cartUtils::formatMoneyUS($taxes); 
$taxes = 'TBD';

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
			<form method="post" action="/checkout/addcoupon">
			<span>Coupon Code</span><br/>
			<input type="text" name="coupon" id="coupon" class="line" value="" />
			<span style="padding-left:5px;"></span><input type="submit" class="btn" value="Add" /></span>
			</form>
		</div>
	</div>
<?php echo $this->element('layouts/lightbg_bottom'); ?>
</div>


<div id="details-wrapper">
	<form method="POST" action="/checkout/process">
	<div class="title">
		Billing Information
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2">
	<div>
		<span>Name</span><br/>
		<input type="text" name="bill_name" id="bill_name" class="line <?php echo $errorClass['bill_name']; ?>" value="<?php echo $fieldData['bill_name']; ?>" />
	</div>
	<div>
		<span>Address Line 1</span><br/>
		<input type="text" name="bill_line_1" id="bill_line_1" class="line <?php echo $errorClass['bill_line_1']; ?>" value="<?php echo $fieldData['bill_line_1']; ?>" />
	</div>
	<div>
		<span>Address Line 2</span><br/>
		<input type="text" name="bill_line_2" id="bill_line_2" class="line <?php echo $errorClass['bill_line_2']; ?>"  value="<?php echo $fieldData['bill_line_2']; ?>" />
	</div>
	<div>
		<div style="width:265px">
			<table width="100%" ><tr>
			<td style="text-align:left;">
			<div class="line-3">
				<span>City</span><br/>
				<input type="text" name="bill_city" id="bill_city" class="city  <?php echo $errorClass['bill_city']; ?>" value="<?php echo $fieldData['bill_city']; ?>" />
			</div>
			</td><td style="text-align:center;">
			<div class="line-3">
				<span>State</span><br/>
				<select name="bill_state" id="bill_state" class="<?php echo $errorClass['bill_state']; ?>" >
					<?php 
					foreach($states as $short=>$long) {
						$selected = ($short == $fieldData['bill_state']) ? 'selected' : '';
						echo "\t<option value='$short' $selected>$short</option>\n";
					}
					?>
				</select>
			</div>
			</td><td style="text-align:right;">
			<div class="line-3">
				<span>Zip</span><br/>
				<input type="text" name="bill_zip" id="bill_zip" class="zip <?php echo $errorClass['bill_zip']; ?>" value="<?php echo $fieldData['bill_zip']; ?>" />
			</div>
			</td></tr></table>
	</div>
	
	<div style="padding-top:10px;">
		<span class="title">Shipping Information</span>&nbsp;&nbsp;<span style="font-size:12px">(same as billing <input name="billing-cbox" id="billing-cbox" type="checkbox" <?php if(isset($post['billing-cbox']) || !isset($post)) echo 'checked'; ?> />)</span>
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" />
	<div id="billing-wrapper">
		
		<div>
			<span>Name</span><br/>
			<input type="text" name="ship_name" id="ship_name" class="line <?php echo $errorClass['ship_name']; ?>" value="<?php echo $fieldData['ship_name']; ?>" />
		</div>
		<div>
			<span>Address Line 1</span><br/>
			<input type="text" name="ship_line_1" id="ship_line_1" class="line <?php echo $errorClass['ship_line_1']; ?>" value="<?php echo $fieldData['ship_line_1']; ?>" />
		</div>
		<div>
			<span>Address Line 2</span><br/>
			<input type="text" name="ship_line_2" id="ship_line_2" class="line <?php echo $errorClass['ship_line_2']; ?>" value="<?php echo $fieldData['ship_line_2']; ?>" />
		</div>
		<div style="width:265px">
			<table width="100%" ><tr>
			<td style="text-align:left;">
			<div class="line-3">
				<span>City</span><br/>
				<input type="text" name="ship_city" id="ship_city" class="city <?php echo $errorClass['ship_city']; ?>" value="<?php echo $fieldData['ship_city']; ?>" />
			</div>
			</td><td style="text-align:center;">
			<div class="line-3">
				<span>State</span><br/>
				<select name="ship_state" id="ship_state" class="<?php echo $errorClass['ship_state']; ?>">
					<?php 
					foreach($states as $short=>$long) {
						$selected = ($short == $fieldData['ship_state']) ? 'selected' : '';
						echo "\t<option value='$short' $selected>$short</option>\n";
					}
					?>
				</select>
			</div>
			</td><td style="text-align:right;">
			<div class="line-3">
				<span>Zip</span><br/>
				<input type="text" name="ship_zip" id="ship_zip" class="zip <?php echo $errorClass['ship_zip']; ?>" value="<?php echo $fieldData['ship_zip']; ?>" />
			</div>
			</td></tr></table>
		</div>
	</div>
	<div class="title" style="padding-top:10px;">
		Credit Information
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2">
	<div>
		<span>Card Number</span><br/>
		<input type="text" name="card_number" id="card_number" class="line <?php echo $errorClass['card_number']; ?>" value="<?php echo $fieldData['card_number']; ?>" />
	</div>
	<div  style="text-align:center;width:265px">
		<table width="100%" ><tr>
		<td style="text-align:left;">
		<div class="line-3">
			<span>Exp. MM</span><br/>
			<select name="card_exp_mm" id="card_exp_mm" class="<?php echo $errorClass['card_exp_mm']; ?>">
				<?php 
				for($i = 1; $i < 13; $i++){
					$temp = str_pad($i, 2, "0", STR_PAD_LEFT);
					$selected = ($fieldData['card_exp_mm'] == $temp) ? 'selected' : '';
					echo "\t\t<option vlaue='$temp' $selected>$temp</option>\n";
				}
				?>
			</select>
		</div>
		</td><td style="text-align:center;">
		<div class="line-3">
			<span>Exp. YY</span><br/>
			<select name="card_exp_yy" id="ship_exp_yy" class="<?php echo $errorClass['card_exp_yy']; ?>">
				<?php
				$thisYear = date('y') * 1;
				for($i = 1; $i < 8; $i++){
					$temp = str_pad($thisYear, 2, "0", STR_PAD_LEFT);
					$selected = ($fieldData['card_exp_yy'] == $thisYear ) ? 'selected' : '';
					
					echo "\t\t<option value='$temp' $selected>$temp</option>\n";
					
					$thisYear = 1 + $temp * 1;
				}
				?>
			</select>
		</div>
		</td><td style="text-align:right;">
		<div class="line-3">
			<span>C V V</span><br/>
			<input type="text" name="card_cvv" id="card_cvv" class="zip <?php echo $errorClass['card_cvv']; ?>" value="<?php echo $fieldData['card_cvv']; ?>" />
		</div>
		</td></tr></table>
	</div>
	<div style="padding-top:20px;">
		<input style="float:right" type="submit" class="btn" value="Purchase" />
	</div>
	</form>
	<div style="margin-top: 40px;">
	<!-- VeriSign Trust Seal -->
	<?php echo $this->element('trustseal',array('protocal'=>$protocal)); ?>
	</div>
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