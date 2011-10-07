<div class="pstyles form">
<?php echo $this->Form->create('Pstyle');?>
	<fieldset>
		<legend><?php __('Add Pstyle'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('desc');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pstyles', true), array('action' => 'index'));?></li>
	</ul>
</div>