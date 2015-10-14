<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#CategoryAdminAddForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Add Category</div>

	<div>
	<?php echo $this->Form->create('Category', array('action'=>'admin_add'));?>
		<div class="formField">
			<span>Name :</span>
			<?php echo $this->Form->input('Category.name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('Category.name');?>
		</div>

		<div class="formField">
			<span>Status :</span>
			<?php echo $this->Form->radio('Category.status', array('1'=>'Active', '0'=>'Inactive'), array('legend'=>false, 'value'=>'1'));?>
		</div>			

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Add Category', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>