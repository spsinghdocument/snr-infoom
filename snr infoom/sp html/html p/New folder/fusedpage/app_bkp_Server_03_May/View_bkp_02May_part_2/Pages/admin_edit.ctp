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
	<div class="mainHd">Edit Page Content</div>

	<div>
	<?php 
		echo $this->Form->create('Page', array('action'=>'admin_edit'));
		echo $this->Form->hidden('Page.id');
	?>
		<div class="formField">
			<span><?php echo '<label style="color:#DC0B14; font-size:15px;">'.$this->data['Page']['page_name'].'</label>';?></span>
		</div>

		<div class="formField">
			<span>Meta Title :</span>
			<?php echo $this->Form->input('Page.meta_title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Page.meta_title');?>
		</div>

		<div class="formField">
			<span>Meta Keywords :</span>
			<?php echo $this->Form->input('Page.meta_keywords', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('Page.meta_keywords');?>
		</div>

		<div class="formField">
			<span>Meta Description :</span>
			<?php echo $this->Form->input('Page.meta_description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('Page.meta_description');?>
		</div>

		<div class="formField">
			<span>Content :</span>
			<?php echo $this->Fck->fckeditor(array('Page', 'description'), $this->Html->base, $this->data['Page']['description'], '70%', '450');?>
		</div>

		<div class="formField">
			<span>Status :</span>
			<?php
				echo $this->Form->radio('Page.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false));
			?>
		</div>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>