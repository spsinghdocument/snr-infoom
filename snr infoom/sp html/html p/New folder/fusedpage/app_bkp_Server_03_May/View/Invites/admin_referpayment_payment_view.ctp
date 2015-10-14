<?php //pr($userArr);die;?>
<div id="main" style=" width:700px;">
	<h3>User Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Inviter :</div>
			<div class="fielddiv2"><?php echo $viewlisting['Inviter']['first_name'].' '.$viewlisting['Inviter']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Amount :</div>
			<div class="fielddiv2"><?php echo '$'.$viewlisting['ReferralPayment']['amount'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Date :</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($viewlisting['ReferralPayment']['created']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Invitee :</div>
			<div class="fielddiv2"><?php echo $viewlisting['Invitee']['first_name'].' '.$viewlisting['Invitee']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Claimed Business :</div>
			<div class="fielddiv2"><?php echo $viewlisting['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		
	</fieldset>
</div>