<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		//Facebook Share Information
		echo $this->Hfacebook->shareMeta($shareImage);
		
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('default.css');
		echo $this->Html->css('viewer.css');
		
		if(file_exists(WWW_ROOT . 'css' . DS . $this->params['controller'] . '.css')){
			echo $this->Html->css($this->params['controller'] . '.css');
		}
		
		if(isset($cssFiles)){
			foreach($cssFiles as $file){
				echo "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"$file\" />\n";
			}
		}
		
		if(isset($jsFilesTop)){
			foreach($jsFilesTop as $file){
				echo "\t<script type\"text/javascript\" language=\"javascript\" src=\"$file\"></script>";
			}
		}

		echo $scripts_for_layout;
		
	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
	
	<script language="javascript">
		//tell parent window we have loaded enough
	    try{//trap error if this page is loaded by itself and not from parent window
	  	  window.parent.mioPopup.loadComplete();
	    } catch(e){};
  	</script>
	
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16246818-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript" language="javascript" src="/js/jquery.miozoom.js"></script> 

</head>
<body>
<?php echo $content_for_layout; ?>


<!-- SIZE CHART -->
<div style="display:none;overflow:auto;height:500px;" id="size-chart">
<?php echo $this->element('sizechart'); ?>
</div>

<div id="return-policy" style="display:none;overflow:auto;height:500px;">
	<?php echo $this->element('returnshort'); ?>
</div>

</body>

<script type="text/javascript" language="javascript">

var imageData = <?php echo json_encode($product['Pimage']); ?>;
var attrData = <?php echo json_encode($product['Pattribute']); ?>;
</script>

<script type="text/javascript" language="javascript" src="/js/viewer2.js"></script>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>

<script type="text/javascript" language="javascript">
//share this
var switchTo5x=true;
$(window).load(function(){
	$.getScript('<?php echo $protocal; ?>://w<?php if($protocal == 'https') echo 's'; ?>.sharethis.com/button/buttons.js',function(){
		
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
		
	});
});

<?php echo $this->element('prompts/bodypop'); ?>

//size chart
$('#size-chart-link').click(function(){
	$('body').qtip('api').elements.content.css({'overflow':'auto','max-height':'500px'});

	$('body').qtip('api').updateContent($('#size-chart').html(),true);
	$('body').qtip('api').updateWidth(650);
	
	$('body').qtip('show');
	return false;
});

//shipping
$('#return-link').click(function(){
	$('body').qtip('api').updateContent($('#return-policy').html(),true);
	$('body').qtip('api').updateWidth(650);
	
	$('body').qtip('show');
	return false;
});
</script>
</html>