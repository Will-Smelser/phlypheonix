<div class="addressbills index">
	<h2><?php __('Addressbills');?></h2>
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
	foreach ($addressbills as $addressbill):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $addressbill['Addressbill']['id']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['line1']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['line2']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['city']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['state']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['zip']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['modified']; ?>&nbsp;</td>
		<td><?php echo $addressbill['Addressbill']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $addressbill['Addressbill']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $addressbill['Addressbill']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $addressbill['Addressbill']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $addressbill['Addressbill']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Addressbill', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Uinfos', true), array('controller' => 'uinfos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Uinfo', true), array('controller' => 'uinfos', 'action' => 'add')); ?> </li>
	</ul>
</div>