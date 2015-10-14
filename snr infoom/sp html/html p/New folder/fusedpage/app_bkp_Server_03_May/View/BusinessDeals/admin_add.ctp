<!-- CALL CALENDER FILES START -->
<?php
	echo $this->Html->Script('calender/jscal2.js');
	echo $this->Html->Script('calender/lang/en.js');
	echo $this->Html->Css('calender/jscal2.css');
	echo $this->Html->Css('calender/border-radius.css');
	echo $this->Html->Css('calender/steel/steel.css');
?>
<!-- CALL CALENDER FILES END -->

<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#BusinessDealAdminAddForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END --> <?php //pr($this->data);die;?>

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Add Deal</div>

	<div>
	<?php 
		echo $this->Form->create('BusinessDeal', array('action'=>'admin_add', 'type'=>'file'));
		echo $this->Form->hidden('BusinessDeal.business_id', array('value'=>$this->params['pass'][0]));
	?>
		<div class="formField">
			<span>Title :</span>
			<?php echo $this->Form->input('BusinessDeal.title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('BusinessDeal.title');?>
		</div>

		<div class="formField">
			<span>Price :</span>
			<?php echo '$'.$this->Form->input('BusinessDeal.price', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required,custom[price]]', 'maxlength'=>10, 'error'=>false, 'style'=>'width:10%;')); echo $this->Form->error('BusinessDeal.price');?>
		</div>

		<div class="formField">
			<span>Tagline :</span>
			<?php echo $this->Form->input('BusinessDeal.tagline', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'maxlength'=>200, 'error'=>false)); echo $this->Form->error('BusinessDeal.tagline');?>
		</div>

		<div class="formField">
			<span>Description :</span>
			<?php echo $this->Form->input('BusinessDeal.description', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('BusinessDeal.description');?>
		</div>

		<div class="formField">
			<span>Fine Prints :</span>
			<?php echo $this->Form->input('BusinessDeal.fine_prints', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('BusinessDeal.fine_prints');?>
		</div>

		<div class="formField">
			<span>High Lights :</span>
			<?php echo $this->Form->input('BusinessDeal.high_lights', array('div'=>false, 'label'=>false, 'type'=>'textarea', 'class'=>'formInput validate[required]', 'error'=>false)); echo $this->Form->error('BusinessDeal.high_lights');?>
		</div>

		<div class="formField">
			<span>Upload Image :</span>
			<?php echo $this->Form->input('BusinessDeal.image_1', array('div'=>false, 'label'=>false, 'type'=>'file', 'class'=>'formInput'));?>
		</div>

		<div class="formField">
			<span>Start Date :</span>
			<?php echo $this->Form->input('BusinessDeal.start_date', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'error'=>false, 'readonly'=>'readonly')); echo $this->Form->error('BusinessDeal.start_date');?>
		</div>
		<script type="text/javascript">
			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide() }
			});
			cal.manageFields("BusinessDealStartDate", "BusinessDealStartDate", "%Y-%m-%d");
		</script>

		<div class="formField">
			<span>End Date :</span>
			<?php echo $this->Form->input('BusinessDeal.end_date', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate[required]', 'error'=>false, 'readonly'=>'readonly')); echo $this->Form->error('BusinessDeal.end_date');?>
		</div>
		<script type="text/javascript">
			var cal = Calendar.setup({
				onSelect: function(cal) { cal.hide() }
			});
			cal.manageFields("BusinessDealEndDate", "BusinessDealEndDate", "%Y-%m-%d");
		</script>

		<div class="norbtnmain">
			<?php echo $this->Form->submit('Update', array('div'=>false, 'label'=>false, 'class'=>'normalbtn'));?>
		</div>
		<div class="clr"></div>
	<?php echo $this->Form->end();?>
	</div>
</div>