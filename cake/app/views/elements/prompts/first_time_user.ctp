$(document).ready(function(){
	
	//first time user
	var qtipSetting = {
	   content: {
		   text: 'Loading...',
		   prerender: true
	   },
	   style: { 
	      name: 'dark', // Inherit from preset style
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
 	      tip:true
	   },
	   position: {
	      corner: {
	         target: 'topRight',
	         tooltip: 'bottomLeft'
	      },
	      adjust: {
		      x: 0, y: 0
		  }   
	   },
	   show: 'qtipShow',
	   hide: 'qtipHide',
	};

	var rotate = {
			cnt       : 0, //gets set before this is called
			obj       : this,
			btnClass  : 'one',
			spanClass : 'qtipSpan',
			len       : 2000,
			time      : false,
			show : function($seq, i) {
				var obj = this;
				if(!obj.time){
					$seq.qtip('api').onShow = function(){
						var pos = i*1 + 1;
						var btnTxt = (pos == obj.cnt) ? 'Close' : 'Next';
						
						var div = document.createElement('div');
						var span = document.createElement('span');
						var btn = document.createElement('input');
	
						$(span).html(pos+' of '+obj.cnt);
						$(span).attr('class',obj.spanClass);
						$(btn).attr('type','button');
						$(btn).attr('value',btnTxt);
						$(btn).click(function(){obj.rotate();});
						$(btn).attr('class',obj.btnClass);
	
						$(div).append(span);
						$(div).append(btn);
	
						this.elements.content.append(div);
					};
				}
				$seq.trigger('qtipShow');
			},
			init : function() {
				var obj = this;
				if(this.time){
					setTimeout(function(){obj.rotate(true)}, this.len);
				}
				obj.func(true);
			},
			rotate : function() {
				var obj = this;
				if(this.time) {
					setTimeout(function(){obj.rotate(false)}, this.len);
				}
				obj.func(false);
			},
			func : function(first) {
			var obj = this;
			
			//initialize
			if(first == true) {
				obj.show($sequence[0],0);
				return;
			}
			
			//get out if this is last tip
			if(current == $sequence[$sequence.length-1].attr('id')){
				$sequence[$sequence.length-1].trigger('qtipHide');
				return;
			}

			var found = false;
			for(var x in $sequence) {
				
				//last 
				if(found == true) {
					current = $sequence[x].attr('id');
					obj.show($sequence[x],x);
					return;
				}
				//if this is the current qtip, hide
				if($sequence[x].attr('id') == current) {
					$sequence[x].trigger('qtipHide');
					found = true;
				}
			}
		}
	};

	//put rotate to global scope for buttons
	//window.myQtip = rotate;
	
	//create the tips
	$('.qtip').each(function(){
		var id = $(this).attr('id');

		switch(id){
		case 'buynowtag':
			qtipSetting.content = '<div>Member only price available while the sale lasts!</div>'; 
			qtipSetting.position.corner.target = 'bottomRight';
			qtipSetting.position.corner.tooltip = 'leftTop';
			qtipSetting.position.adjust.x = -35;
			qtipSetting.position.adjust.y = -70;
			break;
		case 'gender':
			qtipSetting.content = '<div>Select which gender you want to view products for.</div>';
			qtipSetting.position.corner.target = 'topLeft';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 10;
			break;
		case 'search':
			qtipSetting.content = 'Add schools to your favorites.';
			qtipSetting.position.corner.target = 'topLeft';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 10;
			break;
		default:
			qtipSetting.content = 'No Content Given.';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 0;
			break;
		}
		$(this).qtip(qtipSetting);
	});

	
	//being showing the tips
	var $sequence = [$('#buynowtag'),$('#gender'),$('#search')];
	var current = $sequence[0].attr('id');

	rotate.cnt = $sequence.length;
	rotate.init();
	
	$('#buynowtag').trigger('qtipShow');
	
});