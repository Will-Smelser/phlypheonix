<div class="actors index">
	<h2><?php __('Actors');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('height');?></th>
			<th><?php echo $this->Paginator->sort('weight');?></th>
			<th><?php echo $this->Paginator->sort('waist');?></th>
			<th><?php echo $this->Paginator->sort('bust');?></th>
			<th><?php echo $this->Paginator->sort('sex');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($actors as $actor):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $actor['Actor']['id']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['name']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['height']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['weight']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['waist']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['bust']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['sex']; ?>&nbsp;</td>
		<td><?php echo $actor['Actor']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $actor['Actor']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $actor['Actor']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $actor['Actor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $actor['Actor']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Actor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
	</ul>
</div>