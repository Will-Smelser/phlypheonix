<?php
	$height = 613; 
	$width  = 920;
	
	$imgUrl = Configure::read('siteconfig.signup.image');
	
	list($imgWidth, $imgHeight) = $this->Sizer->resizeConstrainX(WWW_ROOT . $imgUrl,$width,$height);
	$mainImage = str_replace(DS,'/',$imgUrl);
?>
<div id="model-image-main">
	<img class="image" src="<?php echo $mainImage; ?>" width="<?php echo $imgWidth; ?>" height="<?php echo $imgHeight; ?>" />
</div>
<div id="content-wrapper">
<div id="column-one">
<form id="UserRegisterForm" method="post" action="/users/signup_process" accept-charset="utf-8" style="margin:0px;padding:0px;">

<div class="reg-sub-wrapper" id="register-form">
<div class="reg-header title">
<div class="title-inner f-accented2">Register<a id="edit-user" style="font-size:15px;padding-left:20px;">edit</a></div>
</div>
<div id="user-wrap" class="reg-inner">

  <div style="display:none;">
    <input type="hidden" name="_method" value="POST" />
  </div>
  <div class="input text required">
    <label for="username">Username</label>
    <input name="data[User][username]" type="text" maxlength="40" id="username" />
	<div id="error-username" class="error-message"></div>
  </div>
  <div class="input text required">
    <label for="email">Email</label>
    <input name="data[User][email]" type="text" maxlength="150" id="email" />
	<div id="error-email" class="error-message"></div>
  </div>
  <div class="input password required">
    <label for="password">Password</label>
    <input type="password" name="data[User][password]" id="password" />
	<div id="error-password" class="error-message"></div>
  </div>
  <div class="input password required">
    <label for="pass_confirm">Password Confirm</label>
    <input type="password" name="data[User][password_confirm]" value="" id="pass_confirm" />
	<div id="error-passconfirm" class="error-message"></div>
  </div>
  
  <div class="submit">
    <input class="btn" type="button" value="Next" id="check_user" />
  </div>
</div>
</div>
<div class="reg-sub-wrapper" id="register-billing">
<div class="reg-header">
<div class="reg-header title">
<div class="title-inner f-accented2">Billing Information<a id="edit-billing" style="font-size:15px;padding-left:20px;">edit</a></div>
</div>
</div>
<div id="billing-wrap" class="reg-inner">
  <div class="input text required">
    <label for="firstname">First Name</label>
    <input name="data[User][firstname]" type="text" maxlength="40" id="firstname" />
	<div id="error-firstname" class="error-message"></div>
  </div>
  <div class="input text required">
    <label for="lastname">Last Name</label>
    <input name="data[User][lastname]" type="text" maxlength="40" id="lastname" />
	<div id="error-lastname" class="error-message"></div>
  </div>
  <div class="input text required">
    <label for="address">Address</label>
    <input name="data[User][address]" type="text" maxlength="40" id="address" />
	<div id="error-address" class="error-message"></div>
  </div>
  <div class="input text required">
    <label for="city">City / Province</label>
    <input name="data[User][city]" type="text" maxlength="40" id="city" />
	<div id="error-city" class="error-message"></div>
  </div>
  
  <div class="input text required">
    <label for="zip">Postal Code</label>
    <input name="data[User][zip]" type="text" maxlength="40" id="zip" />
	<div id="error-zip" class="error-message"></div>
  </div>
    
  <div class="input text required">
    <label for="UserCountry">Country</label>
    <select name="data[User][country]" id="country" >
			<option value="US" selected>United States</option>
			<option value="CA">Canada</option>
			<option value="">----------</option>
			<option value="AF">Afghanistan</option>
			<option value="AL">Albania</option>
			<option value="DZ">Algeria</option>
			<option value="AS">American Samoa</option>
			<option value="AD">Andorra</option>
			<option value="AO">Angola</option>
			<option value="AI">Anguilla</option>
			<option value="AQ">Antarctica</option>
			<option value="AG">Antigua and Barbuda</option>
			<option value="AR">Argentina</option>
			<option value="AM">Armenia</option>
			<option value="AW">Aruba</option>
			<option value="AU">Australia</option>
			<option value="AT">Austria</option>
			<option value="AZ">Azerbaidjan</option>
			<option value="BS">Bahamas</option>
			<option value="BH">Bahrain</option>
			<option value="BD">Bangladesh</option>
			<option value="BB">Barbados</option>
			<option value="BY">Belarus</option>
			<option value="BE">Belgium</option>
			<option value="BZ">Belize</option>
			<option value="BJ">Benin</option>
			<option value="BM">Bermuda</option>
			<option value="BT">Bhutan</option>
			<option value="BO">Bolivia</option>
			<option value="BA">Bosnia-Herzegovina</option>
			<option value="BW">Botswana</option>
			<option value="BV">Bouvet Island</option>
			<option value="BR">Brazil</option>
			<option value="IO">British Indian Ocean Territory</option>
			<option value="BN">Brunei Darussalam</option>
			<option value="BG">Bulgaria</option>
			<option value="BF">Burkina Faso</option>
			<option value="BI">Burundi</option>
			<option value="KH">Cambodia</option>
			<option value="CM">Cameroon</option>
			<option value="CV">Cape Verde</option>
			<option value="KY">Cayman Islands</option>
			<option value="CF">Central African Republic</option>
			<option value="TD">Chad</option>
			<option value="CL">Chile</option>
			<option value="CN">China</option>
			<option value="CX">Christmas Island</option>
			<option value="CC">Cocos (Keeling) Islands</option>
			<option value="CO">Colombia</option>
			<option value="KM">Comoros</option>
			<option value="CG">Congo</option>
			<option value="CK">Cook Islands</option>
			<option value="CR">Costa Rica</option>
			<option value="HR">Croatia</option>
			<option value="CU">Cuba</option>
			<option value="CY">Cyprus</option>
			<option value="CZ">Czech Republic</option>
			<option value="DK">Denmark</option>
			<option value="DJ">Djibouti</option>
			<option value="DM">Dominica</option>
			<option value="DO">Dominican Republic</option>
			<option value="TP">East Timor</option>
			<option value="EC">Ecuador</option>
			<option value="EG">Egypt</option>
			<option value="SV">El Salvador</option>
			<option value="GQ">Equatorial Guinea</option>
			<option value="ER">Eritrea</option>
			<option value="EE">Estonia</option>
			<option value="ET">Ethiopia</option>
			<option value="FK">Falkland Islands</option>
			<option value="FO">Faroe Islands</option>
			<option value="FJ">Fiji</option>
			<option value="FI">Finland</option>
			<option value="CS">Former Czechoslovakia</option>
			<option value="SU">Former USSR</option>
			<option value="FR">France</option>
			<option value="FX">France (European Territory)</option>
			<option value="GF">French Guyana</option>
			<option value="TF">French Southern Territories</option>
			<option value="GA">Gabon</option>
			<option value="GM">Gambia</option>
			<option value="GE">Georgia</option>
			<option value="DE">Germany</option>
			<option value="GH">Ghana</option>
			<option value="GI">Gibraltar</option>
			<option value="GB">Great Britain</option>
			<option value="GR">Greece</option>
			<option value="GL">Greenland</option>
			<option value="GD">Grenada</option>
			<option value="GP">Guadeloupe (French)</option>
			<option value="GU">Guam (USA)</option>
			<option value="GT">Guatemala</option>
			<option value="GN">Guinea</option>
			<option value="GW">Guinea Bissau</option>
			<option value="GY">Guyana</option>
			<option value="HT">Haiti</option>
			<option value="HM">Heard and McDonald Islands</option>
			<option value="HN">Honduras</option>
			<option value="HK">Hong Kong</option>
			<option value="HU">Hungary</option>
			<option value="IS">Iceland</option>
			<option value="IN">India</option>
			<option value="ID">Indonesia</option>
			<option value="INT">International</option>
			<option value="IR">Iran</option>
			<option value="IQ">Iraq</option>
			<option value="IE">Ireland</option>
			<option value="IL">Israel</option>
			<option value="IT">Italy</option>
			<option value="CI">Ivory Coast (Cote D&#39;Ivoire)</option>
			<option value="JM">Jamaica</option>
			<option value="JP">Japan</option>
			<option value="JO">Jordan</option>
			<option value="KZ">Kazakhstan</option>
			<option value="KE">Kenya</option>
			<option value="KI">Kiribati</option>
			<option value="KW">Kuwait</option>
			<option value="KG">Kyrgyzstan</option>
			<option value="LA">Laos</option>
			<option value="LV">Latvia</option>
			<option value="LB">Lebanon</option>
			<option value="LS">Lesotho</option>
			<option value="LR">Liberia</option>
			<option value="LY">Libya</option>
			<option value="LI">Liechtenstein</option>
			<option value="LT">Lithuania</option>
			<option value="LU">Luxembourg</option>
			<option value="MO">Macau</option>
			<option value="MK">Macedonia</option>
			<option value="MG">Madagascar</option>
			<option value="MW">Malawi</option>
			<option value="MY">Malaysia</option>
			<option value="MV">Maldives</option>
			<option value="ML">Mali</option>
			<option value="MT">Malta</option>
			<option value="MH">Marshall Islands</option>
			<option value="MQ">Martinique (French)</option>
			<option value="MR">Mauritania</option>
			<option value="MU">Mauritius</option>
			<option value="YT">Mayotte</option>
			<option value="MX">Mexico</option>
			<option value="FM">Micronesia</option>
			<option value="MD">Moldavia</option>
			<option value="MC">Monaco</option>
			<option value="MN">Mongolia</option>
			<option value="MS">Montserrat</option>
			<option value="MA">Morocco</option>
			<option value="MZ">Mozambique</option>
			<option value="MM">Myanmar</option>
			<option value="NA">Namibia</option>
			<option value="NR">Nauru</option>
			<option value="NP">Nepal</option>
			<option value="NL">Netherlands</option>
			<option value="AN">Netherlands Antilles</option>
			<option value="NT">Neutral Zone</option>
			<option value="NC">New Caledonia (French)</option>
			<option value="NZ">New Zealand</option>
			<option value="NI">Nicaragua</option>
			<option value="NE">Niger</option>
			<option value="NG">Nigeria</option>
			<option value="NU">Niue</option>
			<option value="NF">Norfolk Island</option>
			<option value="KP">North Korea</option>
			<option value="MP">Northern Mariana Islands</option>
			<option value="NO">Norway</option>
			<option value="OM">Oman</option>
			<option value="PK">Pakistan</option>
			<option value="PW">Palau</option>
			<option value="PA">Panama</option>
			<option value="PG">Papua New Guinea</option>
			<option value="PY">Paraguay</option>
			<option value="PE">Peru</option>
			<option value="PH">Philippines</option>
			<option value="PN">Pitcairn Island</option>
			<option value="PL">Poland</option>
			<option value="PF">Polynesia (French)</option>
			<option value="PT">Portugal</option>
			<option value="PR">Puerto Rico</option>
			<option value="QA">Qatar</option>
			<option value="RE">Reunion (French)</option>
			<option value="RO">Romania</option>
			<option value="RU">Russian Federation</option>
			<option value="RW">Rwanda</option>
			<option value="GS">S. Georgia & S. Sandwich Isls.</option>
			<option value="SH">Saint Helena</option>
			<option value="KN">Saint Kitts & Nevis Anguilla</option>
			<option value="LC">Saint Lucia</option>
			<option value="PM">Saint Pierre and Miquelon</option>
			<option value="ST">Saint Tome (Sao Tome) and Principe</option>
			<option value="VC">Saint Vincent & Grenadines</option>
			<option value="WS">Samoa</option>
			<option value="SM">San Marino</option>
			<option value="SA">Saudi Arabia</option>
			<option value="SN">Senegal</option>
			<option value="SC">Seychelles</option>
			<option value="SL">Sierra Leone</option>
			<option value="SG">Singapore</option>
			<option value="SK">Slovak Republic</option>
			<option value="SI">Slovenia</option>
			<option value="SB">Solomon Islands</option>
			<option value="SO">Somalia</option>
			<option value="ZA">South Africa</option>
			<option value="KR">South Korea</option>
			<option value="ES">Spain</option>
			<option value="LK">Sri Lanka</option>
			<option value="SD">Sudan</option>
			<option value="SR">Suriname</option>
			<option value="SJ">Svalbard and Jan Mayen Islands</option>
			<option value="SZ">Swaziland</option>
			<option value="SE">Sweden</option>
			<option value="CH">Switzerland</option>
			<option value="SY">Syria</option>
			<option value="TJ">Tadjikistan</option>
			<option value="TW">Taiwan</option>
			<option value="TZ">Tanzania</option>
			<option value="TH">Thailand</option>
			<option value="TG">Togo</option>
			<option value="TK">Tokelau</option>
			<option value="TO">Tonga</option>
			<option value="TT">Trinidad and Tobago</option>
			<option value="TN">Tunisia</option>
			<option value="TR">Turkey</option>
			<option value="TM">Turkmenistan</option>
			<option value="TC">Turks and Caicos Islands</option>
			<option value="TV">Tuvalu</option>
			<option value="UG">Uganda</option>
			<option value="UA">Ukraine</option>
			<option value="AE">United Arab Emirates</option>
			<option value="GB">United Kingdom</option>
			<option value="UY">Uruguay</option>
			<option value="MIL">USA Military</option>
			<option value="UM">USA Minor Outlying Islands</option>
			<option value="UZ">Uzbekistan</option>
			<option value="VU">Vanuatu</option>
			<option value="VA">Vatican City State</option>
			<option value="VE">Venezuela</option>
			<option value="VN">Vietnam</option>
			<option value="VG">Virgin Islands (British)</option>
			<option value="VI">Virgin Islands (USA)</option>
			<option value="WF">Wallis and Futuna Islands</option>
			<option value="EH">Western Sahara</option>
			<option value="YE">Yemen</option>
			<option value="YU">Yugoslavia</option>
			<option value="ZR">Zaire</option>
			<option value="ZM">Zambia</option>
			<option value="ZW">Zimbabwe</option>

	</select>
	<div id="error-country" class="error-message"></div>
  </div>
  
    <div class="input text required">
    <label for="state_us state_nonus">State</label>
	<div style="display:inline;" id="state_us_wrapper">
    <select id="state_us" name="data[User][state][us]">
		<option value="" selected="selected">Select a State</option> 
		<option value="AL">Alabama</option> 
		<option value="AK">Alaska</option> 
		<option value="AZ">Arizona</option> 
		<option value="AR">Arkansas</option> 
		<option value="CA">California</option> 
		<option value="CO">Colorado</option> 
		<option value="CT">Connecticut</option> 
		<option value="DE">Delaware</option> 
		<option value="DC">District Of Columbia</option> 
		<option value="FL">Florida</option> 
		<option value="GA">Georgia</option> 
		<option value="HI">Hawaii</option> 
		<option value="ID">Idaho</option> 
		<option value="IL">Illinois</option> 
		<option value="IN">Indiana</option> 
		<option value="IA">Iowa</option> 
		<option value="KS">Kansas</option> 
		<option value="KY">Kentucky</option> 
		<option value="LA">Louisiana</option> 
		<option value="ME">Maine</option> 
		<option value="MD">Maryland</option> 
		<option value="MA">Massachusetts</option> 
		<option value="MI">Michigan</option> 
		<option value="MN">Minnesota</option> 
		<option value="MS">Mississippi</option> 
		<option value="MO">Missouri</option> 
		<option value="MT">Montana</option> 
		<option value="NE">Nebraska</option> 
		<option value="NV">Nevada</option> 
		<option value="NH">New Hampshire</option> 
		<option value="NJ">New Jersey</option> 
		<option value="NM">New Mexico</option> 
		<option value="NY">New York</option> 
		<option value="NC">North Carolina</option> 
		<option value="ND">North Dakota</option> 
		<option value="OH">Ohio</option> 
		<option value="OK">Oklahoma</option> 
		<option value="OR">Oregon</option> 
		<option value="PA">Pennsylvania</option> 
		<option value="RI">Rhode Island</option> 
		<option value="SC">South Carolina</option> 
		<option value="SD">South Dakota</option> 
		<option value="TN">Tennessee</option> 
		<option value="TX">Texas</option> 
		<option value="UT">Utah</option> 
		<option value="VT">Vermont</option> 
		<option value="VA">Virginia</option> 
		<option value="WA">Washington</option> 
		<option value="WV">West Virginia</option> 
		<option value="WI">Wisconsin</option> 
		<option value="WY">Wyoming</option>
	</select>
	</div>
	<div style="display:none;" id="state_other_wrapper">
		<input name="data[User][state][nonus]" type="text" id="state_nonus" />
	</div>
	<div id="error-state" class="error-message"></div>
  </div>

  
  <div class="submit">
    <input class="btn" type="button" value="Next" id="check_billing" />
  </div>
</div>
</div>
<div class="reg-sub-wrapper" id="register-credit">
  <div class="reg-header">
  <div class="reg-header title">
<div class="title-inner f-accented2">Credit Information<a id="edit-credit" style="font-size:15px;padding-left:20px;">edit</a></div>
</div>
</div>
  <div id="credit-wrap" class="reg-inner">
  
  <div class="input select required">
	<label for="product">Product</label>
	<select name="data[User][productid]" id="productid">
	<?php
	foreach(Configure::read('siteconfig.checkout.products') as $product){
		$name = $product['name'];
		$amount = $product['amount'];
		$id = $product['id'];
		echo "\n\t\t<option value='$id'>$name</option>";
	}
	?>
	</select>
	<div id="error-product" class="error-message"></div>
  </div>
  
  <!--
  <div class="input text required">
	<label for="">Recurring Billing</label>
	<input name="data[User][recurring]" type="checkbox" checked id="" style="width:20px;" />
	<div id="error-recurring" class="error-message"></div>
  </div>
  //-->
  
  <div class="input text required">
	<label for="UserCreditCardNum">Card Number</label>
	<input type="text" name="data[User][cardnumber]" id="cardnumber" />
	<div id="error-card" class="error-message"></div>
  </div>
  
  
  
  <div class="input text required">
	<label for="UserCreditExpMonth">Expiration Date</label>
	<label class="expdate f-accented" for="UserCreditExpMonth">mm</label>
	<select class="expdate" name="data[User][expmonth]" id="expmonth" >
		<option value="1">01</option>
		<option value="2">02</option>
		<option value="3">03</option>
		<option value="4">04</option>
		<option value="5">05</option>
		<option value="6">06</option>
		<option value="7">07</option>
		<option value="8">08</option>
		<option value="9">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
	</select>
	<label class="expdate f-accented" for="UserCreditExpYear">yy</label>
	<select class="expdate" id="expyear" name="data[User][expyear]">
		<?php
		$year = date('y');
		for($i=0; $i<10; $i++) {
			$tmp = $year * 1 + $i;
			echo "\n\t\t<option value='$tmp'>$tmp</option>";
		}
		?>
	</select>
	<div id="error-expdate" class="error-message"></div>
  </div>
  <div class="input text required">
	<label class="ccv" for="UserCreditCCV">3 Digit CCV</label>
	<input type="text" name="data[User][ccv]" id="ccv" maxlength="3" />
	<div id="error-ccv" class="error-message"></div>
  </div>
  
  <div class="submit">
    <input class="btn" type="button" value="Process" id="process" />
  </div>
  </div>
</form>
</div>
</form>
</div>
</div>