<!-- LOAD AJAX IMAGE UPLOAD FILE END -->
<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){
		echo $this->Html->script('ajax_upload/ajaxupload');
	}
?>
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


<?php echo $this->Html->script('FrontEnd/jquery-1.js'); ?>
<?php echo $this->Html->script('FrontEnd/loopedslider'); ?>
<script>
var j = jQuery.noConflict();
	j(function(){
		j('#loopedSlider').loopedSlider({
			autoStart: 2000,
			restart: 2000
		});
	j('#newsSlider').loopedSlider({
		autoHeight: 400
	});
 });
</script>

<div class="insiderightbox">
	<div class="insidetopflbox">
		<div>
			<span class="insidehd"><?php echo $businessArr['Business']['title'];?></span> 
			<!-- <a href="<?php echo $businessArr['Business']['website'];?>" target="_blank" class="websitename"><?php echo $businessArr['Business']['website'];?></a> -->
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
	
		<!-- DISPLAY FAVORITE MESSAGE START -->
		<div id="favorite_div" style="margin-top:10px; color:red; margin-left:140px;"></div>
		<!-- DISPLAY FAVORITE MESSAGE END -->
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
		<!-- CLAIM/ FAVORITE/ EDIT SECTION START -->
		<?php
			if($this->Fused->fetchBusinessOwner($businessArr['Business']['id']) == $this->Session->read('Auth.User.User.id')){
		?>
		<div class="btnimage fr" style="margin-top:15px;">
			<a href="<?php echo SITE_PATH.'businesses/edit_business/'.$businessArr['Business']['id'].'/'.$this->params->pass[0].'/';?>"><span>Edit</span></a>
		</div>
		<?php
			}else{
		?>
		<div class="btnimage fr" style="margin-top:15px;">
			<?php if($this->Fused->countFavorite($businessArr['Business']['id']) == 0){ ?>
			<label id="add_favorite"><a href="JavaScript:void(0);" onclick="return add_favorite(this.value);" style="margin-right:10px;"><span>Add to Favorite</span></a></label>
			<?php } ?>

			<a href="<?php echo SITE_PATH.'businesses/membership_plans/'.$this->params->pass[0].'/';?>"><span>Claim</span></a>
		</div>
		<?php } ?>
		<!-- CLAIM/ FAVORITE/ EDIT SECTION END -->
	</div>
	<div class="clr"></div>
	<!-- FUSEDPAGE RATING END -->

	<!-- BUSINESS BANNER START -->
	<?php if(!empty($businessArr['BusinessBanner'])){?>
	<div class="inaidebannerbox">
		<!--Start banner part -->
			<div id="loopedSlider">
				<div class="container">
					 <?php
					 //pr($businessArr['BusinessBanner']);die;
							foreach($businessArr['BusinessBanner'] as $banner){ //pr($banner);die;
								$realBannerPath = '../webroot/img/front_end/business/banners/'.$banner['banner'];
								if(is_file($realBannerPath)){
					?>
					<div style="width:715px;" class="slides">
						 <div style="position: absolute; display: block;" class="bnrSlideMain">
							<div class="bannerfr"><?php echo $this->Image->resize('front_end/business/banners/'.$banner['banner'], 715, 250, array('alt'=>''));?></div>
							<div class="clr"></div>
						</div>		
					</div>
                                        <?php
			                       }}
	                                ?>
				</div>
				<div class="paginationNew">	
					<div class="paginationLeft"><a href="#" class="previous"><?php echo $this->Html->image('front_end/next_img.png')?></a></div>
						<ul class="pagination">
                                                <?php if($businessArr['BusinessBanner'] != ''){ //pr($businessArr['BusinessBanner']);die;
						        $i=1;
							foreach($businessArr['BusinessBanner'] as $banner){
							 $class="";
							if($i=='1'){
							  $class="active";
							}//pr($banner);die;
                                                ?>
					         <li class="<?php $class; ?>"><a rel="<?php $i;?>" href="#">&nbsp;</a></li>
						 <?php } 
						  $i++;
						 }?>
						</ul>
					<div class="paginationRight"><a href="#" class="next"><?php echo $this->Html->image('front_end/pre_img.png');?></a></div>
				</div>
			</div>
	</div>
	<?php } ?>
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

<script type="text/javascript">
function add_favorite(){
	business_id = "<?php echo $businessArr['Business']['id'];?>";

	if(business_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH;?>favorites/add_to_favorite/",
			data: "business_id="+business_id,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/opc-ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:200px;"));?>'; 
				$('#favorite_div').html(bSend);
			},
			success: function(response){
				$('#favorite_div').html(response);
				$('#add_favorite').hide();
			}
		});
	}
}
</script>