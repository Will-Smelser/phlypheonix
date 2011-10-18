	<div class="title">Choose Your School</div>
  	<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2" /><br/>
	<p>
		
		Select a school from the list below.  If you do not see your school in the list below; 
		be patient we are constantly adding new schools.  So, check back soon!
		
	</p><!-- End content -->
  
	
		<div id="school">
		<form method="post" action="/shop/main/0/<?php echo $myuser['User']['sex']; ?>" >
        <select id="school-list" class="fieldwidth" name="school-id" size="1">
        	<?php echo $this->element('school_select_box',array('schools'=>$schools)); ?>
        </select>
        <noscript>
        	<input class="btn space-left" name="select" type="submit" value="&nbsp;Select&nbsp;" />
        </noscript>
        
        	<input id="btnselect" style="display:none;" class="btn space-left" name="select" type="button" value="&nbsp;Select&nbsp;" />
        
        <script language="javascript">$('#btnselect').show();</script>
        </form>
        </div>
		
        
      
<script language="javascript">
//bind to form
$(document).ready(function(){
	
	$('#btnselect').click(function(){
		var schoolid = $('#school-list').val();
		$.getJSON('/users/add_school/'+schoolid, function(data){
			//if(data.result){}
			document.location.href = '/shop/main/'+schoolid+'/<?php echo $myuser['User']['sex']; ?>';
		});
	});
});
</script> 
  