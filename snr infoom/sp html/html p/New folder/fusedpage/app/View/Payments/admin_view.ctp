<?php //pr($listing);die;?>
<div id="main" style=" width:700px;">
	<h3>Payment Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Business Name:</div>
			<div class="fielddiv2"><?php echo $listing['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Username:</div>
			<div class="fielddiv2"><?php echo $listing['User']['first_name'].' '.$listing['User']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Membership:</div>
			<div class="fielddiv2"><?php echo $listing['Membership']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Amount:</div>
			<div class="fielddiv2"><?php 
				if($listing['Payment']['currency'] == 'USD')
						$curr = '$';
				echo $curr.$listing['Payment']['total_amount'];
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Payment For:</div>
			<div class="fielddiv2"><?php echo 'Business '.$listing['Payment']['payment_type'];?></div>
		</div>
		<div class="clear"></div>

		<!-- <div class="fielddiv">
			<div class="fielddiv1">Paypal Profile:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['profile_id'];?></div>
		</div>
		<div class="clear"></div> -->

		<div class="fielddiv">
			<div class="fielddiv1">Card Type:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['card_type'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Card Number:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['card_number'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Card Expiry:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['exp_month'].', '.$listing['Payment']['exp_year'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Payment Made On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($listing['Payment']['payment_date_time']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Payment Status:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['payment_status'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Correlation ID:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['correlation_id'];?></div>
		</div>
		<div class="clear"></div>

		<?php if(!empty($listing['Payment']['failure_reason']) && $listing['Payment']['payment_status'] == 'Failure'){?>
		<div class="fielddiv">
			<div class="fielddiv1">Failure Reason:</div>
			<div class="fielddiv2"><?php echo $listing['Payment']['failure_reason'];?></div>
		</div>
		<div class="clear"></div>
		<?php } ?>
	</fieldset>
</div>