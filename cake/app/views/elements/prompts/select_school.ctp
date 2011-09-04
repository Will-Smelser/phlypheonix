$(document).ready(function(){
	var qtipSetting = {
	   content: {
		   text: '',
		   prerender: true
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
 	      tip:false,
 	      width:400
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
	   show: 'qtipShow',
	   hide: 'qtipHide',
	};
	
	var $wrap = $(document.createElement('div'));
	var $img = null;
	var $a = null;
	
	<?php foreach($data as $s) {?>
	$img = $(document.createElement('img')).attr('src','<?php echo $s['School']['logo_large']?>');
	$a = $(document.createElement('a')).attr('href','/shop/main/<?php echo $s['School']['id']; ?>').append($img);
	$wrap.append($a);
	<?php } ?>
	
	$('body').qtip(qtipSetting);
	$($('body').qtip('api').elements.content).append('<h2>HELLO WORLD</h2>');
	$('body').trigger('qtipShow');
});