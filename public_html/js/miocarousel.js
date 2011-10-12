(function( $ ){
	$.fn.mioCarousel = function( options ) { 
		  
		var settings = {
			constrain : 'width', //[width, height, cropY, cropX]
			x: 175, //viewer x dimensions
			y: 350, //viewer y dimaensions
			orient : 'vertical', //orientation [vertical, horizontal]
			speed: 200, //click scroll speed
			loadComplete: function($targetImage){},
			nearEnd:null,
			nearEndPos:5,
			upNav:false,
			downNav:false,
			autoScroll:true,
			autoScrollDelay: 1500,
			autoScrollRestartDelay: 3000
		}
		var methods = {		
			add : function(location, url){
					var data = $(this).data('mioCarousel');
					var $li = $(document.createElement('li')).addClass('loading');
					var $img = $(document.createElement('img'));
					
					var $ul = $(this).find('ul');
					
					$img.appendTo($li);
					
					if(location == 0){
						$li.prependTo($ul);
					} else{
						$ul.find(' li:nth-child('+location+')').after($li);
					}
					
					$(this).mioCarousel('bindImgLoading',$img,url);
					$(this).mioCarousel('refreshCache');
			},
			refreshCache : function(){
				var obj = $(this);
				obj.data('mioCarousel').elCache = [];
				obj.find('ul').children().each(function(){obj.data('mioCarousel').elCache.push($(this))});
			},
			
			shift : function(url){
				$(this).mioCarousel('add',0,url);
			},
			push : function(url){
				var obj = $(this);				
				obj.mioCarousel('add',(obj.find('ul').children().length),url)
			},
			bindImgLoading : function($img,url){
				$img.attr('src',url).load(function(){
					//$(this).mioCarousel('loadComplete');
					$(this).parent().css({}).removeClass('loading');//remove the css style
				});
			},
			nearEnd : null,
			scrollNext : function(){
				
				var obj = $(this);
				var data = obj.data('mioCarousel');
				
				if(data.position == data.elCache.length-1) return;
				
				var topPos = data.topPos;
				var $el = data.elCache[data.position];
				var offset = $el.outerHeight();
				
				topPos -= offset;
				obj.data('mioCarousel').position++;
				
				obj.mioCarousel('anim',topPos);
				
				//update the near end
				if(data.elCache.length - data.position < data.nearEndPos){
					obj.data('mioCarousel').nearEnd();
					obj.mioCarousel('refreshCache');
				}
			},
			scrollPrev : function(){
				var obj = $(this);
				var data = obj.data('mioCarousel');
				
				if(data.position == 0) return;
				
				var topPos = data.topPos;
				var $el = data.elCache[data.position-1];
				var offset = $el.height();
				
				topPos += offset;
				
				obj.data('mioCarousel').position--;
				
				obj.mioCarousel('anim',topPos);
			},
			anim : function(pos){
				var obj = $(this);
				var data = obj.data('mioCarousel');
				var $ul = obj.find('ul');
				var dir = (settings.orient == 'vertical') ? 'top' : 'left';
				var callback = (data.autoScroll) ? function(){setTimeout(function(){obj.mioCarousel('scrollNext')},data.autoScrollDelay);} : function(){};
				
				//save the position
				obj.data('mioCarousel').topPos = pos;
				
				var info = {};
				info[dir] = pos+'px';
				
				$ul.animate(info,settings.speed, callback);
			},
			autoScroll : function(){
				var $ul = $(this).find('ul');
				
				$ul.animate(
					{top:pos+'px'},
					{step:function(now, fx){
						
					}}	
				);
			}
		};
		
		// Method calling logic
		if(typeof options == 'string'){
			if(methods[options] == null) alert(options);
			//if(typeof methods[options] != 'undefined') return;
			return methods[options].apply( this, Array.prototype.slice.call( arguments, 1 ));
		}
		
		return this.each(function(key) { 
			var obj = $(this);
			
			if ( options ) { 
				$.extend( settings, options );
		    }
			
			obj.data('mioCarousel',{
				elCache:[],
				position:0,
				topPos:0,
				loadComplete:settings.loadComplete,
				nearEnd:settings.nearEnd,
				nearEndPos:settings.nearEndPos,
				autoScroll: settings.autoScroll,
				autoScrollDelay: settings.autoScrollDelay,
				autoScrollRestartDelay: settings.autoScrollRestartDelay
			});
			
			var topPos = 0; //either left or top, depending on orient
			var height = 0;
			var width = 0;
			
		    //the wrapper
			var $wrapper = $(this);
			
			//setup the layout
			//add up arrow
			if(settings.upNav){
				$prev = $(document.createElement('div')).addClass('carousel-prev').html('prev');
				$wrapper.append($prev);
				$prev.click(function(){obj.mioCarousel('scrollPrev');});
			}
			
			$inner = $(document.createElement('div')).addClass('carousel-inner');
			$wrapper.append($inner);
			
			//add down arrow
			if(settings.downNav){
				$next = $(document.createElement('div')).addClass('carousel-next').html('next');
				$wrapper.append($next);
				$next.click(function(){obj.mioCarousel('scrollNext');});
			}
			
			
			var $ul = $wrapper.find('ul');
			$ul.css({'position':'relative'});
			$ul.appendTo($inner);
			
			//set basics
			height = $inner.height();
			width = $inner.width();
			
			//set the cache
			$ul.children().each(function(){
				obj.data('mioCarousel').elCache.push($(this));
			});
			
			if(settings.autoScroll){
				setTimeout(function(){obj.mioCarousel('scrollNext');},settings.autoScrollDelay);
			}
		});
	};
	
})( jQuery );