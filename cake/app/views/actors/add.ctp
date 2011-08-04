<div class="actors form">
<?php echo $this->Form->create('Actor');?>
	<fieldset>
		<legend><?php __('Add Actor'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('height');
		echo $this->Form->input('weight');
		echo $this->Form->input('waist');
		echo $this->Form->input('bust');
		echo $this->Form->input('sex');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Actors', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pimages', true), array('controller' => 'pimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pimage', true), array('controller' => 'pimages', 'action' => 'add')); ?> </li>
	</ul>
</div>