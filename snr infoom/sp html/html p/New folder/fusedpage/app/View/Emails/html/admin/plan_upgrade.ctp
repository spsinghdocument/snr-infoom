<div style="margin:20px 5px 5px 5px; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#000000;">
	Hello <?php echo $preReqArr['User']['first_name'].' '.$preReqArr['User']['last_name'];?>, <br/><br/>

	Your request for upgrading your plan to Platinum has been approved. Please login to website and <a href="<?php echo str_replace('http://', 'https://', SITE_PATH).'businesses/membership_plans/'.$this->Fused->encrypt($preReqArr['Business']['id']).'/';?>">visit</a> the payment page and upgrade the plan or copy and paste the url in the browser as, <?php echo str_replace('http://', 'https://', SITE_PATH).'businesses/membership_plans/'.$this->Fused->encrypt($preReqArr['Business']['id']).'/';?><br/><br/>

	With Warm Regards,<br/>
	<?php echo EMAIL_SIGNATURE;?>
</div>