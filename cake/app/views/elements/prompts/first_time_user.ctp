$(document).ready(function(){
	
	//first time user
	var qtipSetting = {
	   content: {
		   text: 'Loading...',
		   prerender: true,
		   title:{
	   		   text:false,
	   		   button:'close'
	   		   
	   	   }
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
						
						$(btn).css('float','right');
						$(span).css('float','left');
	
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
					//setTimeout(function(){obj.rotate(true)}, this.len);
				}
				obj.func(true);
			},
			rotate : function() {
				var obj = this;
				if(this.time) {
					//setTimeout(function(){obj.rotate(false)}, this.len);
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
	//var $sequence = [$('#mfg-logo'),$('#buynowtag'),$('#selector'),$('#sharethis'),$('#inventory'),$('#rightarrow'),$('#comment-wrapper')];
	var $sequence = [$('#selector'),$('#sharing')];
	for(var x in $sequence){
		var id = $sequence[x].attr('id');

		switch(id){
		case 'mfg-logo':
			qtipSetting.content.text = '<div class="title">Brand</div><p>Brand of the item you\'re viewing.</p>'; 
			qtipSetting.position.corner.target = 'rightMiddle';
			qtipSetting.position.corner.tooltip = 'leftTop';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 0;
			break;
		case 'buynowtag':
			qtipSetting.content.text = '<div class="title">Buy Now Time</div><p>Your member-only price and the amount of time left to get the deal.</p>'; 
			qtipSetting.position.corner.target = 'leftMiddle';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 10;
			qtipSetting.position.adjust.y = -10;
			break;
		case 'selector':
			qtipSetting.content.text = '<div class="title">Navigation / Selector</div>' +
			'<p><table>'+
			'	<tr><td valign="top"><img src="/img/productpresentation/flyfoenix_product_presentation_female.png" /><td><p>Click on this icon to switch between male and female products for the current team.</p>'+
			'	<tr><td valign="top"><img src="/img/productpresentation/flyfoenix_product_presentation_cart.png" /><td><p>See what\'s in your shopping cart.</p>'+
			'	<tr><td valign="top"><img src="/img/ajax/heart_small_red.png" /><td><p>Click on this icon to add a team to your favorites list.</p>'+
			'	<tr><td valign="top"><img src="/img/productpresentation/flyfoenix_product_presentation_search.png" /><td><p>Find a sale for a different team.</p>'+
			'</table></p>';
			qtipSetting.position.corner.target = 'leftMiddle';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 20;
			qtipSetting.position.adjust.y = -15;
			break;
		case 'sharethis':
		case 'sharing':
			qtipSetting.content.text = '<div class="title">Share &amp; Earn</div><p>Share a sale and get a $5 credit anytime a referral makes a purchase.</p>';
			qtipSetting.position.corner.target = 'leftMiddle';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 0;
			break;
		case 'inventory':
			qtipSetting.content.text = '<div class="title">Inventory</div><p>Real-time count of how many items we have left...when it\'s gone, it\'s gone.</p>';
			qtipSetting.position.corner.target = 'leftMiddle';
			qtipSetting.position.corner.tooltip = 'rightTop';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 0;
			break;
		case 'rightarrow':
			qtipSetting.content.text = '<div class="title">Navigation</div><p>Move on to view the next product.</p>';
			qtipSetting.position.corner.target = 'leftMiddle';
			qtipSetting.position.corner.tooltip = 'rightMiddle';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = -10;
			break;
		case 'comment-wrapper':
			qtipSetting.content.text = '<div class="title">Comments</div><p>Leave us some feedback about the sale or the product.</p>';
			qtipSetting.position.corner.target = 'rightMiddle';
			qtipSetting.position.corner.tooltip = 'leftMiddle';
			qtipSetting.position.adjust.x = 160;
			qtipSetting.position.adjust.y = 20;
			break;
		//hopefully never here
		default:
			qtipSetting.content.text = '<p>No Content Given.</p>p>';
			qtipSetting.position.adjust.x = 0;
			qtipSetting.position.adjust.y = 0;
			break;
		}
		$sequence[x].qtip(qtipSetting);
	}

	
	//being showing the tips
	var current = $sequence[0].attr('id');

	rotate.cnt = $sequence.length;
	rotate.init();
	
	//$('#mfg-logo').trigger('qtipShow');
	$('#buynowtag').trigger('qtipShow');
	
});