<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('dynamic.css');

		echo $scripts_for_layout;

	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>

<img id="background" src="/img/schools/background/ohiostate_brutusrun.jpg" alt="ohiostatebackground" />

<div id="wrapper"> 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('myuser'=>$myuser)); ?>
  </div>
  
	<div id="bodyHeader"><!-- Begin bodyHeader -->
	<table>
		<tr>
			<td class="left"></td>
			<td class="bg-main">
				<img src="<?php echo $title; ?>" alt="title" id="title-image" />
			</td>
			<td class="right"></td>
		</tr>
	</table>
	</div><!-- End bodyHeader -->
	
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark">
	<table id="tableContainer">
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

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>


<script type="text/javascript">

//bind to form
$(document).ready(function(){
	var schoolid = $('#school-list').val();
	$('#btnselect').click(function(){
		$.getJSON('/users/add_school/'+schoolid,function(data){
			if(data.result){ 
				document.location.href = '/shop/main/'+schoolid+'/<?php echo $myuser['User']['sex']; ?>';
			} else {

			}
		});
	});
});

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>

</script>
</html>