$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: '',
		   prerender: true,
		   title:{
	   		   text:false,
	   		   
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
	      }   
	   },
	   show:'showViewer',
	   hide:{
	   	  when:{
	   	  	  event:false
	   	  }
	   },
	   api:{
	   	onHide : function(){
	   		$('#black-out').hide();
	   	},
	   	onFocus : function(){
	   		var z = $('body').qtip('api').elements.tooltip.css('z-index');
	   		$('#black-out').show().css('z-index',z);
	   	},
	   	onRender : function(){
				
			},
		onContentLoad : function(){
				
			}
	   }
	   
	};
	
	$('body').qtip(qtipSetting).trigger('showFlash');
	
	//multiple popups can occurr, make sure this is on top
	setTimeout(function(){$('body').qtip('api').focus();},500);
	setTimeout(function(){$('body').qtip('api').focus();},1000);
	setTimeout(function(){$('body').qtip('api').focus();},1500);
	setTimeout(function(){$('body').qtip('api').focus();},2000);
});

