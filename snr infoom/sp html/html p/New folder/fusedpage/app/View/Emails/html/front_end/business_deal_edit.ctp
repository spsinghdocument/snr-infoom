<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $username;?>, <br/><br/>
	A business deal has been edited, which you have subscribed.<br/><br/>

	Business Name: <?php echo $businessname;?><br/><br/>
	Deal Name: <?php echo $offer;?><br/><br/>

	<!-- Please <a href="<?php echo SITE_PATH.'users/sign_in/';?>">login</a> and change your password.<br/><br/> -->

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>