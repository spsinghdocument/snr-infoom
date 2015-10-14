<div id="pulic_4" style="display:none;">
	<h5>Events
	<?php //echo $this->Fused->validateUserForGroup();?>
	<?php if($this->Fused->validateUserForGroup($this->Fused->decrypt($this->params['pass'][0])) == $this->Session->read('Auth.User.User.id')){?>
		<div class="editinlink" id="EventsTabNavigate">
			<a href="javascript:void(0);" onclick="return validateEventsTabs('add', '<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>');">Add New Event</a>
		</div>
		<div class="clr"></div>
	<?php } ?>
	</h5>

		<!-- MAIN CONTAINER START -->
		<div id="main_events_container">
			<div style="text-align:center; color:#0171C3; margin-top:50px;">
				<?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong>
			</div>
		</div>
		<!-- MAIN CONTAINER END -->

		<?php echo $this->Form->hidden('events_listing_value', array('value'=>'0'));?>
		
			
</div>

<script type="text/javascript">
function fetch_events_for_listing(){
	//load all the deals listing in the corresponding Div
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_events/fetch_group_events/';?>",
		data: "group_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
		success: function(response){
			$('#main_events_container').html(response);
		}
	});
}

function load_deals_listing(){
	if($('#events_listing_value').val() == '0'){
		fetch_events_for_listing();
		$('#events_listing_value').val('1')
	}
}
</script>
<?php if($this->Fused->validateUserForGroup($this->Fused->decrypt($this->params['pass'][0])) == $this->Session->read('Auth.User.User.id')){?>
<script type="text/javascript">
function validateEventsTabs(type, id){

	//FOR ADD	
	if(type == 'add'){
		$('#EventsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateEventsTabs(\'list\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">List Event</a>');
		//send ajax for loading the add deals form start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_events/fetch_add_events_form/';?>",
			data: "group_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
			success: function(response){
				$('#main_events_container').html(response);
			}
		});
		//send ajax for loading the add deals form end
	}

	//FOR LIST
	if(type == 'list'){
		$('#EventsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateEventsTabs(\'add\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">Add New Event</a>');
		fetch_events_for_listing();
	}

	//FOR EDIT
	if(type == 'edit'){
		$('#EventsTabNavigate').html('<a href="javascript:void(0);" onclick="return validateEventsTabs(\'list\', \'<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>\');">List Event</a>');
		//send ajax for loading the add deals form start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_events/fetch_edit_events_form/';?>",
			data: "id="+id,
			success: function(response){
				$('#main_events_container').html(response);
			}
		});
		//send ajax for loading the add deals form end
	}
}


function validateAddEventsForm(){
	var BusinessId = '<?php echo $this->Fused->decrypt($this->params["pass"][0]);?>';
	

	var GroupEventTitle = $('#GroupEventTitle').val();
	if(GroupEventTitle == ''){
		$('#EventTitleError').html('Required');
		$('#GroupEventTitle').focus();
		return false;
	}else
		$('#EventTitleError').html('');

	

	var GroupEventDescription = $('#GroupEventDescription').val();
	if(GroupEventDescription == ''){
		$('#EventDescriptionError').html('Required');
		$('#GroupEventDescription').focus();
		return false;
	}else
		$('#EventDescriptionError').html('');

	var GroupEventStartDate = $('#GroupEventStartDate').val();
	if(GroupEventStartDate != ''){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear(); 
		if(dd<10){dd='0'+dd;} if(mm<10){mm='0'+mm;} 
		var today = yyyy+'-'+mm+'-'+dd;

		if(GroupEventStartDate >= today)
			$('#EventStartDateError').html('');
		else{
			$('#EventStartDateError').html('Start Date should be greater then or equal to today!');
			$('#GroupEventStartDate').focus();
			return false;
		}

	}

	//send Ajax for Deals saving
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_events/add_events_data/';?>",
		data: "group_id="+BusinessId+"&GroupEventTitle="+GroupEventTitle+"&GroupEventDescription="+GroupEventDescription+"&GroupEventStartDate="+GroupEventStartDate,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#resultAddDealDiv').html(bSend);
		},
		success: function(response){
			if(response == 'saved'){
				$('.addOfferClass').val('');
				$('#resultAddDealDiv').html('<font color="green">Deal Added Successfully!!</font>');
				setTimeout(function(){
				      validateEventsTabs('list', BusinessId);
				}, 2000);
				
				//load the listing again
				$('#main_deals_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				fetch_events_for_listing();
			}else
				$('#resultAddDealDiv').html(response);
		}
	});
}


function validateEditEventsForm(){
	var GroupEventId = $('#GroupEventId').val();

	var GroupEventTitle = $('#GroupEventTitle').val();
	if(GroupEventTitle == ''){
		$('#EventTitleError').html('Required');
		$('#GroupEventTitle').focus();
		return false;
	}else
		$('#EventTitleError').html('');

	
	var GroupEventDescription = $('#GroupEventDescription').val();
	if(GroupEventDescription == ''){
		$('#EventDescriptionError').html('Required');
		$('#GroupEventDescription').focus();
		return false;
	}else
		$('#EventDescriptionError').html('');

	
	var GroupEventStartDate = $('#GroupEventStartDate').val();
	if(GroupEventStartDate != ''){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear(); 
		if(dd<10){dd='0'+dd;} if(mm<10){mm='0'+mm;} 
		var today = yyyy+'-'+mm+'-'+dd;

		if(GroupEventStartDate >= today)
			$('#eventStartDateError').html('');
		else{
			$('#eventStartDateError').html('Start Date should be greater then or equal to today!');
			$('#GroupEventStartDate').focus();
			return false;
		}

	}

	
	//send Ajax for Deals saving
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_events/edit_events_data/';?>",
		data: "GroupEventId="+GroupEventId+"&GroupEventTitle="+GroupEventTitle+"&GroupEventDescription="+GroupEventDescription+"&GroupEventStartDate="+GroupEventStartDate,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#resultAddEventDiv').html(bSend);
		},
		success: function(response){
			if(response == 'saved'){
				$('.addOfferClass').val('');
				$('#resultAddEventDiv').html('<font color="green">Event Updated Successfully!!</font>');
				setTimeout(function(){
				      validateEventsTabs('list', BusinessId);
				}, 2000);
				
				//load the listing again
				$('#main_events_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				fetch_events_for_listing();
			}else
				$('#resultAddEventDiv').html(response);
		}
	});
}


function deleteGroupEvent(id){
	var conf = confirm('Do you really want to delete this Event?');
	if(conf == true){
		//delete the offer
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_events/delete_event/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Deleting... Please Wait...</strong></div>';
				$('#main_events_container').html(bSend);
			},
			success: function(response){
				if(response == 'deleted'){
					//load the listing again
					$('#main_deals_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
					fetch_events_for_listing();
				}else
					$('#main_events_listing_container').html('<font>Please Try Later!!</font>');
			}
		});

	}else
		return false;

}
</script>
<?php } ?>