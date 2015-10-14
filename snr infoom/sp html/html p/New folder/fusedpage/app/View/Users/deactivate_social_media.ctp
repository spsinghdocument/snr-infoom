<?php
	if($saved == 'yes'){
		//for facebook
		if($post['socialMedia'] == 'facebook'){
?>
		<a href="javascript:void(0);" style="text-decoration:none; color:green;" onclick="return validateSocialMedia('facebook', 'enable');">Enable</a>
<?php
		}else if($post['socialMedia'] == 'twitter'){ // for twitter
?>
		<a href="javascript:void(0);" style="text-decoration:none; color:green;" onclick="return validateSocialMedia('twitter', 'enable');">Enable</a>
<?php
		}
	}else{
		echo '<font color="red">Please Try Later</font>';
	}
?>