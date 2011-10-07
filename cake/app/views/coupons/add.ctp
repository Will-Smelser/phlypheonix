<div class="coupons form">
<?php echo $this->Form->create('Coupon');?>
	<fieldset>
		<legend><?php __('Add Coupon'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('user_id');
		echo $this->Form->input('type');
		echo $this->Form->input('amt');
		echo $this->Form->input('refer_id');
		echo $this->Form->input('expires',array('label'=>'Expires on mm/dd/yy'));
		echo $this->Form->input('open',array('label'=>'0=>closed, 1=>open, -1=>always open','type'=>'text'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Coupons', true), array('action' => 'index'));?></li>
	</ul>
</div>