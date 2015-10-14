<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#FaqAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Edit FAQ</div>

	<div>
	<?php 
		echo $this->Form->create('Faq', array('action'=>'admin_edit'));
		echo $this->Form->hidden('Faq.id');
	?>
		<div class="formField">
			<span>Question :</span>
			<?php echo $this->Form->input('Faq.question', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Faq.question');?>
		</div>

		<div class="formField">
			<span>Answer :</span>
			<?php echo $this->Form->input('Faq.answer', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('Faq.answer');?>
		</div>

		<div class="formField">
			<span>Status :</span>
			<?php echo $this->Form->radio('Faq.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false));?>
		</div>		

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>