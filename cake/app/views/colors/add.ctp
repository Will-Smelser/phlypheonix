<div class="colors form">
<?php echo $this->Form->create('Color');?>
	<fieldset>
		<legend><?php __('Add Color'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Colors', true), array('action' => 'index'));?></li>
	</ul>
</div>