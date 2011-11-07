<?php
//shows a tooltip to DOM target that allows users to add schools
//ajax will fail if user is not logged in
//$DOMtarget - The element for tooltip to hook to
?>
$(document).ready(function(){
	var qtipSetting = {
	   content: {
		   text: 'Loading...',
		   prerender: true,
		   title:{
	   		   text:false,
	   		   
	   	   }
	   },
	   style: { 
	      name: 'dark', // Inherit from preset style
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
 	      tip:true,
 	      width:320,
 	      height:400,
	   },
	   position: {
	      corner: {
	         target: 'leftBottom',
	         tooltip: 'topRight'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show:{
	   	  when:{event:'click'}
	   },
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   }
	   
	};
	
	
	
	var $find = $('<?php echo $DOMtarget?>');
	
	if($find.length){
		$find.qtip(qtipSetting);
		$($find.qtip('api').elements.content).html($('#list-schools').show());
		$find.click(function(){$(this).qtip('show');});
		
		//handle the selecting of the school
		/*
		$('#list-schools a').
			click(function(){
				var $el = $(this);
				$el.parent().addClass('loading').removeClass('added').removeClass('fail');
				
				var url = $el.attr('href');
				
				$.ajax({
					'url':url,
					'dataType' : 'json',
					'success'  :function(data){
						if(data.result){
							$el.parent().removeClass('loading').addClass('added');
						} else {
							$el.parent().removeClass('loading').addClass('fail');
						}
					},
					'error': function() {
						$el.parent().removeClass('loading').addClass('fail');
					}
				});
			});
			*/
	}
});