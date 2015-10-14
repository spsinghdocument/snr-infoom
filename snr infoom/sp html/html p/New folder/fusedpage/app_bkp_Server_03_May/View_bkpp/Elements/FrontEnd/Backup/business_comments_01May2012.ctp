<?php
	if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){
		$business_id = $this->Fused->decrypt($this->params['pass'][0]);
?>
<div class="usermidtopbox">
	<ul class="deshboardtoplink">
		<li><a href="javascript:void(0);" style="padding-left:0;"><?php echo $this->Html->image('front_end/gray_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("feeds_message");', 'title'=>'Comment'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/camera_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("feeds_image");', 'title'=>'Image'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/vedio_icon.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("feeds_video");', 'title'=>'Video'));?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/blue_clip_img.jpg', array('alt'=>'', 'onclick'=>'return manage_feeds_tabs("feeds_link");', 'title'=>'Embed Code'));?></a></li>
	</ul>
	<div class="clr"></div>

	<div class="tabshowmainbox">
		<!-- FOR BUSINESS COMMENTS START -->
		<div id="business_feeds_posting_container">
			<div class="tabshowtoparrow">
				<?php echo $this->Html->image('front_end/desh_board_tab_hover_bg.jpg', array('alt'=>''));?>
			</div>
			<div class="tabshowbox">
				<textarea name="post_feeds" id="feeds_message" cols="" rows="" class="commenttextbox" onfocus="clearText(this)" onblur="replaceText(this)" style="resize:none;">Share Your Thoughts</textarea>
			</div>
		</div>
		<input type="hidden" id="post_type" value="feeds_message">
		<!-- FOR BUSINESS COMMENTS END -->
	</div>

	<div>
		<div class="sociallinkbox">
			<input name="" type="checkbox" value="" class="checkbox" />
			<a href="javascript:void(0);" class="soicallink"><?php echo $this->Html->image('front_end/google_plus_logo.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>

			<input name="" type="checkbox" value="" class="checkbox" />
			<a href="javascript:void(0);" class="soicallink"><?php echo $this->Html->image('front_end/twitter_logo.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>
			
			<input name="" type="checkbox" value="" class="checkbox" />
			<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/face_book_logo_inside.jpg', array('alt'=>'', 'class'=>'sociallogo'));?></a>
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
function manage_feeds_tabs(type){
	$('#post_type').val(type);

	//send Ajax For the corresponding container start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_feeds/open_corresponding_field/';?>",
		data: "type="+type,
		beforeSend:function(){
			var bSend = '<div style="text-align:center; color:#0171C3;"><?php echo $this->Html->image("ajax/bar.gif", array("alt"=>""));?></div>';
			$('#business_feeds_posting_container').html(bSend);
		},
		success: function(response){
			$('#business_feeds_posting_container').html(response);
		}
	});
}

function validate_business_post(){
	var business_id = "<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>";
	var post_type = $('#post_type').val();
	var post_content = $('#'+post_type).val();

	if((post_content != '') && (post_content != 'Share Your Thoughts')){
		//send Ajax For Posting Feeds
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_feeds/post_feed/';?>",
			data: "business_id="+business_id+"&post_type="+post_type+"&post_content="+post_content,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
				$('#feeds_result_span').html(bSend);
			},
			success: function(response){
				if(response == 'saved'){
					$('#'+post_type).val('');
					$('#feeds_result_span').html('');
					window.location.reload();
				}else{
					$('#feeds_result_span').html(response);
				}
			}
		});
	}
}
</script>
<?php } ?>

