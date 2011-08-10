<div class="products view">
<h2><?php  __('Product');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Manufacturer'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($product['Manufacturer']['name'], array('controller' => 'manufacturers', 'action' => 'view', $product['Manufacturer']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['desc']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sex'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['sex']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Style'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['style']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price Retail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['price_retail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price Member'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['price_member']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price Buynow'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['price_buynow']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product', true), array('action' => 'edit', $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Product', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Manufacturers', true), array('controller' => 'manufacturers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manufacturer', true), array('controller' => 'manufacturers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product details', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product detail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product images', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product image', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product attributes', true), array('controller' => 'pattributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product attribute', true), array('controller' => 'pattributes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Oinfos');?></h3>
	<?php if (!empty($product['Oinfo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Unitprice'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['Oinfo'] as $oinfo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $oinfo['id'];?></td>
			<td><?php echo $oinfo['product_id'];?></td>
			<td><?php echo $oinfo['quantity'];?></td>
			<td><?php echo $oinfo['unitprice'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'oinfos', 'action' => 'view', $oinfo['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'oinfos', 'action' => 'edit', $oinfo['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'oinfos', 'action' => 'delete', $oinfo['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $oinfo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Oinfo', true), array('controller' => 'oinfos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Pdetails');?></h3>
	<?php if (!empty($product['Pdetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Size Id'); ?></th>
		<th><?php __('Color'); ?></th>
		<th><?php __('Inventory'); ?></th>
		<th><?php __('Counter'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['Pdetail'] as $pdetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pdetail['id'];?></td>
			<td><?php echo $pdetail['product_id'];?></td>
			<td><?php echo $pdetail['size_id'];?></td>
			<td><?php echo $pdetail['color'];?></td>
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
	<?php if (!empty($product['Pimage'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Actor Id'); ?></th>
		<th><?php __('Image'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['Pimage'] as $pimage):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pimage['id'];?></td>
			<td><?php echo $pimage['product_id'];?></td>
			<td><?php echo $pimage['actor_id'];?></td>
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
	<h3><?php __('Related Pattributes');?></h3>
	<?php if (!empty($product['Pattribute'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Image'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['Pattribute'] as $pattribute):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pattribute['id'];?></td>
			<td><?php echo $pattribute['name'];?></td>
			<td><?php echo $pattribute['image'];?></td>
			<td><?php echo $pattribute['description'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'pattributes', 'action' => 'view', $pattribute['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'pattributes', 'action' => 'edit', $pattribute['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'pattributes', 'action' => 'delete', $pattribute['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pattribute['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pattribute', true), array('controller' => 'pattributes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
