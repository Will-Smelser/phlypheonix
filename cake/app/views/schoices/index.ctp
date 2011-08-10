<div class="schoices index">
	<h2><?php __('Schoices');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('size_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('chest');?></th>
			<th><?php echo $this->Paginator->sort('waist');?></th>
			<th><?php echo $this->Paginator->sort('hip');?></th>
			<th><?php echo $this->Paginator->sort('order');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($schoices as $schoice):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $schoice['Schoice']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($schoice['Size']['name'], array('controller' => 'sizes', 'action' => 'view', $schoice['Size']['id'])); ?>
		</td>
		<td><?php echo $schoice['Schoice']['name']; ?>&nbsp;</td>
		<td><?php echo $schoice['Schoice']['chest']; ?>&nbsp;</td>
		<td><?php echo $schoice['Schoice']['waist']; ?>&nbsp;</td>
		<td><?php echo $schoice['Schoice']['hip']; ?>&nbsp;</td>
		<td><?php echo $schoice['Schoice']['order']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $schoice['Schoice']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $schoice['Schoice']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $schoice['Schoice']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $schoice['Schoice']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Size choice', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('controller' => 'sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('controller' => 'sizes', 'action' => 'add')); ?> </li>
	</ul>
</div>