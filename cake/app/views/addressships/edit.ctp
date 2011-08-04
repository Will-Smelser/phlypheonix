<div class="addressships form">
<?php echo $this->Form->create('Addressship');?>
	<fieldset>
		<legend><?php __('Edit Addressship'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('line1');
		echo $this->Form->input('line2');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Addressship.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Addressship.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Addressships', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Uinfos', true), array('controller' => 'uinfos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Uinfo', true), array('controller' => 'uinfos', 'action' => 'add')); ?> </li>
	</ul>
</div>