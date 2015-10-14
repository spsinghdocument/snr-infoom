<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#PageAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Home Page Meta Tags</div>

	<div>
	<?php 
		echo $this->Form->create('User', array('action'=>'admin_manage_tags'));
		echo $this->Form->hidden('MetaTag.id');
	?>
		<div class="formField">
			<span><?php echo '<label style="color:#DC0B14; font-size:15px;">'.ucwords($this->data['MetaTag']['alias_name']).' Page</label>';?></span>
		</div>

		<div class="formField">
			<span>Meta Keywords :</span>
			<?php echo $this->Form->input('MetaTag.meta_keywords', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('Page.meta_keywords');?>
		</div>

		<div class="formField">
			<span>Meta Description :</span>
			<?php echo $this->Form->input('MetaTag.meta_description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('Page.meta_description');?>
		</div>
		
		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>