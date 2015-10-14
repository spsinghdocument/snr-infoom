<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?>, <br/><br/>
	Thank You for upgrading your business and purchasing the membership.<br/><br/>

	The required details are as:<br/><br/>
	<strong>Total Amount Paid:</strong> <?php echo '$'.number_format($savePaymentData['total_amount'], 2);?><br/>
	<strong>Card Number:</strong> <?php echo $savePaymentData['card_number'];?><br/>
	<strong>Card Type:</strong> <?php echo $savePaymentData['card_type'];?><br/>
	<strong>Payment Date Time:</strong> <?php echo date('d M, Y H:i:s', strtotime($savePaymentData['payment_date_time']));?><br/>
	<strong>Correlation ID:</strong> <?php echo $savePaymentData['correlation_id'];?><br/>
	<strong>Claimed Business:</strong> <?php echo $businessArr['Business']['title'];?><br/>
	<strong>Membership:</strong> <?php echo $membershipArr['Membership']['name'];?><br/><br/>

	Please login to your account and start promoting yur business.<br/><br/>

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>