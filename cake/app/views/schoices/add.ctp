<div class="schoices form">
<?php echo $this->Form->create('Schoice');?>
	<fieldset>
		<legend><?php __('Add Schoice'); ?></legend>
	<?php
		echo $this->Form->input('size_id');
		echo $this->Form->input('name');
		echo $this->Form->input('chest');
		echo $this->Form->input('waist');
		echo $this->Form->input('hip');
		echo $this->Form->input('order');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Size choices', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('controller' => 'sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('controller' => 'sizes', 'action' => 'add')); ?> </li>
	</ul>
</div>