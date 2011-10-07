<div class="coupons index">
	<h2><?php __('Coupons');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('amt');?></th>
			<th><?php echo $this->Paginator->sort('refer_id');?></th>
			<th><?php echo $this->Paginator->sort('expires');?></th>
			<th><?php echo $this->Paginator->sort('open');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($coupons as $coupon):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $coupon['Coupon']['id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['name']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['user_id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['type']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['amt']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['refer_id']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['expires']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['open']; ?>&nbsp;</td>
		<td><?php echo $coupon['Coupon']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $coupon['Coupon']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $coupon['Coupon']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $coupon['Coupon']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Coupon', true), array('action' => 'add')); ?></li>
	</ul>
</div>