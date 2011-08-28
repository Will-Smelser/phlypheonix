<div class="prompts index">
	<h2><?php __('Prompts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('action');?></th>
			<th><?php echo $this->Paginator->sort('controller');?></th>
			<th><?php echo $this->Paginator->sort('ends');?></th>
			<th><?php echo $this->Paginator->sort('order');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($prompts as $prompt):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $prompt['Prompt']['id']; ?>&nbsp;</td>
		<td><?php echo $prompt['Prompt']['name']; ?>&nbsp;</td>
		<td><?php echo $prompt['Prompt']['action']; ?>&nbsp;</td>
		<td><?php echo $prompt['Prompt']['controller']; ?>&nbsp;</td>
		<td><?php echo $prompt['Prompt']['ends']; ?>&nbsp;</td>
		<td><?php echo $prompt['Prompt']['order']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $prompt['Prompt']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $prompt['Prompt']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $prompt['Prompt']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $prompt['Prompt']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Prompt', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
	<h3>Misc</h3>
	<ul>
		<li><?php echo $this->Html->link('Cleanup Old Prompts', array('action' => 'clean')); ?></li>
	</ul>
</div>