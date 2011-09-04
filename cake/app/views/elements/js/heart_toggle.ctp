<?php 
//$school_id
?>
$(document).ready(function(){
	//bind the clikc event
	var clicked = false; //avoid double clicks
	$('#favorite').click(function(){
		var $obj = $(this);
		if(clicked) return true;
		
		var curClass = $(this).attr('class');
		
		var url = '/users/';
		url += (curClass == 'heart') ? 'remove_school/' : 'add_school/';
		url += <?php echo $school_id; ?>;
		
		$.ajax({
			'url' : url,
			dataType: 'json',
			success: function(data){
				if(data.result){
					if(curClass=='heart'){
						$obj.removeClass('heart').addClass('heart-no');
					}else{
						$obj.removeClass('heart-no').addClass('heart');
					}
				}
				clicked = false;
			}
		});
	});
});