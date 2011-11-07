<?php 
//the product to show's unique id
$pLinkId = '';
?>
<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
	<div id="bodyHeader" style="top:45px" class="<?php echo $classWidth; ?>"><!-- Begin bodyHeader -->
	<table width="100%">
		<tr>
			<td class="left"></td>
			<td class="bg-main">
			<a href='/pages/shipping' class='return-link big title sale easyreturns'>
					<div class='sale easyreturns'>
						<img src='/img/header/easyreturns.png' align='left' />
					</div>
					<div class='sale easyreturns' style='padding:10px'>Easy Returns</div>
				</a>
			<div style="position:absolute;top:15px;left:50px;right:50px;text-align:center;">
	 	  		<!-- <img src="/img/header/onsalenow.png" alt="Accessories" /> -->
	 	  	</div>
	   		
 			
  			<?php
  				//if($loggedin){
	 				echo "<!-- HEADER FOR PRODUCT MFG and SELECTOR -->\n";
	  				//echo $this->element('selector_noschool',array());
	  				$gsex = (strtolower($sex) == 'f') ? 'M' : 'F';
	  				$sexlong = ($gsex=='M') ? 'female' : 'male';
	  				$glink = '/shop/main/'.$school['id'].'/'.$gsex;
	  				
	  				echo $this->element('selector',
	  					array('glink'=>$glink,'gender'=>$sexlong,'myuser'=>$myuser,
	  						'school'=>$school,'schoolName'=>$school['long'],
	  						'schoolLogo'=>$school['logo_small']));
  				//}
			?>
			
			</td>
			<td class="right"></td>
		</tr>
	</table>
	</div><!-- End bodyHeader -->
	
	
	
	<!-- MAIN PRODUCT VIEWER -->
	<div id="bodyContainerDark" style="top:35px"  class="<?php echo $classWidth; ?>">
	<table id="tableContainer"  width="100%">
		<tr>
			<td class="top left"></td>
			<td class="top edge"></td>
			<td class="top right"></td>
		</tr>
		<tr>
			<td class="left edge"></td>
			<td class="bg-main" style="padding-left:10px;padding-right:10px">
				
							
				<?php
				$style2= '';
				$style3 = ' sale1';
				$columns = 3;
				$counter = 0;
				$saleNum = 1;
				$prev = current($sale);
				
				foreach($sale as $key=>$s){
				//if(!preg_match('/boot/i',$s['Product']['style'])){
					$counter++; 
					
					//image url
					$image = '/users/getimage?width=280&image='.urlencode($s['Pimage']['image']);
					
					//some style for layout
					$style = '';//($counter%$columns == 0 || $counter == count($sale)) ? ' pad-right' : '';
					if($counter == ($columns+1)) $style2 = ' pad-top';
					if($prev['Sale']['id'] != $s['Sale']['id']){
						$saleNum++;
						$style3 = ' sale'.$saleNum;
					}
					
					//calculate time remaining in the sale
					if($prev['Sale']['id'] != $s['Sale']['id'] || $counter == 1){
						if(Configure::read('config.sales.on')){
							$stime = time() + Configure::read('config.sales.length');
							
							if($loggedin){
								foreach($myuser['Saleuser'] as $su){
									if($su['id'] == $s['Sale']['id'] &&
										$su['created'] != 0
									){
										$stime = $su['created'] + Configure::read('config.sales.length');
										break;
									}
								}
							}
						
					    	$mytime = $time->relativeTime($stime);
						}
						
						if($counter != 1) echo "<div style='clear:both;'></div></div><div style='height:10px;'></div>";
						//title
						echo "<div class='$style3'>
							<div class='big title sale info'>
								{$s['Sale']['name']}
							</div>
							<div style='float:left;display:none;padding:10px 0px 0px 0px;max-width:135px' id='fb-like-wrap-{$key}'>\n";
						
						//facebook like
						echo $this->Hfacebook->likeButtonHTML5('http://'.$_SERVER['HTTP_HOST'].'/'.$this->params['url']['url']);
						
						?>
						</div><!-- End facebook wrapper -->
						
						<div id="sharing" class="wrap-title big title" style="padding:0px;float:right;">
							<noscript>
						    	<span>Copy this Link</span><br/>
						    	<input style="width:251px" type="text" value="http://www.flyfoenix.com/users/referer/<?php echo $myuser['User']['id']; ?>" />
						    </noscript>
						    <div style="display:none;" id="sharethis-wrap">
						    	<?php 
						    		$st_url = "http://www.flyfoenix.com/users/referred/{$myuser['User']['id']}/$product";
									$st_img = "http://www.flyfoenix.com{$shareImage}";
						    	?>
						    	<div class="sharethis" style="padding-top:5px;">
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_twitter_large' ></span>
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_facebook_large' ></span>
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_yahoo_large' ></span>
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_gbuzz_large' ></span>
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_email_large' ></span>
							      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_sharethis_large' ></span>
							    </div>
						    </div>
						    <script type="text/javascript">$('#sharethis-wrap').show();</script>
						</div>
						
						<?php
						
						
						//echo "</div>";
						
						//the expire time
						if(Configure::read('config.sales.on')){
							echo "
								<div class='big title sale expire'><span class='text'>Expires in </span>{$mytime}</div>
								";
						}
						
						echo "<div style='clear:both'></div>";
					
				?>
					<!-- Show the facebook like -->
					<script language="javascript" >$('#fb-like-wrap-<?php echo $key; ?>').show().css('float','left');</script>
					
				<?php
					}
						
					//previous
					$prev = $sale[$key];
					
					//if this was the product given in link
					if($s['Product']['id'] == $product) $pLinkId = ' id="show-'.$product.'" ';
				?>
				
				<div class="preview-wrapper <?php echo $style.$style2.$style3; ?>">
					<a <?php echo $pLinkId; ?> class="preview-link" href="/shop/viewer/<?php echo $s['Product']['id'].'/'.$s['Sale']['id']; ?>">
					<div class="image-wrapper"><img src="<?php echo $image; ?>" /></div>
					<div class="info">
						<div class="price-wrapper" >
							<div class="member">$<?php echo $s['Product']['price_member']?></div>
							<div class="retail" >retail $<span style=""><?php echo $s['Product']['price_retail']?></span></div>
						</div>
						<div class="product-about">
							<div class="mfg">
								<?php echo $s['Manufacturer']['name']; ?>
							</div>
							<div class="name">
								<?php echo $s['Product']['name']; ?>
							</div>
						</div>
					</div>
					</a>
				</div>
				
				<?php 
					//}//end if
				}//end of sales 
				?>
				<!-- Have to closeout the sale wrapper -->
				<div style='clear:both;'></div></div>
				<div style='height:10px;'></div>
				<?php 
				//show all boots
				//title
				$saleNum++;
				$style3 = ' sale'.$saleNum;
				echo "<div class='$style3'>
					<div class='big title sale info'>Stadium Stomper Boots</div>
					<div style='float:left;display:none;padding:10px 0px 0px 0px;max-width:135px' id='fb-like-wrap-100'>\n";
				
				//facebook like
				echo $this->Hfacebook->likeButtonHTML5('http://'.$_SERVER['HTTP_HOST'].'/'.$this->params['url']['url']);
				
				echo '</div><div style="clear:both"></div>';
				
				$counter = 0;
				foreach($boots as $b){
					$counter++;
					
					//image url
					$image = '/users/getimage?width=280&image='.urlencode($b['Pimage']['image']);
					
					//some style for layout
					$style = '';//($counter%$columns == 0 || $counter == count($boots)) ? ' pad-right' : '';
					if($counter == ($columns+1)) $style2 = ' pad-top';

					if($counter != 1 && (($counter-1)%$columns == 0)) echo "<div style='clear:both;'></div><div style='height:10px;'></div>";
				?>
				
				<div class="preview-wrapper <?php echo $style.$style2.$style3; ?>">
					<a class="preview-link" href="/shop/viewer/<?php echo $b['Product']['id']; ?>">
					<div class="image-wrapper"><img src="<?php echo $image; ?>" /></div>
					<div class="info">
						<div class="price-wrapper" >
							<div class="member">$<?php echo $b['Product']['price_member']?></div>
							<div class="retail" >retail $<span style=""><?php echo $b['Product']['price_retail']?></span></div>
						</div>
						<div class="product-about">
							<div class="mfg">
								<?php echo $b['Manufacturer']['name']; ?>
							</div>
							<div class="name">
								<?php echo $b['Product']['name']; ?>
							</div>
						</div>
					</div>
					</a>
				</div>
				
				<?php }//end of boots ?>
				
				<!-- Have to closeout the sale wrapper -->
				<div style='clear:both;'></div></div>
				
				<!-- Show the facebook like -->
				<script language="javascript" >$('#fb-like-wrap-100').show().css('float','left');</script>
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
<script language="javascript">
<?php 
//if a product was given, show it
if(!empty($product) && $pLinkId != ''){
?>
/* need to fix the layering of popup
$(document).ready(function(){
	$('#show-<?php echo $product; ?>').click();
});
*/
<?php } ?>
</script>	
	