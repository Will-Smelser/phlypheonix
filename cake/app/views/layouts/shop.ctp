<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
	<!-- Facebook Share Information -->
	<?php echo $this->Hfacebook->shareMeta($shareImage); ?>
	
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
	
	<!-- The Viewer //-->
	<script src="/js/viewer.js" type="text/javascript"></script>
	
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

<div id="wrapper"> 
  <div id="mainHeader">
  	<?php echo $this->element('layouts/header',array('school'=>$school,'myuser'=>$myuser)); ?>
  </div>
  
	<?php //echo $this->Session->flash(); ?>
	<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
	<?php echo $this->element('layouts/shop_top_banner',array('sale'=>$sale,'product'=>$product,'school'=>$school,'myuser'=>$myuser)); ?>
	
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark">
	
	<?php  $flash = $this->Session->flash(); ?>
	<?php if(strlen($flash) > 0){ ?>
	<noscript>
		<div style="position:absolute;top:2px;left:45px;">
			<div id="error-console" class="border-rad-med error" style="width:558px;">
				<span class='ename'>Message</span>
				<span class='emsg'><?php  echo $flash; ?></span>
			</div>
		</div>
	</noscript>
	<?php } ?>
	
	<?php echo $content_for_layout; ?>
	
	<div id="accessories-wrapper" style="position:absolute;bottom:35px;right:25px;width:930px;height:30px;overflow:hidden">
	
	<!-- Accessories Popup -->
	<div id="qtip-general-container" style="position:relative;top:200px;left:0px;"></div>

	<div style="height:35px;">
	<noscript><div style="display:none"></noscript>
		<div style="text-align:right;">
			<a href="#" id="accessories-link" class="up">
				<img src="/img/productpresentation/accessories_<?php echo (strtolower($sex)=='f') ? 'female' : 'male'; ?>.png" />
			</a>
		</div>
	<noscript></div></noscript>
	</div>
	
	<?php echo $this->element('slist_with_favs',array('schools'=>$schools,'userSchools'=>$myuser['School'],'sex'=>$sex,'link'=>'/shop/main/')); ?>

	<?php 
	if(!empty($adata) && isset($adata['swatch']['Pimage'][0])){
		//show swatch
		echo "\n<div style='float:left'>\n\n";
		echo $this->element('product/accessories_swatch',
			array(
				'name'=>'Current Pattern',
				'image'=>$adata['swatch']['Pimage'][0]['image'],
				'price'=>'Swatches',
				'DOMbtnId'=>'swatch_btn',
				'btnText'=>'View Another Color',
				'productClass'=>'swatch_image',
				'productId'=>$adata['swatch']['Product']['id'],
				'colorId'=>$adata['swatch']['Color'][0]['id'],
				'sex'=>$adata['swatch']['Product']['sex'],
				'swatches'=>$adata['swatches'],
				'schoolId'=>$school['id'],
				'ajax'=>true,
			)
		);
		echo "\n</div>\n\n";
		
		//show accessories
		$i=0;
		foreach($adata['products'] as $entry){
			if(!preg_match('/swatch/i',$entry['Product']['name'])){
				echo "\n<div class='acc_prod_wrapper'>\n";
				echo $this->element('product/accessories_product',
					array(
						'name'=>$entry['Product']['name'],
						'image'=>$entry['Pimage'][0]['image'],
						'price'=>'Sale&nbsp;$'.$entry['Product']['price_buynow'],
						'DOMbtnId'=>'btn_'.$i,
						'btnText'=>'Add Item',
						'productClass'=>'acc_image',
						'productId'=>$entry['Product']['id'],
						'colorId'=>$entry['Color'][0]['id'],
						'sex'=>$entry['Product']['sex'],
						'pdetail'=>$entry['Pdetail']
					)
				);
				echo "\n</div>\n";
			}
			$i++;
		}
	} else{
		
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

<!-- Accessories Popup -->
<div id="qtip-general-container"></div>



<!-- FB comments -->
<div id="fb-comments" style="overflow:auto;height:350px;"><?php echo $this->Hfacebook->comments($fbcommentId,440,array()); ?></div>
<div id="fb-root"></div>


<div id="background-wrapper">
	<?php if(strtolower($sex) == 'f') { ?>
	<img id="background" src="/img/schools/background/default.jpg" alt="NCAA clothes School Background" style="width:100%" />
	<?php }else{ ?>
	<img id="background" src="<?php echo $school['background']; ?>" alt="NCAA clothes School Background" style="width:100%" />
	<?php } ?>
</div>


<!-- SIZE CHART -->
<div style="display:none;overflow:auto;height:500px;" id="size-chart">
<?php echo $this->element('sizechart'); ?>
</div>

<?php echo $this->element('layouts/social'); ?>
</body>

<script type="text/javascript" src="/js/jquery.miozoom.js"></script>

<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.js"></script>


<script type="text/javascript">


var schoolId = <?php echo $school['id']; ?>;
var sex = '<?php echo $sex; ?>';
var color = "<?php echo isset($schoolColors[0]['schools_colors']['color_id']) ? $schoolColors[0]['schools_colors']['color_id'] : ''; ?>";

//product viewer
$(document).ready(function(){

	<?php echo $this->element('prompts/accessories_for_shop'); ?>
	
	<?php echo $this->element('prompts/accessory'); ?>

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

//products
window.products = <?php echo json_encode($products); ?>;

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
	$.getScript('<?php echo $protocal; ?>://w<?php if($protocal == 'https') echo 's'; ?>.sharethis.com/button/buttons.js',function(){
		stLight.options({publisher:'4db8f048-2ddb-45c3-87c8-40b6077626c7',
    		st_url:'http%3A%2F%2Fflyfoenix.com%2Fusers%2Freferred%2F8'
		});
	});
});

//prompts
<?php echo $this->element('layouts/prompts',array('cprompts'=>$cprompts,'cpdata'=>$cpdata)); ?>

//size chart
<?php echo $this->element('prompts/sizechart')?>

//prompt for flash message
<?php if(strlen($flash) > 0) echo $this->element('prompts/flash'); ?>

</script>
</html>