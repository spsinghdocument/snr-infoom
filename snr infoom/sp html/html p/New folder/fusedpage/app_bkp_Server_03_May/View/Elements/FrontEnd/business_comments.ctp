<?php
	if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){
		$business_id = $this->Fused->decrypt($this->params['pass'][0]);
?>
<div class="usermidtopbox">
	<ul class="deshboardtoplink">
		<li><a href="javascript:void(0);" style="padding-left:0;"><?php echo $this->Html->image('front_end/gray_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("business_feeds_comments_container");', 'title'=>'Comment'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/camera_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("business_feeds_image_container");', 'title'=>'Image'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/vedio_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("business_feeds_video_container");', 'title'=>'Video'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/blue_clip_img.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("business_feeds_link_container");', 'title'=>'Link'));?></a></li>
	</ul>
	<div class="clr"></div>

	<div class="tabshowmainbox">
		<!-- FOR BUSINESS FEEDS COMMENTS START -->
		<div class="business_feeds" id="business_feeds_comments_container">
			<div class="tabshowtoparrow">
				<?php echo $this->Html->image('front_end/desh_board_tab_hover_bg.jpg', array('alt'=>''));?>
			</div>
			<div class="tabshowbox">
				<textarea name="post_feeds" id="feeds_message" cols="" rows="" class="commenttextbox feeds_input" style="resize:none;" placeholder="Share Your Thoughts"></textarea>
			</div>
		</div>
		<!-- FOR BUSINESS FEEDS COMMENTS END -->

		<!-- FOR BUSINESS FEEDS IMAGE START -->
		<div class="business_feeds" id="business_feeds_image_container" style="display:none;">
			<div align="center">
				Upload Image:
				<input type="file" name="feeds_image_1" id="feeds_image_1">		
				<input type="hidden" id="feeds_image" value="" class="feeds_input">
				<div style="float:right; margin-right:30px;" id="display_upload_image"></div>
			</div>	
		</div>
		<!-- FOR BUSINESS FEEDS IMAGE END -->

		<!-- FOR BUSINESS FEEDS VIDEO START -->
		<div class="business_feeds" id="business_feeds_video_container" style="display:none;">
			<div align="center">
				Upload FLV File:
				<input type="file" name="feeds_video_1" id="feeds_video_1">		
				<input type="hidden" id="feeds_video" value="" class="feeds_input">
				<div style="float:right; margin-right:30px;" id="display_upload_video"></div>
			</div>
		</div>
		<!-- FOR BUSINESS FEEDS VIDEO END -->

		<!-- FOR BUSINESS FEEDS LINK START -->
		<div class="business_feeds" id="business_feeds_link_container" style="display:none;">
			<div>
				<!-- Add Link:
				<div class="tabshowbox">
					<textarea name="feeds_link" id="feeds_link" cols="" rows="" class="commenttextbox feeds_input" style="resize:none;"></textarea>
				</div> -->

				<div align="center">
				Add Link:
				<input type="text" name="feeds_link" id="feeds_link" class="feeds_input" style="border:1px solid #CDCDCD; width:280px; color:#909090; height:20px;">
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
			<span style="float:left;" id="feeds_result_span"></span>
			<div class="btnimage fr">
				<a href="javascript:void(0);" onclick="return validate_business_post();"><span>Post</span></a>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>						
	</div>
</div>

<script type="text/javascript">
function manage_feeds_tabs(tab){
	$('.business_feeds').hide();
	$('#'+tab).show();
}

function validate_business_post(){
	var flag = '0';
	$('.feeds_input').each(function(){
		if($(this).val() != '')
			flag = '1';
	});

	//SOCIAL MEDIA SECTION
	var social_medias = '';
	$('.social_media').each(function(){
		if($(this).attr('checked') == 'checked'){
			social_medias += $(this).val()+',';
		}
	});

	if(flag == '1'){	
		var business_id = "<?php echo $business_id;?>";
		var image = $('#feeds_image').val();
		var video = $('#feeds_video').val();
		var link = $('#feeds_link').val();
		var message = $('#feeds_message').val();

		//send ajax for saving the data start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_feeds/save_feeds_data/';?>",
			data: "business_id="+business_id+"&image="+image+"&video="+video+"&link="+link+"&message="+message+"&social_medias="+social_medias,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#feeds_result_span').html(bSend);
			},
			success: function(response){ //alert(response); return false;
				var spltArr = response.split('*');
				if(spltArr[0] == 'saved'){
					fetchAjaxFeedsData(spltArr[1]);
				}else
					$('#feeds_result_span').html(spltArr[1]);
			}
		});
		//send ajax for saving the data end
	}
}

function fetchAjaxFeedsData(id){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_feeds/fetch_corresponding_feeds_data/';?>",
		data: "id="+id,
		success: function(response){
			$('#feeds_result_span').html(''); //empty the loader span
			$('.feeds_input').each(function(){ //empty all input fields
				$(this).val('');
			});
			$('#display_upload_image').html(''); //empty the image display div
			$('#display_upload_video').html(''); //empty the video image display div
			manage_feeds_tabs('business_feeds_comments_container'); // open the comment section
			$('#business_feeds_main_container').prepend(response); //add the result in the beginning of the listing
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
	var FeedsImage = $('#feeds_image_1'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'business_feeds/upload_image/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#feeds_result_span').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#feeds_result_span').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#feeds_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#feeds_result_span').html('');
			$('#feeds_image').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/feeds/'+response+'" style="height:20px; width:20px;"/>';
				$('#display_upload_image').html(aSend);
			}
		}
	});
});
//FOR IMAGE END

//FOR VIDEO START
$(document).ready(function(){ //alert('test'); return false;
	var FeedsVideo = $('#feeds_video_1'), interval;
	new AjaxUpload(FeedsVideo, {
		action: "<?php echo SITE_PATH.'business_feeds/upload_video/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var ret = validateVideoExtention(ext);
			if(ret == '0'){
				$('#feeds_result_span').html('<font color="red">Invalid Video!!</font>');
				return false;
			}else
				$('#feeds_result_span').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#feeds_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#feeds_result_span').html('');
			$('#feeds_video').val(response);
			if(response != ''){
				var imageNameArr = response.split('.');
				var imageName = imageNameArr[0]+'.jpg';
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/feeds/video/image/'+imageName+'" style="height:20px; width:30px;"/>';
				$('#display_upload_video').html(aSend);
			}
		}
	});
});
//FOR VIDEO END
</script>
<!-- SCRIPT FOR FILE UPLOADS END -->
<?php } ?>

