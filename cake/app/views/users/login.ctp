<div id="register">
       
       <img id="registerimg" src="/img/landing/flyfoenix_landingpage_register.png" width="199" height="57" alt="register" />
        
          <div id="fb1">
          <div id="fb-root"></div>
          <a id="fb-reg" class="fb_button fb_button_medium"><span class="fb_button_text">Register with Facebook</span></a>
          </div><!-- End fb1 -->
          
        <img id="or1" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
        <form method="post" action="/users/register"><div id="email"><span class="six">Email&nbsp;&nbsp;</span><br />
        <input class="fieldwidth" name="data[User][email]" type="text" size="" /></div>
        <div id="birthdate"><span class="six">Birthdate&nbsp;&nbsp;</span><br />
        <input class="fieldwidth" name="data[User][birthdate]" value="MM/DD/YYYY" type="text"  size="" /></div>
        <span id="gender"class="six">Gender</span>
        
        	    <div id="tradio"><form>
<input type="radio" name="data[User][sex]" value="M" /><span class="seven"> Male</span>
<input type="radio" name="data[User][sex]" value="F" id="female"/> <span class="seven"> Female</span>

                 </div>
      	     
      	    
      
        <div id="school"><br /><span class="six">School&nbsp;&nbsp;</span><br />
        <select class="fieldwidth" name="data[school][id]" style="width:186px">
        <option>Ohio State</option>
        <option>University of North Carolina</option>
        <option>Texas</option>
        </select>
        </div>
		
        <input id="btnregister" class="two" name="register" type="submit" value="&nbsp;Register&nbsp;" />
      
      </div></form> <!-- End Register --> 
        
      <div id="login"> 
         
<img id="loginimg" src="/img/landing/flyfoenix_landingpage_login.png" width="199" height="51" alt="login" />
<div id="fb2">
     <div id="fb-root"></div>
     		<a id="fb-auth" class="fb_button fb_button_medium"><span class="fb_button_text">Login with Facebook</span></a>
           
          </div><!-- End fb2 -->
          <img id="or2" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
          <form method="post" action="/users/login"><div id="email2"><span class="six">Email&nbsp;&nbsp;</span><br />
          <input class="fieldwidth" name="data[User][email]" type="text" size="" /></div>
        	<div id="birthdate2"><span class="six">Birthdate&nbsp;&nbsp;</span><br />
        	<input class="fieldwidth" name="data[User][birthdate]" type="text"  value="MM/DD/YYYY" size="" /></div>
       		
            <input id="btnlogin"  class="two" name="login" type="submit" value="&nbsp;Login&nbsp;" />
            <div id="rememberme"><label for="remember-me"><span class="six">Remember Me&nbsp;&nbsp;</span>
            <input name="data[User][remember_me]" type="checkbox" value="1" checked id="remember-me" /></label></div>
        </div></form><!-- End Login -->