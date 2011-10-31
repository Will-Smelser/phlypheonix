<?php 
	//make a list of all colors
	$colors = array();
	foreach($product['Pdetail'] as $p){
		$colors[$p['Color']['id']] = $p['Color']['name'];
	}

	
	//find the index for the front image
	$index = 0;
	foreach($product['Pimage'] as $key=>$p){
		if(preg_match('/front/i',$p['name'])){
			$index = $key;
		}
	}

	$tcounter = 0; //the thumb and feature counter
	$columns = 4;
	
	//get the discount
	$discount = floor((1-$product['Product']['price_member'] / $product['Product']['price_retail']) * 100);
?>
<div id="viewer-pop-header" onclick="window.parent.mioPopup.close()" style="cursor:pointer">X</div>
<div id="content">
	<div class="big title wrap-title" id="productname">
		<?php echo $product['Product']['name']; ?> 
	</div>
	
	<div id="sharing" class="wrap-title big title">
	<noscript>
    	<span>Copy this Link</span><br/>
    	<input style="width:251px" type="text" value="http://www.flyfoenix.com/users/referer/<?php echo $myuser['User']['id']; ?>/<?php echo $product['Product']['id']?>" />
    </noscript>
    <div style="display:none;float:right;" id="sharethis-wrap">
    	<?php echo $this->element('sharthis'); ?>
    </div>
    <script type="text/javascript">$('#sharethis-wrap').show();</script>
	
	</div>
	
	<div style="clear:both;"></div>
<div id="left-wrapper">
	
	<div style="height:401px">
		<div class="mainphoto">
		      <img src="<?php echo $product['Pimage'][$index]['image']; ?>" width="351" height="401" />
		      <div class="attribute-detail" style="display:none;" ></div>
		</div><!-- End Main Photo -->
	    
	    
	</div>
	
	<div id="viewer-features">
	    	<?php 
	    	foreach($product['Pattribute'] as $p){ 
	    		$tcounter++;
	    		$style = ($tcounter%$columns != 0) ? ' pad-right' : '';
	    	?> 
	        <div class="feature-wrapper<?php echo $style; ?>">
	        	<a class="feature-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>">
	        	<img src="<?php echo $p['image']; ?>" title="" width="77" height="88" />
	        	</a>
	        	<div class="attribute-info" style="display:none;"><?php echo $p['description'];?></div>
	        </div>
	        <?php } ?>
	</div><!-- End Unique Features -->
	
	<div id="viewer-thumbs" >
	    	<?php 
	    	//this only looks for front images
	    	foreach($product['Pimage'] as $key=>$p){
	    			if(preg_match('/front/i',$p['name'])){
	    				$tcounter++;
	    				$style = ($tcounter%$columns != 0) ? ' pad-right' : '';
	    	?>
	        	<div class="thumb-wrapper<?php echo $style; ?>">
	        	<a target="_blank" class="gallery-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>" target="_blank">
	        		<img  src="<?php echo $p['image']; 	?>" width="77" height="88" />
	        	</a>
	        	</div>
	        		<?php 
	        		unset($product['Pimage'][$key]);
	        		break;
	    			}
	         } ?>
	        <?php
	        //go through again, diregard front images
	        foreach($product['Pimage'] as $p){ 
	        	$tcounter++;
	        	$style = ($tcounter%$columns != 0) ? ' pad-right' : '';
	        	
	        ?>
	        	<div class="thumb-wrapper<?php echo $style; ?>">
	        	<a class="gallery-thumb" href="<?php echo $p['image']; 	?>" rel="<?php echo $p['image']; 	?>" target="_blank">
	        		<img  src="<?php echo $p['image']; 	?>" width="77" height="88" />
	        	</a>
	        	</div>
	        <?php } ?>
	</div><!-- End Thumbnails -->

</div>


<div id="right-wrapper">
	
	<div id="main-info-wrap">
		<form action="/cart/addProductNoAjax" method="post" target="_top" >
		<input type="hidden" name="returnUrl" value="/shop/main/<?php echo $product['School']['id'].'/'.$product['Product']['sex'];?>" />
		<input id="product-id" type="hidden" name="product" value="<?php echo $product['Product']['id']; ?>" />
		<div id="price-wrap">
			<div id="price">$ <?php echo $product['Product']['price_member']; ?></div>
			<div id="discount"><?php echo $discount?> % off retail<br/>
				<span style="text-decoration: line-through;">Retail $ <?php echo $product['Product']['price_retail']; ?></span>
			</div>			
			
			<div style="clear:both;"></div>
		</div>
		
		<div id="size-wrap">
			<div class="title big">Choose Size</div>
			<?php 
				//perform custom sort
				function cmp($a, $b){
					//just shoe sizes or integers
					if(is_numeric($a['Size']['display'])){
						if($a['Size']['display'] == $b['Size']['display']){
							return 0;	
						}
						return (intval($a['Size']['display']) < intval($b['Size']['display'])) ? -1 : 1;
					} else {
						$valA = getSize($a);
						$valB = getSize($b);
						if($valA == $valB) return 0;
						return ($valA < $valB) ? -1 : 1;
					}
					
				}
				//convert sizes to integer
				function getSize($a){
					//essentially create an enumeration
					$key = strtolower($a['Size']['display']);
					$sizes = array(
						's'=>0,'small'=>0,
						'm'=>1,'medium'=>1,
						'l'=>2,'large'=>2,
						'xl'=>3,'x-large'=>3,'xlarge'=>3,'extra large'=>3,'extra-large'=>3,
						'xxl'=>4,'2xl'=>4,'xx-large'=>4,'2x-large'=>4,
						'xxxl'=>5,'3xl'=>5,'xxx-large'=>5,'3x-large'=>5,
					);
					
					return (array_key_exists($key,$sizes)) ? $sizes[$key] : 0;
				}
				
				usort($product['Pdetail'],'cmp');
			
				$sizes = array();
				foreach($product['Pdetail'] as $p){
					if(!in_array($p['Size']['id'],$sizes)){
						echo "<label for='size-{$p['Size']['id']}'><div class='size'>{$p['Size']['display']}</div></label>";
						array_push($sizes,$p['Size']['id']);
					}
				}			
			?>
			<div style="clear:both;"></div>
			<!-- holds user selection for size -->
			<div id="size-radios" style="color:#333;">
				<?php 
				$sizes = array();
				foreach($product['Pdetail'] as $p){
					if(!in_array($p['Size']['id'],$sizes)){
						echo "{$p['Size']['display']}<input id='size-{$p['Size']['id']}' type='radio' name='size' value='{$p['Size']['id']}' />&nbsp;&nbsp;";
					
						array_push($sizes,$p['Size']['id']);
					}
				}
				?>
			</div>
			<script language="javascript">
				$('#size-radios').css({'overflow':'hidden','height':'0'});
			</script>
			<div style="clear:both;"></div>
		</div>
		
		<div>
			<div id="qty-wrap">
				<div class="title big" style="padding-top:0px;">Quantity</div>
				<input id="input-quantity" name="quantity" type="text" value="1" />
			</div>
			
		
		
			<div id="color-wrap" style="padding-left:20px">
			<div class="title big" style="padding-top:0px;">Choose Color</div>
			<?php 
			asort($colors);
			echo $this->element('select',
				array('list'=>$colors,'name'=>'Choose Color','sname'=>'color',
					'DOMid'=>'input-color','hook'=>'changeImage'));
			?>
			</div>

			<div style="clear:both"></div>
		</div>
		<noscript>
			<input style="margin-top:20px" class="big green btn" type="submit" value="Add to Cart" />
		</noscript>
		<div id="submit-btn" style="display:none;">
			<input id="add-to-cart" style="margin-top:20px" class="big green btn" type="button" value="Add to Cart" />
		</div>
		</form>
	</div>
	<div class="big title">Description</div>
	<hr/>
	<p><?php echo $product['Product']['desc']; ?></p>
		
	<div id="image-info-wrap" style="display:none;width:100%">
		<div class="big title">Photo Information</div>
		<hr/>
		<div style="position: relative;">
		<div style="float:left;">
			<div class="title white">Product Info.</div>
			<div><span class="small title">Color </span><span id="p-color">??</span></div>
			<div><span class="small title">Size </span><span id="p-size">??</span></div>
		</div>
		<div style="float:right;">
			<div class="actor-stats">
			<div class="title white">Model Info.</div>
			<table class="">
				<tbody>
					<th>Height</th>
					<th>Weight</th>
					<th>Waist</th>
					<th><?php echo (strtolower($product['Product']['sex']) == 'f') ? 'Bust' : 'Chest'; ?></th>
				</tr>
				<tr>
					<td id="height">N/A</td>
					<td id="weight">N/A</td>
					<td id="waist">N/A</td>
					<td id="bust">N/A</td>
				</tr>
			</tbody></table>
		    </div>
		</div>
		<div style="clear:both;"></div>
		<div id="image-info-loader"></div>
		</div>
	</div>
	
</div>
</div>

<script language="javascript">
$('#submit-btn').show();
$('#image-info-wrap').show();
$('#size-wrap .size').click(function(){$(this).parent().parent().find('.size').removeClass('selected');$(this).toggleClass('selected');});

<?php if(count($sizes) == 1){ ?>
//set the default size
$($('#size-wrap .size')[0]).click();
<?php }?>

<?php if(count($colors) == 1){ ?>
//set the default size
$($('#input-color input')[0]).click();
<?php }?>


</script>