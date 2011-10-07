$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: 'Loading <img src="/img/ajax/loading.gif" />',
		   prerender: true,
		   title:{
	   		   text:'Size Chart',
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
 	      width:700,
 	      height:500,
 	      
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
	   show:'showSizechart',
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
	
	$('#size-chart').appendTo($('body').qtip(qtipSetting).qtip('api').elements.content.empty()).show();
	
});

function showSizeChart(){
	$('body').trigger('showSizechart');
}