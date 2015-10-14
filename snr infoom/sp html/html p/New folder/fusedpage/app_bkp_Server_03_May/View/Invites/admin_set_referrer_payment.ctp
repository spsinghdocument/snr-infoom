<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#InviteAdminSetReferrerPaymentForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Set Refferer Payment</div>

	<div>
	<?php 
		echo $this->Form->create('Invite', array('action'=>'admin_set_referrer_payment'));
		echo $this->Form->hidden('Referrer.id');
	?>
		<div class="formField">
			<span>Amount :</span>
			<?php echo '$'.$this->Form->input('Referrer.amount', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[price]]', 'maxlength'=>10, 'error'=>false, 'required'=>false, 'style'=>'width:15%')); echo $this->Form->error('Referrer.amount');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Save', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>