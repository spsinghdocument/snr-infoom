<?php //pr($this->data);die;?>
<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#BusinessAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Update Business</div>

	<div>
	<?php 
		echo $this->Form->create('Business', array('action'=>'admin_edit', 'type'=>'file'));
		echo $this->Form->hidden('Business.id');
		
		//For Location Start
		echo $this->Form->hidden('Business.country');
		echo $this->Form->hidden('Business.state');
		echo $this->Form->hidden('Business.state_code');
		echo $this->Form->hidden('Business.old_image', array('value'=>$this->data['Business']['image']));
		echo $this->Form->hidden('Business.old_user_id', array('value'=>$this->data['Business']['user_id']));
		//echo $this->Form->hidden('Business.old_membership_id', array('value'=>$this->Fused->fetchBusinessMembershipPlan($this->data['Business']['id'])));
		//echo $this->Form->text('Business.old_plan_type', array('value'=>$this->Fused->fetchBusinessPlanType($this->data['Business']['id'])));
	?>
		<div class="formField">
			<span>Title :</span>
			<?php echo $this->Form->input('Business.title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.title');?>
		</div>

		<div class="formField">
			<span>Tagline :</span>
			<?php echo $this->Form->input('Business.tagline', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>120, 'error'=>false)); echo $this->Form->error('Business.tagline');?>
		</div>

		<div class="formField">
			<span>Tags (comma seperated) :</span>
			<?php echo $this->Form->input('Business.tags', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>255, 'error'=>false)); echo $this->Form->error('Business.tags');?>
		</div>

		<div class="formField">
			<span>Category :</span>
			<?php echo $this->Form->select('Business.category_id', $this->Fused->fetchAllCategories(), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;', 'onchange'=>'return validate_subcategory(this.value, "admin");'));
			?>
		</div>

		<div class="formField">
			<span>Email :</span>
			<?php echo $this->Form->input('Business.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[email]]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.email');?>
		</div>

		<div class="formField">
			<span>Sub-Category :</span>
			<div id="sub-category">
			<?php echo $this->Form->select('Business.subcategory_id', $this->Fused->fetchAllSubCategories($this->data['Business']['category_id']), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;'));
			?>
			</div>
		</div>

		<div class="formField">
			<span>Street :</span>
			<?php echo $this->Form->input('Business.street', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.street');?>
		</div>

		<div class="formField">
			<span>Zip :</span>
			<?php echo $this->Form->input('Business.zip', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>200, 'error'=>false, 'onkeyup'=>'fetchPostalCode(this.value);', 'autocomplete'=>'off')); echo $this->Form->error('Business.zip');?>
		</div>

		<div class="formField">
			<span>City :</span>
			<?php echo $this->Form->input('Business.city', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>200, 'error'=>false, 'readonly'=>'readonly', 'autocomplete'=>false)); echo $this->Form->error('Business.city');?>
			<div id="suggestions" style="border:1px solid #B8B8B8; width:22%; display:none; position:absolute; background-color:#FFFFFF; margin-top:2px; border-radius:6px; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
		</div>

		<!-- <div class="formField">
			<span>State :</span>
			<?php echo $this->Form->input('Business.state', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.state');?>
		</div> -->

		<div class="formField">
			<span>Phone :</span>
			<?php echo $this->Form->input('Business.phone', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[phone]]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.phone');?>
		</div>

		<div class="formField">
			<span>Website :</span>
			<?php echo $this->Form->input('Business.website', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[custom[url]]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Business.website');?>
		</div>

		<div class="formField">
			<span>Hours :</span>
			<?php echo $this->Form->input('Business.hours', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput', 'error'=>false)); echo $this->Form->error('Business.hours');?>
		</div>

		<div class="formField">
			<span>About Us :</span>
			<?php echo $this->Form->input('Business.about_us', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput', 'error'=>false)); echo $this->Form->error('Business.about_us');?>
		</div>

		<div class="formField">
			<span>Rating :</span>
			<?php echo $this->Form->select('Business.rating', array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5'), array('div'=>false, 'label'=>false, 'empty'=>false, 'class'=>'formInput', 'style'=>'width:15%;'));
			?> / 5
		</div>

		<div class="formField">
			<span>Upload Image (90x90) :</span>
			<?php echo $this->Form->input('Business.image', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput','error'=>false)); echo $this->Form->error('Business.image');

			//show old image start
			if($this->data['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$this->data['Business']['image'];
				if(is_file($imageRealPath)){
					echo $this->Image->resize('front_end/business/'.$this->data['Business']['image'], 40, 40, array('alt'=>''));
				}
			}
			//show old image end
			?>
		</div>

		<div class="formField">
			<span>Status :</span>
			<?php echo $this->Form->radio('Business.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false));?>
		</div>	
		
		<!-- FOR MEMBERSHIP PLAN START -->
		<div class="formField">
			<span>Assign Business To :</span>
			<?php echo $this->Form->select('Membership.user_id', $this->Fused->fetchAllUsersForListing(), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;', 'value'=>$this->data['Business']['user_id']));
			?>
		</div>

		<div class="formField">
			<span>Assign Membership Plan :</span>
			<?php echo $this->Form->select('Membership.membership_plan', $this->Fused->fetchAllMembershipsForListing(), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'formInput', 'style'=>'width:30%;', 'value'=>$this->Fused->fetchBusinessMembershipPlan($this->data['Business']['id']), 'onchange'=>'fetchPlanType(this.value);'));
			?>
		</div>

		<div class="formField">
			<span>Plan Type:</span>
			<div id="plan_type_div">
				<?php echo $this->Form->select('Membership.plan_type', $this->Fused->fetch_plan_type($this->Fused->fetchBusinessMembershipPlan($this->data['Business']['id'])), array('div'=>false, 'label'=>false, 'empty'=>false, 'class'=>'formInput', 'style'=>'width:30%;', 'value'=>$this->Fused->fetchBusinessPlanType($this->data['Business']['id'])));
				?>
			</div>
		</div>

		<!-- FOR MEMBERSHIP PLAN END -->

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update Business', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>

<script type="text/javascript">
var cityArr = new Array();
function validate_subcategory(id, type){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'categories/fetch_sub_categories/';?>",
			data: "category_id="+id+"&type="+type,
			beforeSend:function(){
				var bSend = '<div align="left"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "style"=>"margin-left:10px;"));?></div>';
				$('#sub-category').html(bSend);
			},
			success: function(response){
				$('#sub-category').html(response);	
			}
		});
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
		$('#BusinessCity').val('');
		$('#suggestions').html('');
		$('#suggestions').hide();
	}
}

function validateState(temp){
	$('#BusinessCountry').val(cityArr.data[temp]['Postcode']['CountryName']);
	$('#BusinessState').val(cityArr.data[temp]['Postcode']['ProvinceName']);
	$('#BusinessStateCode').val(cityArr.data[temp]['Postcode']['ProvinceAbbr']);
	$('#BusinessCity').val(cityArr.data[temp]['Postcode']['CityName']);

	$('#suggestions').html('');
	$('#suggestions').hide();
}

function fetchPlanType(plan_id){
	if(plan_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'admin/memberships/fetch_plan_type/';?>",
			data: "plan_id="+plan_id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "style"=>"margin-left:10px;"));?>';
				$('#plan_type_div').html(bSend);
			},
			success: function(response){
				$('#plan_type_div').html(response);
			}
		});
	}else
		return false;
}
</script>