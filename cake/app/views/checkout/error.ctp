<?php if(isset($errors) && count($errors) > 0){ ?>
	<div id="error-console" class="border-rad-med error">
	<?php 
		foreach($errors as $error){
			echo "<div><span class='ename'>{$error->getDisplayName()}</span><span class='emsg'>{$error->getMsg()}</span></div>\n";
		}
	?>
	</div>
<?php } ?>

<?php 
echo $this->element('layouts/lightbg_top');
?>
<div class="title">An error occurred</div>

<p>Above is a list of errors.  If you need more information regarding the error or beleive there was a mistake; please contact
us.
</p>

<?php
echo $this->element('layouts/lightbg_bottom');
?>