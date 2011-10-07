<div class="pstyles view">
<h2><?php  __('Pstyle');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pstyle['Pstyle']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pstyle['Pstyle']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pstyle['Pstyle']['desc']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pstyle', true), array('action' => 'edit', $pstyle['Pstyle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Pstyle', true), array('action' => 'delete', $pstyle['Pstyle']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pstyle['Pstyle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pstyles', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pstyle', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
