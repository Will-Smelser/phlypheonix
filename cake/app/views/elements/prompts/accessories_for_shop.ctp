$(document).ready(function(){

	var $acclink = $('#accessories-link');
	
	var open = false;
	var animated = false;
	var leftBtn = ($('#leftarrow').css('display') == 'block');
	
	
	$acclink.click(function(){
		//$(this).trigger('showAccessories');
		if(animated) return;
		
		animated = true;
		
		if(open){
			toggleDown();
			$(this).addClass('up').removeClass('down');
		} else {
			toggleUp();
			$(this).addClass('down').removeClass('up');
		}
	});
	
	
	
	var toggleUp = function(){
		leftBtn = ($('#leftarrow').css('display') == 'block');
		
		open = true;
		$('#accessories-wrapper').animate({height:515},function(){
			animated = false;	
		});
		
		$('#leftarrow').hide();
		$('#rightarrow').hide();
		$('#buytwo').hide();
		$('#sliderwrapper').hide();
	};
	
	var toggleDown = function(){
		open = false;
		$('#accessories-wrapper').animate({height:30},function(){
			animated = false;
			$('#buytwo').show();
			$('#sliderwrapper').show();
			
			$('#rightarrow').show();
			if(leftBtn) $('#leftarrow').show();
		});
	}
	
	
});