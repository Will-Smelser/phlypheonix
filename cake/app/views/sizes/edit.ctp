<div class="sizes form">
<?php echo $this->Form->create('Size');?>
	<fieldset>
		<legend><?php __('Edit Size'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('sex');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Size.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Size.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Product details', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product detail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
	</ul>
</div>