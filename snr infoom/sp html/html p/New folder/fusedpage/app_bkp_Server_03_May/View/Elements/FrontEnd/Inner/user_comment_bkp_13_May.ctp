<div id="business_div">
<div id="pulic_1">

	<div class="clr" style="margin-top:10px;"></div>
	
	<?php
		$feedsArr = $this->Fused->fetchUsersRecentFeeds($page);
		//pr($feedsArr);
		if(!empty($feedsArr)){
?>
<div id="business_feeds_main_container">
<?php
			foreach($feedsArr as $feed){ //pr($feed);die;
				$businessImage = 'front_end/business/noimage.jpg';
				if($feed['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$feed['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$feed['User']['image'];
						
				}
	?>
	<div class="deshlistbox" id="business_feed_<?php echo $feed['BusinessFeed']['id'];?>">
		<div class="deshboadflimg">
			<?php echo $this->Image->resize($businessImage, 59, 59, array('alt'=>''));?>
		</div>

		<div class="deshboarlistfrbox">
			<!-- DELETE SECTION START -->
			<!-- <?php if($this->Fused->validateUserForBusiness() == $feed['BusinessFeed']['business_id']){?>
			<span style="float:right;" id="delete_span_<?php echo $feed['BusinessFeed']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteBusinesFeed('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a></span>
			<?php } ?> -->
			<!-- DELETE SECTION END -->
			<div class="busnissimgfrhd"><a href="javascript:void(0);"><?php echo $feed['User']['first_name']." ".$feed['User']['last_name'];?></a></div>

			<div class="deshtextsml"><?php echo $feed['User']['city'];?></div>
			<div class="deshboardbluetext" style="overflow:hidden;">
				<?php
					if($feed['BusinessFeed']['message'] != ''){ //comment
					//If link available, then add link
					if($feed['BusinessFeed']['link'] != ''){
						echo '<a href="'.$feed['BusinessFeed']['link'].'" target="_blank" style="text-decoration:none;">';
					}
				?>
					<div <?php if($feed['BusinessFeed']['link'] != ''){echo 'style="color:#1564A6;"';}else{echo 'style="color:#000000;"';}?>><?php echo $feed['BusinessFeed']['message'];?></div>
				<?php
					if($feed['BusinessFeed']['link'] != ''){
						echo '</a>';
					}
				?>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php						
					}

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

					/*if($feed['BusinessFeed']['link'] != ''){*/ //Embed Code
				?>
					<!-- <div><?php echo $feed['BusinessFeed']['link'];?></div>
					<div class="clr" style="margin-bottom:10px;"></div> -->
				<?php	
					/*} */

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
				?>
			</div>
			<div class="deshboardwhitebox">
				<div class="likeboxfl">
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img1.jpg', array('alt'=>''));?></a>
				</div>
				
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img2.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img3.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>''));?></a>
				</div>
				</div>

				<div class="likeboxfr"><?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));?><span>20 People</span> recommended this</div>
				<div class="clr"></div>

				<div class="coomentlinbox">
					<div class="commentfltext"><span>3  People </span>you know recommended this</div>
					<div class="commentfrlink"><a href="javascript:void(0);">Comments</a></div>
					<div class="clr"></div>
				</div>
<!-- Comment Start -->
				<div class="coomentlinbox" id="comment_div_<?php echo $feed['BusinessFeed']['id'];?>" style="border:none;">
				<?php $commentArr = $this->Fused->fetchAllComments($feed['BusinessFeed']['id']); ?>
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
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['Comment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentFeed('<?php echo $comment['Comment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>'', 'style'=>'height:15px; width:15px;'));?></a></span></div>
					<?php } ?>
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
	<?php
			}
?>
</div>
</div>
<?php
		}else{
	?>
		<?php echo $this->Element('FrontEnd/Inner/page_content');?>
	<?php } ?>
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
		alert(type);
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
</script>