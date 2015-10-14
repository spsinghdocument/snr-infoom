<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Business Details</h3>
	<fieldset>
		
		<div class="fielddiv">
			<div class="fielddiv1">Username:</div>
			<div class="fielddiv2"><?php echo $businessArr['User']['first_name'].' '.$businessArr['User']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Business:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Enquiry:</div>
			<div class="fielddiv2"><?php echo nl2br($businessArr['SupportEmail']['enquiry']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Made On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($businessArr['Business']['created']));?></div>
		</div>
		<div class="clear"></div>
		
	</fieldset>
</div>