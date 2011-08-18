<div id="content-wrapper">
<div id="column-one" style="padding:10px;">

<?php echo $this->Session->flash('auth'); ?>

<h3 class="f-red f-accented2 f-bigger">Login Here</h3>

<?php	if($myuser == null){ ?>

<a class="form-link f-accented" href="/users/register" class="small-link">Register</a> or 
<a class="form-link f-accented" href="/users/recover" class="small-link">Recover</a>

<?php
    echo $form->create('User', array('action' => 'login'));
    echo $this->Form->input('email');
	echo $this->Form->input('password',array('label'=>'birthdate'));
	echo $form->end('login');
    }else{
    	echo '<p>Already logged in.</p>';
    }
    
?>



</div>
</div>