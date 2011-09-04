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

<img id="background" src="<?php echo $school['background']; ?>" alt="ohiostatebackground" />

<div id="wrapper"> 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('school'=>$school,'myuser'=>$myuser)); ?>
  </div>
  
	<?php //echo $this->Session->flash(); ?>

	<?php echo $content_for_layout; ?>

</div>

<?php echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$sex)); ?>

</body>

<script type="text/javascript" src="/js/jquery.miozoom.js"></script>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>


<script type="text/javascript">
//product viewer
$(document).ready(function(){
	<?php echo $this->element('js/viewer'); ?>

	//reference to the current slider pane
	var $main = $('#sliderpane').children().first();

	//gallery images
	$main.find(".gallery-thumb").mioZoom({
		'$target':$main.find('.mainphoto'),
		'onEnterHook' : function(id){
			//this should reference the zoom object
			var $temp = $main.find('.product-detail-wrapper').children();
			$temp.hide();
			$($temp[id]).show();
		}
	});
	
	//product features
	$main.find(".feature-thumb").
		mioZoom({
			'$target':$main.find('.mainphoto'),
			'zoom':false,
			'hideOnExit':true,
			'onEnterHook':function(id){
				var $temp = $main.find('.feature-wrapper .attribute-info');
				//padding is 20, so to get the correct widht, have to sebtract the padding
				$('.attribute-detail').css({'z-index':this.zoomZindex+1,'width':this.wrapperWidth-20+'px'}).html($($temp[id]).html()).slideDown();
			},
			'onExitHook':function(id){
				$('.attribute-detail').slideUp();
			}
		});

	//timer
	<?php echo $this->element('js/timer'); ?>
	
});

//search for schools
<?php echo $this->element('prompts/search_school',array('DOMtarget'=>'#search')); ?>

//heart toggle...add school to favorites
<?php echo $this->element('js/heart_toggle',array('school_id'=>$school['id'])); ?>

//add to cart
<?php echo $this->element('prompts/checkout',array('count'=>count($products))); ?>
$(document).ready(function(){
	$('#sliderpane:first-child .checkout').click(function(){
		bindCheckout(1);
	});
});

//share this
var switchTo5x=true;
$(document).ready(function(){
	$.getScript('<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
	});
});

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>
</script>
</html>