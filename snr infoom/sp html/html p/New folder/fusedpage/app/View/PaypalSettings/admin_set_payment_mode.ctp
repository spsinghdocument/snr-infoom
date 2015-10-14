<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Set Payment Mode</div>

	<div>
	<?php echo $this->Form->create('PaypalSetting', array('action'=>'admin_set_payment_mode'));?>
		<div class="formField">
			<span>Payment Mode :</span>
			<?php echo $this->Form->radio('PaypalSetting.mode', array('Testing'=>'Testing', 'Live'=>'Live'), array('legend'=>false, 'value'=>$mode_type));?>
		</div>			

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>