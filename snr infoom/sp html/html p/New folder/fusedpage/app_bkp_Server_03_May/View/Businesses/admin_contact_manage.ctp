<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#AdminAdminChangeEmailForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Change Support Contact</div>

	<div>
	<?php 
		echo $this->Form->create('Business', array('action'=>'admin_contact_manage'));
		echo $this->Form->hidden('SupportContact.id');
	?>
		<div class="formField">
			<span>Email :</span>
			<?php echo $this->Form->input('SupportContact.phone', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>20, 'error'=>false, 'required'=>false));?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Submit', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>