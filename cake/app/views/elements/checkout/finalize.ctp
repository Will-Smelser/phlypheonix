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
	
	<div class="title" style="padding-top:10px;">
		Shipping Information
	</div>
	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2">
	<p><?php echo $info['ship_name']; ?></p>
	<p><?php echo $info['ship_line_1']; ?></p>
	<?php if(strlen($info['ship_line_2']) > 0) {?>
		<p><?php echo $info['ship_line_2']; ?></p>
	<?php } ?>
	<p><?php echo $info['ship_city']; ?>, <?php echo $info['ship_state']; ?> <?php echo $info['ship_zip']; ?></p>
	
	
	
	<form method="POST" action="/checkout/finalize" >
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
		<a href="/checkout/index"><input style="float:left" type="button" class="btn" value="Back" /></a>
		<input style="float:right" type="submit" class="btn" value="Complete Order" />
	</div>
	</form>