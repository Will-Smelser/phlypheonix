<div class="products form">
<?php echo $this->Form->create('Product');?>
	<fieldset>
		<legend><?php __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('desc');
		echo $this->Form->input('sex');
		echo $this->Form->input('style');
		echo $this->Form->input('active');
		echo $this->Form->input('price_retail');
		echo $this->Form->input('price_member');
		echo $this->Form->input('price_buynow');
		echo $this->Form->input('cost');
		echo $this->Form->input('Pattribute');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Products', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Oinfos', true), array('controller' => 'oinfos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Oinfo', true), array('controller' => 'oinfos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pdetails', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pdetail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pattributes', true), array('controller' => 'pattributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pattribute', true), array('controller' => 'pattributes', 'action' => 'add')); ?> </li>
	</ul>
</div>