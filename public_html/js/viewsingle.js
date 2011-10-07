$(".feature-thumb").
	mioZoom({
		'$target':$('.mainphoto'),
		'zoom':false,
		'hideOnExit':true,
		'onEnterHook':function(id){
			
		},
		'onExitHook':function(id){
			//obj.$sliders[temp].find('.attribute-detail').slideUp();
		}
	});

$(".gallery-thumb").mioZoom({'$target':$('.mainphoto')});