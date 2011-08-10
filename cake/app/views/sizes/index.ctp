<div class="sizes index">
	<h2><?php __('Sizes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('sex');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($sizes as $size):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $size['Size']['id']; ?>&nbsp;</td>
		<td><?php echo $size['Size']['name']; ?>&nbsp;</td>
		<td><?php echo $size['Size']['sex']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $size['Size']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $size['Size']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $size['Size']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $size['Size']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Size', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Details', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size Choices', true), array('controller' => 'schoices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Detail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
	</ul>
</div>