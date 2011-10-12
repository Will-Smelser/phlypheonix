<?php 
if(isset($swatch['Pimage'][0])){
ob_start();
echo '<div id="accessories-wrapper">';
//show swatch
echo "\n<div style='float:left'>\n\n";
echo $this->element('product/accessories_swatch',
	array(
		'name'=>'Current Pattern',
		'image'=>$swatch['Pimage'][0]['image'],
		'price'=>'Swatches',
		'DOMbtnId'=>'swatch_btn',
		'btnText'=>'View Another Color',
		'productClass'=>'swatch_image',
		'productId'=>$swatch['Product']['id'],
		'colorId'=>$swatch['Color'][0]['id'],
		'sex'=>$swatch['Product']['sex'],
		'swatches'=>$swatches,
		'schoolId'=>$schoolId,
		'ajax'=>true
	)
);
echo "\n</div>\n\n";


//show accessories
$i=0;
foreach($data as $entry){
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
				'pdetail'=>$entry['Pdetail'],
				
			)
		);
		echo "\n</div>\n\n";
	}
	$i++;
}
echo '</div>';

$content = ob_get_contents();
ob_end_clean();

} else {
	$content = "<div style='height:400px'><div class='title'>No Products</div><p>
		There are no accessories available for this sale for the current gender.  Try another school or toggle the gender.<br/><br/>
		<a style='z-index:100;display:block;position:relative;' href='/checkout/index'> <input class='btn' type='button' value='Checkout' /></a>
	</p>";
}
?>

	<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
	<div id="bodyHeader" class="<?php echo $classWidth; ?>"><!-- Begin bodyHeader -->
	<table width="100%">
		<tr>
			<td class="left"></td>
			<td class="bg-main">
			
	 	  	<img id="additem" src="/img/header/accessories.png" alt="Accessories" />
	   		
 			
  			<?php
  				if($loggedin){
	 				echo "<!-- HEADER FOR PRODUCT MFG and SELECTOR -->\n";
	  				//echo $this->element('selector_noschool',array());
	  				$gsex = (strtolower($sex) == 'f') ? 'M' : 'F';
	  				$sexlong = ($gsex=='M') ? 'female' : 'male';
	  				$glink = '/accessories/index/'.$schoolId.'/'.$gsex.'/'.$colorId;
	  				
	  				echo $this->element('selector',array('glink'=>$glink,'gender'=>$sexlong,'myuser'=>$myuser,'school'=>$school['School'],'schoolName'=>$school['School']['long'],'schoolLogo'=>$school['School']['logo_small']));
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
			<td class="bg-main">
				<div style="height:20px;">
					<img src="/img/upsell/flyfoenix_upsell_needgift.png" style="position:absolute;top:10px;left:40px;" />
					<div id="sharethis-wrap" style="display:none;position:absolute;top:20px;left:420px">
					
						<img src="/img/productpresentation/flyfoenix_product_presentation_earn5.png" />
					      <span  class='st_twitter_large' ></span>
					      <span  class='st_facebook_large' ></span>
					      <span  class='st_yahoo_large' ></span>
					      <span  class='st_gbuzz_large' ></span>
					      <span  class='st_email_large' ></span>
					      <span  class='st_sharethis_large' ></span>    
    				</div>
    				<script language="javascript">$('#sharethis-wrap').show();</script>
    				
				</div>
				<div style="width:850px;margin-left:auto;margin-right:auto">
				<?php
				$flash = $this->Session->flash();
				if(strlen($flash) > 0){
				?>
				
					<div>
						<div id="error-console" class="border-rad-med error" >
							<span class='ename'>Message</span>
							<span class='emsg'><?php  echo $flash; ?></span>
						</div>
					</div>
				
				<?php } ?>
				
				<!-- Accessories Popup -->
				<div id="qtip-general-container" style="position:relative;top:200px;left:0px;"></div>
	
				<?php echo $this->element('layouts/lightbg_top'); ?>
				
				<?php echo $content; ?>
				<?php echo $this->element('layouts/lightbg_bottom'); ?>
				</div>
				
				<!-- NAVIGATION ARROWS -->
				<a href="/shop/main/<?php echo $school['School']['id'].'/'.$sex; ?>"><div id="leftarrow"></div></a>
				<a href="/checkout/index"><div id="rightarrow"></div></a>
		
				<div id="forcentering"> <!-- Begin Wrapper Used to Center dwrapper over light gray background -->
				<div id="dwrapper"><!-- Begin Dynamicly Sized Wrapper -->
			</td>
			<td class="right edge"></td>
		</tr>
		<tr>
			<td class="bottom left"></td>
			<td class="bottom edge"></td>
			<td class="bottom right"></td>
		</tr>
	</table>
	
	</div>
	
