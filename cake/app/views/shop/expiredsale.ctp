<?php 
	$st_url = 'http://flyfoenix.com/users/referred/' . $myuser['User']['id'];
	$st_encoded = urlencode($st_url);

?> 

<!--
<img id="network" src="/img/invite/flyfoenix_invite_network.png" width="101" height="119" alt="network" style="position:absolute;right:60px;top:45px" />
//-->
<img id="moretime" src="/img/expiredtime/flyfoenix_expiredtime_moretime.png" width="286" height="48" alt="moretime" />

<div style="clear:both;"></div>
<div id="content" style="">
	<p>
	Invite friends and get a 24-hour extension to buy!
	</p>
	<p>
	Earn $5 everytime a referral makes a purchase!
	</p>
	<p>
	<label for="sharing" style="cursor:pointer;"><input id="sharing" type="checkbox" value="" name="sharing">&nbsp;&nbsp;I want more time!</label>
	</p>
</div><!-- End content -->

  	<div id="hideShareThis" style="position:absolute;top:185px;left:50px;height:40px;width:300px;z-index:1000"></div>
	<div style="padding-top:10px;height:30px;">
	    
	    <div id="sharethis" style="height:30px; display:inline;">
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_twitter_large' ></span>
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_facebook_large' ></span>
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_yahoo_large' ></span>
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_gbuzz_large' ></span>
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_email_large' ></span>
	
	      <span st_url='<?php echo $st_url; ?>'  class='st_sharethis_large' ></span>
	
	    </div>
	
	    
	</div>
	<div style="height:10px;"></div>
    <img id="viewschool" src="/img/expiredtime/flyfoenix_expiredtime_view.png" width="290" height="45" alt="viewschool" />

	

    
    <div id="school" style="padding-top:5px;">

        <select id="school-select" name="data[school][id]" size="1">
		<?php echo $this->element('school_select_box',array('schools'=>$schools)); ?>
        </select>

        <input id="btnselect" class="btn space-left" name="select" type="submit" value="&nbsp;Select&nbsp;" />

	</div>      

   

   

   <div id="imgcontainer" style="padding-top:5px;">

  <div id="imgtxt" class="two" style="padding:5px;">Your sale includes these items, plus accessories...</div>
	<?php 
	reset($images);
	$entry = current($images);
	$i = 0;
	while ($i < count($images) && $i < 4){
		$margin = ($i == 3) ? 0 : 5;
		echo "\n\t<div class='border-rad-med' style='margin-right:{$margin}px;display:inline-block;border:solid #333 5px;'><img src='{$entry}' width='77' height='88' /></div>";
		$entry = next($images);	
		$i++;
	}
	
	?>
    </div>

    <script language="javascript">

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
					setTimeout(checkShareThisComplete,250);
				}
			}
			
			var extendTime = function(){
				$.get('/shop/extendtime/<?php echo $sale; ?>',function(){
					document.location.href = '<?php echo $shopUrl; ?>';
				});
			}
    		
    		
    		$('#sharing').click(function(){
        		if($('#sharing').attr('checked')){
        			$('#sharethis').css('opacity','1').css('alpha','100');
					$('#hideShareThis').hide();
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