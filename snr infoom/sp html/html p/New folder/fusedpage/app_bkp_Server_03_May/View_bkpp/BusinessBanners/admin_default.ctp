<?php //pr($defaultBannerArr);?>

<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#BusinessBannerAdminManageForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Manage Business Default Banner</div>

	<?php if(empty($defaultBannerArr)){?>
	<div>
	<?php 
		echo $this->Form->create('BusinessBanner', array('action'=>'admin_default', 'type'=>'file'));
		echo $this->Form->hidden('BusinessDefaultBanner.id', array('value'=>'1'));
	?>
		<div class="formField">
			<span>Upload Banner (715x250) :</span>
			<?php echo $this->Form->input('BusinessDefaultBanner.banner', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput validate[required]','error'=>false, 'data-prompt-position'=>'topLeft'));?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Upload', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
	<?php }else{ ?>

	<!-- LIST ALL BUSINESS BANNERS START -->
	<div style="border-top:1px solid #CCCCCC;">
		<?php
			$realImagePath = '../webroot/img/front_end/business/banners/'.$defaultBannerArr['BusinessDefaultBanner']['banner'];
			if(is_file($realImagePath)){
		?>
			<div style="margin-top:20px;">
				<div style="float:left; width:600px;">
				<?php echo $this->Image->resize('front_end/business/banners/'.$defaultBannerArr['BusinessDefaultBanner']['banner'], 572, 225, array('alt'=>''));?>
				</div>
				<div style="float:left; text-align:left; width:50px;">
					<?php echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_banners/delete_default_banner/', array('escape'=>false, 'title'=>'Delete'), 'Do You Really Want to Delete this Default Banner?');?>
				</div>
				<div class="clr"></div>
			</div>
		<?php }else{
			echo 'No Banner Found!!';
		} ?>
	</div>
	<?php } ?>
	<!-- LIST ALL BUSINESS BANNERS END -->
</div>