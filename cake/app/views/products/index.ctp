<div class="products index">
	<h2><?php __('Products');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('manufacturer_id');?></th>
			<th><?php echo $this->Paginator->sort('school_id');?></th>
			<th><?php echo $this->Paginator->sort('controller'); ?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('desc');?></th>
			<th><?php echo $this->Paginator->sort('sex');?></th>
			<th><?php echo $this->Paginator->sort('style');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('price_retail');?></th>
			<th><?php echo $this->Paginator->sort('price_member');?></th>
			<th><?php echo $this->Paginator->sort('price_buynow');?></th>
			<th><?php echo $this->Paginator->sort('pricetag');?></th>
			<th><?php echo $this->Paginator->sort('cost');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $product['Product']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($product['Manufacturer']['name'], array('controller' => 'manufacturers', 'action' => 'view', $product['Manufacturer']['id'])); ?>
		</td>
		<td><?php echo $product['School']['name']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['controller']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['desc']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['sex']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['style']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['active']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['price_retail']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['price_member']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['price_buynow']; ?>&nbsp;</td>
		<td><img width="150%" src="<?php echo $product['Product']['pricetag']; ?>"/></td>
		<td><?php echo $product['Product']['cost']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Product', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Manufacturers', true), array('controller' => 'manufacturers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manufacturer', true), array('controller' => 'manufacturers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product details', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Prodcut detail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product images', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product image', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product attributes', true), array('controller' => 'pattributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product attribute', true), array('controller' => 'pattributes', 'action' => 'add')); ?> </li>
	</ul>
</div>