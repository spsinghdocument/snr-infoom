<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#BusinessOfferAdminEditForm").validationEngine()	
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
		echo $this->Form->create('BusinessOffer', array('action'=>'admin_edit', 'type'=>'file'));
		echo $this->Form->hidden('BusinessOffer.id');
		echo $this->Form->hidden('BusinessOffer.business_id');
	?>
		<div class="formField">
			<span>category :</span>
			<?php 
			//echo $this->Form->input('BusinessOffer.name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('BusinessOffer.name');
			 echo $this->Form->select('BusinessOffer.name', $this->Fused->fetchOfferCategories(), array('empty'=>'Select', 'class'=>'formInput'));
			?>
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
			<?php echo $this->Form->input('BusinessOffer.image_1', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput'));
			echo $this->Form->hidden('BusinessOffer.old_image', array('value'=>$this->data['BusinessOffer']['image']));

			if($this->data['BusinessOffer']['image'] != ''){
				$imagerealPath = '../webroot/img/front_end/business/offers/'.$this->data['BusinessOffer']['image'];
				if(is_file($imagerealPath)){
			?>
			<span style="float:right; margin-right:300px;">
				<?php echo $this->Image->resize('front_end/business/offers/'.$this->data['BusinessOffer']['image'], 50, 50, array('alt'=>''));?>
			</span>
			<?php
				}
			}
			?>
		</div>
		
		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>