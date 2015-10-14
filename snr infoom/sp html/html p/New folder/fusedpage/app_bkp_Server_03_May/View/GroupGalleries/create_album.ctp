<!-- ALBUM CREATE SECTION START -->
<div id="create_new_album">
<span class="insidehd" style="font-size:15px;">Create New Album</span>
<div class="contactwebsitename">&nbsp;</div>

<div class="contectflbox" style="width:400px;">
	<div class="contactlable" style="width:85px;">Name:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('album_name', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>200));?>
		<div id="album_name_error" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">&nbsp;</div>
	<div class="contactfield" style="padding-top:10px; float:left;">
		<div style="margin-top:15px;" class="btnimage"><a href="javascript:void(0);" onclick="return validate_directory_form();"><span>Create</span></a></div>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
<!-- ALBUM CREATE SECTION END -->


<!-- IMAGE UPLOAD SECTION START -->
<div id="upload_photos_to_album" style="width:400px; display:none;">
<span class="insidehd" style="font-size:15px;">Upload New Photos</span>
<div class="contactwebsitename">&nbsp;</div>

<div class="contectflbox" style="width:400px;">
	<div class="contactlable" style="width:85px; padding:0px;">Upload:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->file('album_image_upload', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass'));?>
		<div id="album_image_error" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
</div>
<!-- IMAGE UPLOAD SECTION END -->

<!-- UPLOADED IMAGE LISTING SECTION START -->
<div id="publish_uploaded_images" style="display:none;"></div>
<!-- UPLOADED IMAGE LISTING SECTION END -->



<!-- INPUT FIELDS SECTION START -->
<?php
echo $this->Form->hidden('newAlbumId');
echo $this->Form->hidden('group_id', array('value'=>$group_id));
echo $this->Form->hidden('newUploadedImages');
?>
<!-- INPUT FIELDS SECTION END -->

<script type="text/javascript">
var uploadedImages = '';
function validate_directory_form(){
	var folder_name = $('#album_name').val();

	if(folder_name != ''){
		$('#album_name_error').html('');
		validateAlbumName(folder_name);
	}else{
		$('#album_name_error').html('Required');
		return false;
	}
}

function validateAlbumName(folder_name){
	//send ajax for checking the provided folder already exists or not
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_galleries/validate_album_name/';?>",
		data: "folder_name="+folder_name+"&group_id=<?php echo $group_id;?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#album_name_error').html(bSend);
		},
		success: function(response){
			if(response == 'OK'){
				save_new_album(folder_name);
			}else
				$('#album_name_error').html(response);
		}
	});
}

function save_new_album(album_name){
	//send ajax for saving new album
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_galleries/save_new_album/';?>",
		data: "album_name="+album_name+"&group_id=<?php echo $group_id;?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#album_name_error').html(bSend);
		},
		success: function(response){
			var splittedArr = response.split('*');
			$('#album_name_error').html(splittedArr[0]);
			if(splittedArr[0] == 'OK'){
				$('#newAlbumId').val(splittedArr[1]);
				//hide the current section, open the new upload section
				validateImagesUpload();
			}else
				$('#album_name_error').html(response);
		}
	});
}

function validateImagesUpload(){
	$('#create_new_album').hide();
	$('#upload_photos_to_album').show();
}

$(document).ready(function(){ //alert('test1'); return false;
	var AlbumImage = $('#album_image_upload'), interval;
	var albumId = $('#newAlbumId').val();
	new AjaxUpload(AlbumImage, {multiple:true,
		action: "<?php echo SITE_PATH.'group_galleries/upload_album_photos';?>",
		name: "image[]",
		onSubmit : function(file, ext){ //alert(file); return false;
			/* var ret = validateVideoExtention(ext);
			if(ret == '0'){
				$('#groups_result_span_vedio').html('<font color="red">Invalid Video!!</font>');
				return false;
			}else
				$('#groups_result_span_vedio').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#groups_result_span_vedio').html(bSend); */
		},
		onComplete: function(file, response){ //alert(response); return false;
			$('#newUploadedImages').val(response);
			uploadedImages = response;
			publishUploadedFiles();
		}
	});
});

function publishUploadedFiles(){
	//send ajax for showing all uploaded images start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_galleries/publish_images/';?>",
		data: "uploaded_images="+uploadedImages,
		beforeSend:function(){
			$('#upload_photos_to_album').hide();
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#publish_uploaded_images').html(bSend);
			$('#publish_uploaded_images').show();
		},
		success: function(response){
			$('#publish_uploaded_images').html(response);
		}
	});


	$('#upload_photos_to_album').hide();
}
</script>