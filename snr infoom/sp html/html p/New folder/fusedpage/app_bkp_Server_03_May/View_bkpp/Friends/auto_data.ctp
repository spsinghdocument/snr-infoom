<?php if(!empty($searchArr)){ ?>
<div>
<?php 
		foreach($searchArr as $searchArr){ //pr($listing);die;

		$userImage = 'front_end/business/noimage.jpg';
				if($searchArr['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$searchArr['User']['image'];
					if(is_file($imageRealPath))
					$userImage = 'front_end/users/profile/'.$searchArr['User']['image'];
					}
				$username = $searchArr['User']['username'];
?>

<div class="friendmainbox">
					<div class="friendimgbox"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a></div>
					<div class="friendfrbox">
						<div class="friendhd"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name']; ?></a></div>
						<div class="friendsmltext"><?php echo $searchArr['User']['city'].", ".$searchArr['User']['state_code']; ?> </div>
						
					</div>
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