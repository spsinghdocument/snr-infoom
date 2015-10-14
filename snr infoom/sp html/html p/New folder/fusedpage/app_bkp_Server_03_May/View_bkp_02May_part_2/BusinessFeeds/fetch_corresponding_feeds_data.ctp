<?php //pr($feed);?>

<!-- for fancybox Start -->
<?php
	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<?php if(!empty($feed)){
	$businessImage = 'front_end/business/noimage.jpg';
	if($feed['Business']['image'] != ''){
		$imageRealPath = '../webroot/img/front_end/business/'.$feed['Business']['image'];
		if(is_file($imageRealPath))
			$businessImage = 'front_end/business/'.$feed['Business']['image'];
			
	}
?>
<div class="deshlistbox" id="business_feed_<?php echo $feed['BusinessFeed']['id'];?>">
	<div class="deshboadflimg">
		<?php echo $this->Image->resize($businessImage, 59, 59, array('alt'=>''));?>
	</div>

	<div class="deshboarlistfrbox">
		<!-- DELETE SECTION START -->
		<?php if($this->Fused->validateUserForBusiness() == $feed['BusinessFeed']['business_id']){?>
		<span style="float:right;" id="delete_span_<?php echo $feed['BusinessFeed']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteBusinesFeed('<?php echo $feed['BusinessFeed']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a></span>
		<?php } ?>
		<!-- DELETE SECTION END -->
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
<?php }else{
	echo '';
}
?>
