<div class="pimages view">
<h2><?php  __('Pimage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pimage['Pimage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($pimage['Product']['name'], array('controller' => 'products', 'action' => 'view', $pimage['Product']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Actor'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($pimage['Actor']['name'], array('controller' => 'actors', 'action' => 'view', $pimage['Actor']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Color Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pimage['Pimage']['color_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Schoice Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pimage['Pimage']['schoice_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pimage['Pimage']['image']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pimage', true), array('action' => 'edit', $pimage['Pimage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Pimage', true), array('action' => 'delete', $pimage['Pimage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pimage['Pimage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actors', true), array('controller' => 'actors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actor', true), array('controller' => 'actors', 'action' => 'add')); ?> </li>
	</ul>
</div>
