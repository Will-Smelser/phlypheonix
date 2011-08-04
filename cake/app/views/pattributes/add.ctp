<div class="pattributes form">
<?php echo $this->Form->create('Pattribute');?>
	<fieldset>
		<legend><?php __('Add Pattribute'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('image');
		echo $this->Form->input('description');
		echo $this->Form->input('Product');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pattributes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>