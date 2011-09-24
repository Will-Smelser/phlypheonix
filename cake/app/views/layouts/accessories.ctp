<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('accessories.css');

		echo $scripts_for_layout;

	?>
	
	<!-- Google //-->
	<script src="https://www.google.com/jsapi?key=ABQIAAAAJlXI2Bwm7HpvuBgtX-0aFRS_grDaFF6eWWjqmO0l-XDntG-CnxSdbe1KeTrfkdPgIp2MP99cn4oF_Q" type="text/javascript"></script>
	
	<!-- JQuery //-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<body>

<img id="background" src="<?php echo $school['School']['background']; ?>" />

<div id="wrapper"> 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('school'=>$school,'myuser'=>$myuser)); ?>
  </div>
  
	<?php //echo $this->Session->flash(); ?>

<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
<div id="bodyHeader">

   <img id="savemoney" src="/img/upsell/flyfoenix_upsell_savemoney.png" width="161" height="33" alt="savemoney" />
   <img id="additem" src="/img/upsell/flyfoenix_upsell_additem.png" width="335" height="56" alt="additem" />
   <img id="freeshipping" src="/img/upsell/flyfoenix_upsell_freeshipping.png" width="219" height="35" alt="freeshipping" />

	<?php
		$gender = (strtolower($sex) == 'f') ? 'female' : 'male';
		$gopsite= (strtolower($sex) == 'f') ? 'M' : 'F';
		$glink = "/accessories/index/{$school['School']['id']}/$gopsite"; 
			
		echo $this->element('selector',
				array(
					'glink'=>$glink,
					'gender'=>$gender,
					'myuser'=>$myuser,
					'school'=>$school['School'],
					'schoolName'=>$school['School']['long'],
					'schoolLogo'=>$school['School']['logo_small']
				)
		); 
	?>

</div><!-- End Body Header -->
	
	
	<div id="bodyContainerDark">
		<a href="#"><img id="gift" src="/img/upsell/flyfoenix_upsell_needgift.png" width="389" height="51" alt="gift" /></a>
		<img id="earn5" src="/img/productpresentation/flyfoenix_product_presentation_earn5.png" width="214" height="33" alt="earn5" />

		<div id="sharethis">
			<span  class='st_twitter_large' ></span>
			<span  class='st_facebook_large' ></span>
			<span  class='st_yahoo_large' ></span>
			<span  class='st_gbuzz_large' ></span>
			<span  class='st_email_large' ></span>
			<span  class='st_sharethis_large' ></span>
		</div>

		<!-- NAVIGATION ARROWS -->
		<a href="/shop/main/<?php echo $school['School']['id'].'/'.$sex; ?>"><div id="leftarrow"></div></a>
		<a href="/checkout/index"><div id="rightarrow"></div></a>

		<div id="forcentering"> <!-- Begin Wrapper Used to Center dwrapper over light gray background -->
		<div id="dwrapper"><!-- Begin Dynamicly Sized Wrapper -->
		
		<?php echo $content_for_layout; ?>
		
		</div>
		</div>
</div>
<?php 
//some vars are set by the index file
/*
//get first color
reset($colors);
reset($swatches);
$firstColor = current($colors);
$colorId = $firstColor[0]['Color']['id'];
*/
	if(count($colors) > 0){
		echo $this->element('swatches_wrapper',array('school'=>$school,'sex'=>$sex,'swatches'=>$swatches,'colors'=>$colors,'images'=>$images));
		echo $this->element('accessories_wrapper',array('pdetails'=>$pdetails,'products'=>$colors,'images'=>$images)); 
	}
?>

<?php echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$sex,'link'=>'/accessories/index/')); ?>

</body>


<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>


<script type="text/javascript">

//swatches
window.swatches = <?php echo json_encode($swatches); ?>;
window.products = <?php echo json_encode($colors); ?>;
window.pdetails = <?php echo json_encode($pdetails); ?>;

//show the tooltip for products
<?php if(count($colors)>0) echo $this->element('prompts/accessories_product'); ?>

//search for schools
<?php echo $this->element('prompts/search_school',array('DOMtarget'=>'#search')); ?>

//heart toggle...add school to favorites
<?php echo $this->element('js/heart_toggle',array('school_id'=>$school['School']['id'])); ?>

//show cart
<?php echo $this->element('prompts/cart'); ?>



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