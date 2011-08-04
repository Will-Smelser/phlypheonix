<div class="addressships view">
<h2><?php  __('Addressship');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Line1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['line1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Line2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['line2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['state']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zip'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['zip']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $addressship['Addressship']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Addressship', true), array('action' => 'edit', $addressship['Addressship']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Addressship', true), array('action' => 'delete', $addressship['Addressship']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $addressship['Addressship']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Addressships', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Addressship', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uinfos', true), array('controller' => 'uinfos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Uinfo', true), array('controller' => 'uinfos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Uinfos');?></h3>
	<?php if (!empty($addressship['Uinfo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Addressbill Id'); ?></th>
		<th><?php __('Addressship Id'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($addressship['Uinfo'] as $uinfo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $uinfo['id'];?></td>
			<td><?php echo $uinfo['user_id'];?></td>
			<td><?php echo $uinfo['addressbill_id'];?></td>
			<td><?php echo $uinfo['addressship_id'];?></td>
			<td><?php echo $uinfo['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'uinfos', 'action' => 'view', $uinfo['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'uinfos', 'action' => 'edit', $uinfo['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'uinfos', 'action' => 'delete', $uinfo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $uinfo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Uinfo', true), array('controller' => 'uinfos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
