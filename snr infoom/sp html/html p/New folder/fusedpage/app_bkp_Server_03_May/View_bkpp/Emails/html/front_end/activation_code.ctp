<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $userDetails['User']['first_name'].' '.$userDetails['User']['last_name'];?>, <br/><br/>
	Thanks for registering on Fused Page Website.<br/><br/>

	Your Login details are as,<br/><br/>

	Email: <?php echo $userDetails['User']['email'];?><br/><br/>
	Password: <?php echo $userDetails['User']['password_1'];?><br/><br/>

	Please activate your account by <a href="<?php echo SITE_PATH.'users/activate/'.$userDetails['User']['activation_link'].'/';?>">clicking here</a>,<br/><br/>

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>