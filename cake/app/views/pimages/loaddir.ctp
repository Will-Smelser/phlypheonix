<?php 

echo $this->element('admin/choose_image',
			array(
				'title'=>'Choose Image',
				'dir'=>$abs,
				'model'=>'Pimage',
				'field'=>'image'
			)
		);

?>