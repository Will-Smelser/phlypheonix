<div class="manufacturers view">
<h2><?php  __('Manufacturer');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $manufacturer['Manufacturer']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $manufacturer['Manufacturer']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $manufacturer['Manufacturer']['image']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $manufacturer['Manufacturer']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Manufacturer', true), array('action' => 'edit', $manufacturer['Manufacturer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Manufacturer', true), array('action' => 'delete', $manufacturer['Manufacturer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $manufacturer['Manufacturer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Manufacturers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manufacturer', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Products');?></h3>
	<?php if (!empty($manufacturer['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Manufacturer Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Desc'); ?></th>
		<th><?php __('Sex'); ?></th>
		<th><?php __('Style'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Price Retail'); ?></th>
		<th><?php __('Price Member'); ?></th>
		<th><?php __('Price Buynow'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($manufacturer['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['id'];?></td>
			<td><?php echo $product['manufacturer_id'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['desc'];?></td>
			<td><?php echo $product['sex'];?></td>
			<td><?php echo $product['style'];?></td>
			<td><?php echo $product['active'];?></td>
			<td><?php echo $product['price_retail'];?></td>
			<td><?php echo $product['price_member'];?></td>
			<td><?php echo $product['price_buynow'];?></td>
			<td><?php echo $product['cost'];?></td>
			<td><?php echo $product['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'products', 'action' => 'view', $product['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'products', 'action' => 'edit', $product['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'products', 'action' => 'delete', $product['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
