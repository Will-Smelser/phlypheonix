<?php 
	//Used the viewer for deciding what to do on the checkout button click
	//$count
?>
$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: 'Loading...',
		   prerender: true,
		   title:{
	   		   text:'Cart Contents',
	   		   button:'x'
	   		   
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
 	      width:500
	   },
	   position: {
	      corner: {
	         target: 'leftMiddle',
	         tooltip: 'rightTop'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show:'showCart',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onRender : function(){
				
			},
		onContentLoad : function(){
				/*
				//$('#cart').trigger('showCart');
				var $cart = $('#cart');
				
				$cart.qtip('api').elements.content.find('.cart-trash').click(function(){
				
				$cart.qtip('api').updateContent('Removing...',false);
				var url = $(this).attr('id');
				$.getJSON(url,
						function(){
							$cart.trigger('click');
						}
					);
				});
				*/
			}
	   }
	   
	};
	
	var $cart = $('#cart');
	$cart.qtip(qtipSetting); 
	$cart.click(function(){
		$cart.qtip('api').elements.content.html('Loading...');
		
		$('#cart').trigger('showCart');
		$cart.qtip('api').loadContent('/cart/index');
	});
	
	//handles the cart forms events
	window.cart = {
		$el : $('#cart'),
		removeAll : function(url, el){
			var $tr = $(el).parent().parent();
			var obj = this;
			
			$.getJSON(url,
				function(){
					obj.$el.qtip('api').loadContent('/cart/index');
					
					//obj.$el.qtip('hide');
					//setTimeout(function(){obj.$el.trigger('click');},100);
					obj.deleteCallback();
				}
			);
		},
		
		update : function(){
			var obj = this;
			var data = $('#cart-form').serialize();
			
			obj.$el.qtip('hide');
			$.post('/cart/update',data,function(){
					//obj.$el.qtip('hide');
					//setTimeout(function(){obj.$el.trigger('click');},100);
					obj.updateCallback();
				}
			);
		},
		
		updateCallback : function(){},
		deleteCallback : function(){}
	}
});