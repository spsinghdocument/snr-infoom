<?php //pr($businessArr);die;
echo $this->Html->script('validation/jquery-1.7.2.min');
	/*------------------ MESSAGE START --------------------*/
	//set the message section, with link
	$msg = '';
	if($businessArr['BusinessFeed']['link'] != ''){
		$msg .= '<a href="'.$businessArr['BusinessFeed']['link'].'" target="_blank" style="text-decoration:none; color:#000000;">';
	}
	$msg .= $businessArr['BusinessFeed']['message'];
	if($businessArr['BusinessFeed']['link'] != ''){
		$msg .= '</a>';
	}

	//decide the location
	$side = 'center';
	if(($businessArr['BusinessFeed']['image'] != '') || ($businessArr['BusinessFeed']['video'] != '')){
		$side = 'left';
	}
	/*------------------ MESSAGE END --------------------*/

	/*------------------ IMAGE START --------------------*/
	//set image section,
	$image = '';
	if($businessArr['BusinessFeed']['image'] != ''){
		$imageUrl = '../webroot/img/front_end/';
		if($businessArr['BusinessFeed']['user_id'] != ''){ // if from user feeds
			$imageUrl .= 'business/feeds/';
		}elseif($businessArr['BusinessFeed']['business_id'] != ''){ // if from business
			$imageUrl .= 'business/feeds/';
		}elseif($businessArr['BusinessFeed']['group_id'] != ''){// if from group
			$imageUrl .= 'groups/recents/';
		}
		$imageUrl .= $businessArr['BusinessFeed']['image'];
	}
	/*------------------ IMAGE END --------------------*/

	/*------------------ VIDEO START --------------------*/
	$videoUrl = '';
	if($businessArr['BusinessFeed']['video'] != ''){
		$videoUrl = '../webroot/img/front_end/';
		$videoImage = '../webroot/img/front_end/';

		if($businessArr['BusinessFeed']['user_id'] != ''){ // if from user feeds
			$videoUrl .= 'business/feeds/video/flv/';
			$videoImage .= 'business/feeds/video/image/';
		}elseif($businessArr['BusinessFeed']['business_id'] != ''){ // if from business
			$videoUrl .= 'business/feeds/video/flv/';
			$videoImage .= 'business/feeds/video/image/';
		}elseif($businessArr['BusinessFeed']['group_id'] != ''){// if from group
			$videoUrl .= 'groups/recents/video/flv/';
			$videoImage .= 'groups/recents/video/image/';
		}
		$videoUrl .= $businessArr['BusinessFeed']['video'].'.flv';
		$videoImage .= $businessArr['BusinessFeed']['video'].'.jpg';
	}
	/*------------------ VIDEO END   --------------------*/

	/*-------------------- POSTED BY SECTION START ---------------*/
	$postedBy = '';
	$postedName = '';
	$postlocation = '';
	if($businessArr['BusinessFeed']['image'] != ''){
		$postedBy = '../webroot/img/front_end/';
		if($businessArr['BusinessFeed']['user_id'] != ''){ // if from user feeds
			$postedBy .= 'users/profile/'.$businessArr['User']['image'];
			$postedName = $businessArr['User']['first_name'].' '.$businessArr['User']['last_name'];
			$postlocation = $businessArr['User']['city'].', '.$businessArr['User']['state'];
		}elseif($businessArr['BusinessFeed']['business_id'] != ''){ // if from business
			$postedBy .= 'business/'.$businessArr['Business']['image'];
			$postedName = $businessArr['Business']['title'];
		}elseif($businessArr['BusinessFeed']['group_id'] != ''){// if from group
			$postedBy .= 'groups/'.$businessArr['Group']['image'];
			$postedName = $businessArr['Group']['title'];
		}
	}
	/*-------------------- POSTED BY SECTION END   ---------------*/
?>

<div style="margin-bottom:30px;">&nbsp;</div><div class="clr"></div>

<!-- LEFT SECTION START -->
<div class="popupflimg" style="background-color:#FFFFFF;">
	<?php
	if($side == 'center'){ //for only message
		echo $msg;
	}else{ // for video and image
		if($businessArr['BusinessFeed']['image'] != ''){ //For Image
			if(is_file($imageUrl)){
				$image = str_replace('../webroot/img/', '', $imageUrl);
	?>
			<div style="width:100%; background-color:#FFFFFF; text-align:center;">
				<?php
					list($image_width, $image_height) = getimagesize($imageUrl);

					if($image_width > 490)
						echo $this->Image->resize($image, 485, 450, array('alt'=>''));
					else
						echo $this->Html->image($image, array('alt'=>''));
				?>
			</div>
	<?php
			}else{
	?>
			<div style="text-align:center;">Sorry!! The image is no longer available!!</div>
	<?php
			}
		} //image section end

		if($businessArr['BusinessFeed']['video'] != ''){ //For video
			if(is_file($videoUrl)){
				echo $this->Html->script('flowplayer/flowplayer-3.2.6.min');
				$player = SITE_PATH.'js/flowplayer/swf/flowplayer-3.2.7.swf';

				$pVideo = str_replace('../webroot/', '', $videoUrl);

				$playerVideo = SITE_PATH.$pVideo;

				//validate the Video Image
				if(is_file($videoImage)){
					$pVImg = str_replace('../webroot/', '', $videoImage);
					$playerVideoImage = SITE_PATH.$pVImg;
				}else
					$playerVideoImage = SITE_PATH.'img/front_end/business/noimage.jpg';
		?>
		<div id="player1" style="height:400px; margin-top:20px;"></div>

		<script type="text/javascript">
		flowplayer("player1", "<?php echo $player;?>",{
			playlist : [{
				url: "<?php echo $playerVideoImage;?>",
				scaling: 'fit'
			},
			{
				url: "<?php echo $playerVideo;?>",
				autoPlay: false,
				autoBuffering: true
			}]
		});
		</script>
		<?php
				}else{
		?>
		<div style="text-align:center;">Sorry!! The video is no longer available!!</div>
		<?php
				}
		}// video section end
	}
	?>
</div>
<!-- LEFT SECTION END -->


<div class="popupimgfr">
	<!-- POSTED BY SECTION START -->
	<div class="fl">
		<?php 
			if(is_file($postedBy))
				$postedBy = str_replace('../webroot/img/', '', $postedBy);
			else
				$postedBy = 'front_end/business/noimage.jpg';
			echo $this->Image->resize($postedBy, 59, 48, array('alt'=>''));
		?>
	</div>
	<!-- POSTED BY SECTION END -->

	<div class="popupfrtextbox">
		<div class="popupfrtext"><a href="javascript:void(0);"><?php echo $postedName;?></a></div>
		<div class="graytext"><?php echo $postlocation;?></div>
	</div>
	<div class="clr"></div>
	
	<?php if($side != 'center'){?>
	<div class="popupfrtotext">
		<?php echo $msg;;?>
	</div>
	<?php } ?>

<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
	<div class="popupfrlink"><!-- <a href="javascript:void(0);">Recommend</a>| --><a href="javascript:void(0);">Comment</a></div>
<?php } ?>


	<!-- Comment Start -->
				<div class="coomentlinbox" id="comment_div" style="border:none;">
				<?php $commentArr = $this->Fused->fetchAllComments($businessArr['BusinessFeed']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
				//$businessImage = 'front_end/business/noimage.jpg';
				if($this->Session->read('Auth.User.User.gender') == '1')
							$businessImage = 'front_end/users/male.jpg';
						else
							$businessImage = 'front_end/users/female.jpg';
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
<span id="content_roller"></span>
	
<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
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
		<div class="inputboxlogofr"><input type="text" value="" name="feed_content_comment" id="feed_content_comment"/></div>
		<div class="clr"></div>

		<div class="pstbtn" onclick="saveFeedContentComment('<?php echo $businessArr['BusinessFeed']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
	</div>
<?php } ?>


</div>
<div class="clr"></div>

<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
<script type="text/javascript">
function saveFeedContentComment(feed_id){
	var comment = $('#feed_content_comment').val();
	var business_feeds_id = "<?php echo $businessArr['BusinessFeed']['id']; ?>";
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/saveComment/';?>",
				data: "business_feeds_id="+business_feeds_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#content_roller').html(bSend);
				},
				success: function(response){
						$('#content_roller').html('');
						$('#feed_content_comment').val('');
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
<?php } ?>