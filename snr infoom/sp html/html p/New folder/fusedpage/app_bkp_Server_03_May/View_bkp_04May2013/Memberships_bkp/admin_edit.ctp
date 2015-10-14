<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#MembershipAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Edit Membership</div>

	<div>
	<?php 
		echo $this->Form->create('Membership', array('action'=>'admin_edit'));
		echo $this->Form->hidden('Membership.id');
	?>
		<div class="formField">
			<span>Name :</span>
			<?php echo $this->Form->input('Membership.name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Membership.name');?>
		</div>

		<div class="formField">
			<span>Description :</span>
			<?php echo $this->Form->input('Membership.description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false, 'rows'=>10)); echo $this->Form->error('Membership.description');?>
		</div>

		<div class="formField">
			<span>Price :</span>
			<?php echo '$'.$this->Form->input('Membership.price', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[price]]', 'maxlength'=>10, 'error'=>false, 'style'=>'width:10%;')); echo $this->Form->error('Membership.price');?>
		</div>

		<div class="formField">
			<span>Validity :</span>
			<?php
				echo $this->Form->input('Membership.valid_year', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[integer],min[1]]', 'maxlength'=>10, 'error'=>false, 'style'=>'width:10%;')).' Years';
				echo $this->Form->input('Membership.valid_month', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[integer],min[1],max[11]]', 'maxlength'=>10, 'error'=>false, 'style'=>'width:10%; margin-left:20px;')).' Months';
			?>
		</div>

		<div class="formField">
			<span>Status :</span>
			<?php echo $this->Form->radio('Membership.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false));?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>

	<?php echo $this->Form->end();?>
	</div>
</div>