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

<img id="background" src="/img/ohiostate/ohiostate_brutusrun.jpg" alt="ohiostatebackground" />

<div id="wrapper"> 
  <div id="mainHeader">
    <img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="flyfoenixlogo" />
    <span id="caption" class="four">Unique Collegiate Fashion.&nbsp;&nbsp;Quick Shopping.&nbsp;&nbsp;Great Fit & Feel.&nbsp;&nbsp;High Style.&nbsp;&nbsp;Lower Prices.</span>
    <div id="navigate">
    <span class="five">Welcome &nbsp; <?php echo $myuser['User']['email']; ?></span>
    <span class="five"><a class="nav" href="#">Log Out</a></span>
    <span class="five"><a class="nav" href="#">Contact</a></span>
    <span class="five"><a class="nav" href="#">Account Info</a></span>
    </div>
    
  </div>

<div id="bodyHeader">
  
  <img id="campuscouturelogo" src="/img/logos/logo_campuscoutureblack.png" width="166" height="56" alt="campuscouturelogo" />
  <img id="buynowtag" class="qtip" src="/img/flyfoenix_buynowtag.png" width="313" height="156" alt="buynowtag" />
  <span id="counter" class="one">2d 12h 36m</span>
  
  
  <div id="selector">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="#"><img class="qtip" id="gender" src="/img/productpresentation/flyfoenix_product_presentation_male.png" width="52" height="19" alt="gender" /></a></td>
    <td><img id="logoschool" src="/img/logos/logo_osu.png" width="44" height="56" alt="logoschool" /></td>
    <td>
    	<table width=15px border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><a href="#"><img id="cart" src="/img/productpresentation/flyfoenix_product_presentation_cart.png" width="14" height="13" alt="cart" /></a></td>
            </tr>
            <tr>
              <td><a href="#"><img id="favorite" src="/img/productpresentation/flyfoenix_product_presentation_heart.png" width="14" height="13" alt="favorite" /></a></td>
            </tr>
            <tr>
              <td><a href="#"><img class="qtip" id="search" src="/img/productpresentation/flyfoenix_product_presentation_search.png" width="16" height="15" alt="search" /></a></td>
            </tr>
          </table>
        </td>
  </tr>
</table>
	
  </div>
   
  </div><!-- End Body Header -->
  
<div id="bodyContainerDark">

<?php //echo $this->Session->flash(); ?>

<?php echo $content_for_layout; ?>
			
</div>		
</body>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script type="text/javascript">
var switchTo5x=true;
$(document).ready(function(){
	$.getScript('<?php echo $protocal; ?>://w.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7'});
	});
});

<?php 

	$pdeletes = array();

	//key = prompts id
	//val = the prompt name
	foreach($cprompts as $key=>$p){
		$data = (isset($cpdata[$key])) ? $cpdata[$key] : array();
		//run the prompt
		echo $this->element('prompts/'.$p,
			array(
				'id'=>$key,
				'data'=>$data
			)
		);
		
		//delete the prompt
		array_push($pdeletes,"\n\t$.post('/prompts/deleteUserPrompt/$key');\n");
	}
?>
//delete prompts
$(document).ready(function(){

	<?php foreach($pdeletes as $str) {echo $str; }?>
	
});
</script>
</html>