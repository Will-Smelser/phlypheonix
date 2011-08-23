<div id="register">
       
       <img id="registerimg" src="/img/landing/flyfoenix_landingpage_register.png" width="199" height="57" alt="register" />
        
          <div id="fb1">
          <div id="fb-root"></div>
          <script>
             FB.init({ 
                appId:'257750490911384', cookie:true, 
                status:true, xfbml:true 
             });
          </script>
          <fb:login-button>Register with Facebook</fb:login-button>
          </div><!-- End fb1 -->
          
        <img id="or1" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
        <form method="POST" action="/users/register"><div id="email"><span class="six">Email&nbsp;&nbsp;</span><br /><input id="fieldwidth" name="data[User][email]" type="text" size="" /></div>
        <div id="birthdate"><span class="six">Birthdate&nbsp;&nbsp;</span><br /><input id="fieldwidth" name="data[User][birthdate]" value="MM/DD/YYYY" type="text"  size="" /></div>
        <span id="gender"class="six">Gender</span>
        
        	    <div id="tradio"><form>
<input type="radio" name="data[User][sex]" value="M" /><span class="seven"> Male</span>
<input type="radio" name="data[User][sex]" value="F" id="female"/> <span class="seven"> Female</span>

                 </div>
      	     
      	    
      
        <div id="school"><br /><span class="six">School&nbsp;&nbsp;</span><br />
        <select id="fieldwidth" name="data[school][id]" size="1">
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
     <input type="button" value="Login with Facebook" id="fb-auth" />
          </div><!-- End fb2 -->
          <img id="or2" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
          <form method="POST" action="/users/login">
          <div id="email2"><span class="six">Email&nbsp;&nbsp;</span><br /><input id="fieldwidth" name="data[User][email]" type="text" size="" /></div>
        	<div id="birthdate2"><span class="six">Birthdate&nbsp;&nbsp;</span><br /><input id="fieldwidth" name="data[User][password]" type="text"  value="MM/DD/YYYY" size="" /></div>
        	<div id="remember"><span class="six">Remember Me</span>&nbsp;&nbsp;</div><br/>
        		<input type="checkbox" checked name="data[User][remember_me]" />
       		<input id="btnlogin"  class="two" name="login" type="submit" value="&nbsp;Login&nbsp;" />
        </div></form><!-- End Login -->