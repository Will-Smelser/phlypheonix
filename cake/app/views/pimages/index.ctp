<div class="pimages index">
	<h2><?php __('Pimages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('actor_id');?></th>
			<th><?php echo $this->Paginator->sort('image');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($pimages as $pimage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $pimage['Pimage']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pimage['Product']['name'], array('controller' => 'products', 'action' => 'view', $pimage['Product']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($pimage['Actor']['id'], array('controller' => 'actors', 'action' => 'view', $pimage['Actor']['id'])); ?>
		</td>
		<td><?php echo $pimage['Pimage']['image']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $pimage['Pimage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $pimage['Pimage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $pimage['Pimage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pimage['Pimage']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Pimage', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actors', true), array('controller' => 'actors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actor', true), array('controller' => 'actors', 'action' => 'add')); ?> </li>
	</ul>
</div>