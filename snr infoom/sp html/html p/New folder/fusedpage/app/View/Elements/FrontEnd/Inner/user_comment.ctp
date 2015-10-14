<div id="business_div">
<div id="pulic_1">

	<div class="clr" style="margin-top:10px;"></div>
	
	<?php //echo '+++ '.$this->Session->read('Auth.User.User.id');
		$feedsArr = $this->Fused->fetchUsersRecentFeeds($page); //pr($feedsArr);die;
		if(!empty($feedsArr)){
?>
<div id="business_feeds_main_container">
<?php
			foreach($feedsArr as $feed){ //pr($feed);//die;
			$show = $this->Fused->validateTheUserFeed($feed['BusinessFeed']['visibility'], $page, $feed['User']['id']);
				if($show == 'show'){
			if($feed['BusinessFeed']['user_id'] != ''){ // for user
				$businessImage = 'front_end/business/noimage.jpg';
				if($feed['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$feed['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$feed['User']['image'];
				}
				$profileUrl = SITE_PATH.'users/profile/'.$feed['User']['username'].'/';
				$feedTitle = $feed['User']['first_name'].' '.$feed['User']['last_name'];
				$feedLocation = $feed['User']['city'];
			} else if($feed['BusinessFeed']['group_id'] != ''){ //for group
					$businessImage = 'front_end/business/noimage.jpg';
					if($feed['Group']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/groups/'.$feed['Group']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/groups/'.$feed['Group']['image'];	
				}
				$profileUrl = SITE_PATH.'groups/details/'.$this->Fused->encrypt($feed['Group']['id']).'/'.$feed['Group']['alias_name'].'/';
				$feedTitle = $feed['Group']['title'];
				$feedLocation = $feed['User']['city'];
			} else { //for business
					$businessImage = 'front_end/business/noimage.jpg';
					if($feed['Business']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/business/'.$feed['Business']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/business/'.$feed['Business']['image'];	
				}
				$profileUrl = SITE_PATH.'businesses/details/'.$this->Fused->encrypt($feed['Business']['id']).'/'.$feed['Business']['alias_name'].'/';
				$feedTitle = $feed['Business']['title'];
			}

			//check for normal post
			if($feed['BusinessFeed']['recommend'] == '0'){
				
	?>
	<div class="deshlistbox" id="business_feed_<?php echo $feed['BusinessFeed']['id'];?>">
		<div class="deshboadflimg">
			<?php echo $this->Html->link($this->Image->resize($businessImage, 59, 59, array('alt'=>'')), $profileUrl, array('escape'=>false));?>
		</div>

		<div class="deshboarlistfrbox">
			<!-- DELETE SECTION START -->
			<!-- <?php if($this->Fused->validateUserForBusiness() == $feed['BusinessFeed']['business_id']){?>
			<span style="float:right;" id="delete_span_<?php echo $feed['BusinessFeed']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteBusinesFeed('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a></span>
			<?php } ?> -->
			<!-- DELETE SECTION END -->
			<?php //if($feed['BusinessFeed']['group_id'] == ''){ ?>
				<!-- <div class="busnissimgfrhd"><a href="javascript:void(0);"><?php echo $feed['User']['first_name']." ".$feed['User']['last_name'];?></a></div>
				<div class="deshtextsml"><?php echo $feed['User']['city'];?></div> -->
			<?php //} else { ?>
				<!-- <div class="busnissimgfrhd"><a href="javascript:void(0);">
					<?php echo $this->Html->link($feed['Group']['title'], $profileUrl, array('escape'=>false));?>
				</a></div> -->
			<?php //}?>
		
			
			<div class="busnissimgfrhd">
				<a href="<?php echo $profileUrl;?>"><?php echo $feedTitle;?></a>
			</div>
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
					/*if($feed['BusinessFeed']['link'] != ''){
						echo '</a>';
					} */
				?>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php						
					}

				?>
				<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['image_caption'];?></div>
				<?php
				if($feed['BusinessFeed']['group_id'] == ''){
					if($feed['BusinessFeed']['image'] != ''){ //Image
						$imagePath = '../webroot/img/front_end/business/feeds/'.$feed['BusinessFeed']['image'];
						if(is_file($imagePath)){
							$image = 'front_end/business/feeds/'.$feed['BusinessFeed']['image'];
				?>			
						<div style="width:100%; text-align:center;"><?php 
							list($image_width, $image_height) = getimagesize($imagePath);
							if($image_width > 370)
								echo $this->Html->link($this->Image->resize($image, 370, 250, array('alt'=>'')), '/business_feeds/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							else
								echo $this->Html->link($this->Html->image($image, array('alt'=>'')), '/business_feeds/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							?></div>
							<div class="clr" style="margin-bottom:10px;"></div>
				<?php		
						}
					}
				} else {
					if($feed['BusinessFeed']['image'] != ''){ //Image
						$imagePath = '../webroot/img/front_end/groups/recents/'.$feed['BusinessFeed']['image'];
						if(is_file($imagePath)){
							$image = 'front_end/groups/recents/'.$feed['BusinessFeed']['image'];
				?>
							<div style="width:100%; text-align:center;"><?php 
							list($image_width, $image_height) = getimagesize($imagePath);
							if($image_width > 370)
								echo $this->Html->link($this->Image->resize($image, 370, 250, array('alt'=>'')), '/business_feeds/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							else
								echo $this->Html->link($this->Html->image($image, array('alt'=>'')), '/business_feeds/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));
							?></div>
							<div class="clr" style="margin-bottom:10px;"></div>
				<?php		
						}
					}
				}

				?>
				<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['link_caption'];?></div>
				<?php

					if($feed['BusinessFeed']['link'] != ''){ //Embed Code
				?>
					<div><a href="<?php echo $this->Fused->validateLink($feed['BusinessFeed']['link']);?>" target="_blank" style="text-decoration:none; color:#006EBD;"><?php echo $feed['BusinessFeed']['link'];?></a></div>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php	
					}
				?>
				<div style="font-weight:bold; color:#000000; font-size:11px; margin-bottom:5px;"><?php echo $feed['BusinessFeed']['video_caption'];?></div>
				<?php
				if($feed['BusinessFeed']['group_id'] == ''){
					if($feed['BusinessFeed']['video'] != ''){ //Video
						$imagePath = '../webroot/img/front_end/business/feeds/video/flv/'.$feed['BusinessFeed']['video'].'.flv';
						if(is_file($imagePath)){
							$videoDefaultImagePath = 'front_end/business/noimage.jpg';
							$videoImageRealPath = '../webroot/img/front_end/business/feeds/video/image/'.$feed['BusinessFeed']['video'].'.jpg';
							if(is_file($videoImageRealPath))
								$videoDefaultImagePath = 'front_end/business/feeds/video/image/'.$feed['BusinessFeed']['video'].'.jpg';
					?>
						<div>
							<div class="play">
								<?php echo $this->Html->link($this->Html->image('front_end/play.png', array('alt'=>'')), '/business_feeds/view_content/v/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));?>
							</div>
							<?php echo $this->Image->resize($videoDefaultImagePath, 370, 250, array('alt'=>''));?>
						</div>
						<div class="clr"></div>
					<?php
						}
					}
				} else {
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
								<?php echo $this->Html->link($this->Html->image('front_end/play.png', array('alt'=>'')), '/business_feeds/view_content/v/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));?>
							</div>
							<?php echo $this->Image->resize($videoDefaultImagePath, 370, 250, array('alt'=>''));?>
						</div>
						<div class="clr"></div>
					<?php
						}
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
			<div class="deshboardwhitebox">
<!-- Recommended Start -->

				<div class="likeboxfl" id="image1_<?php echo $feed['BusinessFeed']['id']; ?>">	
				<?php
				$UserImageArr = $this->Fused->fetchUserImage($feed['BusinessFeed']['id']);
				foreach($UserImageArr as $UserImage){
					$username = $UserImage['User']['username'];
				$businessImage = 'front_end/business/noimage.jpg';
				if($UserImage['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$UserImage['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$UserImage['User']['image'];
						
				} ?>
				<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?></a>
				<?php } ?>
				</div>
<?php $countRecommended = $this->Fused->fetchFeedRecommended($feed['BusinessFeed']['id']);?>
<?php $countUserImage = $this->Fused->fetchUserFeed($feed['BusinessFeed']['id'],$this->Session->read('Auth.User.User.id')); ?>
				<div class="likeboxfr">
				<?php if($countUserImage < 1){ ?>
				<span id="like_<?php echo $feed['BusinessFeed']['id']; ?>">
					<?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'recommended('.$feed['BusinessFeed']['id'].'), recommendedImage('.$feed['BusinessFeed']['id'].', '.$this->Session->read('Auth.User.User.id').');'));?>
				</span>
				<?php } ?>
					<!-- <span id="recommended_<?php echo $feed['BusinessFeed']['id'];?>">
						<?php if($countRecommended > 0){
							echo $countRecommended;
						} else {
							echo '0';
						} ?> People</span> recommended this -->
						<span id="recommended_<?php echo $feed['BusinessFeed']['id'];?>">
						<?php if($countRecommended > 0){
							echo $countRecommended.' person has recommended';
						} else {
							echo 'Be the first to recommended';
						} ?></span>
				</div>
				<span id="roller1_<?php echo $feed['BusinessFeed']['id'];?>"></span>
				<div class="clr"></div>
<!-- Recommended End -->
				<div class="coomentlinbox">
					<!-- <div class="commentfltext"><span>3  People </span>you know recommended this</div> -->
					<?php if($countUserImage < 1){ ?>
					<div class="commentfrlink" id="reco_<?php echo $feed['BusinessFeed']['id']; ?>"><a href="javascript:void(0);" onclick="recommended('<?php echo $feed['BusinessFeed']['id']; ?>'), recommendedImage('<?php echo $feed['BusinessFeed']['id'] ;?>', '<?php echo $this->Session->read('Auth.User.User.id'); ?>');">Recommend</a></div>
					<?php } else {?>
					<div class="coomentlinbox" style="border:none;"></div>
					<?php } ?>
					<div class="clr"></div>
				</div>
<!-- Comment Start -->
				<div class="coomentlinbox" id="comment_div_<?php echo $feed['BusinessFeed']['id'];?>" style="border:none;">
				<?php $commentArr = $this->Fused->fetchAllComments($feed['BusinessFeed']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
					$username = $comment['User']['username'];
				$businessImage = 'front_end/business/noimage.jpg';
				if($comment['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$comment['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$comment['User']['image'];
						
				} ?>
				<table id="business_comment_<?php echo $comment['Comment']['id'];?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
				<tr>
					<td style="width:10%"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?></a></td>

					<td>
					<label><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>" style="color:#006EBD; text-decoration:none; font-weight:bold;"><?php echo $comment['User']['first_name'].' '.$comment['User']['last_name'];?></a></label>
					<?php 
					echo $comment['Comment']['comment'];
					?>
					<?php if($this->Session->read('Auth.User.User.id') == $comment['Comment']['user_id']){ ?>
					<div class="listboxbg" style="float:right;"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['Comment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentFeed('<?php echo $comment['Comment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?>

					<!-- RECOMMEND COMMENT SECTION START -->
					<div id="recommend_comment_<?php echo $comment['Comment']['id'];?>">
						<?php 
						$recm = $this->Fused->fetchUserRecommendedCommentCount($feed['BusinessFeed']['id'], $comment['Comment']['id']);
						$type = 'recommend';
						$rec = 'Recommend';
						if($recm > 0){
							$type = 'unrecommend';
							$rec = 'Unrecommend';
						}
						?>
						<a href="javascript:void(0);" class="recommendClass" onclick="return validateCommentRecommend('<?php echo $feed['BusinessFeed']['id'];?>', '<?php echo $comment['Comment']['id'];?>', '<?php echo $type;?>');"><?php echo $rec;?></a>
						
						<?php 
						$recm = $this->Fused->fetchUserRecommendedCommentCount($feed['BusinessFeed']['id'], $comment['Comment']['id'], 'all');
						if($recm > 0){?>
						<span class="recommendClass" style="float:right;"><?php 
						echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));
						echo '&nbsp;&nbsp;'.$recm;?> people recommended</span>
						<?php } ?>
					</div>
					<!-- RECOMMEND COMMENT SECTION END -->
					</td>

				</tr>
				</table>
				<?php } } ?>
				</div>
				<span id="roller_<?php echo $feed['BusinessFeed']['id'];?>"></span>
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
						<textarea name="user_comment", id="user_comment_<?php echo $feed['BusinessFeed']['id'];?>", cols="" rows="" class="commentfrbox" style="resize:none;"></textarea>
					</div>
					<div class="clr"></div>
				</div>
			</div>
			
		</div>
		<div class="clr"></div>

<input type="hidden" id="business_feeds_<?php echo $feed['BusinessFeed']['id'];?>" value="<?php echo $feed['BusinessFeed']['id'];?>" >

		<div class="pstbtn" onclick="saveComment('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
		
	</div>
	<?php }else{ //For Business Msg Posting ?>
	<div class="deshlistbox" id="business_feed_<?php echo $feed['BusinessFeed']['id'];?>">
		<div class="deshboadflimg">
			<?php echo $this->Html->link($this->Image->resize($businessImage, 59, 59, array('alt'=>'')), $profileUrl, array('escape'=>false));?>
		</div>

		<div class="deshboarlistfrbox">
			<div class="busnissimgfrhd">
				<a href="<?php echo $profileUrl;?>"><?php echo $feedTitle;?></a>
			</div>
			<div class="deshtextsml"><?php echo $feed['User']['city'];?></div>

			<div class="deshboardbluetext" style="color:#000000;">
				<?php $feedComment = array('Feed', 'Comment');
				if(in_array($feed['BusinessFeed']['recommend_type'], $feedComment)){
					$msgType = 'feed';
					$msgLink = SITE_PATH.'feeds/'.$this->Fused->encrypt($feed['BusinessFeed']['recommend_feed_id']);
					if($feed['BusinessFeed']['recommend_type'] == 'Comment')
						$msgType = 'comment';
				}else{ //pr($feed);die;
					$msgType = 'Business';
					$msgLink = SITE_PATH.'businesses/details/'.$this->Fused->encrypt($feed['Business']['id']).'/'.$feed['Business']['alias_name'].'/';
				}?>

				<?php echo $feedTitle;?> has recommended <a href="<?php echo $msgLink;?>" style="text-decoration:none; color:#006EBD;" target="_blank"><?php echo $msgType;?></a>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<?php } ?>
	<?php } } } else { ?>
		<?php echo $this->Element('FrontEnd/Inner/page_content');?>
	<?php } ?>

</div>
</div>
	
</div>

<script type="text/javascript">
function deleteBusinesFeed(feed_id){
	if(feed_id != ''){
		var conf = confirm("Do you want to delete this Feed?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_feeds/delete_feeds_data/';?>",
				data: "feed_id="+feed_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#delete_span_'+feed_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#business_feed_'+feed_id).html('');
						$('#business_feed_'+feed_id).hide();
					}else
						$('#delete_span_'+feed_id).html(response);
				}
			});
			//send Ajax for Deleting End
		}
	}
}



function filter_data(type){
	if(type == 'all'){
		window.location.href = '<?php echo SITE_PATH; ?>users/dashboard/';
	} else if(type == 'popular'){
		window.location.href = '<?php echo SITE_PATH; ?>users/dashboard/';
	}else if(type == 'business'){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'businesses/fetch_user_business/';?>",
				data: "type="+type,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#business_div').html(bSend);
				},
				success: function(response){
						$('#business_div').html(response);
						
					}
			});
	} else if(type == 'friend'){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'friends/fetch_user_friends_feed/';?>",
				data: "type="+type,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#business_div').html(bSend);
				},
				success: function(response){
						$('#business_div').html(response);
						
					}
			});
	}
}

function saveComment(feed_id){
	var comment = $('#user_comment_'+feed_id).val();
	var business_feeds_id = $('#business_feeds_'+feed_id).val();
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/saveComment/';?>",
				data: "business_feeds_id="+business_feeds_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#roller_'+feed_id).html(bSend);
				},
				success: function(response){
						$('#roller_'+feed_id).html('');
						$('#user_comment_'+feed_id).val('');
						$('#comment_div_'+feed_id).append(response);
						
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
						$('#reco_'+recommended_id).hide();
						
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

function validateCommentRecommend(feed_id, comment_id, type){ //alert(feed_id+', '+comment_id+', '+type); return false;
	if(comment_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'recommendeds/comment_recommend/';?>",
			data: "feed_id="+feed_id+"&comment_id="+comment_id+"&type="+type,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				$('#recommend_comment_'+comment_id).html(bSend);
			},
			success: function(response){
					$('#recommend_comment_'+comment_id).html(response);
			}
		});
	}
}
</script>