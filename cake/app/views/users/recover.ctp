<div id="content-wrapper">
<div id="column-one" style="padding:10px;">
<?php echo $session->flash('auth'); ?>
<h2 class="f-red f-accented2 f-bigger">Recover Password</h2>
<?php
    echo $form->create('User', array('action' => 'recover'));
    echo $form->input('username',array('label'=>'Username or Email'));
    echo $form->input('captcha',array('label'=>'Enter Leters Below','value'=>''));
?>
<div style="padding-left:10px">
<img id="captcha" src="<?php echo $html->url('/users/captcha_image');?>" alt="" /> 
<br/>
<a class="capatcha" href="javascript:void(0);" onclick="javascript:document.images.captcha.src='<?php echo $html->url('/users/captcha_image');?>?' + Math.round(Math.random(0)*1000)+1">Reload image</a>
</div>
<?
	echo $form->end('Recover');
?> 
</div>
</div>