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
 	      width:500,
 	      height:350,
 	      
	   },
	   position: {
	      corner: {
	         target: 'rightMiddle',
	         tooltip: 'leftTop'
	      },
	      adjust: {
		      x: -20, y: -5
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
				
			}
	   }
	   
	};
	var $comments = $('#comments');
	
	$comments.qtip(qtipSetting);
	
	$comments.click(function(){
		$comments.trigger('showCart');
	});
});