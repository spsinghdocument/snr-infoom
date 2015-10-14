<!-- LOAD AJAX IMAGE UPLOAD FILE END -->
<?php echo $this->Html->script('ajax_upload/ajaxupload');?>
<!-- LOAD AJAX IMAGE UPLOAD FILE START -->

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

		<!--Start inside right part -->
		<div class="insiderightbox">
			<!-- <div class="insidetopflbox">
				<div class="groupsmlgrytext">Subscribe</div>
				<div>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
				</div>
			</div> -->

			<!-- RATING SECTION START -->
			<div class="insidetopfr">
				<div class="ratingbox" style="display:none;">
					Fusedpage rating:
					<span id="overAllRatingBox">
					<?php
						for($i=1; $i<=5; $i++){
							if($i <= $grpArr['Group']['rating'])
								echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
							else
								echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
						}
					?>
					</span>
				</div>
				<div class="ratingbtmtext">Fusedpage Verified Business</div>
			</div>
			<div class="clr"></div>
			<!-- RATING SECTION END -->

			<!-- BANNER SECTION START -->
			<?php
				if(!empty($grpArr['GroupBanner'])){
			?>
			<div class="inaidebannerbox">
				<?php //echo $this->Html->link($this->Html->image('front_end/inside_banner.jpg'), 'javascript:void(0);', array('escape'=>false));
					foreach($grpArr['GroupBanner'] as $banner){ //pr($banner);die;
						$bannerPath = '../webroot/img/front_end/groups/'.$banner['banner'];
						if(is_file($bannerPath)){
							echo $this->Image->resize('front_end/groups/'.$banner['banner'], 715, 250, array('alt'=>''));
						}
					}
				?>
			</div>
			<?php } ?>
			<!-- BANNER SECTION END -->

		<div class="userdeshboardmid">		
			<!-- PAGE MIDDLE NAVIGATION START -->
			<?php echo $this->Element('FrontEnd/groups_middle_navigation');?>
			<!-- PAGE MIDDLE NAVIGATION END -->
			
			<!-- BUSINESS RECENT ACTIVITY START -->
			<?php echo $this->Element('FrontEnd/groups_recent_activity');?>
			<!-- BUSINESS RECENT ACTIVITY END -->
			
			<!-- BUSINESS RECENT ACTIVITY START -->
			<?php echo $this->Element('FrontEnd/groups_about_us');?>
			<!-- BUSINESS RECENT ACTIVITY END -->

			<!-- BUSINESS RECENT ACTIVITY START -->
			<?php echo $this->Element('FrontEnd/groups_photo');?>
			<!-- BUSINESS RECENT ACTIVITY END -->
			
			<!-- BUSINESS RECENT ACTIVITY START -->
			<?php echo $this->Element('FrontEnd/groups_event');?>
			<!-- BUSINESS RECENT ACTIVITY END -->
			
			<!-- BUSINESS RECENT ACTIVITY START -->
			<?php echo $this->Element('FrontEnd/groups_vedio');?>
			<!-- BUSINESS RECENT ACTIVITY END -->
				
		</div>			
			<!--End deshboard mid part -->
				
			<!-- GROUP DEATILS RIGHT SECTION START  -->
				<?php echo $this->Element('FrontEnd/group_details_right_section');?>
			<!-- GROUP DEATILS RIGHT SECTION END  -->
			<div class="clr"></div>
		</div>
			<!--End inside right part -->
			<div class="clr"></div>
			