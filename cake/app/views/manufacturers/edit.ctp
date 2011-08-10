<div class="manufacturers form">
<?php echo $this->Form->create('Manufacturer');?>
	<fieldset>
		<legend><?php __('Edit Manufacturer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		//echo $this->Form->input('image');
		echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Image',
				'dir'=>WWW_ROOT . Configure::read('config.image.mfg'),//'img' . DS . 'products' . DS,
				'model'=>'Manufacturer',
				'field'=>'image'
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Manufacturer.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Manufacturer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Manufacturers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>