<div id="pulic_1">



	<!-- POST COMMENTS START -->
	<?php echo $this->Element('FrontEnd/business_comments');?>
	<!-- POST COMMENTS END -->
	<div class="clr" style="margin-top:10px;"></div>

	<?php
		$feedsArr = $this->Fused->fetchBusinessRecentFeeds($this->Fused->decrypt($this->params['pass'][0]));
		if(!empty($feedsArr)){
			foreach($feedsArr as $feed){ //pr($feed);die;
				$businessImage = 'front_end/business/noimage.jpg';
				if($feed['Business']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/business/'.$feed['Business']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/business/'.$feed['Business']['image'];
						
				}
	?>
	<div class="deshlistbox">
		<div class="deshboadflimg">
			<?php echo $this->Image->resize($businessImage, 59, 59, array('alt'=>''));?>
		</div>

		<div class="deshboarlistfrbox">
			<div class="busnissimgfrhd"><a href="javascript:void(0);"><?php echo $feed['Business']['title'];?></a></div>

			<div class="deshtextsml"><?php echo $feed['Business']['city'];?></div>
			<div class="deshboardbluetext" style="overflow:hidden;">
				<?php
					if($feed['BusinessFeed']['message'] != ''){ //comment
				?>
					<div><?php echo $feed['BusinessFeed']['message'];?></div>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php						
					}

					if($feed['BusinessFeed']['image'] != ''){ //Image
						$imagePath = '../webroot/img/front_end/business/feeds/'.$feed['BusinessFeed']['image'];
						if(is_file($imagePath)){
							$image = 'front_end/business/feeds/'.$feed['BusinessFeed']['image'];
				?>
							<div><?php echo $this->Html->link($this->Image->resize($image, 370, 250, array('alt'=>'')), '/business_feeds/view_content/i/'.$this->Fused->encrypt($feed['BusinessFeed']['id']), array('escape'=>false, 'class'=>'fancyclass'));?></div>
							<div class="clr" style="margin-bottom:10px;"></div>
				<?php		
						}
					}

					if($feed['BusinessFeed']['link'] != ''){ //Embed Code
				?>
					<div><?php echo $feed['BusinessFeed']['link'];?></div>
					<div class="clr" style="margin-bottom:10px;"></div>
				<?php	
					}

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

				<div>
					<div class="commentflimg"><?php echo $this->Html->image('front_end/comment_fl_img.jpg', array('alt'=>''));?></div>
					<div class="commentfrboxmain">
						<div class="commetarrow"><?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?></div>
						<textarea name="" cols="" rows="" class="commentfrbox"></textarea>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>
		<div class="clr"></div>

		<div class="pstbtn"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
	</div>		
	<?php
			}
		}else{
	?>
		<div class="deshlistbox" align="center" style="margin-top:50px;">No Feeds Available!!</div>
	<?php } ?>
</div>