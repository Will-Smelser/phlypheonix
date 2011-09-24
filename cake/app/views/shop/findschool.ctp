	<img id="canwe" src="/img/noschool/flyfoenix_noschool_canwe.png" width="380" height="55" alt="canwe" />
  
	<div id="content" style="padding-bottom:10px">
		<span class="eight">
		Select a school from the list below.  If you do not see your school in the list below; 
		be patient we are constantly adding new schools.  So, check back soon!
		</span>
	</div><!-- End content -->
  
	
		<div id="school">
        <select id="school-list" class="fieldwidth" name="data[school][id]" size="1">
        	<?php echo $this->element('school_select_box',array('schools'=>$schools)); ?>
        </select>
        <input id="btnselect" class="btn space-left" name="select" type="submit" value="&nbsp;Select&nbsp;" />
        </div>
		
        
      
<script language="javascript">
//bind to form
$(document).ready(function(){
	
	$('#btnselect').click(function(){
		var schoolid = $('#school-list').val();
		$.getJSON('/users/add_school/'+schoolid,function(data){
			if(data.result){ 
				document.location.href = '/shop/main/'+schoolid+'/<?php echo $myuser['User']['sex']; ?>';
			} else {

			}
		});
	});
});
</script> 
  