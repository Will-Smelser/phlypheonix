<?php 



?>

$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: 'Loading <img src="/img/ajax/loading.gif" />',
		   prerender: true,
		   title:{
	   		   text:false,
	   		   button:'x'
	   		   
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
 	      width:300,
 	      //height:350,
 	      
	   },
	   position: {
	      corner: {
	         target: 'rightMiddle',
	         tooltip: 'leftMiddle'
	      },
	      adjust: {
		      x: 0, y: 0, screen:true
		  }   
	   },
	   show:'showDetails',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onRender : function(){
				
			},
		onContentLoad : function(){
				
			},
		beforeShow : function(){
			
			}
	   }
	   
	};
	
	//setup the tooltips and bind the show events
	var $swatch = $('.swatch_image');
	var $products = $('.acc_image');
	
	//setup the add to cart button
	$('#accessories-tool-tips .add-to-cart').click(function(){
		var $parent = $(this).parent();
		
		var pid = $parent.find('.input-product').val();
		var qty = $parent.find('.input-quantity').val();
		var size = $parent.find('.input-size').val();
		var color = $parent.find('.input-color').val();
		
		ajaxAddToCart(pid,qty,size,color);
		
		$products.qtip('hide');
	});
	
	if($products.length > 0){
		$products.each(function(){
			var $target = $(this); 
			$target.qtip(qtipSetting);
			
			$target.qtip('api').elements.content.html('');
			
			var parts = $target.attr('id').split('_'); //0=>product, 1=>color, 2=>sex
		
			var pid = parts[0].split('-')[1];
			var cid = parts[1].split('-')[1];
			var sex = parts[2].split('-')[1];
			
			var $content = $('#tooltip-product-'+pid);
			
			$content.css('display','block').appendTo($target.qtip('api').elements.content);
			
			$products.click(function(){
				$(this).trigger('showDetails');
			});
		});
	}
	
	$swatch.click(function(){$(this).trigger('showDetails');});
	
	$('.pbutton').click(function(){
		$(this).parent().parent().find('img:first').trigger('showDetails');
	});
	
	//swatch DOM setup
	if($swatch.length > 0){
		$swatch.qtip(qtipSetting);
		$swatch.qtip('api').elements.content.html('');
		$('#swatches-wrapper').css('display','block').appendTo($swatch.qtip('api').elements.content);
	}
	
	var ajaxAddToCart = function(id, qty, size, color){
			var items = (qty > 1) ? ' items' : ' item';
			var $cart = $('#cart');
			
			$cart.qtip('api').elements.content.html('Adding '+qty+items+'...');
			$cart.trigger('showCart');
			
			$.getJSON('/cart/addProduct/'+id+'/'+qty+'/'+size+'/'+color,
				//success
				function(data){
					$cart.qtip('api').elements.content.html('Successfully added '+qty+items);
					setTimeout(function(){$cart.qtip('hide');},1000);
				}
			);
		}
	
	
});