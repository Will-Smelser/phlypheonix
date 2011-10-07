$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: '<div class="title">Register with Facebook</div><div style="font-size:12px;margin-left:5px;">Fast, easy and you login with one click.  Facebook members have additional access to promotions and discounts.</div>',
		   prerender: true,
		   title:{
	   		   text:'Register',
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
 	      width:250,
 	      height:80,
 	      
	   },
	   position: {
	      corner: {
	         target: 'rightMiddle',
	         tooltip: 'leftMiddle'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show:'showFbAlert',
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
	
	$('#fb-reg').qtip(qtipSetting).trigger('showFbAlert');
	
});