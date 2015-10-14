<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?>, <br/><br/>
	You forgot your password, but no worries, we have generated a new password for you.<br/><br/>

	Your Login Credentials are as,<br/><br/>

	Email: <?php echo $userArr['User']['email'];?><br/><br/>
	Password: <?php echo $newPassword;?><br/><br/>

	Please <a href="<?php echo SITE_PATH.'users/sign_in/';?>">login</a> and change your password.<br/><br/>

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>