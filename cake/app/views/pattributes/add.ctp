<div class="pattributes form">
<?php echo $this->Form->create('Pattribute');?>
	<fieldset>
		<legend><?php __('Add Pattribute'); ?></legend>
	<?php
		echo $this->Form->input('name');
		//echo $this->Form->input('image');
		echo $this->Form->input('description');
		echo $this->Form->input('Product');
		
		$dir = WWW_ROOT . Configure::read('config.image.attr');
		echo $this->element('admin/recursive_dir_list',array('dir'=>$dir,'replace'=>$dir,'controller'=>'pattributes','action'=>'loaddir'));
		
		/*
		echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Image',
				'dir'=>WWW_ROOT . Configure::read('config.image.attr'),
				'model'=>'Pattribute',
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

		<li><?php echo $this->Html->link(__('List Pattributes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>