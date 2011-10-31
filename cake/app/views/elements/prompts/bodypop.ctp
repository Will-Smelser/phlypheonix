$(document).ready(function(){
	var qtipSetting = {
	   content: {
		  text: '',
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
 	         color: '#111'
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
		      x: 0, y: -50
		  }   
	   },
	   show:'showMsg',
	   hide:{
	   	  when:{
	   	  	  event:'unfocus'
	   	  }
	   },
	   api:{
	   	onHide : function(){},
	   	onFocus : function(){},
	   	onRender : function(){},
		onContentLoad : function(){}
	   }
	   
	};
	
	$('body').qtip(qtipSetting).trigger('showFlash');
	
	//multiple popups can occurr, make sure this is on top
	setTimeout(function(){$('body').qtip('api').focus();},500);
	setTimeout(function(){$('body').qtip('api').focus();},1000);
	setTimeout(function(){$('body').qtip('api').focus();},1500);
	setTimeout(function(){$('body').qtip('api').focus();},2000);
});
