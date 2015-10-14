<?php
if($post['type'] == 'suburb'){
	echo '<span>Suburb :</span>';
	echo $this->Form->select('User.suburb_id', $ret, array('empty'=>'Select', 'class'=>'formInput validate[required]', 'style'=>'width:30%;', 'onchange'=>'fetchCorrespondingListing(this.value, "postcode")'));
}else{
	echo '<span>Postcode :</span>';
	echo $this->Form->input('User.postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'error'=>false, 'style'=>'width:28%;', 'readonly'=>'readonly', 'value'=>$ret));
}
?>