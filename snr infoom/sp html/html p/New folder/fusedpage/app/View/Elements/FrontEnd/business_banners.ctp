<?php 
	echo $this->Html->css('slider/bjqs');
	echo $this->Html->css('slider/demo');
?>
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<?php
	echo $this->Html->script('slider/bjqs-1.3.min');


	if(!empty($businessArr['BusinessBanner'])){
	foreach($businessArr['BusinessBanner'][0] as $key=>$val){
		if(substr($key, 0, 7) == 'banner_'){
			$ret[]['banner'] = $val;
		}
	}
	$businessArr['BusinessBanner'] = $ret;

	//pr($businessArr['BusinessBanner']);die;
?>
<div class="inaidebannerbox">
	<div id="banner-fade">
		<ul class="bjqs">
			<?php
				foreach($businessArr['BusinessBanner'] as $banner){ //pr($banner);die;
					$realBannerPath = '../webroot/img/front_end/business/banners/'.$banner['banner'];
					if(is_file($realBannerPath)){
			?>
						 <li><?php echo $this->Image->resize('front_end/business/banners/'.$banner['banner'], 715, 250, array('alt'=>''));?></li>
			<?php 
					}
				}			  
			?>
		</ul>


		<script class="secret-source">
			jQuery(document).ready(function($){
				$('#banner-fade').bjqs({
					responsive  : true
				});
			});
		</script>
	</div>
</div>
<?php }else{?>
<!-- DEFAULT BANNER SECTION START -->
<?php
	$defaultBannerArr = $this->Fused->fetchDefaultBanner();
	if(!empty($defaultBannerArr) && $defaultBannerArr['BusinessDefaultBanner']['banner'] != ''){
?>
<div class="inaidebannerbox">
	<div class="dummerybannerbox">
		<div class="fl">
			<div><span class="insidehd"><?php echo $businessArr['Business']['title'];?></span>
			<!-- <a href="javascript:void(0);" class="websitename">www.onecoffee.com</a> --></div>
			<div class="addresstext">
				<?php
					if($businessArr['Business']['street'] != '')
						echo '<p>'.$businessArr['Business']['street'].'</p>';
					if($businessArr['Business']['city'] != '')
						echo '<p>'.$businessArr['Business']['city'].', '.$businessArr['Business']['state_code'].', '.$businessArr['Business']['country'].'</p>';
					
				?>
			</div>	
		</div>
		<div class="bannerphNo">
			Ph: <?php echo $businessArr['Business']['phone'];?>
		</div>
		<div class="clr"></div>
	</div>
	<?php echo $this->Image->resize('front_end/business/banners/'.$defaultBannerArr['BusinessDefaultBanner']['banner'], 715, 250, array('alt'=>''));?>
</div>
<!-- DEFAULT BANNER SECTION END -->
<?php }} ?>