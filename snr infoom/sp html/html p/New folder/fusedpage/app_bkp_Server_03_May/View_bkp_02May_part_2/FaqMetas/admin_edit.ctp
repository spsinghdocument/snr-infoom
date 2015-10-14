<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#FaqMetaAdminEditForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Edit Page Content</div>

	<div>
	<?php 
		echo $this->Form->create('FaqMeta', array('action'=>'admin_edit'));
		echo $this->Form->hidden('FaqMeta.id');
	?>
		<div class="formField">
			<span>Meta Title :</span>
			<?php echo $this->Form->input('FaqMeta.meta_title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('FaqMeta.meta_title');?>
		</div>

		<div class="formField">
			<span>Meta Keyword :</span>
			<?php echo $this->Form->input('FaqMeta.meta_keyword', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('FaqMeta.meta_title');?>
		</div>

		<div class="formField">
			<span>Meta Description :</span>
			<?php echo $this->Form->input('FaqMeta.meta_description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('FaqMeta.meta_description');?>
		</div>		

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>