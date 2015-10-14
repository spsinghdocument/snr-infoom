<!-- for fancybox Start -->
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<div id="business_feeds_main_container">
<?php
		if(!empty($feedsArr)){
			foreach($feedsArr as $feed){ //pr($feed);die;
				$businessImage = 'front_end/business/noimage.jpg';
				if($feed['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$feed['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$feed['User']['image'];
						
				}
	?>
	<div class="deshlistbox" id="business_feed_<?php echo $feed['User']['id'];?>">
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
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['Comment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentFeed('<?php echo $comment['Comment']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a></span></div>
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
			} else {
?>
<div style="color:red; margin-left:150px;"> No Friends Available!</div>
<?php } ?>