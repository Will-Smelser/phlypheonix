<?php 

//setup default information
//all fields
$fields = array(
	'email2'
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
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark"  class="<?php echo $classWidth; ?>">
	<table id="tableContainer"  width="100%">
		<tr>
			<td class="top left"></td>
			<td class="top edge"></td>
			<td class="top right"></td>
		</tr>
		<tr>
			<td class="left edge"></td>
			<td class="bg-main">
			
			<?php if(isset($errors) && count($errors) > 0){
				$found = false;
				$first = '<div id="error-console" class="border-rad-med error">';
				
					foreach($errors as $error){
						if($error->getContext() == 'register'){
							$found = true;
							echo $first;
							echo "<div><span class='ename'>{$error->getDisplayName()}</span><span class='emsg'>{$error->getMsg()}</span></div>\n";
						}
					}
					if($found) echo '</div>';
				?>
			<?php } ?>
			
			<table><tr>
				<td>
				<div id="carousel" style="float:left;width:150px;overflow:hidden;display:none;margin-top:00px;margin-left:15px;">
					<img id="paper-title" src="/img/header/paper.png" style="position:absolute;top:-50px;left:-20px;z-index:100;" />
					<!-- carousel of images will be loaded here -->
					<div id="carousel-inner">
						<ul>
						
						</ul>
					</div>
				</div>
				
				</td><td>
				
				<div style="width:460px;padding-left:10px;">
				<?php echo $this->element('layouts/lightbg_top'); ?>
				
					<div class="big title">Start Shopping</div>
					<hr/>
					<p style="line-height: 26px">
					FlyFoenix finds the best NCAA apparel for your favorite teams, according to your gender selection, so viewing products is quick
					and easy.  
					</p>
					<p style="line-height: 26px">
					There are hundreds of items from premium brands, with new items and sales launching every week.
					Inventory is limited, so upgrade your NCAA apparel today! As always save up to 50%...
					</p>
					<hr>
					<form method="post" action="/shop/main">
					<p>
						<span class="six">Gender&nbsp;&nbsp;</span><br />
						<label for="male"><input name="sex" id="male" type="radio" value="M" />&nbsp;&nbsp;Male</label>&nbsp;&nbsp;&nbsp;&nbsp; 
						<label for="female"><input name="sex" id="female" type="radio" value="F" checked />&nbsp;&nbsp;Female</label>
					</p>
					<input type="submit" value="Shop Now" class="big green btn" style="float:right;margin-top:10px" />
					<p>
						<span class="six">School&nbsp;&nbsp;</span><br />
		        		<select class="" name="school-id"  style="width:200px">
							<?php echo $this->element('school_select_box',array('schools'=>$schools,'selected'=>null)); ?>
						</select>
					</p>
					</form>

				<?php echo $this->element('layouts/lightbg_bottom'); ?>
				
				<?php if(isset($errors) && count($errors) > 0){
					$found = false;
					$first = '<div id="error-console" class="border-rad-med error">';
					
						foreach($errors as $error){
							if($error->getContext() == 'login'){
								$found = true;
								echo $first;
								echo "<div><span class='ename'>{$error->getDisplayName()}</span><span class='emsg'>{$error->getMsg()}</span></div>\n";
							}
						}
						if($found) echo '</div>';
					?>
				<?php } ?>
				
				
				<?php echo $this->element('layouts/lightbg_top'); ?>
					<div class="title">Returning Members</div>
					<hr/>
					<form method="POST" action="/users/landing"  id="loginForm" name="loginForm">
						<p>
						
						<div style="float:left">
							<span class="six">Email&nbsp;&nbsp;</span><br />
							<input type="text" name="data[User][email]" id="email2" style="width:150px" class="<?php echo $errorClass['email2']; ?>" />
						</div>
					
						<div style="float:right">
							<input type="submit" class="green btn" value="Shop Now" style='height:27px' />
						
		          			<div id="fb1" style="display:none;text-align:right;">
		          				<i>&nbsp;&nbsp;- OR - </i>
		          				<div style="display:inline-block;">
			          			<span class="six">w/ Facebook&nbsp;&nbsp;</span><br />
						        <input id="fb-reg" style="margin-right:6px;height:27px;padding-left:30px;background-position: left -138px;" type="button" value="Shop " class="green btn fb_button" />
						        </div>
			          		</div><!-- End fb1 -->
			          	</div>
		          		</p>
	          		
	          		</form>
				<?php echo $this->element('layouts/lightbg_bottom'); ?>
				</div>
		
				</td></tr></table>
			</td>
			<td class="right edge"></td>
		</tr>
		<tr>
			<td class="bottom left"></td>
			<td class="bottom edge"></td>
			<td class="bottom right"></td>
		</tr>
	</table>
	
	</div>
	<div id="fb-root"></div>
<script type="text/javascript">

$('.width-custom').css({'width':'670px'});
$('#carousel').show();

$(document).ready(function(){
	//carousel
	$('#carousel').show();
	
	var pimages = <?php echo json_encode($pimages);?>;
	var ppos = 0;

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


	$('#fb1').css('display','inline-block');
	
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
	    
		
		$('#fb-reg').click(function(){
			window.formClick=true;
			<?php echo $this->Hfacebook->loginJs('fbloggedin',null,'email,user_birthday,user_education_history'); ?>
		})
	
		//logged in function
		function fbloggedin(){
			window.location.href = '<?php echo $protocal; ?>://flyfoenix.com/users/landing';
		}
	
		//logout function
		var fblogout = function(){
			FB.logout(function(response) {
				document.location.href = '/users/logout';	
			});
		}
		
	});
	
});
</script>