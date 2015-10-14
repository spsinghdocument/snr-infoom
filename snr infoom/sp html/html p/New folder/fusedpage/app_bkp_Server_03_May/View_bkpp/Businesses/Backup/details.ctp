<!-- LOAD AJAX IMAGE UPLOAD FILE END -->
<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){
		echo $this->Html->script('ajax_upload/ajaxupload');
	}
?>
<!-- LOAD AJAX IMAGE UPLOAD FILE START -->

<!-- for fancybox Start -->
<?php
	echo $this->Html->Css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->Script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<div class="insiderightbox">
	<div class="insidetopflbox">
		<div>
			<span class="insidehd"><?php echo $businessArr['Business']['title'];?></span> 
			<a href="<?php echo $businessArr['Business']['website'];?>" target="_blank" class="websitename"><?php echo $businessArr['Business']['website'];?></a>
		</div>
		<div>
		<?php
			if($businessArr['Business']['street'] != '')
				echo '<p>'.$businessArr['Business']['street'].'</p>';
			if($businessArr['Business']['city'] != '')
				echo '<p>'.$businessArr['Business']['city'].', '.$businessArr['Business']['state_code'].', '.$businessArr['Business']['country'].'</p>';
			if($businessArr['Business']['phone'] != '')
				echo '<p>'.$businessArr['Business']['phone'].'</p>';
			
		?>
		</div>
	</div>

	<!-- FUSEDPAGE RATING START -->
	<div class="insidetopfr">
		<div class="ratingbox" id="overAllRatingBox">
			Fusedpage rating:
			<?php
				for($i=1; $i<=5; $i++){
					if($i <= $businessArr['Business']['rating'])
						echo $this->Html->image('front_end/rating_star.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/gray_star.png', array('alt'=>'', 'border'=>0));
				}
			?>
		</div>
		<div class="ratingbtmtext">Fusedpage Verified Business</div>
		<?php 
			if($this->Fused->validateUserForBusiness() == ''){
				if($this->Fused->fetchBusinessClaimStatus($businessArr['Business']['id']) == ''){?>
				<div class="btnimage fr" style="margin-top:15px;">
					<a href="<?php echo SITE_PATH.'businesses/membership_plans/'.$this->params->pass[0].'/';?>"><span>Claim This Business</span></a></div>
		<?php }} ?>
	</div>
	<div class="clr"></div>
	<!-- FUSEDPAGE RATING END -->

	<!-- BUSINESS BANNER START -->
	<?php
		if($businessArr['BusinessBanner'] != ''){ //pr($businessArr['BusinessBanner']);die;
			foreach($businessArr['BusinessBanner'] as $banner){ //pr($banner);die;
				$realBannerPath = '../webroot/img/front_end/business/banners/'.$banner['banner'];
				if(is_file($realBannerPath)){
	?>
		<div class="inaidebannerbox">
			<?php echo $this->Image->resize('front_end/business/banners/'.$banner['banner'], 715, 250, array('alt'=>''));?>
		</div>
	<?php
			}}
		}
	?>
	<!-- BUSINESS BANNER END -->



	<!-- MIDDLE PART START -->
	<div class="userdeshboardmid">

		<!-- PAGE MIDDLE NAVIGATION START -->
		<?php echo $this->Element('FrontEnd/business_middle_navigation');?>
		<!-- PAGE MIDDLE NAVIGATION END -->

		<!-- BUSINESS RECENT ACTIVITY START -->
		<?php echo $this->Element('FrontEnd/recent_activity');?>
		<!-- BUSINESS RECENT ACTIVITY END -->

		<!-- BUSINESS ABOUT US START -->
		<?php echo $this->Element('FrontEnd/about_us');?>
		<!-- BUSINESS ABOUT US END -->

		<!-- BUSINESS OFFERS START -->
		<?php echo $this->Element('FrontEnd/offers');?>
		<!-- BUSINESS OFFERS END -->

		<!-- BUSINESS DEALS START -->
		<?php echo $this->Element('FrontEnd/deals');?>
		<!-- BUSINESS DEALS END -->

		<!-- BUSINESS FEEDBACK START -->
		<?php echo $this->Element('FrontEnd/feedback');?>
		<!-- BUSINESS FEEDBACK END -->

		<!-- BUSINESS CONTACT US START -->
		<?php echo $this->Element('FrontEnd/contact_us');?>
		<!-- BUSINESS CONTACT US END -->

		<!-- BUSINESS LOCATION ON MAP START -->
		<?php echo $this->Element('FrontEnd/map');?>
		<!-- BUSINESS LOCATION ON MAP END -->
	</div>			
	<!-- MIDDLE PART START -->

	<!-- PAGE RIGHT SECTION START  -->
	<?php echo $this->Element('FrontEnd/business_right_section');?>
	<!-- PAGE RIGHT SECTION END  -->

	<div class="clr"></div>
</div>