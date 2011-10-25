<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('default.css');
		echo $this->Html->css('dynamic.css');
		
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
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
	
</head>
<body>

<div id="wrapper" > 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('myuser'=>$myuser)); ?>
  </div>

	<?php echo $content_for_layout; ?>	
	
</div>

<?php
	//if($loggedin){ 
		echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$myuser['User']['sex'],'link'=>'/shop/main/'));
	//}
?>



<div id="background-wrapper">
	<?php 
	if(isset($bgImg)){ 
		echo "<img id=\"background\" src=\"$bgImg\" alt=\"ohiostatebackground\" />";
	} else {
	?>
	<img id="background" src="/img/schools/background/default.jpg" alt="ohiostatebackground" />
	<?php 
	}
	?>
</div>

</body>

<?php
//controller set scripts
if(isset($jsFilesBottom)){
	foreach($jsFilesBottom as $file){
		echo "<script type=\"text/javascript\" language=\"javascript\" src=\"$file\"></script>\n";
	}
}
?>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>


<script type="text/javascript">

//search for schools
<?php echo $this->element('prompts/search_school',array('DOMtarget'=>'#search')); ?>

//show cart
<?php echo $this->element('prompts/cart'); ?>

//heart toggle...add school to favorites
<?php if($loggedin) echo $this->element('js/heart_toggle',array('school_id'=>$school['School']['id'])); ?>

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>

//page specific scripts
<?php 
	if(file_exists(ELEMENTS . 'js' . DS . $this->params['controller'] . '.ctp')) 
		echo $this->element('js/'.$this->params['controller'],compact('scriptData','protocal','loggedin')); 
?>

//page specific prompts
<?php 
if(isset($pageElements)){
	foreach($pageElements as $el){
		echo $this->element($el['element'],array('data'=>$el['data']));
	}
}
?>

//share this
var switchTo5x=true;
$(document).ready(function(){
	$.getScript('<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
	});
});

//js to handle the navigation
//bind the school select events
$('#h-search ul li').each(function(){
	var $el = $(this);
	//$el.find('input').hide();
	$el.click(function(){
		var html = $el.find('p').html();
		$('#h-search li:first span:first').html(html);
	});
});

//bind the sex events
$('#h-sex ul li').each(function(){
	var $el = $(this);
	//$el.find('input').hide();
	$el.click(function(){
		var src = $(this).find('img').attr('src');
		$('#h-sex-icon img').attr('src',src);
	});
});
</script>
</html>