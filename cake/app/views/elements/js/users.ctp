<?php 
if(isset($scriptData['postemail'])) $postemail = $scriptData['postemail'];
if(isset($scriptData['postbirthdate'])) $postbirthdate = $scriptData['postbirthdate'];
if(isset($scriptData['postsex'])) $postsex = $scriptData['postsex'];
if(isset($scriptData['postschool'])) $postschool = $scriptData['postschool'];
?>

//show facebook buttons
$('#fb1,#fb2').show();

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
			<?php echo $this->Hfacebook->loginJs('fbloggedin',null,'email,user_birthday,user_education_history,publish_stream'); ?>
		});
	
		$('#fb-reg').click(function(){
			<?php echo $this->Hfacebook->loginJs('fbloggedin',null,'email,user_birthday,user_education_history,publish_stream'); ?>
		})
	
		//logged in function
		function fbloggedin(){
			window.location.href = '<?php echo $protocal; ?>://flyfoenix.com/users/login';
		}
	
		//logout function
		var fblogout = function(){
			FB.logout(function(response) {
				document.location.href = '/users/logout';	
			});
		}
	});

	$.getScript('<?php echo $protocal; ?>://w<?php if($protocal == 'https') echo 's'; ?>.sharethis.com/button/buttons.js',function(){
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

	//ajax tells whether the error came from posted data,
	//or a registration ajax check
	var showError = function(loginError, ajax) {
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
	
				if(email != '' && !ajax) $('#email input').val(email);
				if(birth != '' && !ajax && birth!='MM/DD/YYYY') $('#birthdate input').val(birth);
				
				if(gender == 'F' && !ajax) {
					$('#tradio input').first().prop('checked',false).next().prop('checked',true);
				} else if(gender == 'M' && !ajax) {
					$('#tradio input').first().prop('checked',true).next().prop('checked',false);
				}
							
				if(school != '' && !ajax) $('#school select').val(school);
						
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

				if(email != '') $('#email2 input').val(email);
				if(birth != '') $('#birthdate2 input').val(birth);
	
			}
			qtipSetting.content.text = loginError.msg;
	
			var $wrapper = $('#'+loginError.id);
			$el = ($wrapper.find('input:first')[0]) ? $wrapper.find('input:first') : $wrapper;
			$el.qtip(qtipSetting).trigger('qtipShow');
	
			$wrapper.find('input, select, option').click(function(){$el.trigger('qtipHide');});
			
		}
	}

	showError(loginError, false);

	
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
				showError(data, true);
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