<div id="main" style=" width:700px;">
	<h3>Enquiry Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Name:</div>
			<div class="fielddiv2"><?php echo $enqAqq['Enquiry']['first_name'].' '.$enqAqq['Enquiry']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Email:</div>
			<div class="fielddiv2"><?php echo $enqAqq['Enquiry']['email'];?></div>
		</div>
		<div class="clear"></div>

		<?php if($enqAqq['Enquiry']['phone'] != ''){?>
		<div class="fielddiv">
			<div class="fielddiv1">Phone:</div>
			<div class="fielddiv2"><?php echo $enqAqq['Enquiry']['phone'];?></div>
		</div>
		<div class="clear"></div>
		<?php } ?>

		<div class="fielddiv">
			<div class="fielddiv1">Message:</div>
			<div class="fielddiv2"><?php echo nl2br($enqAqq['Enquiry']['message']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Date:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($enqAqq['Enquiry']['created']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>