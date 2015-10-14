<?php //pr($requestArr);die;?>

<div id="main" style=" width:700px;">
	<h3>Request Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">User:</div>
			<div class="fielddiv2"><?php echo $requestArr['User']['first_name'].' '.$requestArr['User']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Business:</div>
			<div class="fielddiv2"><?php echo $requestArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Message:</div>
			<div class="fielddiv2"><?php echo nl2br($requestArr['PremiumRequest']['message']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Sent On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($requestArr['PremiumRequest']['created']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Request Status:</div>
			<div class="fielddiv2"><?php 
			$reqArr = array('1'=>'Request Received', '2'=>'Payment Request Sent', '3'=>'Request Cancelled!!', '4'=>'Paid');
			echo $reqArr[$requestArr['PremiumRequest']['status']];
			?></div>
		</div>
		<div class="clear"></div>

	</fieldset>
</div>