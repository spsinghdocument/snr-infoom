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
		echo $this->Form->hidden('User.country');
		echo $this->Form->hidden('User.state');
		echo $this->Form->hidden('User.state_code');
		echo $this->Form->hidden('User.latitude');
		echo $this->Form->hidden('User.longitude');
	?>

		<div class="formField">
			<span>User Type :</span>
			<?php //echo $this->Form->radio('User.usertype', array('1'=>'Normal User', '2'=>'Business User'), array('legend'=>false));
			if($this->data['User']['usertype'] == '1')
				echo 'Normal User';
			else
				echo 'Business User';
			?>
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
			<?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[email]]', 'maxlength'=>100, 'error'=>false, 'required'=>false, 'readonly'=>'readonly')); echo $this->Form->error('User.email');?>
		</div>

		<div class="formField">
			<span>Gender :</span>
			<?php echo $this->Form->radio('User.gender', array('1'=>'Male', '2'=>'Female'), array('legend'=>false));?>
		</div>

		<div class="formField">
			<span>Phone :</span>
			<?php echo $this->Form->input('User.phone', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[phone]]', 'maxlength'=>15, 'error'=>false)); echo $this->Form->error('User.phone');?>
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

		<div class="formField" id="postcode">
			<span>Postcode :</span>
			<?php echo $this->Form->input('User.postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'error'=>false, 'maxlength'=>8, 'style'=>'width:28%;', 'onkeyup'=>'fetchPostalCode(this.value);')); echo $this->Form->error('User.postcode');?>
		</div>
		
		<div class="formField" id="suburb">
			<span>City :</span>
			<?php echo $this->Form->input('User.city', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false, 'readonly'=>'readonly', 'style'=>'width:28%')); echo $this->Form->error('User.city');?>
			<div id="suggestions" style="border:1px solid #B8B8B8; width:22%; display:none; position:absolute; background-color:#FFFFFF; margin-top:2px; border-radius:6px; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>

<script type="text/javascript">
var cityArr = new Array();
function fetchCorrespondingListing(id, type){
	if(id != ''){
		//send ajax for scroll pagination
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

function fetchPostalCode(postCode){
	if(postCode.length >= 5){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'admin/users/fetch_post_codes_details/';?>",
			data: "postcode="+postCode,
			dataType:"json",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#suggestions').show();
				$('#suggestions').html(bSend);
			},
			success: function(response){
				if(response.data != ''){
					cityArr = response;
					$('#suggestions').html('');
					for(temp in response.data){
						$('#suggestions').append('<div style="cursor:pointer; margin:2px;" onclick="return validateState('+temp+')">'+response.data[temp]['Postcode']['CityName']+'</div>');
						
					}
				}else
					$('#suggestions').html('<div style="color:#FF0000; margin:2px; text-align:center;">No City Found!!</div>');
			}
		});
	}else{
		$('#UserCity').val('');
		$('#suggestions').html('');
		$('#suggestions').hide();
	}
}

function validateState(temp){
	$('#UserCountry').val(cityArr.data[temp]['Postcode']['CountryName']);
	$('#UserState').val(cityArr.data[temp]['Postcode']['ProvinceName']);
	$('#UserStateCode').val(cityArr.data[temp]['Postcode']['ProvinceAbbr']);
	$('#UserCity').val(cityArr.data[temp]['Postcode']['CityName']);

	$('#UserLatitude').val(cityArr.data[temp]['Postcode']['Latitude']);
	$('#UserLongitude').val(cityArr.data[temp]['Postcode']['Longitude']);

	$('#suggestions').html('');
	$('#suggestions').hide();
}
</script>