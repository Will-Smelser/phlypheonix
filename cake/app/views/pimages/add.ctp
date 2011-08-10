<div class="pimages form">
<?php echo $this->Form->create('Pimage');?>
	<fieldset>
		<legend><?php __('Add Pimage'); ?></legend>
	<?php
		echo $this->Form->input('product_id');
		echo $this->Form->input('actor_id');
		//echo $this->Form->input('image');
		echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Image',
				'dir'=>WWW_ROOT . Configure::read('config.image.product'),
				'model'=>'Pimage',
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

		<li><?php echo $this->Html->link(__('List Pimages', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actors', true), array('controller' => 'actors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actor', true), array('controller' => 'actors', 'action' => 'add')); ?> </li>
	</ul>
</div>