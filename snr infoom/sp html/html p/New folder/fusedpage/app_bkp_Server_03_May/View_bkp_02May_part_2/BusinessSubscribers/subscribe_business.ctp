<?php
	if($ret == 'subscribed'){
?>
	<a href="javascript:void(0);" onclick="return subscribe_business('unsubscribe');"><span>Subscribed</span></a>
<?php
	}else if($ret == 'unsubscribed'){
?>
	<a href="javascript:void(0);" onclick="return subscribe_business('subscribe');"><span>Subscribe</span></a>
<?php }else{ ?>
	<font color="red"><?php echo $ret;?></font>
<?php
	}
?>