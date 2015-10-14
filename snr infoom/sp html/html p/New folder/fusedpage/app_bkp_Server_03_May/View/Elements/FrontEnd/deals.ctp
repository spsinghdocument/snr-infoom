<div id="pulic_4" style="display:none;">
	<h5>Deals
	<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){?>
		<div class="editinlink" id="DealsTabNavigate">
			<a href="javascript:void(0);" onclick="return validateDealsTabs('add', '<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>');">Add New Deal</a>
		</div>
		<div class="clr"></div>
	<?php } ?>
	</h5>

	<!-- MAIN CONTAINER START -->
	<div id="main_deals_container">
		<div style="text-align:center; color:#0171C3; margin-top:50px;">
			<?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong>
		</div>
	</div>
	<!-- MAIN CONTAINER END -->

	<?php echo $this->Form->hidden('deals_listing_value', array('value'=>'0'));?>


	
</div>

<script type="text/javascript">
function fetch_deals_for_listing(){
	//load all the deals listing in the corresponding Div
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_deals/fetch_business_deals/';?>",
		data: "business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
		success: function(response){
			$('#main_deals_container').html(response);
		}
	});
}

function load_deals_listing(){
	/*if($('#deals_listing_value').val() == '0'){
		fetch_deals_for_listing();
		$('#deals_listing_value').val('1')
	} */

	// new code
	var bSend = '<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>';
	$('#main_deals_container').html(bSend);
	fetch_deals_for_listing();
}

function view_details(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_deals/fetch_business_deals_details/';?>",
			data: "business_deal_id="+id,
			beforeSend:function(){
				var bSend = '<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>';
				$('#main_deals_container').html(bSend);
			},
			success: function(response){
				$('#main_deals_container').html(response);
			}
		});
	}else
		return false;
}
</script>

<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){?>
<script type="text/javascript">
function validateDealsTabs(type, id){
	//FOR ADD	
	if(type == 'add'){
		$('#DealsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateDealsTabs(\'list\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">List Deal</a>');
		//send ajax for loading the add deals form start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_deals/fetch_add_deals_form/';?>",
			data: "business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
			success: function(response){
				$('#main_deals_container').html(response);
			}
		});
		//send ajax for loading the add deals form end
	}

	//FOR LIST
	if(type == 'list'){
		$('#DealsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateDealsTabs(\'add\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">Add New Deal</a>');
		fetch_deals_for_listing();
	}

	//FOR EDIT
	if(type == 'edit'){
		$('#DealsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateDealsTabs(\'list\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">List Deal</a>');
		//send ajax for loading the add deals form start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_deals/fetch_edit_deals_form/';?>",
			data: "id="+id,
			success: function(response){
				$('#main_deals_container').html(response);
			}
		});
		//send ajax for loading the add deals form end
	}
}

function validateAddDealsForm(){
	var BusinessId = '<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>';
	var BusinessDealTagline = $('#BusinessDealTagline').val();
	var BusinessDealImage = $('#BusinessDealImage').val();
	var BusinessDealHighLights = $('#BusinessDealHighLights').val();		

	var BusinessDealTitle = $('#BusinessDealTitle').val();
	if(BusinessDealTitle == ''){
		$('#DealTitleError').html('Required');
		$('#BusinessDealTitle').focus();
		return false;
	}else
		$('#DealTitleError').html('');

	var BusinessDealPrice = $('#BusinessDealPrice').val();
	if(BusinessDealPrice == ''){
		$('#DealPriceError').html('Required');
		$('#BusinessDealPrice').focus();
		return false;
	}else{
		var reg = /^[\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/;
		if(reg.test(BusinessDealPrice) == false){
			$('#DealPriceError').html('Invalid Price');
			$('#BusinessDealPrice').focus();
			return false;
		}else
			$('#DealPriceError').html('');
	}

	var BusinessDealDescription = $('#BusinessDealDescription').val();
	if(BusinessDealDescription == ''){
		$('#dealDescriptionError').html('Required');
		$('#BusinessDealDescription').focus();
		return false;
	}else
		$('#dealDescriptionError').html('');

	var BusinessDealFinePrints = $('#BusinessDealFinePrints').val();
	if(BusinessDealFinePrints == ''){
		$('#dealFinePrintsError').html('Required');
		$('#BusinessDealFinePrints').focus();
		return false;
	}else
		$('#dealFinePrintsError').html('');

	var BusinessDealStartDate = $('#BusinessDealStartDate').val();
	if(BusinessDealStartDate != ''){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear(); 
		if(dd<10){dd='0'+dd;} if(mm<10){mm='0'+mm;} 
		var today = yyyy+'-'+mm+'-'+dd;

		if(BusinessDealStartDate >= today)
			$('#DealStartDateError').html('');
		else{
			$('#DealStartDateError').html('Start Date should be greater then or equal to today!');
			$('#BusinessDealStartDate').focus();
			return false;
		}

	}

	var BusinessDealEndDate = $('#BusinessDealEndDate').val();
	if(BusinessDealEndDate == ''){
		if(BusinessDealStartDate != ''){
			$('#DealEndDateError').html('Required');
			$('#BusinessDealEndDate').focus();
			return false;
		}
	}else{
		if(BusinessDealEndDate >= BusinessDealStartDate){
			$('#DealEndDateError').html('');
		}else{
			$('#DealEndDateError').html('End Date should be greater then or equal to start date!');
			$('#BusinessDealEndDate').focus();
			return false;
		}
	}

	//send Ajax for Deals saving
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_deals/add_deals_data/';?>",
		data: "business_id="+BusinessId+"&BusinessDealHighLights="+BusinessDealHighLights+"&BusinessDealTagline="+BusinessDealTagline+"&BusinessDealImage="+BusinessDealImage+"&BusinessDealTitle="+BusinessDealTitle+"&BusinessDealPrice="+BusinessDealPrice+"&BusinessDealDescription="+BusinessDealDescription+"&BusinessDealFinePrints="+BusinessDealFinePrints+"&BusinessDealStartDate="+BusinessDealStartDate+"&BusinessDealEndDate="+BusinessDealEndDate,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#resultAddDealDiv').html(bSend);
		},
		success: function(response){
			if(response == 'saved'){
				$('.addOfferClass').val('');
				$('#resultAddDealDiv').html('<font color="green">Deal Added Successfully!!</font>');
				setTimeout(function(){
				      validateDealsTabs('list', BusinessId);
				}, 2000);
				
				//load the listing again
				$('#main_deals_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				fetch_deals_for_listing();
			}else
				$('#resultAddDealDiv').html(response);
		}
	});
}

function validateEditDealsForm(){
	var BusinessDealId = $('#BusinessDealId').val();

	var BusinessDealTagline = $('#BusinessDealTagline').val();
	var BusinessDealImage = $('#BusinessDealImage').val();
	var BusinessDealHighLights = $('#BusinessDealHighLights').val();

	var BusinessDealTitle = $('#BusinessDealTitle').val();
	if(BusinessDealTitle == ''){
		$('#DealTitleError').html('Required');
		$('#BusinessDealTitle').focus();
		return false;
	}else
		$('#DealTitleError').html('');

	var BusinessDealPrice = $('#BusinessDealPrice').val();
	if(BusinessDealPrice == ''){
		$('#DealPriceError').html('Required');
		$('#BusinessDealPrice').focus();
		return false;
	}else{
		var reg = /^[\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/;
		if(reg.test(BusinessDealPrice) == false){
			$('#DealPriceError').html('Invalid Price');
			$('#BusinessDealPrice').focus();
			return false;
		}else
			$('#DealPriceError').html('');
	}

	var BusinessDealDescription = $('#BusinessDealDescription').val();
	if(BusinessDealDescription == ''){
		$('#dealDescriptionError').html('Required');
		$('#BusinessDealDescription').focus();
		return false;
	}else
		$('#dealDescriptionError').html('');

	var BusinessDealFinePrints = $('#BusinessDealFinePrints').val();
	if(BusinessDealFinePrints == ''){
		$('#dealFinePrintsError').html('Required');
		$('#BusinessDealFinePrints').focus();
		return false;
	}else
		$('#dealFinePrintsError').html('');

	var BusinessDealStartDate = $('#BusinessDealStartDate').val();
	if(BusinessDealStartDate != ''){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear(); 
		if(dd<10){dd='0'+dd;} if(mm<10){mm='0'+mm;} 
		var today = yyyy+'-'+mm+'-'+dd;

		if(BusinessDealStartDate >= today)
			$('#DealStartDateError').html('');
		else{
			$('#DealStartDateError').html('Start Date should be greater then or equal to today!');
			$('#BusinessDealStartDate').focus();
			return false;
		}

	}

	var BusinessDealEndDate = $('#BusinessDealEndDate').val();
	if(BusinessDealEndDate == ''){
		if(BusinessDealStartDate != ''){
			$('#DealEndDateError').html('Required');
			$('#BusinessDealEndDate').focus();
			return false;
		}
	}else{
		if(BusinessDealEndDate >= BusinessDealStartDate){
			$('#DealEndDateError').html('');
		}else{
			$('#DealEndDateError').html('End Date should be greater then or equal to start date!');
			$('#BusinessDealEndDate').focus();
			return false;
		}
	}

	//send Ajax for Deals saving
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_deals/edit_deals_data/';?>",
		data: "BusinessDealId="+BusinessDealId+"&BusinessDealHighLights="+BusinessDealHighLights+"&BusinessDealTagline="+BusinessDealTagline+"&BusinessDealImage="+BusinessDealImage+"&BusinessDealTitle="+BusinessDealTitle+"&BusinessDealPrice="+BusinessDealPrice+"&BusinessDealDescription="+BusinessDealDescription+"&BusinessDealFinePrints="+BusinessDealFinePrints+"&BusinessDealStartDate="+BusinessDealStartDate+"&BusinessDealEndDate="+BusinessDealEndDate,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#resultAddDealDiv').html(bSend);
		},
		success: function(response){
			if(response == 'saved'){
				$('.addOfferClass').val('');
				$('#resultAddDealDiv').html('<font color="green">Deal Updated Successfully!!</font>');
				setTimeout(function(){
				      validateDealsTabs('list', BusinessId);
				}, 2000);
				
				//load the listing again
				$('#main_deals_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				fetch_deals_for_listing();
			}else
				$('#resultAddDealDiv').html(response);
		}
	});




}

function deleteBusinesDeal(id){
	var conf = confirm('Do you really want to delete this Deal?');
	if(conf == true){
		//delete the offer
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_deals/delete_deal/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Deleting... Please Wait...</strong></div>';
				$('#main_deals_container').html(bSend);
			},
			success: function(response){
				if(response == 'deleted'){
					//load the listing again
					$('#main_deals_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
					fetch_deals_for_listing();
				}else
					$('#main_offers_listing_container').html('<font>Please Try Later!!</font>');
			}
		});

	}else
		return false;

}
</script>
<?php } ?>