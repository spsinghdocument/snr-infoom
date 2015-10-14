<div class="usermidtopbox">
	<ul class="deshboardtoplink">
		<li><a href="javascript:void(0);" style="padding-left:0;"><?php echo $this->Html->image('front_end/gray_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_recents_tabs("group_recents_comments_container");', 'title'=>'Comment'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/camera_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_recents_tabs("group_recents_image_container");', 'title'=>'Image'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/vedio_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_recents_tabs("group_recents_video_container");', 'title'=>'Video'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/blue_clip_img.jpg', array('alt'=>'', 'onclick'=>'return manage_recents_tabs("group_recents_link_container");', 'title'=>'Link'));?></a></li>
	</ul>
	<div class="clr"></div>

	<div class="tabshowmainbox">
		<!-- FOR BUSINESS FEEDS COMMENTS START -->
		<div class="group_recents" id="group_recents_comments_container">
			<div class="tabshowtoparrow">
				<?php echo $this->Html->image('front_end/desh_board_tab_hover_bg.jpg', array('alt'=>''));?>
			</div>
			<div class="tabshowbox">
				<textarea name="post_recents" id="recents_message" cols="" rows="" class="commenttextbox recents_input" style="resize:none;" placeholder="Share Your Thoughts"></textarea>
			</div>
		</div>
		<!-- FOR BUSINESS FEEDS COMMENTS END -->

		<!-- FOR BUSINESS FEEDS IMAGE START -->
		<div class="group_recents" id="group_recents_image_container" style="display:none;">
			<div align="center">
				Upload Image:
				<input type="file" name="recents_image_1" id="recents_image_1">		
				<input type="hidden" id="recents_image" value="" class="recents_input">
				<div style="float:right; margin-right:30px;" id="display_upload_image"></div>
			</div>	
		</div>
		<!-- FOR BUSINESS FEEDS IMAGE END -->

		<!-- FOR BUSINESS FEEDS VIDEO START -->
		<div class="group_recents" id="group_recents_video_container" style="display:none;">
			<div align="center">
				Upload FLV File:
				<input type="file" name="recets_video_1" id="recents_video_1">		
				<input type="hidden" id="recents_video" value="" class="recents_input">
				<div style="float:right; margin-right:30px;" id="display_upload_video"></div>
			</div>
		</div>
		<!-- FOR BUSINESS FEEDS VIDEO END -->

		<!-- FOR BUSINESS FEEDS LINK START -->
		<div class="group_recents" id="group_recents_link_container" style="display:none;">
			<div>
				<!-- Add Link:
				<div class="tabshowbox">
					<textarea name="feeds_link" id="feeds_link" cols="" rows="" class="commenttextbox feeds_input" style="resize:none;"></textarea>
				</div> -->

				<div align="center">
				Add Link:
				<input type="text" name="recents_link" id="recents_link" class="recents_input" style="border:1px solid #CDCDCD; width:280px; color:#909090; height:20px;">
			</div>
			</div>
		</div>
		<!-- FOR BUSINESS FEEDS LINK END -->
	</div>

	<div>
		<div class="sociallinkbox">
			<?php 
				$socialsValidate = $this->Fused->authticateSocialAccounts();
				$errorMsg = '';
			?>
			<!-- <input name="" type="checkbox" value="google" class="checkbox social_media" />
			<a href="javascript:void(0);" class="soicallink"><?php echo $this->Html->image('front_end/google_plus_logo.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a> -->

			<?php	$twitterCheckBox = '';
				$twitterChecked = 'checked="checked"';
				if($socialsValidate['twitter'] == ''){
					$twitterCheckBox = 'disabled="disabled"';
					$twitterChecked = '';
					$errorMsg .= ' Twitter ';
				}
			?>
			<input name="" type="checkbox" value="twitter" class="checkbox social_media" <?php echo $twitterCheckBox.$twitterChecked;?>/>
			<a href="javascript:void(0);" class="soicallink"><?php echo $this->Html->image('front_end/twitter_logo.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>

			<?php	$facebookCheckBox = '';
				$facebookChecked = 'checked="checked"';
				if($socialsValidate['facebook'] == ''){
					$facebookCheckBox = 'disabled="disabled"';
					$facebookChecked = '';
					$errorMsg .= ' Facebook ';
				}
			?>			
			<input name="" type="checkbox" value="facebook" class="checkbox social_media" <?php echo $facebookCheckBox.$facebookChecked;?>/>
			<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/face_book_logo_inside.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>
			<div class="clr"></div>	

			<?php if($errorMsg != ''){?>
			<div style="color:#FF0000; margin-top:5px; font-size:10px;">
				Authenticate your <?php echo $errorMsg;?> Account.
			</div>
			<?php } ?>
		</div>

		<div class="signinboxin" style="width:150px;">
			<span style="float:left;" id="recents_result_span"></span>
			<div class="btnimage fr">
				<a href="javascript:void(0);" onclick="return validate_group_post();"><span>Post</span></a>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>						
	</div>
</div>

<!-- Start for User Comments (Saurabh 5/6/2013)-->
<!-- Start for User End (Saurabh 5/6/2013)-->

<script type="text/javascript">
function manage_recents_tabs(tab){
	$('.group_recents').hide();
	$('#'+tab).show();
}

function validate_group_post(){
		var group_user_id = "<?php echo $this->Session->read('Auth.User.User.id');?>";
		var group_id = "<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>";
		var image = $('#recents_image').val();
		var video = $('#recents_video').val();
		var link = $('#recents_link').val();
		var message = $('#recents_message').val();

		//SOCIAL MEDIA SECTION
		var social_medias = '';
		$('.social_media').each(function(){
			if($(this).attr('checked') == 'checked'){
				social_medias += $(this).val()+',';
			}
		});

		//send ajax for saving the data start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'groups/save_group_recents_data/';?>",
			data: "group_user_id="+group_user_id+"&group_id="+group_id+"&image="+image+"&video="+video+"&link="+link+"&message="+message+"&social_medias="+social_medias,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#recents_result_span').html(bSend);
			},
			success: function(response){
				var spltArr = response.split('*');
				if(spltArr[0] == 'saved'){
					fetchAjaxRecentsData(spltArr[1]);
				}else
					$('#recents_result_span').html(spltArr[1]);
			}
		});
		//send ajax for saving the data end
	
}

function fetchAjaxRecentsData(id){ 
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'groups/fetch_corresponding_recents_data/';?>",
		data: "id="+id,
		success: function(response){
			$('#recents_result_span').html(''); //empty the loader span
			$('.recents_input').each(function(){ //empty all input fields
				$(this).val('');
			});
			$('#display_upload_image').html(''); //empty the image display div
			$('#display_upload_video').html(''); //empty the video image display div
			manage_recents_tabs('group_recents_comments_container'); // open the comment section
			$('#group_recents_main_container').prepend(response); //add the result in the beginning of the listing
		}
	});
}
</script>

<!-- SCRIPT FOR FILE UPLOADS START -->
<script type="text/javascript">
function validateImageExtention(ext){
	var ret = '';
	if((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

function validateVideoExtention(ext){
	var ret = '';
	if((ext == 'flv')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

//FOR IMAGE START
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#recents_image_1'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'groups/upload_image/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#recents_result_span').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#recents_result_span').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#recents_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#recents_result_span').html('');
			$('#recents_image').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/groups/recents/'+response+'" style="height:20px; width:20px;"/>';
				$('#display_upload_image').html(aSend);
			}
		}
	});
});
//FOR IMAGE END

//FOR VIDEO START
$(document).ready(function(){ //alert('test1'); return false;
	var FeedsVideo = $('#recents_video_1'), interval;
	new AjaxUpload(FeedsVideo, {
		action: "<?php echo SITE_PATH.'groups/upload_video/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var ret = validateVideoExtention(ext);
			if(ret == '0'){
				$('#recents_result_span').html('<font color="red">Invalid Video!!</font>');
				return false;
			}else
				$('#recents_result_span').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#recents_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#recents_result_span').html('');
			$('#recents_video').val(response);
			if(response != ''){
				var imageNameArr = response.split('.');
				var imageName = imageNameArr[0]+'.jpg';
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/groups/recents/video/image/'+imageName+'" style="height:20px; width:30px;"/>';
				$('#display_upload_video').html(aSend);
			}
		}
	});
});
//FOR VIDEO END
</script>