$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: 'Loading <img src="/img/ajax/loading.gif" />',
		   prerender: true,
		   title:{
	   		   text:'Accessory',
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
 	      background: '#FFF',
 	      color: '#333',
 	      padding: 15,
 	      tip:true,
 	      width:500
 	      
	   },
	   position: {
	      corner: {
	         target: 'center',
	         tooltip: 'center'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show:'showAccessory',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onRender : function(){
				
			},
		onContentLoad : function(){
				
			}
	   }
	   
	};
	
	$('body').qtip(qtipSetting);
	
});

function showAccessory(el){
	var src = $(el).find('img').attr('src');
	var img = $(document.createElement('img'));
	$(img).attr('src',src);
	$('body').qtip('api').elements.content.empty().append(img);
	$('body').qtip('api').elements.content.css('text-align','center');
	$('body').trigger('showAccessory');
	$('body').qtip('api').updateWidth();
}