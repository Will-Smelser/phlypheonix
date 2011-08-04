<div class="pdetails form">
<?php echo $this->Form->create('Pdetail');?>
	<fieldset>
		<legend><?php __('Edit Pdetail'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('size_id');
		echo $this->Form->input('color');
		echo $this->Form->input('inventory');
		echo $this->Form->input('counter');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Pdetail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Pdetail.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pdetails', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('controller' => 'sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('controller' => 'sizes', 'action' => 'add')); ?> </li>
	</ul>
</div>