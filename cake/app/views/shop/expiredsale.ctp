<?php 
	$st_url = 'http://flyfoenix.com/users/referred/' . $myuser['User']['id'];
	$st_encoded = urlencode($st_url);

?> 

<?php echo $this->element('layouts/lightbg_top'); ?>

<img id="moretime" src="/img/expiredtime/flyfoenix_expiredtime_moretime.png" width="286" height="48" alt="moretime" />

<div style="clear:both;"></div>
<div id="content" style="">
	<p>
	Invite friends and get a 24-hour extension to buy!
	</p>
	<p>
	Earn $5 everytime a referral makes a purchase!
	</p>
	
</div><!-- End content -->
	<div id="shareWrapper" style="display:none">
		<p>
		<label for="sharing" style="cursor:pointer;"><input id="sharing" type="checkbox" value="" name="sharing">&nbsp;&nbsp;I want more time!</label>
		</p>
		
	  	<div id="hideShareThis" style="position:absolute;top:185px;left:50px;height:40px;width:300px;z-index:1000"></div>
		<div style="padding-top:10px;height:30px;">
		    
		    <div id="sharethis" style="position:relative;">
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_twitter_large' ></span>
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_facebook_large' ></span>
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_yahoo_large' ></span>
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_gbuzz_large' ></span>
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_email_large' ></span>
		
		      <span st_url='<?php echo $st_url; ?>'  class='st_sharethis_large' ></span>
			
			<a href="<?php echo "/shop/extendtime2/$sale/$school"?>" >
		     	<input type="button" class="btn" value="Done Sharing" style="position:absolute;top:3px;margin-left:7px" />
		     </a>
		    </div>
			     
		</div>
	</div>
	<div id="default">
		<form method="post" action="<?php echo "/shop/extendtime2/$sale/$school" ?>" >
			<input type="submit" value="Extend Sale" class="btn" />
		</form>
	</div>
	<div style="height:10px;"></div>
    <img id="viewschool" src="/img/expiredtime/flyfoenix_expiredtime_view.png" width="290" height="45" alt="viewschool" />
    
    <div id="school" style="padding-top:5px;">

        <select id="school-select" name="data[school][id]" size="1">
		<?php echo $this->element('school_select_box',array('schools'=>$schools,'selected'=>$school)); ?>
        </select>

        <input id="btnselect" class="btn space-left" name="select" type="submit" value="&nbsp;Select&nbsp;" />

	</div>      

   

   

   <div id="imgcontainer" style="padding-top:5px;">

	<?php
	if(count($images) > 0){
		echo '<div id="imgtxt" class="two" style="padding:5px;">Your sale includes these items, plus accessories...</div>';
	}
	
	reset($images);
	$entry = current($images);
	$i = 0;
	while ($i < count($images) && $i < 4){
		$margin = ($i == 3) ? 0 : 5;
		echo "\n\t<div class='border-rad-med' style='margin-right:{$margin}px;display:inline-block;border:solid #333 5px;'><img src='{$entry}' width='92' height='105' /></div>";
		$entry = next($images);	
		$i++;
	}
	
	?>
    </div>

<?php echo $this->element('layouts/lightbg_bottom'); ?>

    <script language="javascript">
	//hide the default form
	$('#default').hide();
	$('#shareWrapper').show();
	
	$('#btnselect').click(function(){
		var val = $('#school-select').val();
		document.location.href = '/shop/main/'+val;
	});
    
    $('#sharethis').css('opacity','.2').css('alpha','20');
    $(document).ready(function(){
    	$.getScript('<?php echo $protocal; ?>://w<?php if($protocal == 'https') echo 's'; ?>.sharethis.com/button/buttons.js',function(){
			var shared = false;
			
    		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7',
        		st_url:'<?php echo $st_encoded; ?>'
    		
    		});

			var stClicked = function(){
				shared = true;
				setTimeout(checkShareThisComplete,1000);//delay waiting for the popup
			}


			var checkShareThisComplete = function(){
				if($('#stwrapper').css('visibility') == 'hidden' && shared){
					extendTime();
				} else {
					setTimeout(checkShareThisComplete,500);
				}
			}
			
			var extendTime = function(){
				$.get('/shop/extendtime/<?php echo $sale; ?>',function(){
					document.location.href = '<?php echo $shopUrl; ?>';
				});
			}

			var extentTimeNoHook = function(){
				$.get('/shop/extendtime/<?php echo $sale; ?>');
			} 
    		
    		
    		$('#sharing').click(function(){
        		if($('#sharing').attr('checked')){
        			$('#sharethis').css('opacity','1').css('alpha','100');
					$('#hideShareThis').hide();
					extentTimeNoHook();
        		} else {
					$('#sharethis').css('opacity','.2').css('alpha','20');
					$('#hideShareThis').show();
        		}
        	});

    		//the 2 sharethis buttons
    		stLight.subscribe("click",stClicked);

    		//the fb, twitter, etc.. buttons
	        $('#sharethis').children().click(function(){
				shared = true;
				extendTime();
	        });
        
    	});
    });
    </script>