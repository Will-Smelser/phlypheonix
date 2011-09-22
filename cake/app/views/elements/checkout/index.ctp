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
?>

	<form method="POST" action="/checkout/index">
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
	<div style="padding-top:20px;">
		<input style="float:right" type="submit" class="btn" value="Continue" />
	</div>
	</div>
</form>