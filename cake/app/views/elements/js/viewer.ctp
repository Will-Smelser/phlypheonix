	var viewer = {
		width : 935,
		x : 0,
		$wrapper : null,
		$sliders : [],
		products : <?php echo json_encode($products); ?>,
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
							obj.$sliders[temp].find(".gallery-thumb").mioZoom(
									{
										'$target':obj.$sliders[temp].find('.mainphoto'),
										'onEnterHook' : function(id){
											//this should reference the zoom object
											var $temp = obj.$sliders[temp].find('.product-detail-wrapper').children();
											$temp.hide();
											$($temp[id]).show();
										}
								
									}
							);
							obj.$sliders[temp].find(".feature-thumb").
								mioZoom({
								'$target':obj.$sliders[temp].find('.mainphoto'),
								'zoom':false,
								'hideOnExit':true,
								'onEnterHook':function(id){
									var $temp = obj.$sliders[temp].find('.feature-wrapper .attribute-info');
									//padding is 20, so to get the correct widht, have to sebtract the padding
									obj.$sliders[temp].find('.attribute-detail').
										css({'z-index':this.zoomZindex+1,'width':this.wrapperWidth-20+'px'}).
										html($($temp[id]).html()).slideDown();
								},
								'onExitHook':function(id){
									obj.$sliders[temp].find('.attribute-detail').slideUp();
								}
							});
												
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
			obj.setPrice();
		},

		moveRight : function() {
			var obj = this;

			if(obj.inTrans) return;
			if(obj.current == obj.$sliders.length-1) return; 
			
			obj.inTrans = true;
			obj.current++;
			obj.anim('-='+obj.width);
			obj.toggleNavs();
			obj.setPrice();
			
		},

		setPrice : function() {
			var obj = this;
			$('#buynowtag').attr('src',obj.products[obj.current].pricetag);
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
