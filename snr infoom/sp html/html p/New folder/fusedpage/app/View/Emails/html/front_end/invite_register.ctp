<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $email;?>, <br/><br/>
	<?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?> has  invited you to join on fusedpage.com and has left you a message as,<br/><br/>

	<?php echo nl2br($message);?><br/><br/>

	Please <a href="<?php echo SITE_PATH.'invites/accept_invitation/'.$unique_code.'/';?>">Click Here</a> to accept the invitation or copy and paste this link in the browser, <?php echo SITE_PATH.'invites/accept_invitation/'.$unique_code.'/';?><br/><br/>

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>