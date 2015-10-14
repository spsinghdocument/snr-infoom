<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#HowItWorkAdminManageContentForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Update Content (User)</div>

	<div>
	<?php 
		echo $this->Form->create('HowItWork', array('action'=>'admin_manage_content_user'));
		echo $this->Form->hidden('HowItWork.id');
	?>
		<div class="formField">
			<span>Heading :</span>
			<?php echo $this->Form->input('HowItWork.heading', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false, 'style'=>'width:70%;')); echo $this->Form->error('HowItWork.heading');?>
		</div>

		<div class="formField">
			<span>Content :</span>
			<?php echo $this->Form->input('HowItWork.content', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false, 'rows'=>12, 'style'=>'width:70%;')); echo $this->Form->error('HowItWork.content');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>