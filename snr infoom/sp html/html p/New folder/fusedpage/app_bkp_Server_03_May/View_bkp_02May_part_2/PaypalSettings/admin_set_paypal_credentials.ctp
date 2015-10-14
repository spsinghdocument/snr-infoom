<?php //pr($this->data);die;?>
<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#PaypalSettingAdminSetPaypalCredentialsForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Paypal Credentials</div>

	<div>
	<?php 
		echo $this->Form->create('PaypalSetting', array('action'=>'admin_set_paypal_credentials'));
		echo $this->Form->hidden('PaypalSetting.id');
	?>
		<div class="formField">
			<span>Username :</span>
			<?php echo $this->Form->input('PaypalSetting.user_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false, 'required'=>false)); echo $this->Form->error('PaypalSetting.user_name');?>
		</div>

		<div class="formField">
			<span>Password :</span>
			<?php echo $this->Form->input('PaypalSetting.password', array('div'=>false, 'label'=>false, 'type'=>'password', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false, 'required'=>false)); echo $this->Form->error('PaypalSetting.password');?>
		</div>

		<div class="formField">
			<span>Signature :</span>
			<?php echo $this->Form->input('PaypalSetting.signature', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false, 'required'=>false)); echo $this->Form->error('PaypalSetting.signature');?>
		</div>

		<div class="formField">
			<span>Business Email :</span>
			<?php echo $this->Form->input('PaypalSetting.business_email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false, 'required'=>false)); echo $this->Form->error('PaypalSetting.business_email');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>