	var recycleTimer = function(){
		var $counter = $('#counter');
		var val = $counter.html().split(' ');
		var days  = val[0].substring(0,val[0].length-1)*1;
		var hours = val[1].substring(0,val[1].length-1)*1;
		var min   = val[2].substring(0,val[2].length-1) * 1 - 1;

		//need to reduce hours and carry
		if(min < 0){
			min = 59;
			hours--;
			//need to reducs days and carry
			if(hours < 0){
				hours = 24;
				days--;
				//no time was left
				if(days < 0){
					min = 0;
					hours = 0;
					days = 0;
					clearInterval(window.mioclock);
				}
			}
		}
		//alert('test');
		$counter.html(days+'d '+hours+'h '+min+'m ');
	};
	//recycleTimer();
	window.mioclock = setInterval(recycleTimer, 60000);//every 1 minute