<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#CategoryAdminAddSubCategoryForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Add Sub-Category</div>

	<div>
	<?php echo $this->Form->create('Category', array('action'=>'admin_add_sub_category'));?>
		<div class="formField">
			<span>Parent Category :</span>
			<?php echo $this->Form->select('Category.parent_id', $this->Fused->fetchAllParentCategories(), array('class'=>'formInput validate[required]', 'empty'=>'Select', 'style'=>'width:25%;')); echo $this->Form->error('Category.parent_id');?>
		</div>

		<div class="formField">
			<span>Sub-Category Name :</span>
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