<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('productpresentation.css');
		echo $this->Html->css('kvkContBubbles.css');

		echo $scripts_for_layout;

	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>


<!-- HEADER BEGIN -->
<!-- Dynamically generate backound image -->
<img id="background" src="/img/ohiostate/ohiostate_brutusrun.jpg" alt="ohiostatebackground" />

<div id="wrapper"> 
  <div id="mainHeader">
    <img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="flyfoenixlogo" />
    <span id="caption" class="four">Unique Collegiate Fashion.&nbsp;&nbsp;Quick Shopping.&nbsp;&nbsp;Great Fit & Feel.&nbsp;&nbsp;High Style.&nbsp;&nbsp;Lower Prices.</span>
    <div id="navigate">
	    <span class="five">Welcome &nbsp; <?php echo $myuser['User']['email']; ?></span>
	    <span class="five"><a class="nav" href="/users/logout">Log Out</a></span>
	    <span class="five"><a class="nav" href="#">Contact</a></span>
	    <span class="five"><a class="nav" href="#">Account Info</a></span>
    </div>    
  </div>
</div>
<!-- HEADER END -->

<?php echo $this->Session->flash(); ?>

<?php echo $content_for_layout; ?>
			
			
</body>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});</script>

<script type="text/javascript">
<?php if($noSchools) { ?>
//no school prompt user
$(document).ready(function(){
	var qtipSetting = {
	   content: {
		   text: 'Dark themes are all the rage!',
		   prerender: true
	   },
	   style: { 
	      name: 'green', // Inherit from preset style
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


<?php } ?>
</script>
</html>