<div class="schools index">
	<h2><?php __('Schools');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('long');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('zip');?></th>
			<th><?php echo $this->Paginator->sort('mascot_name');?></th>
			<th><?php echo $this->Paginator->sort('mascot_image');?></th>
			<th><?php echo $this->Paginator->sort('logo_small');?></th>
			<th><?php echo $this->Paginator->sort('logo_large');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($schools as $school):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $school['School']['id']; ?>&nbsp;</td>
		<td><?php echo $school['School']['name']; ?>&nbsp;</td>
		<td><?php echo $school['School']['long']; ?>&nbsp;</td>
		<td><?php echo $school['School']['city']; ?>&nbsp;</td>
		<td><?php echo $school['School']['state']; ?>&nbsp;</td>
		<td><?php echo $school['School']['zip']; ?>&nbsp;</td>
		<td><?php echo $school['School']['mascot_name']; ?>&nbsp;</td>
		<td><?php echo $school['School']['mascot_image']; ?>&nbsp;</td>
		<td><img src="<?php echo $school['School']['logo_small']; ?>" width="50%" width="50%" /></td>
		<td><?php echo $school['School']['logo_large']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $school['School']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $school['School']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $school['School']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $school['School']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New School', true), array('action' => 'add')); ?></li>
	</ul>
</div>