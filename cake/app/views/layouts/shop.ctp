<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('productpresentation.css');
		echo $this->Html->css('kvkContBubbles.css');

		echo $scripts_for_layout;

	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>

<img id="background" src="<?php echo $school['background']; ?>" alt="ohiostatebackground" />

<div id="wrapper"> 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('school'=>$school,'myuser'=>$myuser)); ?>
  </div>
  

	<?php //echo $this->Session->flash(); ?>

	<?php echo $content_for_layout; ?>

</div>
					
</body>
<link rel="stylesheet" type="text/css" href="/css/jquery.jqzoom.css"></link>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>
<script type='text/javascript' src='/js/jquery.jqzoom-core.js'></script> 

<script type="text/javascript">
//product viewer
$(document).ready(function(){
	var viewer = {
		width : 935,
		x : 0,
		$wrapper : null,
		$sliders : [],
		current : 0,
		$lnav : null,
		$rnav : null,
		speed : 1000,
		inTrans : false,
		
		init : function() {
			var obj = this;

			//build info
			obj.$wrapper = $('#sliderpane');
			obj.$wrapper.children('.slider').each(function(){
				obj.$sliders.push($(this));
			});

			//load other pages
			for(var i = 1; i < obj.$sliders.length; i++){
				var temp = i;
				obj.$sliders[i].load(
						obj.$sliders[i].attr('id'), //the id actually holds the url
						function(){
							obj.$sliders[temp].removeClass('product-loading');
							obj.$sliders[temp].find(".gallery-thumb").mioZoom({'$target':obj.$sliders[temp].find('.mainphoto')});
							obj.$sliders[temp].find(".feature-thumb").mioZoom({'$target':obj.$sliders[temp].find('.mainphoto'),'zoom':false,'hideOnExit':true});
						}
				);
			}

			//set left/right nav
			obj.$lnav = $('#leftarrow');
			obj.$rnav = $('#rightarrow');
			 
			//bind nav
			obj.$rnav.click($.proxy(obj.moveRight,obj));
			obj.$lnav.click($.proxy(obj.moveLeft,obj));
		},
		moveLeft : function() {
			var obj = this;

			if(obj.inTrans) return;
			if(obj.current <= 0) return;
			
			obj.inTrans = true;
			obj.current--;
			obj.anim('+='+obj.width);
			obj.toggleNavs();
		},

		moveRight : function() {
			var obj = this;

			if(obj.inTrans) return;
			if(obj.current == obj.$sliders.length-1) return; 
			
			obj.inTrans = true;
			obj.current++;
			obj.anim('-='+obj.width);
			obj.toggleNavs();
		},

		anim : function(pos) {
			var obj = this;
			obj.$wrapper.animate({
				left: pos
			},
			obj.speed,
				function(){
					obj.inTrans = false;
				}
			);
		},

		toggleNavs : function() {
			var obj = this;

			//check left
			(obj.current > 0) ? obj.showLeftNav() : obj.hideLeftNav();
			
			//we never actually hide the right
		},

		showLeftNav : function() {this.$lnav.fadeIn();},
		showRightNav: function() {this.$rnav.fadeIn();},

		hideLeftNav : function() {this.$lnav.fadeOut();},
		hideRightNav: function() {this.$rnav.fadeOut();}
	};

	viewer.init();
});

(function( $ ){

	  $.fn.mioZoom = function( options ) {  

	    var settings = {
	      $target : null, //some jquery element
	      zoom : true,
	      hideOnExit : false, //hide all images on exit
	      onEnterHook: function(){return;},
	      imageWidth   :700,
	      imageHeight  :800,
	      wrapperWidth : 355,
	      wrapperHeight: 405,
	      zoomZindex   : 1000,
	      imageZindex  : 999
	    };

	    //cycle the thumbs
	    this.each(function() {        
	      // If options exist, lets merge them
	      // with our default settings
	      if ( options ) { 
	        $.extend( settings, options );
	      }
	      
	      //lets add the images to the target (hidden)
	      var $el = $(this);
	      
	      var cssWrapper = {
	    	      'display':'none',
	    	      'position':'absolute',
	    	      'z-index':settings.zoomZindex,
	    	      'top':'0px',
	    	      'left':'0px',
	    	      'overflow':'hidden',
	    	      'width':settings.wrapperWidth+'px',
	    	      'height':settings.wrapperHeight+'px'
		  };
		  
	      var $bigImg = $(document.createElement('img')).
	      					attr('src',$el.attr('href')).
	      					attr('height',settings.imageHeight).
	      					attr('width',settings.imageWidth);

		  var $normImg = $(document.createElement('img')).
							attr('src',$el.attr('rel')).
							attr('width',settings.wrapperWidth).
							attr('height',settings.wrapperHeight);
			
	      var $zoomWrapper = $(document.createElement('div')).
	      					addClass('mioZoomWrapper').
	      					append($bigImg).
	      					css(cssWrapper);
			
		  cssWrapper['z-index'] = settings.imageZindex;
	      var $imgWrapper = $(document.createElement('div')).
			addClass('mioImageWrapper').
			append($normImg).
			css(cssWrapper);

		  //needed functions
		  var hideZoom = function(){
				settings.$target.find('.mioZoomWrapper').hide();
		  };
		  var hideImgs = function($except){
			  settings.$target.find('.mioImageWrapper').each(function(){
				if($(this).find('img').attr('src') != $except.attr('src')) $(this).hide();
			  });
		  };
		  var resetZoomImage = function() {
			  $zoomWrapper.find('img').css({
                	'position':'absolute',
					'left':'0px',
					'top' :'0px'
	      	  });
		  };
	      
	      settings.$target.append($zoomWrapper).append($imgWrapper);

	      //need to position all images absolutely
	      var pos = $el.offset();
	      //$el.css({'display':'block','position':'absolute','top':pos.top+'px','left':pos.left+'px'});

	      //now lets bind the events
	      //show zoom window
	      $el.bind('mouseenter mouseover', function (event) {
		      hideImgs($imgWrapper);
		      if(settings.zoom){
	    	  	$zoomWrapper.show();
		      }
	    	  $imgWrapper.show();
	    	  settings.onEnterHook();
	      });

	      
		  //hide zoom window
	      $el.bind('mouseleave',function(){
		      hideZoom();
		      resetZoomImage();
		      if(settings.hideOnExit){
				settings.$target.find('.mioImageWrapper').hide();
		      }
		   });
		   

		   //remove the onclick
		   $el.click(function(){return false;});

		  //make the movement happen
	      if(settings.zoom){
	      $el.bind('mousemove', function (e) {
	    	  var x = -1*(e.pageX - $el.offset().left - 20);// + settings.wrapperWidth/2 ;
	    	  var y = -1*(e.pageY - $el.offset().top - 30);// + settings.wrapperHeight/2;

			  var $img = $zoomWrapper.find('img');
              
              var xFactor = $img.attr('width') / $el.width();
              var yFactor = $img.attr('height') / $el.height();

			  var posX = Math.floor(xFactor*x);
			  var posY = Math.floor(yFactor*y);

			  if(posX > 0) posX = 0;
			  if(posY > 0) posY = 0;
			  if(posX + settings.imageWidth < settings.wrapperWidth) posX = settings.imageWidth - settings.wrapperWidth;
			  if(posY + settings.imageHeight < settings.wrapperHeight) posY = settings.imageHeight - settings.wrapperHeight;
              
              $img.css({
                  	'position':'absolute',
					'left':posX+'px',
					'top' :posY+'px'
	      	  });
          });
	      }
          

	    });

	  };
	})( jQuery );

$(document).ready(function(){
	//$(".gallery-thumb").jqzoom({'ztarget':'mainphoto'});
	var $main = $('#sliderpane').children().first();
	$main.find(".gallery-thumb").mioZoom({'$target':$main.find('.mainphoto')});
	$main.find(".feature-thumb").mioZoom({'$target':$main.find('.mainphoto'),'zoom':false,'hideOnExit':true});
});


//share this
var switchTo5x=true;
$(document).ready(function(){
	$.getScript('<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
	});
});

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>
</script>
</html>