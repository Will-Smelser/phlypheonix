

$(document).ready(function(){
	window.viewer = {
		checkoutUrl : '/accessories/index/'+window.schoolId+'/'+window.sex,
		
		init : function() {
			var obj = this;
			
			obj.updateProductAbout(0);
			
			//bind add to cart
			$('#add-to-cart').click(function(){
				obj.addToCart();
			});
			
			//startup the mioZoom
			$(".feature-thumb").
				mioZoom({
					'$target':$('.mainphoto'),
					'unique':'-feat',
					'zoom':false,
					'hideOnExit':true,
					'onEnterHook':function(id){
						id = id.split('-')[0];
						var desc = attrData[id].description;
						
						if(desc != ''){
							$('.attribute-detail').
								css({'z-index':this.zoomZindex+1,'width':this.wrapperWidth-20+'px'}).
								html(desc).slideDown();
						}
					},
					'onExitHook':function(id){
						$('.attribute-detail').slideUp();
					}
				});
	
			$(".gallery-thumb").mioZoom({
				'$target':$('.mainphoto'),
				'unique':'-thumb',
				'onEnterHook':function(id){
					obj.updateProductAbout(id);
				}
			});
		},
		updateProductAbout : function(id){
			id = id.toString().split('-')[0];
			
			var height = imageData[id].Actor.height;
			var weight = imageData[id].Actor.weight;
			var bust = imageData[id].Actor.bust;
			var waist = imageData[id].Actor.waist;
			var color = imageData[id].Color.name;
			var size = imageData[id].Size.display;
			
			if($('#p-color').html() != color ||
				$('#p-size').html() != size ||
				$('#height').html() != height ||
				$('#weight').html() != weight ||
				$('#bust').html() != bust ||
				$('#waist').html() != waist
			){
				$('#image-info-loader').show();
				setTimeout(function(){
					
					$('#p-color').html(color);
					$('#p-size').html(size);
					$('#height').html(height);
					$('#weight').html(weight);
					$('#bust').html(bust);
					$('#waist').html(waist);
					
					$('#image-info-loader').hide();
				},750);
			}
		},
		addToCart : function(){
			var obj = this;
			var id = $('#product-id').val();
			var qty = $('#input-quantity').val();
			var color = $('#input-color input:checked').val();
			var size = $('#size-wrap input:checked').val();
			
			if(isNaN(qty)){
				var $body = $('body');
				$body.qtip('api').updateContent('Invalid Quantity: '+qty);
				$body.trigger('showMsg');
				return;
			}
			if(isNaN(id)){
				var $body = $('body');
				$body.qtip('api').updateContent('Invalid Product.  Cannot add to cart.');
				$body.trigger('showMsg');
				return;
			}
			if(isNaN(color)){
				var $body = $('body');
				$body.qtip('api').updateContent('Please select a color.');
				$body.trigger('showMsg');
				return;
			}
			if(isNaN(size)){
				var $body = $('body');
				$body.qtip('api').updateContent('Please select a valid size.');
				$body.trigger('showMsg');
				return;
			}
			obj.ajaxAddToCart(id, qty, size, color);
		},
		ajaxAddToCart : function(id, qty, size, color){
			
			var items = (qty > 1) ? ' items' : ' item';
			//var $cart = $('#cart');
			var $body = $('body');
			
			$body.qtip('api').updateContent('Adding '+qty+items+'...');
			$body.trigger('showMsg');
			
			$.getJSON('/cart/addProduct/'+id+'/'+qty+'/'+size+'/'+color,
				//success
				function(data){
					var $body = $('body');
					//alert('done');
					$body.qtip('api').updateContent('Successfully added '+qty+items);
					setTimeout(function(){$body.qtip('hide');},1200);
				}
			);
		}
	};

	viewer.init();
});

var changeImage = function(id){
		for(var x in imageData){
			if(imageData[x].Color.id == id){
				$($('.gallery-thumb')[x]).trigger('mouseenter').trigger('mouseleave');
				return;
			}
		}
}