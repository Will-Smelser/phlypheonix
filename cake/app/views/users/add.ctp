<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('birthdate',array('label'=>'Birthdate (mm/dd/yy)'));
		echo $this->Form->input('password',array('label'=>'Password (use birthdate for customers mmddyyyy)'));
		echo $this->Form->input('fname',array('label'=>'First Name'));
		echo $this->Form->input('lname',array('label'=>'Last Name'));
		echo $this->Form->input('sex',array('options'=>array('M'=>'M','F'=>'F')));
		echo $this->Form->input('group_id');
		echo $this->Form->input('active');
		echo $this->Form->input('School');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>