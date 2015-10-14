<?php if(!empty($searchArr)){ ?>
<div>
<?php 
		foreach($searchArr as $searchArr){ //pr($searchArr);die;
			$friend_Status = $this->Fused->checkFriendStatus($searchArr['User']['id']); //pr($friend_Status);
		$userImage = 'front_end/business/noimage.jpg';
				if($searchArr['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$searchArr['User']['image'];
					if(is_file($imageRealPath))
					$userImage = 'front_end/users/profile/'.$searchArr['User']['image'];
					}
				$username = $searchArr['User']['username'];
?>

<div class="friendmainbox">
					<!-- <div class="friendimgbox"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a></div> -->
					<div class="friendimgbox"><a href="javaScript:void(0);" onclick="return setData('<?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name']; ?>');"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a></div>
					<div class="friendfrbox">
						<div class="friendhd"><a href="javaScript:voida(0);" onclick="return setData('<?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name']; ?>');"><?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name']; ?></a></div>
						<div class="friendsmltext"><?php echo $searchArr['User']['city'].", ".$searchArr['User']['state_code']; ?> </div>
					</div>

					<div style="margin-top:5px; margin-left:85px; font-size:11px;"><?php echo $this->Html->link('View Profile', '/users/profile/'.$username.'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#006EBD;'));?></div>


					<?php if(!empty($friend_Status)){ ?>
					<!-- FOR FRIEND REQUEST SENT START-->
					<?php if($friend_Status['Friend']['friendship_status'] == '0'){ ?>
					<div class="friendsharelink" id="sent_request1" style="margin-left:85px; margin-top:5px;"><a href="JavaScript:void(0);" style="padding-left:0; color:green;">Friend Requested</a></div>

					<?php } else if($friend_Status['Friend']['friendship_status'] == '1'){ ?>

					<div class="friendsharelink" style="margin-left:85px; margin-top:5px;"><a href="JavaScript:void(0);" onclick="return unfriend('<?php echo $friend_Status['Friend']['id']; ?>');" style="color:red; padding-left:0;">Unfriend</a></div>

					<?php } else if($friend_Status['Friend']['friendship_status'] == '2'){ ?>
					<div class="friendsharelink" id="sent_request" style="margin-left:85px; margin-top:5px;"><a href="JavaScript:void(0);" onclick="sent_request('<?php echo $searchArr['User']['id']; ?>');" style="padding-left:0;">Add As Friend</a></div>
					<?php } ?>
					<?php } else { ?>
					<div class="friendsharelink" id="sent_request" style="margin-left:85px; margin-top:5px;"><a href="JavaScript:void(0);" onclick="sent_request('<?php echo $searchArr['User']['id']; ?>');" style="padding-left:0;">Add As Friend</a></div>
					<div class="friendsharelink" id="sent_request1" style="display:none; margin-left:85px; margin-top:5px;"><a href="JavaScript:void(0);" style="padding-left:0; color:green;">Friend Request Sent</a></div>

					<?php } ?>
					<!-- FOR FRIEND REQUEST SENT END-->

				</div>
<div class="clr"></div>

			<!-- <div class="userimgbox"><?php echo $this->Image->resize($userImage, 57, 57, array('alt'=>'')); ?></div>
			<div class="userfrbox" style="width:248px;"><?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name'].".".$searchArr['User']['city']; ?><?php echo $searchArr['User']['state']; ?></div>
			<div class="clr"></div> -->
			
<?php
		}
?>
</div>
<?php } else { ?>
<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>