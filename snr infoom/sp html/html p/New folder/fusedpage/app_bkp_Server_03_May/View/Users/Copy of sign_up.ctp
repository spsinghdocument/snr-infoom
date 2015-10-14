<?php
	function createArrayDropDown($start, $end){
		$ret = '';
		for($i=$start; $i<=$end; $i++)
			$ret[$i] = $i;
		return $ret;
	}
?>

<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#UserSignUpForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<h3>Sign Up</h3>
<div class="pleasetext">Please fill the below fields, and create your accounts! </div>

<!--Start step fl box -->
<div class="stepboxfl">
	<ul class="steptab">
		<li class="sel">Step 1</li>
		<li>Step 2</li>
	</ul>
	<div class="clr"></div>

	<div class="stepinsidebox">
		<div class="stepboinside">
		<?php 
			echo $this->Form->create('User', array('action'=>'sign_up'));
			echo $this->Form->hidden('User.id');
		?>
			<div class="gap">&nbsp;</div>

			<div class="steplablefl">Postal Code:</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->input('User.postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'stepinput validate[required]', 'maxlength'=>'10', 'error'=>false, 'required'=>false));
				echo $this->Form->error('User.postcode');
				?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl">City:</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->input('User.suburb_id', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'stepinput validate[required]', 'maxlength'=>'100', 'error'=>false, 'required'=>false));
				echo $this->Form->error('User.suburb_id');
				?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl" style="padding-top:0;">Gender:</div>
			<div class="stepfieldfr">
				<input name="data[User][gender]" type="radio" value="1"  class="readiocir" checked />Male
				<input name="data[User][gender]" type="radio" value="2"  class="readiocir" style="margin-left:10px;" />Female
				<?php //echo $this->Form->radio('User.gender', array('1'=>'Male', '2'=>'Female'), array('legend'=>false, 'class'=>'readiocir', 'value'=>'1', 'style'=>'margin-left:10px;'));?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl">Birthday:</div>
			<div class="stepfieldfr">
				<div class="selectmain">
					<?php echo $this->Form->select('User.year', createArrayDropDown(1910, date('Y')), array('class'=>'selsmlinput validate[required]', 'empty'=>'Select'));?>
				</div>
				<div class="selectmain">
					<?php echo $this->Form->select('User.month', createArrayDropDown(1, 12), array('class'=>'selsmlinput validate[required]', 'empty'=>'Select'));?>
				</div>
				<?php echo $this->Form->input('User.date', array('div'=>false, 'label'=>false, 'type'=>'text', 'required'=>false, 'class'=>'smlinput validate[required,custom[onlyNumberSp,min[1],max[31]]]'));?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl">&nbsp;</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->submit('front_end/last_step_btn.jpg', array('div'=>false));?>
			</div>
			<div class="clr"></div>
		<?php echo $this->Form->end();?>
		</div>
	</div>
</div>
<!--End step fl box -->

<!--Start step fr text -->
<div class="stepboxfr">
Your location and other information allows us to cater more meaningful content that will matter to you.
</div>
<div class="clr"></div>
<!--End step fr text -->