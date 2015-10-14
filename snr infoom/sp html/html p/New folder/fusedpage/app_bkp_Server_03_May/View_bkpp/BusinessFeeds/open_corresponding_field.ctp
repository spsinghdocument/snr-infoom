<?php
	if($type == 'feeds_message'){ //for messages
?>
		<div class="tabshowtoparrow">
			<?php echo $this->Html->image('front_end/desh_board_tab_hover_bg.jpg', array('alt'=>''));?>
		</div>
		<div class="tabshowbox">
			<textarea name="post_feeds" id="feeds_message" cols="" rows="" class="commenttextbox" onfocus="clearText(this)" onblur="replaceText(this)" style="resize:none;">Share Your Thoughts</textarea>
		</div>
<?php
	}else if($type == 'feeds_image'){ //For Image Uploading
?>	
	<div align="center">
		Upload Image:
		<input type="file" name="feeds_image_1" id="feeds_image_1">		
		<input type="hidden" id="feeds_image" value="">
		<div style="float:right; margin-right:30px;" id="display_upload_image"></div>
	</div>		
<?php }else if($type == 'feeds_link'){?>
	<div>
		Embed Code:
		<div class="tabshowbox">
			<textarea name="feeds_link" id="feeds_link" cols="" rows="" class="commenttextbox" style="resize:none;"></textarea>
		</div>
	</div>
<?php }else if($type == 'feeds_video'){ ?>
	<div align="center">
		Upload FLV File:
		<input type="file" name="feeds_video_1" id="feeds_video_1">		
		<input type="hidden" id="feeds_video" value="">
		<div style="float:right; margin-right:30px;" id="display_upload_video"></div>
	</div>
<?php } ?>






<!-- SCRIPTS FOR IMAGE UPLOAD START -->
<?php if($type == 'feeds_image'){?>
<script type="text/javascript">
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#feeds_image_1'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'business_feeds/upload_image/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#feeds_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#feeds_result_span').html('');
			$('#feeds_link').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/feeds/'+response+'" style="height:20px; width:20px;"/>';
				$('#display_upload_image').html(aSend);
			}
		}
	});
});
</script>
<?php } if($type == 'feeds_video'){?>
<script type="text/javascript">
$(document).ready(function(){ //alert('test'); return false;
	var FeedsVideo = $('#feeds_video_1'), interval;
	new AjaxUpload(FeedsVideo, {
		action: "<?php echo SITE_PATH.'business_feeds/upload_video/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#feeds_result_span').html(bSend);
		},
		onComplete: function(file, response){
			$('#feeds_result_span').html('');
			$('#feeds_video').val(response);
			/*if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/feeds/'+response+'" style="height:20px; width:20px;"/>';
				$('#display_upload_image').html(aSend);
			} */
		}
	});
});
</script>
<?php } ?>
<!-- SCRIPTS FOR IMAGE UPLOAD END -->