<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
<?php echo $this->element('layouts/shop_top_banner',array('sale'=>$sale,'product'=>$product,'school'=>$school,'myuser'=>$myuser)); ?>

<!-- MAIN PRODUCT VIEWER -->
<div id="bodyContainerDark">

<a href="#"><img id="comments" src="/img/productpresentation/flyfoenix_product_presentation_comments.png" width="171" height="57" alt="comments" /></a>
  
  
  <img id="buytwo" src="/img/productpresentation/flyfoenix_product_presentation_buy2.png" width="121" height="121" alt="buyTwo" />
 
  <!-- NAVIGATION ARROWS -->
  <div id="leftarrow">
    <a href="" onMouseOver="document.lbutton.src='/img/productpresentation/flyfoenix_product_presentation_elements_lbuttonorange.png';" onMouseOut="document.lbutton.src='/img/productpresentation/flyfoenix_product_presentation_elements_lbutton.png';"><img name="lbutton" src="/img/productpresentation/flyfoenix_product_presentation_elements_lbutton.png" width="37" height="52" alt="leftarrow" /> </a>
    </div>
    
  <div id="rightarrow">
    <a href="" onMouseOver="document.rbutton.src='/img/productpresentation/flyfoenix_product_presentation_elements_rbuttonorange.png';" onMouseOut="document.rbutton.src='/img/productpresentation/flyfoenix_product_presentation_rbutton.png';"><img name="rbutton" src="/img/productpresentation/flyfoenix_product_presentation_rbutton.png" width="36" height="50" alt="rightarrow" /></a>
  </div>
  
  <!-- SLIDER WRAPPER -->
  <div id="sliderwrapper"><!-- Begin Slider Wrapper -->
  
  
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
</div> <!-- End Slider Wrapper -->