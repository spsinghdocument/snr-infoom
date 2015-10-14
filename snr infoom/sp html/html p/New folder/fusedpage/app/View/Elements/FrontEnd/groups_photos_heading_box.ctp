<div class="phtotobox">
	<!-- <div class="phtotohd">Photos</div> -->
	<div class="phtotohd" id="photos_loading_div"></div>

	<?php if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){?>
	<div class="photoadbox">
		<ul class="photoadlink">
			<li><a href="javascript:void(0);" id="upload_photo_driectly">+ Add Photos</a></li>
			<li style="background:none;"><a href="<?php echo SITE_PATH.'group_galleries/create_album/'.$this->Fused->encrypt($grpArr['Group']['id']).'/';?>" onclick="return validate_photos_link('album_link');" class="fancyclass">+ Create Album</a></li>
		</ul>
		<div class="clr"></div>	
	</div>
	<div class="clr"></div>

	<div class="photomainbox">
		<ul class="photolinkmian">
			<li><a href="javascript:void(0);" id="photo_link" class="plm select" onclick="return validate_photos_link('photo_link');">Photos</a></li>
			<li><a href="javascript:void(0);" id="album_link" class="plm" onclick="return validate_photos_link('album_link');">Albums</a></li>
		</ul>	
	</div>
	<?php } ?>
	<div class="clr"></div>						
</div>

<script type="text/javascript">
function validate_photos_link(id){
	$('.plm').each(function(){
		var currentId = $(this).attr('id');
		if(currentId == id){  //show the current div and selector
			$('#'+id).addClass('select');
			$('#'+currentId+'_container').show();
		}else{ //hide the current div and selector
			$('#'+currentId).removeClass('select');
			$('#'+currentId+'_container').hide();
		}
	});
	//hide the album image listing div
	$('#album_div_container').hide();
}
</script>

<?php if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){?>
<script type="text/javascript">
//FOR IMAGE START
function validateImageExtention(ext){
	var ret = '';
	if((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

$(document).ready(function(){
	var FeedsImage = $('#upload_photo_driectly'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'group_galleries/upload_groups_image/';?>",
		name: "group_image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#photos_loading_div').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#photos_loading_div').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#photos_loading_div').html(bSend);
		},
		onComplete: function(file, response){
			saveNewuploadedImage(response);
		}
	});
});

function saveNewuploadedImage(image_name){
	if(image_name != ''){
		var total_photos = parseInt($('#total_photos').val());
		total_photos = (total_photos + 1);
		$('#total_photos').val(total_photos);
		var photo_album = $('#photo_album').val();

		//send the ajax for new image save data
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_galleries/save_image_data/';?>",
			data: "group_id=<?php echo $grpArr['Group']['id'];?>"+"&image="+image_name+"&total_photos="+total_photos+"&photo_album="+photo_album,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#photos_loading_div').html(bSend);
			},
			success: function(response){
				$('#photos_loading_div').html('');
				$('#main_listing_photos_container').append(response);
				//alert(response);
			}
		});
	}
}
//FOR IMAGE END
</script>
<?php } ?>