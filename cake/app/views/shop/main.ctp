
<div id="comment-wrap" style="display:none;position:absolute;">
<a href="#" id="comment-wrapper"><img id="comments" src="/img/header/comments.png" alt="comments" /></a>
</div>

<div id="fb-like-wrap" style="display:none;position:absolute;left:285px;top:25px;z-index:10;">
<?php echo $this->Hfacebook->likeButtonHTML5('https://www.facebook.com/pages/FlyFoenixcom/228147000574828'); ?>
</div>

<script type="text/javascript">
<!--
$('#comment-wrap').show();
$('#fb-like-wrap').show();
//-->
</script>

 
  <!-- NAVIGATION ARROWS -->
  <?php if($prevLink != '#'){ ?>
  <noscript><a href="<?php echo $prevLink; ?>"><div id="leftarrow2" ></div></a></noscript>
  <?php } ?>
  <div id="leftLink" style="display:none;">
  	<a href="#" style=""><div id="leftarrow" class="hidden"></div></a>
  </div>
  
  <noscript><a href="<?php echo $nextLink; ?>"><div id="rightarrow2" ></div></a></noscript>
  
  <?php $class = (count($productRight) > 0) ? '' : 'hidden'; ?>
  <div id="rightLink" style="display:none;">
  	<a href="#"><div id="rightarrow" class="<?php echo $class; ?>"></div></a>
  </div>
  
  <script type="text/javascript">$('#leftLink').show();$('#rightLink').show();</script>
  
  <!-- SLIDER WRAPPER -->
  <div id="sliderwrapper"><!-- Begin Slider Wrapper -->
  <div id="sliderpane">
  <div class="slider" style="left:0px;"><!-- Begin Slider -->
    
    <div class="viewer">
  	<?php echo $this->element('product/features'); ?>
    
    <?php echo $this->element('product/main_photo',array('index'=>$imageIndex,'product'=>$product)); ?>
    
    <?php echo $this->element('product/thumbs',array('index'=>$imageIndex)); ?>
    
    </div><!-- End Viewer Container -->
  
  <div id="content">
    <div id="earn5">
      <img src="/img/productpresentation/flyfoenix_product_presentation_earn5.png" width="214" height="33" alt="earn5" />
    </div>
    
    <noscript>
    	<span>Copy this Link</span><br/>
    	<input style="width:251px" type="text" value="http://www.flyfoenix.com/users/referer/<?php echo $myuser['User']['id']; ?>/<?php echo $product['Product']['id']?>" />
    </noscript>
    <div style="display:none" id="sharethis-wrap">
    <?php echo $this->element('sharthis'); ?>
    </div>
    <script type="text/javascript">$('#sharethis-wrap').show();</script>
    
    <img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="261" height="2" style="margin:3px 0px;">
    
    <?php echo $this->element('product/details',array('product'=>$product,'index'=>$imageIndex,'currentLink'=>$currentLink))?>
    
  </div>
</div> <!-- End Slider -->

<?php
  	$i = 1;
  	foreach($productRight as $p){ 
  		//calulate the position
  		$x = 935 * $i;
  		$i++;
  		$url = "/shop/product/{$p['school_id']}/{$p['sex']}/{$sale['Sale']['id']}/{$p['id']}";
  	?>
  	<div id="<?php echo $url ?>" class="slider product-loading" style="left:<?php echo $x; ?>px">
  	
  	</div>
  	<?php } ?>
</div>
</div>