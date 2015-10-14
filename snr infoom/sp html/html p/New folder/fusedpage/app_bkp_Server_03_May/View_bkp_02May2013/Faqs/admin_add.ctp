<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#FaqAdminAddForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Add FAQ</div>

	<div>
	<?php echo $this->Form->create('Faq', array('action'=>'admin_add'));?>
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
			<?php echo $this->Form->radio('Faq.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false, 'value'=>'1'));?>
		</div>		

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Add FAQ', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>