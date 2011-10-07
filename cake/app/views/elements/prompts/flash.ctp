$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: '<?php echo $flash; ?>',
		   prerender: true,
		   title:{
	   		   text:'Message',
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
 	      background: '#CCC',
 	      color: '#333',
 	      padding: 15,
 	      tip:true,
 	      width:450,
 	      
 	      
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
	   show:'showFlash',
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
	
	$('body').qtip(qtipSetting).trigger('showFlash');
	
	
});
