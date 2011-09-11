<div class="pimages form">
<?php echo $this->Form->create('Pimage');?>
	<fieldset>
		<legend><?php __('Edit Pimage'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('actor_id');
		echo $this->Form->input('color_id');
		echo $this->Form->input('size_id');
		echo $this->Form->input('name');
		
		$dir = WWW_ROOT . Configure::read('config.image.product');
		echo $this->element('admin/recursive_dir_list',array('dir'=>$dir,'replace'=>$dir,'controller'=>'pimages','action'=>'loaddir'));
		
		/*
		echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Image',
				'dir'=>WWW_ROOT . Configure::read('config.image.product'),
				'model'=>'Pimage',
				'field'=>'image'
			)
		);*/
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Pimage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Pimage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actors', true), array('controller' => 'actors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actor', true), array('controller' => 'actors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors', true), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color', true), array('controller' => 'colors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('controller' => 'sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('controller' => 'sizes', 'action' => 'add')); ?> </li>
	</ul>
</div>