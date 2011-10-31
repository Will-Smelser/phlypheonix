<!-- HEADER FOR PRODUCT MFG and SELECTOR -->
	<div id="bodyHeader" style="top:45px" class="<?php echo $classWidth; ?>"><!-- Begin bodyHeader -->
	<table width="100%">
		<tr>
			<td class="left"></td>
			<td class="bg-main">
			
			<div style="position:absolute;top:15px;left:50px;right:50px;text-align:center;">
	 	  		<img src="/img/header/accessories.png" alt="Accessories" />
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
					$counter++; 
					
					//image url
					$image = '/users/getimage?width=280&image='.urlencode($s['Pimage']['image']);
					
					//some style for layout
					$style = ($counter%$columns == 0 || $counter == count($sale)) ? ' pad-right' : '';
					if($counter == ($columns+1)) $style2 = ' pad-top';
					if($prev['Sale']['id'] != $s['Sale']['id']){
						$saleNum++;
						$style3 = ' sale'.$saleNum;
					}
					
					//calculate time remaining in the sale
					if($prev['Sale']['id'] != $s['Sale']['id'] || $counter == 1){
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
						
						//debug($this->Time);
						$mytime = $time->relativeTime($stime);
						//debug($tdata);exit;
						//$time = "{$tdata['days']} day(s) {$tdata['hours']} hours {$tdata['minutes']} mins.";
						
						if($counter != 1) echo "<div style='clear:both;'></div></div><div style='height:10px;'></div>";
						echo "<div class='$style3'>
							<div class='big title sale info'>{$s['Sale']['name']}</div>
							<div class='big title sale expire'><span class='text'>Expires in </span>{$mytime}</div>
							<div style='clear:both'></div>
							";
					}
					
					//previous
					$prev = $sale[$key];
				?>
				
				<div class="preview-wrapper <?php echo $style.$style2.$style3; ?>">
					<a class="preview-link" href="/shop/viewer/<?php echo $s['Product']['id'].'/'.$s['Sale']['id']; ?>">
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
				
				<?php } ?>
				<!-- Have to closeout the sale wrapper -->
				<div style='clear:both;'></div></div>
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
	
	