<div class="pattributes index">
	<h2><?php __('Pattributes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('image');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($pattributes as $pattribute):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $pattribute['Pattribute']['id']; ?>&nbsp;</td>
		<td><?php echo $pattribute['Pattribute']['name']; ?>&nbsp;</td>
		<td><img src="<?php echo $pattribute['Pattribute']['image']; ?>" width="100" />&nbsp;</td>
		<td><?php echo $pattribute['Pattribute']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $pattribute['Pattribute']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $pattribute['Pattribute']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $pattribute['Pattribute']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pattribute['Pattribute']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Pattribute', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>