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

		echo $scripts_for_layout;
		
	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>

<?php 
if(isset($bgImg)){ 
	echo "<img id=\"background\" src=\"$bgImg\" alt=\"ohiostatebackground\" />";
} else {
?>
<img id="background" src="/img/schools/background/default.jpg" alt="ohiostatebackground" />
<?php 
}
?>

<div id="wrapper" > 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('myuser'=>$myuser)); ?>
  </div>
  	<div id="bodyHeader" class="<?php echo $classWidth; ?>"><!-- Begin bodyHeader -->
  	<table width="100%">
		<tr>
			<td class="left"></td>
			<td class="bg-main">
			<img src="<?php echo $title; ?>" alt="title" id="title-image" style="<?php if(isset($titleCSS)) echo $titleCSS; ?>" />
 			
  			<?php
  				if($loggedin){
	 				echo "<!-- HEADER FOR PRODUCT MFG and SELECTOR -->\n";
	  				echo $this->element('selector_noschool',array());
  				}
			?>
			
			</td>
			<td class="right"></td>
		</tr>
	</table>
	</div><!-- End bodyHeader -->
	
	
	
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark"  class="<?php echo $classWidth; ?>">
	<table id="tableContainer"  width="100%">
		<tr>
			<td class="top left"></td>
			<td class="top edge"></td>
			<td class="top right"></td>
		</tr>
		<tr>
			<td class="left edge"></td>
			<td class="bg-main"><?php echo $content_for_layout; ?></td>
			<td class="right edge"></td>
		</tr>
		<tr>
			<td class="bottom left"></td>
			<td class="bottom edge"></td>
			<td class="bottom right"></td>
		</tr>
	</table>
	
	</div>
	
	
</div>

<?php
	if($loggedin){ 
		echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$myuser['User']['sex'],'link'=>'/shop/main/'));
	}
?>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>


<script type="text/javascript">

//search for schools
<?php if($loggedin) echo $this->element('prompts/search_school',array('DOMtarget'=>'#search')); ?>

//show cart
<?php if($loggedin) echo $this->element('prompts/cart'); ?>

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>

//page specific scripts
<?php 
	if(file_exists(ELEMENTS . 'js' . DS . $this->params['controller'] . '.ctp')) 
		echo $this->element('js/'.$this->params['controller'],compact('scriptData','protocal','loggedin')); 
?>
</script>
</html>