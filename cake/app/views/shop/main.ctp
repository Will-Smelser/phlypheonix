

<a href="#"><img id="comments" src="/img/productpresentation/flyfoenix_product_presentation_comments.png" width="171" height="57" alt="comments" /></a>
  
  
  <img id="buytwo" style="position:absolute;top:1px;right:1px;" 
  	src="/img/productpresentation/flyfoenix_product_presentation_buy2.png" width="121" height="121" alt="buyTwo" />
 
  <!-- NAVIGATION ARROWS -->
  <a href="#"><div id="leftarrow" class="hidden"></div></a>
  
  <?php $class = (count($productRight) > 0) ? '' : 'hidden'; ?>
  <a href="#"><div id="rightarrow" class="<?php echo $class; ?>"></div></a>
  
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
    
    <?php echo $this->element('sharthis'); ?>
    
    <?php echo $this->element('product/details',array('product'=>$product,'index'=>$imageIndex))?>
    
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