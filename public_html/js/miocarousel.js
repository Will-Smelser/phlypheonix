(function( $ ){
	$.fn.mioZoom = function( options ) { 
		  
		var settings : {
			constrain : 'width', //[width, height, cropY, cropX]
			x: 100,
			y: 200,
			orient : 'vertical', //orientation [vertical, horizontal]
			speed: 200
		};
		
		this.each(function(key) {   
			if ( options ) { 
				$.extend( settings, options );
		    }
  
		    //the wrapper
			var $wrapper = $(this);
			
			//setup the layout
			$prevArrow = $(document.createElement('div'));
			$nextArrow = $(document.createElement('div'));
			$inner = $(document.createElement('div'));
			$wrapper.find('ul').appendTo($inner);
			$wrapper.append($prevArrow);
			$wrapper.append($inner);
			$wrapper.append($nextArrow);
				
			var function shift($url){
				
			};
			var function push($url){
				
			};
			var function add(location, $url){
				$(document.creatElement('img'));
				$
			};
		}
	}
	
})( jQuery );