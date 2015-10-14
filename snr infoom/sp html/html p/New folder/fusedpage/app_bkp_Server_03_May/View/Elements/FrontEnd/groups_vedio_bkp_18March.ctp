<div id="pulic_5" style="display:none;">
	<div class="vediotobox">
		<div class="phtotohd">Video</div>

		<!-- Upload Image Start -->
		<div class="phtotohd" id="uploadvedio" style="margin-left:10px; display:block;">
			<input type="file" id="group_vedio_upload">
			<?php //echo $this->Form->input('GroupGallery.group_image_1', array('div'=>false, 'label'=>false, 'type'=>'file'));
			echo $this->Form->hidden('GroupGallery.group_vedio');
			?>
			<span style="float:right;" id="groups_result_span"></span>

			<span style="float:right; margin:0 0 0 5px;" id="display_upload_vedio"></span>

			<div class="btnimage fr">
				<a href="javascript:void(0);" onclick="return validate_group_post_vedio();"><span>Post</span></a>
			</div>
		</div>			
		<!-- Upload Image End -->

		<div class="photoadbox" style="width:90px;">
			<ul class="photoadlink">
				<li style="background:none;"><a href="javaScript:void(0);">+ Add Video</a></li>
			</ul>
			<div class="clr"></div>	
		</div>
		<div class="clr"></div>	
		
		<div style="color:#FF0000; margin-left:55px;" id="groups_result_span_vedio"></div>
		<div class="clr"></div>
	</div>

	<div id="main_listing_video_container">
		<?php 
			$videoArr = $this->Fused->fetchGroupVideos($grpArr['Group']['id']);
			$count = 1;
			foreach($videoArr as $video){ //pr($video);
			$class = 'photoimgbox';
			$dir = '';
			if($count%3 == 0){
				$class = 'photoimgbox last';
				$dir = '<div class="clr"></div>';
			}
		?>
			<div class="<?php echo $class;?>">
				<div class="vedioicon">
					<?php echo $this->Html->link($this->Html->image('front_end/vedio_play_icon.png', array('alt'=>'')), '/group_galleries/view_content/v/'.$this->Fused->encrypt($video['GroupGallery']['id']).'/', array('escape'=>false, 'class'=>'fancyclass'));?>
				</div>
				<?php 
					$defaultVideoImage = 'front_end/groups/noimage.jpg';
					if($video['GroupGallery']['video'] != ''){
						$vidImage = str_replace('.flv', '.jpg', $video['GroupGallery']['video']);
						$videoImg = '../webroot/img/front_end/groups/flv/images/'.$vidImage;
						if(is_file($videoImg))
							$defaultVideoImage = 'front_end/groups/flv/images/'.$vidImage;
					}
					echo $this->Image->resize($defaultVideoImage, 140, 142, array('alt'=>''));
				?>
			</div>
		<?php	echo $dir;
			$count++;
			}
		?>
	</div>
</div>

<!-- HIDDEN FIELDS START -->
<?php
	echo $this->Form->hidden('totalVideos', array('value'=>count($videoArr)));
?>
<!-- HIDDEN FIELDS END -->


<?php if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){?>
<script type="text/javascript">
function validate_group_post_vedio(){
	var group_id = "<?php echo $grpArr['Group']['id'];?>";
	var video = $('#GroupGalleryGroupVedio').val();

	//send ajax for saving the data start
	if(group_id != '' && video != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_galleries/save_group_vedio_data/';?>",
			data: "video="+video+"&group_id="+group_id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#groups_result_span_vedio').html(bSend);
			},
			success: function(response){ //$('#groups_result_span_vedio').html(response);
				var spltArr = response.split('*');
				if(spltArr[0] == 'saved'){
					$('#groups_result_span_vedio').hide();
					$('#display_upload_vedio').hide();
					$('#GroupGalleryGroupVedio').val('');
					fetchAjaxFeedsData(spltArr[1]);
				}else
					$('#groups_result_span_vedio').html(spltArr[1]);
			}
		});
	}
	//send ajax for saving the data end
}

function fetchAjaxFeedsData(id){ //alert(id); return false;
	//increment the count start
	var totalCount = parseInt($('#totalVideos').val());
	totalCount = (totalCount + 1);
	$('#totalVideos').val(totalCount);
	//increment the count end

	//send ajax for video auto populate start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_galleries/populate_new_video/';?>",
		data: "id="+id+"&count="+totalCount,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
			$('#groups_result_span_vedio').html(bSend);
		},
		success: function(response){ //alert(response);
			//$('#groups_result_span_vedio').html(response);
			$('#main_listing_video_container').append(response);
		}
	});
}

function validateVideoExtention(ext){
	var ret = '';
	if((ext == 'flv')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

//FOR VIDEO START
$(document).ready(function(){ //alert('test1'); return false;
	var FeedsVideo = $('#group_vedio_upload'), interval;
	new AjaxUpload(FeedsVideo, {
		action: "<?php echo SITE_PATH.'group_galleries/upload_video/';?>",
		name: "image",
		onSubmit : function(file, ext){ //alert(file); return false;
			var ret = validateVideoExtention(ext);
			if(ret == '0'){
				$('#groups_result_span_vedio').html('<font color="red">Invalid Video!!</font>');
				return false;
			}else
				$('#groups_result_span_vedio').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#groups_result_span_vedio').html(bSend);
		},
		onComplete: function(file, response){ //alert(file); return false;
			$('#groups_result_span_vedio').html('');
			$('#GroupGalleryGroupVedio').val(response);
			if(response != ''){
				var imageNameArr = response.split('.');
				var imageName = imageNameArr[0]+'.jpg';
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/groups/flv/images/'+imageName+'" style="height:20px; width:30px;"/>';
				$('#display_upload_vedio').html(aSend);
			}
		}
	});
});
//FOR VIDEO END
</script>
<?php } ?>