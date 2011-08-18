<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('landing.css');

		echo $scripts_for_layout;

	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>
	
	<img id="background" src="/img/ohiostate/ohiostate_brutusrun.jpg" alt="ohiostatebackground" />

	<div id="wrapper"> 
		<div id="mainHeader">
			<img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="flyfoenixlogo" />
			<span id="caption" class="four">
				Unique Collegiate Fashion.&nbsp;&nbsp;Quick Shopping.&nbsp;&nbsp;
				Great Fit & Feel.&nbsp;&nbsp;High Style.&nbsp;&nbsp;Lower Prices.
			</span>
			
		</div>
		<!--End Main Header -->
  
  		<div id="bodyHeader">
  			<img id="join" src="/img/landing/flyfoenix_landingpage_joinshopsave.png" width="384" height="159" alt="joinshopsave" />
  			<img id="overlayTopCenter" src="/img/landing/flyfoenix_landingpage_lightgraybig.png" alt="bodyheader" />
  		</div>
  		<!-- End Body Header -->

		<div id="bodyContainerDark">
    		<img src="/img/landing/flyfoenix_landingpage_darkgray.png" width="532" height="381" alt="darkgray" />

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
	</div>
	
	<?php //echo $this->element('sql_dump'); ?>
</body>

<script src="http://connect.facebook.net/en_US/all.js"></script>

<script> 
<?php
	echo $this->Hfacebook->initLogin($FACEBOOK_APP_ID,$FACEBOOK_APP_SESSION,false,array('auth.login'=>'fblogedin'));
?>
      
	//logged in function
	function fblogedin(){
		setTimeout(function(){window.location.reload()},1000);
	}      

	//logout function
	var fblogout = function(){
		FB.logout(function(response) {
			document.location.href = '/users/logout';	
		});
	}
	
	$('#logout').click(fblogout);
	

		
</script>

</html>