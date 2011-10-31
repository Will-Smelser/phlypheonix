(function( $ ){

	  $.fn.mioZoom = function( options ) {  

	    var settings = {
	      $target : null, //some jquery element
	      zoom : true,
	      hideOnExit : false, //hide all images on exit
	      onEnterHook: function(){return;},
	      onExitHook: function(){return;},
	      imageWidth   :700,
	      imageHeight  :800,
	      wrapperWidth : 351,
	      wrapperHeight: 401,
	      zoomZindex   : 1000,
	      imageZindex  : 999,
	      id : null,
	      unique : null
	    };

	    //cycle the thumbs
	    this.each(function(key) {        
	      // If options exist, lets merge them
	      // with our default settings
	      if ( options ) { 
	        $.extend( settings, options );
	      }

	      //what is the index value
	      this.id = key+settings.unique;
	      
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
	    	  settings.onEnterHook(this.id);
	    	  
	      });

	      
		  //hide zoom window
	      $el.bind('mouseleave',function(){
		      hideZoom();
		      resetZoomImage();
		      if(settings.hideOnExit){
				settings.$target.find('.mioImageWrapper').hide();
		      }
		      settings.onExitHook(this.id);
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