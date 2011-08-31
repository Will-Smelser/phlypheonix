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
					
</body>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script type="text/javascript">
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