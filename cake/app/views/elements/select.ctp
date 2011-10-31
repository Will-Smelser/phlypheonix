<ul class='select' style='display: none;' id='<?php echo $DOMid; ?>'>
	<li class='select-name'>
		<span><span style="padding:0px;margin:0px;" class='just-name'><?php echo $name?></span><img src='/img/icons/down_arrow_white.png' /></span>
	</li>
	<ul class='option-list'>
<?php 
	foreach($list as $key=>$val){
		echo "<li><div class='select-option'>
			<label for='{$sname}-{$key}'>
			<div>
			<input id='{$sname}-{$key}' name='$sname' type='radio' value='$key'>
				<span class='input-name'>$val</span>
			</div>
			</label>
			</div></li>\n";
	}
?>
	</ul>
</ul>
<noscript>
<select name="<?php echo $sname?>">
<?php 
	foreach($list as $key=>$val){
		echo "<option value='$key'>$val</option>";
	}
?>
</select>
</noscript>
<script language="javascript">
$(document).ready(function(){
	$('#<?php echo $DOMid; ?>').show();
	
	$('#<?php echo $DOMid; ?> input').click(function(){
		var name = $(this).parent().find('.input-name').html();
		$('#<?php echo $DOMid; ?> .select-name .just-name').html(name);
		var id = $('#<?php echo $DOMid; ?> input:checked').val();
		
		<?php 
		if(!empty($hook)) echo $hook.'(id);';
		?>
	});

	//browsers will cache the select, so lets show the selected
	//color if this is the case
	$('#<?php echo $DOMid; ?> input:checked').click();
});
</script>