<div class="products form">
<?php echo $this->Form->create('Product');?>
	<fieldset>
		<legend><?php __('Edit Product'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('manufacturer_id');
		echo $this->Form->input('school_id');
		echo $this->Form->input('name');
		echo $this->Form->input('desc');
		echo $this->Form->input('sex');
		echo $this->Form->input('style');
		echo $this->Form->input('active');
		echo $this->Form->input('price_retail');
		echo $this->Form->input('price_member');
		echo $this->Form->input('price_buynow');
		echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Price Tag Image',
				'dir'=>WWW_ROOT . Configure::read('config.image.pricetag'),
				'model'=>'Product',
				'field'=>'pricetag'
			)
		);
		echo $this->Form->input('cost');
		echo $this->Form->input('Pattribute');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Product.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Product.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Manufacturers', true), array('controller' => 'manufacturers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manufacturer', true), array('controller' => 'manufacturers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product details', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product detail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product images', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product image', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product attributes', true), array('controller' => 'pattributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product attribute', true), array('controller' => 'pattributes', 'action' => 'add')); ?> </li>
	</ul>
</div>