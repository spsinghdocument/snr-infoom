<?php if(!empty($uploadedImagesArr)){?>
	<span class="insidehd" style="font-size:15px;">Save Images</span>

	<div class="contectflbox" style="width:400px;">
		<?php 
				$count = 1;
				foreach($uploadedImagesArr as $key=>$gall){ //echo $key.'=>'.$gall;die;
					$photoClass = 'photoimgbox';
					$photoClrDiv = '';
					if($count%3 == 0){
						$photoClass = 'photoimgbox last';
						$photoClrDiv = '<div class="clr"></div>';
					}
		?>
				<div id="recent_image_container_<?php echo $count;?>" class="<?php echo $photoClass;?>" style="height:82px; width:81px;">
					<?php 
						$profileDefaultImage = 'front_end/groups/'.$uploadedImagesArr[$key];

						echo $this->Image->resize($profileDefaultImage, 80, 82, array('alt'=>''));
					?>
					<div class="photo_del_box">
						<?php echo $this->Html->link($this->Html->image('front_end/delete.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Remove', 'onclick'=>"removePhoto('".$count."')"));?>
					</div>
				</div>
		<?php		echo $photoClrDiv;	
				$count++;
				echo $this->Form->hidden('recent_image_name_'.$count, array('class'=>'recently_uploaded', 'value'=>$uploadedImagesArr[$key]));
				}
		?>
	</div>
	<div class="clr"></div>

	<div class="contactfield" style="padding-top:10px; float:left;">
		<div style="margin-top:15px;" class="btnimage">
			<a href="javascript:void(0);" onclick="return save_recent_images();"><span>Save</span></a>
			<div style="float:rigt;" id="result_upload_div"></div>
		</div>
	</div>
	<div class="clr"></div>
<?php }else{?>
	No Recent Images Found!
<?php } ?>

<script type="text/javascript">
function removePhoto(count){
	var conf = confirm('Remove this image?');
	if(conf == true){
		$('#recent_image_container_'+count).remove();
		$('#recent_image_name_'+count).val('');
	}else
		return false;
}

function save_recent_images(){
	var album_id = $('#newAlbumId').val();
	var group_id = $('#group_id').val();

	//fetch the names of recent images that needs to be uploaded
	var up_image = '';
	var up_count = 1;
	$('.recently_uploaded').each(function(){
		if(this.value != ''){
			if(up_count == 1)
				up_image = this.value;
			else
				up_image += ','+this.value;
			up_count++;	
		}
	});


	if(up_image != ''){
		//send ajax for saving the information for uploaded images
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_galleries/save_album_data/';?>",
			data: "album_id="+album_id+"&group_id="+group_id+"&up_image="+up_image,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
				$('#result_upload_div').html(bSend);
			},
			success: function(response){
				$('#result_upload_div').html('');
				populateNewAlbum(response);
			}
		});
	}else
		return false;
}

function populateNewAlbum(response){
	$('#main_albums_listing_container').append(response);
	$.fancybox.close();
}
</script>