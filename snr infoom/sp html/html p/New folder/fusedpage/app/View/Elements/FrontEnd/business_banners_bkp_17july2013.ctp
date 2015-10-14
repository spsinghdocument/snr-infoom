<?php 
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