<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#EnquiryContactUsForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<?php echo $this->Session->flash();?>

<h3>Contact Us</h3>
<div class="contactmainbox">
	<div class="contacttoptext">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sit amet turpis neque. Integer id tellus eu dolor consectetur eleifend.
	</div>

	<div class="allfiednrequired">All field are required</div>
	<div class="contactfrmbox">
		<div class="contactfrmin">
		<?php echo $this->Form->create('Enquiry', array('action'=>'contact_us'));?>
			<div class="gap"></div>
			<div class="cotactformlable">First Name:</div>
			<div class="formfield">
				<?php echo $this->Form->input('Enquiry.first_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required]', 'maxlength'=>'100', 'error'=>false, 'required'=>false));
				echo $this->Form->error('Enquiry.first_name');
				?>
			</div>
			<div class="clr"></div>

			<div class="cotactformlable">Last Name:</div>
			<div class="formfield">
				<?php echo $this->Form->input('Enquiry.last_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required]', 'maxlength'=>'100', 'error'=>false, 'required'=>false));
				echo $this->Form->error('Enquiry.last_name');
				?>
			</div>
			<div class="clr"></div>

			<div class="cotactformlable">Email Address:</div>
			<div class="formfield">
				<?php echo $this->Form->input('Enquiry.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required,custom[email]]', 'maxlength'=>'100', 'error'=>false, 'required'=>false));
				echo $this->Form->error('Enquiry.email');
				?>
			</div>
			<div class="clr"></div>

			<div class="cotactformlable">Phone:</div>
			<div class="formfield">
				<?php echo $this->Form->input('Enquiry.phone', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[custom[phone]]', 'maxlength'=>'15', 'error'=>false, 'required'=>false));
				echo $this->Form->error('Enquiry.phone');
				?>
			</div>
			<div class="clr"></div>

			<div class="cotactformlable">Message:</div>
			<div class="formfieldtext">
				<?php echo $this->Form->textarea('Enquiry.message', array('div'=>false, 'label'=>false, 'class'=>'forminputtext validate[required]', 'error'=>false, 'required'=>false, 'rows'=>'', 'cols'=>''));
				?>
			</div>
			<div class="clr"></div>			

			<div class="formfield" style="background:none;">
				<?php echo $this->Form->submit('front_end/send_message_btn.jpg', array('div'=>false));?>
			</div>
			<div class="clr"></div>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>