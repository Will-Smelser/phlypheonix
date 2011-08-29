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
    <span id="caption" class="four">Unique Collegiate Fashion.&nbsp;&nbsp;Quick Shopping.&nbsp;&nbsp;Great Fit & Feel.&nbsp;&nbsp;High Style.&nbsp;&nbsp;Lower Prices.</span>    
  </div><!--End Main Header -->
  
	<div id="bodyHeader">
  		<img id="join" src="/img/landing/flyfoenix_landingpage_joinshopsave.png" width="384" height="159" alt="joinshopsave" />
	</div><!-- End Body Header -->

	<div id="bodyContainerDark">
		<?php //echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div>

	<div id="bottomContainer"><!-- Begin bottomContainer -->
    	<img id="tellfriends" src="/img/landing/flyfoenix_landingpage_tellfriends.png" width="316" height="56" alt="tellfriends" />
    	<div id="offer"><!-- Begin offer -->
    		<span class="two">Earn $5 for every purchase made from your referrals!<br/><br/>Earn everytime and everywhere you share!</span>
    	</div><!-- End offer -->
	    <div id="sharethis">
	      <span  class='st_twitter_large' ></span>
	      <span  class='st_facebook_large' ></span>
	      <span  class='st_yahoo_large' ></span>
	      <span  class='st_gbuzz_large' ></span>
	      <span  class='st_email_large' ></span>
	      <span  class='st_sharethis_large' ></span>
	    </div>
    	<img id="sharetag" src="/img/landing/flyfoenix_landingpage_sharetag.png" width="190" height="188" alt="sharetag" />
    </div><!-- End bottomContainer -->

</div>

    
    
	<div style="position:fixed;bottom:25px;z-index:1000;background-color:#FFF;"><h1><?php var_dump($loggedin); ?></h1></div>
	<?php //echo $this->element('sql_dump'); ?>
</body>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script> 
$(document).ready(function(){
	<!-- FACEBOOK //-->
	$.getScript("<?php echo $protocal; ?>://connect.facebook.net/en_US/all.js",function(){
		<?php 
		
		echo $this->Hfacebook->initLogin(
				$FACEBOOK_APP_ID,
				$FACEBOOK_APP_SESSION,
				false,
				array('auth.login'=>'fbloggedin')
		); 
		
		?>
	    
		//bind to the button
		$('#fb-auth').click(function(){
			<?php echo $this->Hfacebook->loginJs('fbloggedin',null,'email,user_birthday,user_education_history'); ?>
		});
	
		$('#fb-reg').click(function(){
			<?php echo $this->Hfacebook->loginJs('fbloggedin',null,'email,user_birthday,user_education_history'); ?>
		})
	
		//logged in function
		function fbloggedin(){
			window.location.href = '<?php echo $protocal; ?>://flyfoenix.com/shop/main';
		}
	
		//logout function
		var fblogout = function(){
			FB.logout(function(response) {
				document.location.href = '/users/logout';	
			});
		}
	});

	$.getScript('<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
	});
	
	<!-- QTIP POPUP for errors //-->
	var loginError = <?php echo $error; ?>;
	
	var qtipSetting = {
			
	   content: {
		   text: '',
		   prerender: true,
	   },
	   style: { 
	      name: 'green', // Inherit from preset style
    	  border: {
 	         width: 3,
 	         radius: 5,
 	         color: '#333'
 	      },
 	      'font-size': 18,
 	      'font-family': 'Arial',
 	      background: '#555',
 	      color: '#DDD',
 	      padding: 15,
 	      tip:true
	   },
	   position: {
	      corner: {
	         target: 'center',
	         tooltip: 'center'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show: 'qtipShow',
	   hide: 'qtipHide',
			   
	};

	var showError = function(loginError) {
		if(loginError.id == 'error-general') {
			qtipSetting.content = $.extend(qtipSetting.content,{
				text : loginError.msg,
				title : {
					text : 'General Error!',
					button : 'Close'
				}
			});
			qtipSetting.style = $.extend(qtipSetting.style,{
					width: 400,
					height: 200,
					name: 'green', // Inherit from preset style
			 	      tip:false
			});
			
			$('#bodyContainerDark').qtip(qtipSetting).trigger('qtipShow');
		} else {
			if(loginError.context == 'register') {
				//set how to display qtip
				qtipSetting.position.corner = $.extend(qtipSetting.position.corner,{
					target  :'leftMiddle',
					tooltip :'rightMiddle'
				});	
	
				//set the register data
				var email = '<?php if(isset($postemail)) echo $postemail; ?>';
				var birth = '<?php if(isset($postbirthdate)) echo $postbirthdate; ?>';
				var gender = '<?php if(isset($postsex)) echo $postsex; ?>';
				var school = '<?php if(isset($postschool)) echo $postschool; ?>';
	

				if(email != '') $('#email input').val(email);
				if(birth != '' && birth!='MM/DD/YYYY') $('#birthdate input').val(birth);
				
				if(gender == 'F') {
					$('#tradio input').first().prop('checked',false).next().prop('checked',true);
				} else if(gender == 'M') {
					$('#tradio input').first().prop('checked',true).next().prop('checked',false);
				}
							
				if(school != '') $('#school select').val(school);
						
			} else {
				//set how to display qtip
				qtipSetting.position = $.extend(qtipSetting.position,{
					corner:{
						target  :'rightMiddle',
						tooltip :'leftMiddle'
					},
					adjust: {
						x: 0, y: 0
					}
				});
	
				//set the user data
				var email = '<?php if(isset($postemail)) echo $postemail; ?>';
				var birth = '<?php if(isset($postbirthdate)) echo $postbirthdate; ?>';
	
				$('#email2 input').val(email);
				$('#birthdate2 input').val(birth);
	
			}
			qtipSetting.content.text = loginError.msg;
	
			var $wrapper = $('#'+loginError.id);
			$el = ($wrapper.find('input:first')[0]) ? $wrapper.find('input:first') : $wrapper;
			$el.qtip(qtipSetting).trigger('qtipShow');
	
			$wrapper.find('input, select, option').click(function(){$el.trigger('qtipHide');});
			
		}
	}

	showError(loginError);

	//overwrite the form submit
	$('#btnregister').click(function(){

		//hide all elements
		$('#registerForm').find('input, select, option').trigger('qtipHide');
		
		$.ajax({
		data: $('#registerForm').serialize(),
		url:'/users/register_ajax',
		success:function(data){
			if(data.msg == 'success') {
				$('#registerForm').submit();
			} else {
				showError(data);
			}	
		},
		error:function(){
			//just send user to register process
			$('#registerForm').submit();
		},
		type:"POST",
		dataType:"json"
		
		});
	});
		
	
	
});	

<?php 

	$pdeletes = array();

	//key = prompts id
	//val = the prompt name
	foreach($cprompts as $key=>$p){
		$data = (isset($cpdata[$key])) ? $cpdata[$key] : array();
		//run the prompt
		echo $this->element('prompts/'.$p,
			array(
				'id'=>$key,
				'data'=>$data
			)
		);
		
		//delete the prompt
		array_push($pdeletes,"\n\t$.post('/prompts/deleteUserPrompt/$key');\n");
	}
?>
//delete prompts
$(document).ready(function(){

	<?php foreach($pdeletes as $str) {echo $str; }?>
	
});

</script>

</html>