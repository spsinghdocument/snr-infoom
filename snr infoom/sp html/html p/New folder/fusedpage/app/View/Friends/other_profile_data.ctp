<?php
	if(($type == 'unfriend') || ($type == 'delete')){ // delete the record
?>
		<!-- ADD FRIEND SECTION START -->
		<span class="norbtn">
			<a href="javascript:void(0);" onclick="return validateRequest('add');">Add Friend</a>
		</span>
		<!-- ADD FRIEND SECTION END -->
<?php
	}elseif($type == 'accept'){ //for frnd rqst accept
?>
		<!-- UNFRIEND START -->
		<span class="norbtn">
			<a href="javascript:void(0);" onclick="return validateRequest('unfriend');">Unfriend</a>
		</span>
		<!-- UNFRIEND START -->
<?php
	}elseif($type == 'ignore'){ //for frnd rqst ignore
?>
		<!-- ACCEPT START -->
		<span class="norbtn">
			<a href="javascript:void(0);" onclick="return validateRequest('accept');">Accept Request</a>
		</span>
		<!-- ACCEPT END -->

		<!-- DELETE START -->
		<span class="norbtn">
			<a href="javascript:void(0);" onclick="return validateRequest('delete');">Decline</a>
		</span>
		<!-- DELETE END -->
<?php
	}elseif($type == 'add'){ //for frnd rqst ignore
?>
		<!-- REQUEST SENT START -->
		<span class="norbtn">
			<a href="javascript:void(0);" style="cursor:text">Friend Request Sent</a>
		</span>
		<!-- REQUEST SENT END -->
<?php
	}
?>