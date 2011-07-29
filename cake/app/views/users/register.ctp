<div id="content-wrapper">
<div id="column-one" style="padding:10px;">

<h2 class="f-red f-accented2 f-bigger">Register</h2>
<?php

	echo $session->flash('auth');

    echo $this->Form->create('User',array('action'=>'register'));
	echo $this->Form->input('email');
	echo $this->Form->input('birthdate');
	echo $this->Form->input('fname',array('label'=>'First Name'));
	echo $this->Form->input('lname',array('label'=>'Last Name'));
	echo $this->Form->input('sex',array('options'=>array('M'=>'M','F'=>'F')));

	echo $this->Form->input('group_id', array('type'=>'hidden','value'=>'2'));
	echo $this->Form->input('active', array('type'=>'hidden','value'=>'1'));
	
	echo $form->end('Register');
    
?>

</div>
</div>