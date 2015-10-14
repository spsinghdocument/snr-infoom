<?php //pr($businessArr);die;
	//echo $type;die;
?>

<!-- PAGE LEFT PART START -->
<div class="popupflimg">
<?php
if($type == 'v'){ //For Video
	//validate Video
	$videoUrl = '../webroot/img/front_end/groups/recents/video/flv/'.$businessArr['BusinessFeed']['video'].'.flv';
	if(is_file($videoUrl)){
		echo $this->Html->script('flowplayer/flowplayer-3.2.6.min');
		$player = SITE_PATH.'js/flowplayer/swf/flowplayer-3.2.7.swf';

		$playerVideo = SITE_PATH.'img/front_end/groups/recents/video/flv/'.$businessArr['BusinessFeed']['video'].'.flv';

		//validate the Video Image
		$videoImageUrl = '../webroot/img/front_end/groups/recents/video/image/'.$businessArr['BusinessFeed']['video'].'.jpg';
		if(is_file($videoImageUrl))
			$playerVideoImage = SITE_PATH.'img/front_end/groups/recents/video/image/'.$businessArr['BusinessFeed']['video'].'.jpg';
		else
			$playerVideoImage = SITE_PATH.'img/front_end/business/noimage.jpg';
?>
<div id="player1" style="height:400px;"></div>

<script type="text/javascript">
flowplayer("player1", "<?php echo $player;?>",{
	playlist : [{
		url: "<?php echo $playerVideoImage;?>",
		scaling: 'fit'
	},
	{
		url: "<?php echo $playerVideo;?>",
		autoPlay: true,
		autoBuffering: true
	}]
});
</script>
<?php
		}else{
?>
<div style="text-align:center; color:#FF0000; margin:130px 0;">Sorry!! The video is not available!!</div>
<?php
		}
}else if($type == 'i'){
	//FOR IMAGE START
	$imageUrl = '../webroot/img/front_end/groups/recents/'.$businessArr['BusinessFeed']['image'];
	if(is_file($imageUrl)){
		$imagePath = 'front_end/groups/recents/'.$businessArr['BusinessFeed']['image'];		
?>
	<div style="width:100%; background-color:#FFFFFF; text-align:center;">
		<?php
			list($image_width, $image_height) = getimagesize($imageUrl);

			if($image_width > 490)
				echo $this->Image->resize($imagePath, 485, 450, array('alt'=>''));
			else
				echo $this->Html->image($imagePath, array('alt'=>''));
		?>
	</div>
<?php
	}else{
?>
<div style="text-align:center; color:#FF0000; margin:130px 0;">Sorry!! The image is not available!!</div>
<?php
	}
}
?>
</div>
<!-- PAGE LEFT PART END -->

<!-- PAGE RIGHT PART START -->
<div class="popupimgfr">
	<div class="fl">
		<?php 
			$businessImage = 'front_end/business/noimage.jpg';
				if($businessArr['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$businessArr['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$businessArr['User']['image'];
						
				}
			echo $this->Image->resize($businessImage, 59, 48, array('alt'=>''));
		?>
	</div>
	<div class="popupfrtextbox">
		<div class="popupfrtext"><a href="javascript:void(0);"><?php echo $businessArr['User']['first_name']." ".$businessArr['User']['last_name'];?></a></div>
		<div class="graytext"><?php echo $businessArr['User']['city'];?></div>
	</div>
	<div class="clr"></div>
	<div class="popupfrtotext">
		<?php echo $businessArr['BusinessFeed']['message'];?>
	</div>
	<div class="popupfrlink"><!-- <a href="javascript:void(0);">Recommend</a>| --><a href="javascript:void(0);">Comment</a></div>

<!-- Comment Start -->
				<div class="coomentlinbox" id="comment_div" style="border:none;">
				<?php $commentArr = $this->Fused->fetchAllComments($businessArr['BusinessFeed']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
				$businessImage = 'front_end/business/noimage.jpg';
				if($comment['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$comment['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$comment['User']['image'];
						
				} ?>
				<table id="business_comment_<?php echo $comment['Comment']['id'];?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
				<tr>
					<td style="width:10%"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?></td>

					<td><?php echo $comment['Comment']['comment']; ?>
					<?php if($this->Session->read('Auth.User.User.id') == $comment['Comment']['user_id']){ ?>
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['Comment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentFeed('<?php echo $comment['Comment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?>
					</td>

				</tr>
				</table>
				<?php } } ?>
				</div>
				
<!-- Comment End -->


	<span id="roller"></span>
	<div class="inputboxmain">
		<div class="inputboxfllogo">
			<?php 
					//PROFILE AVATAR START
						if($this->Session->read('Auth.User.User.gender') == '1')
							$avatar = 'front_end/users/male.jpg';
						else
							$avatar = 'front_end/users/female.jpg';

						if(($this->Session->read('Auth.User.User.image')) != ''){
								$realPath = '../webroot/img/front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
							if(is_file($realPath)){
								$avatar = 'front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
							}
						}

						echo $this->Image->resize($avatar, 32, 32, array('alt'=>''));
					//PROFILE AVATAR END
			?>
		</div>
		<div class="inputboxlogofr"><input type="text" value="" name="feed_comment" id="feed_comment"/></div>
		<div class="clr"></div>

		<div class="pstbtn" onclick="saveComment('<?php echo $businessArr['BusinessFeed']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
	</div>
</div>
<!-- PAGE RIGHT PART END -->
<div class="clr"></div>


<script language="text/javascript">
function saveComment(feed_id){
	var comment = $('#feed_comment').val();
	var business_feeds_id = "<?php echo $businessArr['BusinessFeed']['id']; ?>";
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/saveComment/';?>",
				data: "business_feeds_id="+business_feeds_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#roller').html(bSend);
				},
				success: function(response){
						$('#roller').html('');
						$('#feed_comment').val('');
						$('#comment_div').append(response);
						
					}
			});
	}
}


function deleteCommentFeed(comment_id){
	if(comment_id != ''){
		var conf = confirm("Do you want to delete this Comment?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/delete_comment_data/';?>",
				data: "comment_id="+comment_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#roller_'+comment_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#roller_'+comment_id).html('');
						$('#business_comment_'+comment_id).html('');
						$('#business_comment_'+comment_id).hide();
					}
				}
			});
			//send Ajax for Deleting End
		}
	}
}
</script>