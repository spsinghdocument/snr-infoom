<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $userDetails['User']['first_name'].' '.$userDetails['User']['last_name'];?>, <br/><br/>
	Thanks for registering on Fused Page Website using your Facebook account.<br/><br/>

	Your website login credentials are as,<br/><br/>

	Email: <?php echo $userDetails['User']['email'];?><br/><br/>
	Password: <?php echo $password;?><br/><br/>

	Please login to your account, using the above credentials and change your password.

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>