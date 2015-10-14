<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#UserAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<!-- CALL CALENDER FILES START -->
<?php
	echo $this->Html->script('calender/jscal2');
	echo $this->Html->script('calender/lang/en');
	echo $this->Html->css('calender/jscal2');
	echo $this->Html->css('calender/border-radius');
	echo $this->Html->css('calender/steel/steel');
?>
<!-- CALL CALENDER FILES END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Edit User Details</div>

	<div>
	<?php 
		echo $this->Form->create('User', array('action'=>'admin_edit'));
		echo $this->Form->hidden('User.id');
	?>

		<div class="formField">
			<span>User Type :</span>
			<?php echo $this->Form->radio('User.usertype', array('1'=>'Normal User', '2'=>'Business User'), array('legend'=>false));?>
		</div>

		<div class="formField">
			<span>First Name :</span>
			<?php echo $this->Form->input('User.first_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false)); echo $this->Form->error('User.first_name');?>
		</div>

		<div class="formField">
			<span>Last Name :</span>
			<?php echo $this->Form->input('User.last_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>100, 'error'=>false)); echo $this->Form->error('User.last_name');?>
		</div>

		<div class="formField">
			<span>Email :</span>
			<?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[email]]', 'maxlength'=>100, 'error'=>false)); echo $this->Form->error('User.email');?>
		</div>

		<div class="formField">
			<span>Gender :</span>
			<?php echo $this->Form->radio('User.gender', array('1'=>'Male', '2'=>'Female'), array('legend'=>false));?>
		</div>

		<div class="formField">
			<span>Phone :</span>
			<?php echo $this->Form->input('User.phone', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[phone]]', 'maxlength'=>15, 'error'=>false)); echo $this->Form->error('User.phone');?>
		</div>

		<div class="formField">
			<span>Date of Birth :</span>
			<?php echo $this->Form->input('User.date_of_birth', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>15, 'error'=>false, 'readonly'=>'readonly', 'style'=>'width:28%; cursor:text;')); echo $this->Form->error('User.date_of_birth');?>
		</div>
		<script type="text/javascript">
			var cal = Calendar.setup({
				onSelect: function(cal){
					cal.hide();
				}
			});
			cal.manageFields("UserDateOfBirth", "UserDateOfBirth", "%Y-%m-%d");
		</script>
		
		<div class="formField">
			<span>State :</span>
			<?php echo $this->Form->select('User.state_id', $this->Fused->fetchAllAustraliaStates(), array('empty'=>'Select', 'class'=>'formInput validate[required]', 'style'=>'width:30%;', 'onchange'=>'fetchCorrespondingListing(this.value, "suburb")'));?>
		</div>

		<div class="formField" id="suburb">
			<span>Suburb :</span>
			<?php echo $this->Form->select('User.suburb_id', $this->Fused->fetchCorrespondingSuburbs($this->data['User']['state_id']), array('empty'=>'Select', 'class'=>'formInput validate[required]', 'style'=>'width:30%;', 'onchange'=>'fetchCorrespondingListing(this.value, "postcode")'));?>
		</div>

		<div class="formField" id="postcode">
			<span>Postcode :</span>
			<?php echo $this->Form->input('User.postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'error'=>false, 'style'=>'width:28%;', 'readonly'=>'readonly')); echo $this->Form->error('User.postcode');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>

<script type="text/javascript">
function fetchCorrespondingListing(id, type){
	if(id != ''){
		//send ajax
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'admin/users/fetch_corresponding_listing/';?>",
			data: "id="+id+"&type="+type,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>'; 
				$('#'+type).html(bSend);
			},
			success: function(response){
				$('#'+type).html(response);
			}
		});
	}else{
		return false;
	}
}
</script>