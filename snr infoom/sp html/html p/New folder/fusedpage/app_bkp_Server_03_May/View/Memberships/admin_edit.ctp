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
	<div class="mainHd">Edit Membership Details</div>

	<div>
	<?php 
		echo $this->Form->create('Membership', array('action'=>'admin_edit'));
		echo $this->Form->hidden('Membership.id');
	?>

		<div class="formField">
			<span>Membership Plan :</span>
			<div style="margin-left:5px;"><?php echo $this->data['Membership']['name'];?></div>
		</div>

		<div class="formField">
			<span>Pricing :</span>
			<?php 
				if($this->data['Membership']['id'] == '1')
					echo '<div style="margin-left:5px;">Free</div>';
				if(($this->data['Membership']['id'] == '2') || ($this->data['Membership']['id'] == '3')){
					echo '$'.$this->Form->input('Membership.pricing_month', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[price]]', 'maxlength'=>100, 'error'=>false, 'style'=>'width:18%')).' / Month';

					echo '<br/>$'.$this->Form->input('Membership.pricing_year', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[price]]', 'maxlength'=>100, 'error'=>false, 'style'=>'width:18%')).' / Year';
				}
				if($this->data['Membership']['id'] == '4')
					echo '<div style="margin-left:5px;">Contact Us</div>';
			?>
		</div>

		<div class="formField">
			<span>Yearly Offer Tagline :</span>
			<?php echo $this->Form->text('Membership.pricing_tagline', array('class'=>'formInput', 'div'=>false, 'label'=>false));?>
		</div>

		<div class="formField">
			<span>Search Visibility :</span>
			<?php echo $this->Form->select('Membership.search_visibility', array('1'=>'Limited', '2'=>'High', '3'=>'Really High', '4'=>'Highlighted and Top Three'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Managed Profile :</span>
			<?php echo $this->Form->select('Membership.managed_profile', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Publish Deals :</span>
			<?php echo $this->Form->select('Membership.publish_deals', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Subscribe Button :</span>
			<?php echo $this->Form->select('Membership.subscribe_button', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Analytics :</span>
			<?php echo $this->Form->select('Membership.analytics_info', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Advanced Analytics :</span>
			<?php echo $this->Form->select('Membership.advanced_analytics', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Fusedpage Verified :</span>
			<?php echo $this->Form->select('Membership.fusedpage_verified', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Fusedpage Rating :</span>
			<?php echo $this->Form->select('Membership.fusedpage_rating', array('0'=>'No', '1'=>'Yes'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="formField">
			<span>Push Marketing :</span>
			<?php 
				if($this->data['Membership']['id'] == '4')
					echo 'Custom';
				else
					echo $this->Form->input('Membership.push_marketing', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>10, 'style'=>'width:20%;'));
			?>
		</div>

		<div class="formField">
			<span>Fusedpage Rating :</span>
			<?php echo $this->Form->select('Membership.advanced_priority_support', array('1'=>'1 Hour', '2'=>'24 Hours', '3'=>'7 Days'), array('class'=>'formInput', 'empty'=>false, 'style'=>'width:20%;'));?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>