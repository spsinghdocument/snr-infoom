
<div id="pulic_1">
	<!-- BUSINESS RECENT ACTIVITY START -->
	<?php echo $this->Element('FrontEnd/group_recent_comment');?>
	<!-- BUSINESS RECENT ACTIVITY END -->
<div class="deshboardmidlink" style="background:none; height:0px; margin-top:0px; padding-top:0px;"></div>

<?php
		$feedsArr = $this->Fused->fetchGroupsRecentFeeds($this->Fused->decrypt($this->params['pass'][0]));
		//pr($feedsArr);
		if(!empty($feedsArr)){
?>

<div id="group_recents_main_container">
<?php
			foreach($feedsArr as $feed){ //pr($feed);die;
				$businessImage = 'front_end/business/noimage.jpg';
				if($feed['GroupUser']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$feed['GroupUser']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$feed['GroupUser']['image'];
						
				}
				
	?>
	<div class="deshlistbox" id="group_recent_<?php echo $feed['BusinessFeed']['id'];?>">
		<div class="deshboadflimg">
			<?php echo $this->Image->resize($businessImage, 59, 59, array('alt'=>''));?>
		</div>

		<div class="deshboarlistfrbox">
			<!-- DELETE SECTION START -->
			<?php if($this->Fused->validateUserForGroup($feed['Group']['id']) == $feed['BusinessFeed']['group_user_id']){?>
			<span style="float:right;" id="delete_span_<?php echo $feed['BusinessFeed']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteGroupFeed('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a></span>
			<?php } ?>
			<!-- DELETE SECTION END -->
			<div class="busnissimgfrhd"><a href="javascript:void(0);"><?php echo $feed['User']['first_name']." ".$feed['User']['last_name'];?></a></div>

			<div class="deshtextsml"><?php echo $feed['User']['city'];?></div>
			<div class="deshboardbluetext" style="overflow:hidden;">
				<?php
					if($feed['BusinessFeed']['message'] != ''){ //comment
					//If link available, then add link
					/* if($feed['BusinessFeed']['link'] != ''){
						echo '<a href="'.$feed['BusinessFeed']['link'].'" target="_blank" style="text-decoration:none;">';
					} */
				?>
					<!-- <div <?php if($feed['BusinessFeed']['link'] != ''){echo 'style="color:#1564A6;"';}else{echo 'style="color:#000000;"';}?>><?php echo $feed['BusinessFeed']['message'];?></div> -->
					<div style="color:#000000;"><?php echo $feed['BusinessFeed']['message'];?></div>
				<?php
					/* if($feed['BusinessFeed']['link'] != ''){
						echo '</a>';
					} */
				?>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php						
					}
				?>
					<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['image_caption'];?></div>
				<?php

					if($feed['BusinessFeed']['image'] != ''){ //Image
						$imagePath = '../webroot/img/front_end/groups/recents/'.$feed['BusinessFeed']['image'];
						if(is_file($imagePath)){
							$image = 'front_end/groups/recents/'.$feed['BusinessFeed']['image'];
				?>
							<div style="width:100%; text-align:center;"><?php 
							list($image_width, $image_height) = getimagesize($imagePath);
							if($image_width > 370)
								echo $this->Html->link($this->Image->resize($image, 370, 250, array('alt'=>'')), '/groups/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							else
								echo $this->Html->link($this->Html->image($image, array('alt'=>'')), '/groups/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							?></div>
							<div class="clr" style="margin-bottom:10px;"></div>
				<?php		
						}
					}

					if($feed['BusinessFeed']['link'] != ''){ //Embed Code
				?>
					<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['link_caption'];?></div>
					<div><a href="<?php echo $this->Fused->validateLink($feed['BusinessFeed']['link']);?>" target="_blank" style="text-decoration:none; color:#006EBD;"><?php echo $feed['BusinessFeed']['link'];?></a></div>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php	
					}

				?>
					<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['video_caption'];?></div>
				<?php

					if($feed['BusinessFeed']['video'] != ''){ //Video
						$imagePath = '../webroot/img/front_end/groups/recents/video/flv/'.$feed['BusinessFeed']['video'].'.flv';
						if(is_file($imagePath)){
							$videoDefaultImagePath = 'front_end/business/noimage.jpg';
							$videoImageRealPath = '../webroot/img/front_end/groups/recents/video/image/'.$feed['BusinessFeed']['video'].'.jpg';
							if(is_file($videoImageRealPath))
								$videoDefaultImagePath = 'front_end/groups/recents/video/image/'.$feed['BusinessFeed']['video'].'.jpg';
					?>
						<div>
							<div class="play">
								<?php echo $this->Html->link($this->Html->image('front_end/play.png', array('alt'=>'')), '/groups/view_content/v/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));?>
							</div>
							<?php echo $this->Image->resize($videoDefaultImagePath, 370, 250, array('alt'=>''));?>
						</div>
						<div class="clr"></div>
					<?php
						}
					}

					/*------  YOUTUBE / VIMEO SECTION START ------------*/
					if($feed['BusinessFeed']['youtube_link'] != ''){
						if($feed['BusinessFeed']['youtube_type'] == 'Youtube'){ // FOR YOUTUBE
							$src = str_replace('watch?v=', 'embed/', $feed['BusinessFeed']['youtube_link']);
				?>
							<iframe width="370" height="300" src="<?php echo $src;?>" frameborder="0" allowfullscreen></iframe>
				<?php
						}elseif($feed['BusinessFeed']['youtube_type'] == 'Vimeo'){
							$src = str_replace('//vimeo.com/', '//player.vimeo.com/video/', $feed['BusinessFeed']['youtube_link']);	
				?>
						<iframe src="<?php echo $src;?>" width="370" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<?php
						}
					}
					/*------  YOUTUBE / VIMEO SECTION END ------------*/
				?>
			</div>
			<div class="deshboardwhitebox" style="padding-top:0px;">

				<div class="coomentlinbox" style="border-top:none;">
					
					<div class="commentfrlink"><a href="javascript:void(0);">Comments</a></div>
					<div class="clr"></div>
				</div>
<!-- Comment Start -->
				<div class="coomentlinbox" id="comment_div_<?php echo $feed['BusinessFeed']['id'];?>" style="border:none;">
				<?php $commentArr = $this->Fused->fetchAllGroupComments($feed['BusinessFeed']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
				$businessImage = 'front_end/business/noimage.jpg';
				if($comment['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$comment['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$comment['User']['image'];
						
				} ?>
				<table id="group_comment_<?php echo $comment['GroupComment']['id'];?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
				<tr>
					<td style="width:10%"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?></td>

					<td><?php echo $comment['GroupComment']['comment']; ?>
					<?php if($this->Session->read('Auth.User.User.id') == $comment['GroupComment']['user_id']){ ?>
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['GroupComment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentGroup('<?php echo $comment['GroupComment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?>
					</td>

				</tr>
				</table>
				<?php } } ?>
				</div>
				<span id="group_roller_<?php echo $feed['BusinessFeed']['id'];?>"></span>
<!-- Comment End -->
				<div>
					<div class="commentflimg"><!-- <?php echo $this->Html->image('front_end/comment_fl_img.jpg', array('alt'=>''));?> -->
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
					<div class="commentfrboxmain">
						<div class="commetarrow"><?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?></div>
						<textarea name="group_comment", id="group_comment_<?php echo $feed['BusinessFeed']['id'];?>", cols="" rows="" class="commentfrbox" style="resize:none;"></textarea>
					</div>
					<div class="clr"></div>
				</div>
			</div>
			
		</div>
		<div class="clr"></div>

<input type="hidden" id="group_recents_<?php echo $feed['BusinessFeed']['id'];?>" value="<?php echo $feed['BusinessFeed']['id'];?>" >

		<div class="pstbtn" onclick="saveComment('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>

	<?php if(empty($feedsArr)){?>
	</div>
	<?php } ?>
		
	</div>
	<?php } } else { ?>
		<div style="margin-left:150px; color:red;">No Groups Feed Available!</div>
	<?php } ?>

</div>
<?php if(!empty($feedsArr)){?>
</div>
<?php } ?>


<script type="text/javascript">
function deleteGroupFeed(feed_id){
	if(feed_id != ''){
		var conf = confirm("Do you want to delete this Feed?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'groups/delete_feeds_data/';?>",
				data: "feed_id="+feed_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#delete_span_'+feed_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#group_recent_'+feed_id).html('');
						$('#group_recent_'+feed_id).hide();
					}else
						$('#delete_span_'+feed_id).html(response);
				}
			});
			//send Ajax for Deleting End
		}
	}
}

function saveComment(group_id){
	var comment = $('#group_comment_'+group_id).val();
	var group_feed_id = $('#group_recents_'+group_id).val();
	var group_recents_id = "<?php echo $feed['BusinessFeed']['group_id']; ?>";
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'groups/saveComment/';?>",
				data: "group_recents_id="+group_recents_id+"&group_feed_id="+group_feed_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#group_roller_'+group_id).html(bSend);
				},
				success: function(response){
						$('#group_roller_'+group_id).html('');
						$('#group_comment_'+group_id).val('');
						$('#comment_div_'+group_id).append(response);
						
					}
			});
	}
}


function deleteCommentGroup(comment_id){
	if(comment_id != ''){
		var conf = confirm("Do you want to delete this Comment?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'groups/delete_group_comment/';?>",
				data: "comment_id="+comment_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#group_roller_'+comment_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#group_roller_'+comment_id).html('');
						$('#group_comment_'+comment_id).html('');
						$('#group_comment_'+comment_id).hide();
					}
				}
			});
			//send Ajax for Deleting End
		}
	}
}

function recommended(recommended_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'recommendeds/add_recommended/';?>",
				data: "recommended_id="+recommended_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#roller1_'+recommended_id).html(bSend);
				},
				success: function(response){
						$('#roller1_'+recommended_id).html('');
						$('#recommended_'+recommended_id).html(response);
						$('#like_'+recommended_id).hide();
						
				}
			});
	}
}

function recommendedImage(feed_id, user_id){
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'recommendeds/fetch_user_image/';?>",
				data: "feed_id="+feed_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				},
				success: function(response){
						$('#image_'+feed_id).html('');
						$('#image1_'+feed_id).append(response);
				}
			});
	}
}
</script>
