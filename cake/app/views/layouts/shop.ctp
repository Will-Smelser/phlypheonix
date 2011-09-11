<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('reset.css');
		echo $this->Html->css('productpresentation.css');

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
	<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
	<?php echo $this->element('layouts/shop_top_banner',array('sale'=>$sale,'product'=>$product,'school'=>$school,'myuser'=>$myuser)); ?>
	
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark">
	
	<?php echo $content_for_layout; ?>
	
	<div id="accessories-wrapper" style="position:absolute;bottom:35px;right:25px;width:930px;height:30px;overflow:hidden">
	
	<div style="text-align:right;">
		<a href="#" id="accessories-link" class="up">
			<img src="/img/productpresentation/accessories_<?php echo (strtolower($sex)=='f') ? 'female' : 'male'; ?>.png" />
		</a>
	</div>
	
	
	<?php echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$sex,'link'=>'/shop/main/')); ?>

	<?php 
	
	$btn = 'buynow_';
	$i=0;
	
	if(count($colors) > 0){
	
		//get first color
		reset($colors);
		reset($swatches);
		$firstColor = current($colors);
		$colorId = $firstColor[0]['Color']['id'];
		
		$firstSwatch = $swatches[$colorId][0];
		
		foreach($firstColor as $entry){
			if(!preg_match('/swatch/i',$entry['Product']['name'])){
				$pid = $entry['Product']['id'];
				echo $this->element('product/accessories_product',
					array(
						'name'=>$entry['Product']['name'],
						'image'=>$images[$pid][0]['image'],
						'price'=>'Sale&nbsp;$'.$entry['Product']['price_buynow'],
						'DOMbtnId'=>$btn . $i,
						'btnText'=>'View Product',
						'productClass'=>'acc_image',
						'productId'=>$entry['Product']['id'],
						'colorId'=>$colorId,
						'sex'=>$sex
					)
				);
				$i++;
			}
		}
		
		echo $this->element('swatches_wrapper',array('school'=>array('School'=>$school),'sex'=>$sex,'swatches'=>$swatches,'colors'=>$colors,'images'=>$images));
		echo $this->element('accessories_wrapper');
	} else{
		//just gotta put the swatches wrapper
		echo '<div id="swatches-wrapper" style="display:none;"></div>';
		
		//no accessories
		echo '<div id="tooltip-product">';
		echo '<h2>No Accessories available.</h2>';
		echo '</div>';
	}
	
	?>
	

	<?php  ?>
</div>
	
	
	
	
	</div> <!-- End Slider Wrapper -->
	
</div>




<!-- FB comments -->
<div id="fb-comments" style="overflow:auto;height:350px;"><?php echo $this->Hfacebook->comments($fbcommentId,440,array()); ?></div>
<div id="fb-root"></div>
</body>

<script type="text/javascript" src="/js/jquery.miozoom.js"></script>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>


<script type="text/javascript">


var schoolId = <?php echo $school['id']; ?>;
var sex = '<?php echo $sex; ?>';

//product viewer
$(document).ready(function(){
	//swatches
	window.swatches = <?php echo json_encode($swatches); ?>;
	window.products = <?php echo json_encode($colors); ?>;
	window.pdetails = <?php echo json_encode($pdetails); ?>;

	//show the tooltip for products
	<?php if(count($colors) > 0) echo $this->element('prompts/accessories_product'); ?>

	<?php echo $this->element('prompts/accessories_for_shop'); ?>

	
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

//show cart
<?php echo $this->element('prompts/cart'); ?>


$(document).ready(function(){
	<!-- FACEBOOK //-->
	$.getScript("<?php echo $protocal; ?>://connect.facebook.net/en_US/all.js",function(){
		<?php 
				
				echo $this->Hfacebook->initSimple(
						Configure::read('facebook.apiId'),
						'function(){var $comments=$("#comments");$comments.qtip("api").elements.content.html("");$("#fb-comments").appendTo($comments.qtip("api").elements.content);}'
				); 
				
				?> 
	});
});

//fb comments
<?php echo $this->element('prompts/comments'); ?>

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