<div class="prompts form">
<?php echo $this->Form->create('Prompt');?>
	<fieldset>
		<legend><?php __('Edit Prompt'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('action');
		echo $this->Form->input('controller');
		echo $this->Form->input('ends');
		echo $this->Form->input('order');
		echo $this->Form->input('User');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Prompt.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Prompt.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Prompts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>