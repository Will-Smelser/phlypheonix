<?php 

//setup default information
//all fields
$fields = array(
	'email', 'email2', 'birthdate','birthdate2','gender','school'
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

?>

<?php if(isset($errors) && count($errors) > 0){ ?>
	<div id="error-console" class="border-rad-med error">
	<?php 
		foreach($errors as $error){
			echo "<div><span class='ename'>{$error->getDisplayName()}</span><span class='emsg'>{$error->getMsg()}</span></div>\n";
		}
	?>
	</div>
<?php } ?>

<div id="carousel" style="float:left;width:175px;overflow:hidden;display:none;margin-top:20px;margin-left:5px;">
	<img src="/img/header/paper.png" style="position:absolute;top:-40px;left:-40px;z-index:100;" />
	<!-- carousel of images will be loaded here -->
	<div id="carousel-inner" style="height:350px;margin:0px">
		<ul>
		
		</ul>
	</div>
</div>
<script type="text/javascript">
<!--
$('.width-custom').css({'width':'750px'});
$('#title-image').css({'left':'245px'});
$('#error-console').css({'margin-left':'195px'});
$('#carousel').show();
//-->
</script>

<div id="register">
	<?php echo $this->element('layouts/lightbg_top'); ?>
	<div class="inner">       
       <img id="registerimg" src="/img/landing/flyfoenix_landingpage_register.png" width="199" height="57" alt="register" />
        
          <div id="fb1">
	          <a id="fb-reg" class="fb_button fb_button_medium"><span class="fb_button_text">Register with Facebook</span></a>
          
		        <div class="img-wrapper">  
		        <img align="middle" id="or1" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" />
		        </div>
          </div><!-- End fb1 -->
        
        <form id="registerForm" method="post" action="/users/register">
        
        	<div id="email"><span class="six">Email&nbsp;&nbsp;</span><br />
        	<input class="fieldwidth <?php echo $errorClass['email']; ?>" name="data[User][email]" type="text" size=""
        		value="<?php if(isset($regpostemail)) echo $regpostemail; ?>"
        	 /></div>
	    	
	    	<div class="f-spacer"></div>
	    	    
	        <div id="birthdate"><span class="six">Birthdate&nbsp;&nbsp;</span><br />
	        	<input class="fieldwidth <?php echo $errorClass['birthdate']; ?>" name="data[User][birthdate]" 
	        		value="<?php echo isset($regpostbirthdate) ? $regpostbirthdate : 'MM/DD/YYYY'; ?>" type="text"  size="" />
	        </div>
        
        	<div class="f-spacer"></div>
        
        	<div id="gender">
	        	<span class="six">Gender</span>        
       	    	<span id="tradio" class="<?php echo $errorClass['gender']; ?>">
					<label for="male"><input id="male" type="radio" name="data[User][sex]" 
						value="M" <?php if(isset($regpostsex) && $regpostsex=='M') echo 'checked'; ?> /><span class="seven"> Male</span></label>
					<label for="female"><input id="female" type="radio" name="data[User][sex]" value="F" id="female"
						<?php if(isset($regpostsex) && $regpostsex=='F') echo 'checked'; ?>
					/> <span class="seven"> Female</span>
             	</span>
         	</div>
      	     
      	    <div class="f-spacer"></div>
      
	        <div id="school">
		        <span class="six">School&nbsp;&nbsp;</span><br />
		        <select class="<?php echo $errorClass['school']; ?>" name="data[School][School][id]"  style="width:200px">
		        <?php 
		        	$temp = (isset($regpostschool)) ? $regpostschool : 0;
		        	echo $this->element('school_select_box',array('schools'=>$schools,'selected'=>$temp)); ?>
		        </select>
	        </div>
	        
	        <div class="f-spacer"></div>
			<input type="submit" class="btn" onclick="window.formClick=true;" value="&nbsp;Register&nbsp;" style="float:right" />
        	<input id="btnregister" class="btn" name="register" type="button" style="display:none;" value="&nbsp;Register&nbsp;" />
        </form>
        <div style="clear:both"></div>
        
      </div>
      <?php echo $this->element('layouts/lightbg_bottom'); ?>
</div><!-- End Register --> 
        
<div id="login"> 
    <?php echo $this->element('layouts/lightbg_top'); ?>
    <div class="inner">
		<img id="loginimg" src="/img/landing/flyfoenix_landingpage_login.png" width="199" height="51" alt="login" />
		<div id="fb2">
     		<a id="fb-auth" class="fb_button fb_button_medium"><span class="fb_button_text">Login with Facebook</span></a>
     		<div class="img-wrapper"><img id="or2" src="/img/landing/flyfoenix_landingpage_or.png" width="40" height="12" alt="or" /></div>
        </div><!-- End fb2 -->
          
        <form id="loginForm" method="post" action="/users/login">
        	<div id="email2">
        		<span class="six">Email&nbsp;&nbsp;</span><br />
        		<input class="fieldwidth <?php echo $errorClass['email2']; ?>" name="data[User][email]" type="text" size=""
        			value="<?php if(isset($postemail)) echo $postemail; ?>" />
        	</div>
        	
        	<div class="f-spacer"></div>
        	
        	<div id="birthdate2">
        		<span class="six">Birthdate&nbsp;&nbsp;</span><br />
        		<input class="fieldwidth <?php echo $errorClass['birthdate2']; ?>" name="data[User][birthdate]" type="text"  
					value="<?php echo isset($postbirthdate) ? $postbirthdate : 'MM/DD/YYYY'; ?>"
				 size="" />
        	</div>
       		
       		<div class="f-spacer"></div>
       		
       		<noscript><input type="submit" class="btn" value="&nbsp;Login&nbsp;"  style="float:right"/></noscript>
            <input id="btnlogin" onclick="window.formClick=true;"  class="btn" style="display:none;" name="login" type="submit" value="&nbsp;Login&nbsp;" />
    
            
            <div id="rememberme">
            	<label for="remember-me"><span class="six">Remember Me&nbsp;&nbsp;</span>
            	<input name="data[User][remember_me]" type="checkbox" value="1" checked id="remember-me" /></label>
            </div>
        </form>
        
        <!-- VeriSign Trust Seal -->
        <?php echo $this->element('trustseal',array('protocal'=>$protocal)); ?>
   </div>
   <?php echo $this->element('layouts/lightbg_bottom'); ?>
</div>
<div id="fb-root"></div>
<div class="clear:both;" ></div>
<div style="text-align:left;padding-left:18px;">
<a href="/pages/terms" onclick="window.formClick=true;">Terms of Use</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="/pages/privacy" onclick="window.formClick=true;">Privacy Policy</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="/pages/about" onclick="window.formClick=true;">About Us</a>&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<script language="javascript">
window.formClick = false;

//$('#btnregister').show();
$('#btnlogin').show();

var pimages = <?php echo json_encode($pimages);?>;
var ppos = 0;
$(document).ready(function(){
	var $obj = $('#carousel-inner');
	
	function addImages(){
		
		for(var i=0; i<10; i++){
			if(ppos > pimages.length) return;
			$obj.mioCarousel('push','/users/getimage?image='+pimages[ppos]);
			ppos++;
		}
	}

	$obj.mioCarousel({nearEnd:addImages});
	
	for(var x in pimages){
		$obj.mioCarousel('push','/users/getimage?image='+pimages[x]);
		ppos++;
		if(ppos >=10) break;
	}

	window.onbeforeunload = function(){
		return;/*
		if(!window.formClick){
			setTimeout(function(){
				window.formClick=true;
				document.location.href='/shop/view';
			},100);
			return 'Wait!\n\nDon\'t leave, preview the latest apparel for your favorite team. No registration required!';
		}*/
	}
});
</script>