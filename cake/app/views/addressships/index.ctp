<div class="addressships index">
	<h2><?php __('Addressships');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('line1');?></th>
			<th><?php echo $this->Paginator->sort('line2');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('zip');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($addressships as $addressship):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $addressship['Addressship']['id']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['line1']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['line2']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['city']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['state']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['zip']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['modified']; ?>&nbsp;</td>
		<td><?php echo $addressship['Addressship']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $addressship['Addressship']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $addressship['Addressship']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $addressship['Addressship']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $addressship['Addressship']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Addressship', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Uinfos', true), array('controller' => 'uinfos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Uinfo', true), array('controller' => 'uinfos', 'action' => 'add')); ?> </li>
	</ul>
</div>