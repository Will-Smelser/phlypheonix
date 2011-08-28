<div class="prompts form">
<?php echo $this->Form->create('Prompt');?>
	<fieldset>
		<legend><?php __('Add Prompt'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('action');
		echo $this->Form->input('controller');
		echo $this->Form->input('ends',array('label'=>'Ends On (mm/dd/yy)'));
		echo $this->Form->input('order');
		echo $this->Form->input('User',array('label'=>'Users (Leave empty for all users)'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Prompts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>