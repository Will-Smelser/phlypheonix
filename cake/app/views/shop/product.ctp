<div id="slider"><!-- Begin Slider -->
    
    <div id="viewer">
  	<?php echo $this->element('product/features'); ?>
    
    <?php echo $this->element('product/main_photo',array('index'=>$imageIndex)); ?>
    
    <?php echo $this->element('product/thumbs',array('index'=>$imageIndex)); ?>
    
    </div><!-- End Viewer Container -->
  
  
  <div id="content">
    <div id="earn5">
      <img src="/img/productpresentation/flyfoenix_product_presentation_earn5.png" width="214" height="33" alt="earn5" />
    </div>
    
    <?php echo $this->element('sharthis'); ?>
    
    <?php echo $this->element('product/details',array('product'=>$product,'index'=>$imageIndex))?>
    
  </div>
</div>
</div> <!-- End Slider -->