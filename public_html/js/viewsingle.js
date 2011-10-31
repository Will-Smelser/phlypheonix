$(".feature-thumb").
	mioZoom({
		'$target':$('.mainphoto'),
		'zoom':false,
		'hideOnExit':true,
		'onEnterHook':function(id){
			//$('.attribute-detail').css({'z-index':this.zoomZindex+1,'width':this.wrapperWidth-20+'px'}).html($($temp[id]).html()).slideDown();
		},
		'onExitHook':function(id){
			//obj.$sliders[temp].find('.attribute-detail').slideUp();
			//$('.attribute-detail').slideUp();
		}
	});

$(".gallery-thumb").mioZoom({'$target':$('.mainphoto')});