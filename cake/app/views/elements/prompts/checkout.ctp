<?php 
	//Used the viewer for deciding what to do on the checkout button click
	//$count
?>
$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: '<div class="title">Still more products...</div><p>Are you sure you want to skip to checkout?</p><div  style="float:right;"><input id="prompt-cancel-checkout" type="button" value="Cancel" class="one"/>&nbsp;&nbsp;<input id="prompt-checkout" type="button" value="Yes" class="one"/></div><p style="float:left;" class="">Viewing <span class="pos">x</span> of <?php echo $count; ?> products</p>',
		   prerender: true,
		   title:{
	   		   text:false,
	   		   
	   	   }
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
 	      tip:true,
 	      width:400
	   },
	   position: {
	      corner: {
	         target: 'leftMiddle',
	         tooltip: 'rightMiddle'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show:'checkOutClick',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onRender : function(){
				var $rightArrow = $('#rightarrow');
				$rightArrow.qtip('api').elements.content.find('.cancel-checkout').click(function(){
					$rightArrow.qtip('hide');
				});
			}
	   }
	   
	};
	
	
	var $rightArrow = $('#rightarrow');
	$rightArrow.qtip(qtipSetting);
	$rightArrow.click(function(){$(this).qtip('hide');});
	
	$rightArrow.qtip('api').elements.content.find('#prompt-cancel-checkout').click(function(){
		$rightArrow.qtip('interfaces')[0].hide();
	});
	$rightArrow.qtip('api').elements.content.find('#prompt-checkout').click(function(){document.location.href = window.viewer.checkoutUrl;});
	
	window.bindCheckout = function(pos){
		if(window.viewer.allPagesViewed()){
			document.location.href = window.viewer.checkoutUrl;
			return;
		}
		$rightArrow.qtip('api').elements.content.find('.pos').html(pos);
		$rightArrow.trigger('checkOutClick');
	};
});