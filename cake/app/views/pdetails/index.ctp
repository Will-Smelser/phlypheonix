<div class="pdetails index">
	<h2><?php __('Pdetails');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('size_id');?></th>
			<th><?php echo $this->Paginator->sort('color_id');?></th>
			<th><?php echo $this->Paginator->sort('inventory');?></th>
			<th><?php echo $this->Paginator->sort('counter');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($pdetails as $pdetail):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $pdetail['Pdetail']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pdetail['Product']['name'], array('controller' => 'products', 'action' => 'view', $pdetail['Product']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($pdetail['Size']['name'], array('controller' => 'sizes', 'action' => 'view', $pdetail['Size']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($pdetail['Color']['name'], array('controller' => 'colors', 'action' => 'view', $pdetail['Color']['id'])); ?>
		</td>
		<td><?php echo $pdetail['Pdetail']['inventory']; ?>&nbsp;</td>
		<td><?php echo $pdetail['Pdetail']['counter']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $pdetail['Pdetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $pdetail['Pdetail']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $pdetail['Pdetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pdetail['Pdetail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Pdetail', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('controller' => 'sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('controller' => 'sizes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors', true), array('controller' => 'colors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color', true), array('controller' => 'colors', 'action' => 'add')); ?> </li>
	</ul>
</div>