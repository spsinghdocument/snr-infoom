<?php 
	if($_POST['type'] == 'admin')
		echo $this->Form->select('Business.subcategory_id', $catArr, array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;'));
	else
		echo $this->Form->select('Business.subcategory_id', $catArr, array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;'));
?>