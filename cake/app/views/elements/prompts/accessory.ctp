$(document).ready(function(){
var qtipSetting = {
	   content: {
		  text: 'Loading...',
		   prerender: true,
		   title:{
	   		   text:'Accessory Details',
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
 	      width:300
	   },
	   position: {
	      corner: {
	         target: 'center',
	         tooltip: 'center'
	      },
	      adjust: {
		      x: 0, y: 0,
		  }   
	   },
	   show:'showDetail',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onRender : function(){
				
			},
		onContentLoad : function(){
			
			var obj = this;
			setTimeout(function(){
				//$('#qtip-general-container').qtip('api').updatePosition();
			
				obj.elements.content.find('#qtip-add-to-cart').click(function(){
				
				//setup the form that was loaded
				var $cont = obj.elements.content;
				
				var qty = $cont.find('.input-quantity').val();
				var size = $cont.find('.input-size').val();
				var color = $cont.find('.input-color').val();
				var product = $cont.find('.input-product').val();
				
				var items = (qty > 1) ? ' items' : ' item';
				
				var url = '/cart/addProduct/'+product+'/'+qty+'/'+size+'/'+color;
				
				var $cart = $('#cart');
				$cart.qtip('api').elements.content.html('Adding '+qty+items+'...');
				$cart.trigger('showCart');

				$.getJSON(url,
					//success
					function(data){
						if(data == 0){
							$cart.qtip('api').elements.content.html('Error adding item.');
						} else {
							$cart.qtip('api').elements.content.html('Successfully added '+qty+items);
							setTimeout(function(){$cart.qtip('hide');},1000);
						}
						
					}
				);
				
				$('#qtip-general-container').qtip('hide');
				
			});
		  },200);
		}
	   }
	   
	};
	
	var $cont = $('#qtip-general-container');
	$cont.qtip(qtipSetting);
	$('.acc_image').click(function(){
		
		var info = $(this).attr('id').split('_');
		var url = '/accessories/detail/' + info[0].split('-')[1] + '/' + info[1].split('-')[1];
		
		$cont.qtip('api').elements.content.html('Loading...');
		$cont.qtip('api').loadContent(url);
		$cont.trigger('showDetail');
		$cont.qtip('api').updatePosition();
		
	});
	
	$('.view_detail_btn').click(function(){
		$(this).parent().parent().parent().find('.acc_image').trigger('click');
	});
	
});