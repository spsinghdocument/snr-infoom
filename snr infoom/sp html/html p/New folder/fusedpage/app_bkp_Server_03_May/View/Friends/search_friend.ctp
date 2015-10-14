<?php if(!empty($viewListing)){ //pr($viewListing);
$i = 0;
	foreach($viewListing as $listing){ /*pr($listing); */ //echo ' a ';
	$received_friend = $this->Fused->fetchReceivedFriend($listing['User']['id']); //pr($received_friend);
	/*echo $received_friend['Friend']['friendship_status']; */
	/* echo $received_friend['Friend']['id']; */
	$userImage = 'front_end/business/noimage.jpg';
		if($listing['User']['image'] != ''){
			$imageRealPath = '../webroot/img/front_end/users/profile/'.$listing['User']['image'];
			if(is_file($imageRealPath))
				$userImage = 'front_end/users/profile/'.$listing['User']['image'];
				
		}
		$username = $listing['User']['username'];
	if($i%2 == 0){
	$class = "friendmainbox";
	$class1 = '';
	} else {
	$class = "friendmainbox last";
	$class1 = '<div class="clr"></div>';
	}
	
	?>
				
				<div class="<?php echo $class; ?>">
					<div class="friendimgbox"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a></div>
					<div class="friendfrbox">
						<div class="friendhd"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $listing['User']['first_name']." ".$listing['User']['last_name'].", ".$listing['User']['city']; ?></a></div>
						<div class="friendsmltext"><?php echo $listing['User']['state'].", ".$listing['Country']['countries_name']; ?> </div>
						<?php if($received_friend['Friend']['friendship_status'] == '0'){ ?>
						<div class="friendsharelink" id="sent_request"><a href="JavaScript:void(0);" style="padding-left:0; color:green;">Request Sent</a></div>
						<?php } else if($received_friend['Friend']['friendship_status'] == '1') { ?>
						<div class="friendsharelink" id="sent_request"><a href="JavaScript:void(0);" style="padding-left:0; color:red;" onclick="return unfriend('<?php echo $received_friend['Friend']['id']; ?>');">Unfriend</a></div>
						<?php } else { ?>
						<div class="friendsharelink" id="sent_request"><a href="JavaScript:void(0);" onclick="sent_request('<?php echo $listing['User']['id']; ?>');" style="padding-left:0;">Add As Friend</a></div>
						<?php } ?>
						<div class="friendsharelink" id="sent_request1" style="display:none;"><a href="JavaScript:void(0);" style="padding-left:0; color:green;">Friend Requested</a></div>
						
					</div>
				</div>
				<?php echo $class1; ?>
<?php $i++; } } else { ?>
				<div style="pading-top:10px; color:red; padding-left:250px;"><strong>No Friends Availables!!</strong></div>
<?php } ?>

