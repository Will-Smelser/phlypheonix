	<img id="canwe" src="/img/noschool/flyfoenix_noschool_canwe.png" width="380" height="55" alt="canwe" />
  
	<div id="content" style="padding-bottom:10px">
		<span class="eight">
		Unfortunately we do not have a sale for the requested school at this time.  Below is a list of schools which do have a
		sale current running.
		</span>
	</div><!-- End content -->
  
	
		<div id="school">
        <select id="school-list" class="fieldwidth" name="data[school][id]" size="1">
        <?php echo $this->element('school_select_box',array('schools'=>$schools)); ?>
        </select>
        <input id="btnselect" class="btn space-left" name="select" type="submit" value="&nbsp;Select&nbsp;" />
        </div>
		
<script language="javascript">
$(document).ready(function(){
	$('#btnselect').click(function(){
		var school = $('#school-list').val();
		document.location.href = '/shop/main/'+school+'/<?php echo $myuser['User']['sex']; ?>';
	});
});
</script>
  