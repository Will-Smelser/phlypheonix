<div style="height:420px">
    
  		<?php echo $this->element('product/features'); ?>
    
    	<?php echo $this->element('product/main_photo',array('index'=>$imageIndex,'product'=>$product)); ?>
    
    	<?php echo $this->element('product/thumbs',array('index'=>$imageIndex)); ?>
    
</div>

<div class="title">Check out another school...</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="90%" height="2" />
<form action="/shop/view" method="post"> 
<select style="margin-top:5px" id="school-list" class="fieldwidth" name="product" >
<?php
	foreach($schools as $s){
		echo "<option value='{$s['Product']['id']}'>{$s['School']['display']} &nbsp;&nbsp;&nbsp;{$s['School']['long']}</option>\n";
	}
?>
</select>
&nbsp;
<input type="submit" value="Check it Out!" class="btn" />
</form>
<br/><br/>
<!-- Create thumbnails of all products associated with sale -->
<div class="title">All items associated with this sale...</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="90%" height="2">
    <?php 
    foreach($saleData['Product'] as $p){
    	if(isset($images[$p['id']])){ 
	    	$link = '/shop/view/'.$p['id'];
	    	$src = $images[$p['id']];
	    	echo "<div style='float:left;padding:10px;'><a href='$link'><img src='$src' width='77' height='88' /></a></div>";
    	}
    }
?>
<div style="clear:both"></div>

<div id="accessory-wrap">
<div class="title">Accessories associated with this sale...</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="90%" height="2">
<?php 
if(isset($accessories['products']) && count($accessories['products']) > 0){
    foreach($accessories['products'] as $p){
    	$dims = $this->Sizer->resizeConstrainY(WWW_ROOT . str_replace('/',DS,$p['Pimage'][0]['image']),77,88);
    	$link = '/shop/view/'.$p['Product']['id'];
    	$src = $p['Pimage'][0]['image'];
    	echo "<div style='float:left;padding:10px;'><a onclick='showAccessory(this);return false;' href='$src' target='_blank'><img src='$src' width='{$dims['0']}' height='{$dims['1']}' /></a></div>";
    	
    }
}
    ?>
</div>

<script language="javascript">
	<?php echo $this->element('prompts/view_accessory'); ?>
</script>