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
			<div style="float:left; margin-left:82px;">
				Caption:
				<input type="text" name="image_caption" id="image_caption" style="border:1px solid #CDCDCD; color:#909090; height:20px; width:230px;" class="feeds_input">
			</div>
			<div class="clr"></div>
			<div align="center" style="margin-top:10px;">
				Upload Image:
				<input type="file" name="feeds_image_1" id="feeds_image_1">		
				<input type="hidden" id="feeds_image" value="" class="feeds_input">
				<div style="float:right; margin-right:30px;" id="display_upload_image"></div>
			</div>	
		</div>
		<!-- FOR BUSINESS FEEDS IMAGE END -->

		<!-- FOR BUSINESS FEEDS VIDEO START -->
		<div class="business_feeds" id="business_feeds_video_container" style="display:none;">
			<div style="float:left; margin-left:82px;">
				Caption:
				<input type="text" name="video_caption" id="video_caption" style="border:1px solid #CDCDCD; color:#909090; height:20px; width:230px;" class="feeds_input">
			</div>
			<div class="clr"></div>
			<div align="center" style="margin-top:10px;">
				Upload FLV File:
				<input type="file" name="feeds_video_1" id="feeds_video_1">		
				<input type="hidden" id="feeds_video" value="" class="feeds_input">
				<div style="float:right; margin-right:30px;" id="display_upload_video"></div>
				<div class="clr"></div>

				<!-- YOUTUBE / VIMEO START -->
				<div style="margin-top:10px;">
					<input type="radio" name="you_vim" class="yv_radio" value="Youtube" checked>Youtube
					<input type="radio" name="you_vim" class="yv_radio" value="Vimeo">Vimeo
					<input type="text" name="youtube_vimeo" id="youtube_vimeo" style="border:1px solid #CDCDCD; color:#909090; height:20px; width:230px;" class="feeds_input">
				</div>
				<!-- YOUTUBE / VIMEO END -->
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

				<div style="float:left; margin-left:60px;">
					Caption:
					<input class="feeds_input" type="text" name="link_caption" id="link_caption" style="border:1px solid #CDCDCD; color:#909090; height:20px; width:280px;">
				</div>
				<div class="clr"></div>
				<div align="center" style="margin-top:10px;">
					Add Link:
					<input type="text" name="feeds_link" id="feeds_link" class="feeds_input" style="border:1px solid #CDCDCD; color:#909090; height:20px; width:280px;">
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
			<a href="<?php echo SITE_PATH.'users/login_twitter/';?>" class="soicallink"><?php echo $this->Html->image('front_end/twitter_logo.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>

			<?php	$facebookCheckBox = '';
				$facebookChecked = 'checked="checked"';
				if($socialsValidate['facebook'] == ''){
					$facebookCheckBox = 'disabled="disabled"';
					$facebookChecked = '';
					$errorMsg .= ' Facebook ';
				}
			?>			
			<input name="" type="checkbox" value="facebook" class="checkbox social_media" <?php echo $facebookCheckBox.$facebookChecked;?>/>
			<a href="<?php echo SITE_PATH.'users/login_facebook/';?>"><?php echo $this->Html->image('front_end/face_book_logo_inside.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>
			<div class="clr"></div>	

			<?php if($errorMsg != ''){?>
			<div style="color:#FF0000; margin-top:5px; font-size:10px;">
				Authenticate your <?php echo $errorMsg;?> Account.
			</div>
			<?php } ?>
		</div>

		<div class="signinboxin" style="width:150px;">

		<div style="float:left; margin-left:20px;"><select id="visiblity"><option value="public">Public</option><option value="friend">Friend</option><option value="me">Me</option></select></div>


			<span style="float:left;" id="feeds_result_span"></span>
			<div class="btnimage fr">
				<a href="javascript:void(0);" onclick="return validate_business_post();"><span>Post</span></a>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>						
	</div>
</div>

<!-- Start for User Comments (Saurabh 5/6/2013)-->
<!-- Start for User End (Saurabh 5/6/2013)-->

<script type="text/javascript">
function manage_feeds_tabs(tab){
	$('.business_feeds').hide();
	$('#'+tab).show();
}

function validateFeedsPostingSocialNetworks(socialMedias){
	if(socialMedias != ''){
		var socialTwitter = "<?php echo $this->Session->read('Auth.User.User.social_twitter');?>";
		var socialFacebook = "<?php echo $this->Session->read('Auth.User.User.social_facebook');?>";
		var postFeeds = "<?php echo $this->Session->read('Auth.User.User.social_post_feeds');?>";

		var posting = '0';
		if(socialTwitter  == '1')
			posting = '1';
		if(socialFacebook  == '1')
			posting = '1';

		if((postFeeds == 0) && (posting == 1)){
			var conf = confirm('Your feed will not be posted to social medias as you have not given permission in Account Settings!');
			if(conf == false){
				$('#feeds_result_span').html('');
				return false;
			}else{
				return true;
			}
		}
	}
}

function validate_business_post(){
	var flag = '0';
	$('.feeds_input').each(function(){
		if($(this).val() != '')
			flag = '1'
	});

	//SOCIAL MEDIA SECTION
	var social_medias = '';
	$('.social_media').each(function(){
		if($(this).attr('checked') == 'checked'){
			social_medias += $(this).val()+',';
		}
	});

	//FOR YOUTUBE/VIMEO
	var youtube_link = $('#youtube_vimeo').val();
	var yotube_type = '';
	if(youtube_link != ''){
		$('.yv_radio').each(function(){
			if($(this).attr('checked') == 'checked'){
				yotube_type = this.value;
			}
		});
	}

	if(flag == '1'){
		//authenticate social networks
		validateFeedsPostingSocialNetworks(social_medias);

		var visibility = $('#visiblity').val();
		var user_id = "<?php echo $this->Session->read('Auth.User.User.id');?>";
		var image = $('#feeds_image').val();
		var image_caption = $('#image_caption').val();
		var video = $('#feeds_video').val();
		var video_caption = $('#video_caption').val();
		var link = $('#feeds_link').val();
		var link_caption = $('#link_caption').val();
		var message = $('#feeds_message').val();

		//send ajax for saving the data start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_feeds/save_user_feeds_data/';?>",
			data: "user_id="+user_id+"&image="+image+"&video="+video+"&link="+link+"&message="+message+"&social_medias="+social_medias+"&visibility="+visibility+"&image_caption="+image_caption+"&video_caption="+video_caption+"&link_caption="+link_caption+"&youtube_link="+youtube_link+"&yotube_type="+yotube_type,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#feeds_result_span').html(bSend);
			},
			success: function(response){
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
$(document).ready(function(){ //alert('test1'); return false;
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