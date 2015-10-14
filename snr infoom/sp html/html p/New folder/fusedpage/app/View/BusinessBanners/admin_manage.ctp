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
	<div class="mainHd">Manage Business Banner <span style="float:right; font-size:12px;"><a href="javascript:history.go(-1);">BACK</a></span></div>

	<?php if($show == 'yes'){?>
	<div>
	<?php 
		echo $this->Form->create('BusinessBanner', array('action'=>'admin_manage', 'type'=>'file'));
		echo $this->Form->hidden('BusinessBanner.business_id', array('value'=>$this->params['pass'][0]));
	?>
		<div class="formField">
			<span>Upload Banner (715x250) :</span>
			<?php echo $this->Form->input('BusinessBanner.image', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput validate[required]','error'=>false, 'data-prompt-position'=>'topLeft')); echo $this->Form->error('Business.image');?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Upload', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
	<?php } ?>

	<!-- LIST ALL BUSINESS BANNERS START -->
	<?php if(!empty($businessArr)){ ?>	
	<div style="border-top:1px solid #CCCCCC;">
		<?php
			foreach($businessArr as $banner){ //pr($banner);die;
				$realImagePath = '../webroot/img/front_end/business/banners/'.$banner['BusinessBanner']['banner'];
				if(is_file($realImagePath)){
		?>
			<div style="margin-top:20px;">
				<div style="float:left; width:600px;">
				<?php echo $this->Image->resize('front_end/business/banners/'.$banner['BusinessBanner']['banner'], 572, 225, array('alt'=>''));?>
				</div>
				<div style="float:left; text-align:left; width:50px;">
					<?php //echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_banners/delete/'.$banner['BusinessBanner']['id'].'/'.$banner['BusinessBanner']['business_id'].'/', array('escape'=>false, 'title'=>'Delete'), 'Do You Really Want to Delete this Banner?');?>
				</div>
				<div class="clr"></div>
			</div>
		<?php }} ?>
	</div>
	<?php } ?>
	<!-- LIST ALL BUSINESS BANNERS END -->
</div>