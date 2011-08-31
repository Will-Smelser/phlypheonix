<div class="sizes view">
<h2><?php  __('Size');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $size['Size']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $size['Size']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Display'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $size['Size']['display']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sex'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $size['Size']['sex']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Size', true), array('action' => 'edit', $size['Size']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Size', true), array('action' => 'delete', $size['Size']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $size['Size']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sizes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Size', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pdetails', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pdetail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Schoices', true), array('controller' => 'schoices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Schoice', true), array('controller' => 'schoices', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Pdetails');?></h3>
	<?php if (!empty($size['Pdetail'])):?>
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
		foreach ($size['Pdetail'] as $pdetail):
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
	<h3><?php __('Related Schoices');?></h3>
	<?php if (!empty($size['Schoice'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Size Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Chest'); ?></th>
		<th><?php __('Waist'); ?></th>
		<th><?php __('Hip'); ?></th>
		<th><?php __('Order'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($size['Schoice'] as $schoice):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $schoice['id'];?></td>
			<td><?php echo $schoice['size_id'];?></td>
			<td><?php echo $schoice['name'];?></td>
			<td><?php echo $schoice['chest'];?></td>
			<td><?php echo $schoice['waist'];?></td>
			<td><?php echo $schoice['hip'];?></td>
			<td><?php echo $schoice['order'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'schoices', 'action' => 'view', $schoice['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'schoices', 'action' => 'edit', $schoice['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'schoices', 'action' => 'delete', $schoice['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $schoice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Schoice', true), array('controller' => 'schoices', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
