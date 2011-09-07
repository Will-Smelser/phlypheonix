<div class="colors view">
<h2><?php  __('Color');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $color['Color']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $color['Color']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Color', true), array('action' => 'edit', $color['Color']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Color', true), array('action' => 'delete', $color['Color']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $color['Color']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Colors', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Color', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pdetails', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pdetail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Schools', true), array('controller' => 'schools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New School', true), array('controller' => 'schools', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Pdetails');?></h3>
	<?php if (!empty($color['Pdetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Size Id'); ?></th>
		<th><?php __('Color Id'); ?></th>
		<th><?php __('Inventory'); ?></th>
		<th><?php __('Counter'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($color['Pdetail'] as $pdetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pdetail['id'];?></td>
			<td><?php echo $pdetail['product_id'];?></td>
			<td><?php echo $pdetail['size_id'];?></td>
			<td><?php echo $pdetail['color_id'];?></td>
			<td><?php echo $pdetail['inventory'];?></td>
			<td><?php echo $pdetail['counter'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'pdetails', 'action' => 'view', $pdetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'pdetails', 'action' => 'edit', $pdetail['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'pdetails', 'action' => 'delete', $pdetail['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pdetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pdetail', true), array('controller' => 'pdetails', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Pimages');?></h3>
	<?php if (!empty($color['Pimage'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Actor Id'); ?></th>
		<th><?php __('Color Id'); ?></th>
		<th><?php __('Size Id'); ?></th>
		<th><?php __('Image'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($color['Pimage'] as $pimage):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pimage['id'];?></td>
			<td><?php echo $pimage['product_id'];?></td>
			<td><?php echo $pimage['actor_id'];?></td>
			<td><?php echo $pimage['color_id'];?></td>
			<td><?php echo $pimage['size_id'];?></td>
			<td><?php echo $pimage['image'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'pimages', 'action' => 'view', $pimage['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'pimages', 'action' => 'edit', $pimage['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'pimages', 'action' => 'delete', $pimage['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pimage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Schools');?></h3>
	<?php if (!empty($color['School'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Long'); ?></th>
		<th><?php __('City'); ?></th>
		<th><?php __('State'); ?></th>
		<th><?php __('Zip'); ?></th>
		<th><?php __('Mascot Name'); ?></th>
		<th><?php __('Mascot Image'); ?></th>
		<th><?php __('Logo Small'); ?></th>
		<th><?php __('Logo Large'); ?></th>
		<th><?php __('Background'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($color['School'] as $school):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $school['id'];?></td>
			<td><?php echo $school['name'];?></td>
			<td><?php echo $school['long'];?></td>
			<td><?php echo $school['city'];?></td>
			<td><?php echo $school['state'];?></td>
			<td><?php echo $school['zip'];?></td>
			<td><?php echo $school['mascot_name'];?></td>
			<td><?php echo $school['mascot_image'];?></td>
			<td><?php echo $school['logo_small'];?></td>
			<td><?php echo $school['logo_large'];?></td>
			<td><?php echo $school['background'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'schools', 'action' => 'view', $school['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'schools', 'action' => 'edit', $school['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'schools', 'action' => 'delete', $school['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $school['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New School', true), array('controller' => 'schools', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
