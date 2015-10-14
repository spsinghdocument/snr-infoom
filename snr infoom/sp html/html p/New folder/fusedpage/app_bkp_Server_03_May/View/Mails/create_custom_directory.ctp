<span class="insidehd" style="font-size:15px;">Create New Directory</span>
<div class="contactwebsitename">&nbsp;</div>

<div class="contectflbox" style="width:400px;">
	<div class="contactlable" style="width:85px;">Name:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('folder_name', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>200));?>
		<div id="folder_name_error" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">&nbsp;</div>
	<div class="contactfield" style="padding-top:10px; float:left;">
		<div style="margin-top:15px;" class="btnimage"><a href="javascript:void(0);" onclick="return validate_directory_form();"><span>Create</span></a></div>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>

<script type="text/javascript">
function validate_directory_form(){
	var folder_name = $('#folder_name').val();

	if(folder_name != ''){
		$('#folder_name_error').html('');
		validateFolderName(folder_name);
	}else{
		$('#folder_name_error').html('Required');
		return false;
	}
}

function validateFolderName(folder_name){
	//send ajax for checking the provided folder already exists or not
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'mails/validate_folder_name/';?>",
		data: "folder_name="+folder_name,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#folder_name_error').html(bSend);
		},
		success: function(response){
			if(response == 'OK'){
				save_new_directory(folder_name);
			}else
				$('#folder_name_error').html(response);
		}
	});
}

function save_new_directory(folder_name){
	//send ajax for saving the new directory start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'mails/save_new_directory/';?>",
		data: "folder_name="+folder_name,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#folder_name_error').html(bSend);
		},
		success: function(response){
			if(response == 'OK'){
				$('#folder_name_error').html('<font color="green">Directory Created</font>');
				window.location.reload();
			}else
				$('#folder_name_error').html(response);
		}
	});
}
</script>