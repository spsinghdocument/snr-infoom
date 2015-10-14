<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#BusinessOfferAdminAddForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Edit Offer</div>

	<div>
	<?php 
		echo $this->Form->create('BusinessOffer', array('action'=>'admin_add', 'type'=>'file'));
		echo $this->Form->hidden('BusinessOffer.business_id', array('value'=>$this->params['pass'][0]));
	?>
		<div class="formField">
			<span>Name :</span>
			<?php echo $this->Form->input('BusinessOffer.name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('BusinessOffer.name');?>
		</div>

		<div class="formField">
			<span>Title :</span>
			<?php echo $this->Form->input('BusinessOffer.title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('BusinessOffer.title');?>
		</div>

		<div class="formField">
			<span>Description :</span>
			<?php echo $this->Form->input('BusinessOffer.description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false, 'style'=>'resize:none;')); echo $this->Form->error('BusinessOffer.description');?>
		</div>

		<div class="formField">
			<span>Price :</span>
			<?php echo '$'.$this->Form->input('BusinessOffer.price', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[price]]', 'maxlength'=>10, 'error'=>false, 'style'=>'width:10%;')); echo $this->Form->error('BusinessOffer.price');?>
		</div>

		<div class="formField">
			<span>Upload Image :</span>
			<?php echo $this->Form->input('BusinessOffer.image_1', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput validate[required]')); echo $this->Form->error('BusinessOffer.price');?>
		</div>
		
		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>