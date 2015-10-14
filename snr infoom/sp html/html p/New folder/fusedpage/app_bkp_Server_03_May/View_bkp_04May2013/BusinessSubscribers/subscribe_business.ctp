<?php
	if($ret == 'subscribed'){
		if(isset($post['view']) && $post['view'] == 'listing'){
?>
	<a href="javascript:void(0);" onclick="return subscribe_business('unsubscribe','<?php echo $post['business_id'];?>');"><span>Unsubscribe</span></a>
	<?php }else{ ?>
	<a href="javascript:void(0);" onclick="return subscribe_business('unsubscribe');"><span>Unsubscribe</span></a>
	<?php } ?>
<?php
	}else if($ret == 'unsubscribed'){
		if(isset($post['view']) && $post['view'] == 'listing'){
?>
	<a href="javascript:void(0);" onclick="return subscribe_business('subscribe','<?php echo $post['business_id'];?>');"><span>Subscribe</span></a>
	<?php }else{ ?>
	<a href="javascript:void(0);" onclick="return subscribe_business('subscribe');"><span>Subscribe</span></a>
	<?php } ?>
<?php }else{ ?>
	<font color="red"><?php echo $ret;?></font>
<?php
	}
?>