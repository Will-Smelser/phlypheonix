	<div id="register">
       <img src="/img/landing/flyfoenix_landingpage_lightgraysmall.png" width="249" height="340" alt="lightgraysmall" />
       <img id="registerimg" src="/img/landing/flyfoenix_landingpage_register.png" width="199" height="57" alt="register" />
        
          <div id="fb1">
          <div id="fb-root"></div>
          <?php echo $this->Hfacebook->loginButton('Register with Facebook') ?>
          </div><!-- End fb1 -->
          
        <img id="ors" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
        <div id="email"><span class="six">Email&nbsp;&nbsp;</span><br /><input name="email" type="text" size="20" /></div>
        <div id="birthdate"><span class="six">Birthdate&nbsp;&nbsp;</span><br /><input name="birthdate" value="MM/DD/YYYY" type="text"  size="11" /></div>
        <div id="gender"><span class="six">Gender&nbsp;&nbsp;</span>
        
        	    <table id="tradio">
        	      <tr>
        	        <td >
        	          <input type="radio" name="gender" value="radio" id="male" />
        	          <label for="male"><span class="seven">Male</span></label></td>
      	        
        	      
        	        <td>
        	          <input type="radio" name="gender" value="radio" id="female" />
        	          <label for="female"><span class="seven">Female</span></label></td>
      	        </tr>
      	      </table>
      	
        </div>
        <div id="school"><br /><span class="six">School&nbsp;&nbsp;</span><br />
        <select name="size" size="1">
        <option>Ohio State</option>
        <option>University of North Carolina</option>
        <option>Texas</option>
        </select>
        </div>
		
        <input id="btnregister" class="two" name="btnregister" type="button" value="&nbsp;Register&nbsp;" />
      
      </div><!-- End Register -->
      
      
<div id="login">
	<img src="/img/landing/flyfoenix_landingpage_lightgraysmall.png" width="249" height="340" alt="lightgraysmall" />        
	<img id="loginimg" src="/img/landing/flyfoenix_landingpage_login.png" width="199" height="51" alt="login" />
	<div id="fb2">
    <div id="fb-root"></div>
				<?php echo $this->Hfacebook->loginButton('Login with Facebook') ?>
    </div><!-- End fb2 -->
    <img id="ors" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
          
    <div id="email2">
    	<label for="email_user" class="six">Email&nbsp;&nbsp;</label><br />
    	<input id="email_user" name="email" type="text" size="20" /></div>
    <div id="birthdate2">
    	<label class="six" for="birthday_user">Birthdate&nbsp;&nbsp;</label><br />
    	<input id="birthday_user" name="birthdate" type="text"  value="MM/DD/YYYY" size="11" />
    </div>
    <input id="btnlogin"  class="two" name="btnlogin" type="button" value="&nbsp;Login&nbsp;" />
</div><!-- End Login -->