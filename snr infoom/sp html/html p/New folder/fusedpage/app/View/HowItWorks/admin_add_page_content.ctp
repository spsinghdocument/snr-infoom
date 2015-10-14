<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#HowItWorkAdminAddPageContentForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Add Page Content</div>

	<div>
	<?php 
		echo $this->Form->create('HowItWork', array('action'=>'admin_add_page_content', 'type'=>'file'));
	?>
		<div class="formField">
			<span>Heading :</span>
			<?php echo $this->Form->input('HowItWork.heading', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false, 'style'=>'width:70%;')); echo $this->Form->error('HowItWork.heading');?>
		</div>

		<div class="formField">
			<span>Content :</span>
			<?php echo $this->Form->input('HowItWork.content', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false, 'rows'=>12, 'style'=>'width:70%;')); echo $this->Form->error('HowItWork.content');?>
		</div>

		<!-- <div class="formField">
			<span>Type :</span>
			<?php 
				echo $this->Form->select('HowItWork.type', array('business'=>'Business', 'user'=>'User'), array('empty'=>false, 'class'=>'formInput', 'style'=>'width:20%;'));
			?>
		</div> -->

		<div class="formField">
			<span>Link :</span>
			<?php echo $this->Form->input('HowItWork.link', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[url]]', 'maxlength'=>150, 'error'=>false, 'style'=>'width:70%;')); echo $this->Form->error('HowItWork.link');?>
		</div>

		<div class="formField">
			<span>Upload Image :</span>
			<?php echo $this->Form->input('HowItWork.image', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput','error'=>false)); echo $this->Form->error('HowItWork.image');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>