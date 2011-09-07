<div class="colors form">
<?php echo $this->Form->create('Color');?>
	<fieldset>
		<legend><?php __('Add Color'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('School');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Colors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pdetails', true), array('controller' => 'pdetails', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pdetail', true), array('controller' => 'pdetails', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Schools', true), array('controller' => 'schools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New School', true), array('controller' => 'schools', 'action' => 'add')); ?> </li>
	</ul>
</div>