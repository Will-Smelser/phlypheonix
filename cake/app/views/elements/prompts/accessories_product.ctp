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
			var $el = $(this.elements.target);
			
			var parts = $el.attr('id').split('_'); //0=>product, 1=>color, 2=>sex
		
			var pid = parts[0].split('-')[1];
			var cid = parts[1].split('-')[1];
			var sex = parts[2].split('-')[1];
			
			var text = 'Error loading product information.';
			
			//set the content
			var $target = this.elements.content;
			
			//get the inventory
			var inv = 0;
			var sizes = [];
			for(var x in window.pdetails){
				if(window.pdetails[x].Pdetail.product_id == pid){
					inv += window.pdetails[x].Pdetail.inventory * 1;
					sizes[window.pdetails[x].Size.id] = window.pdetails[x].Size.display;
					
					$target.find('#target-image').attr('src',$el.attr('src'));
				}
			}	
			
			//inventory
			$target.find('#inventory-wrapper').html(inv);
			
			//size menu
			$select = $target.find('#input-size');
			$select.html('');
			for(var x in sizes){
				$el = $(document.createElement('option'));
				$el.attr('value',x);
				$el.html(sizes[x]);
				$select.append($el);
			}
			
			//hide size if its empty
			if(sizes.length == 0){
				$select.hide();
			}else{
				$select.show();
			}
			
			//set the product
			$target.find('#input-product').val(pid);
			$target.find('#input-color').val(cid);
			
			//set the text
			for(var x in window.products[cid]){
				if(window.products[cid][x].Product.id == pid){
					text = window.products[cid][x].Product.desc;
					$target.find('#description-wrapper').html(text);
					return;
				}
			}
			$target.find('#description-wrapper').html(text);
		}
	   }
	   
	};
	
	//setup the tooltips and bind the show events
	var $swatch = $('.swatch_image');
	var $products = $('.acc_image');
	
	//setup the add to cart button
	$('#add-cart').click(function(){
		var $parent = $(this).parent();
		var pid = $parent.find('#input-product').val();
		var qty = $parent.find('#input-quantity').val();
		var size = $parent.find('#input-size').val();
		var color = $parent.find('#input-color').val();
		
		ajaxAddToCart(pid,qty,size,color);
		
		$products.qtip('hide');
	});
	
	$swatch.qtip(qtipSetting);
	$products.qtip(qtipSetting);
	
	$products.qtip('api').elements.content.html('');
	$('#tooltip-product').css('display','block').appendTo($products.qtip('api').elements.content);
	
	$swatch.click(function(){$(this).trigger('showDetails');});
	$products.click(function(){$(this).trigger('showDetails');});
	
	$('.pbutton').click(function(){
		$(this).parent().parent().find('img:first').trigger('showDetails');
	});
	
	//swatch DOM setup
	$swatch.qtip('api').elements.content.html('');
	$('#swatches-wrapper').css('display','block').appendTo($swatch.qtip('api').elements.content);
	
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