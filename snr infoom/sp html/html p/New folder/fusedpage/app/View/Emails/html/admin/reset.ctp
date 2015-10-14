<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?>, <br/><br/>
	Your Login Password has been reset. Your new login credentials are as ,<br/><br/>
	<strong>Email:</strong> <?php echo $userArr['User']['email'];?><br/>
	<strong>Password:</strong> <?php echo $newPassword;?><br/><br/>

	We request you to login and change the password!!<br/>
	Please <a href="<?php echo SITE_PATH.'users/sign_in/';?>">Click Here</a> to login.<br/><br/>
	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>