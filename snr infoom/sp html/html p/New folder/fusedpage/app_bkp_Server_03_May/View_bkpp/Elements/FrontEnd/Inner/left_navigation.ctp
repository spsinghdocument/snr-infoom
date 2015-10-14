<?php 
$Count = $this->Fused->countUserFavorite(); 
	if($Count != ''){
	$count = $Count;
	} else {
	$count = '0';
	}
$BusinessCount = $this->Fused->countUserBusiness();
	if($BusinessCount != ''){
	$businesscount = $BusinessCount;
	} else {
	$businesscount = '';
	}
?>

<div class="userdeshboadfl">
	<div class="userdeshboardflin">
		<div class="userimgbox">
			<?php 
				//PROFILE AVATAR START
				if($this->Session->read('Auth.User.User.gender') == '1')
					$avatar = 'front_end/users/male.jpg';
				else
					$avatar = 'front_end/users/female.jpg';

				if(($this->Session->read('Auth.User.User.image')) != ''){
					$realPath = '../webroot/img/front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
					if(is_file($realPath)){
						$avatar = 'front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
					}
				}

				echo $this->Html->link($this->Image->resize($avatar, 57, 57, array('alt'=>'')), SITE_PATH, array('escape'=>false));
				//PROFILE AVATAR END
			?>
		</div>
		<div class="userfrbox"><a href="<?php echo SITE_PATH;?>"><?php echo $this->Session->read('Auth.User.User.first_name').' '.$this->Session->read('Auth.User.User.last_name');?></a></div>
		<div class="clr"></div>
		<ul class="deshboardfllist">
			<li><a href="<?php echo SITE_PATH;?>" <?php if(($this->params['controller']=='users') && ($this->params['action']=='dashboard')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/feed_icon.png', array('alt'=>''));?> Feed</a></li>
			<li><a href="<?php echo SITE_PATH.'businesses/listings/';?>" <?php if(($this->params['controller']=='businesses') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/business_icon.png', array('alt'=>''));?> Business</a></li>
			<?php if($businesscount != ''){ ?>
			<li><a href="<?php echo SITE_PATH.'businesses/my_business/';?>" <?php if(($this->params['controller']=='businesses') && ($this->params['action']=='my_business')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/business_icon.png', array('alt'=>''));?> My Business</a></li>
			<?php } ?>
			<!-- <li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/search_user_icon.png', array('alt'=>''));?> Search User</a></li> -->

			<li><a href="<?php echo SITE_PATH.'friends/listings/';?>" <?php if(($this->params['controller']=='friends') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/friend_icon.png', array('alt'=>''));?> Friends<span><?php echo $this->Fused->countUserFriend(); ?></span></a></li>
 
			<?php if($this->Fused->countReceivedRequest() != '0'){ ?>
			<li><a href="<?php echo SITE_PATH.'friends/received_requests/';?>" <?php if(($this->params['controller']=='friends') && ($this->params['action']=='received_requests')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/friend_icon.png', array('alt'=>''));?> Received Request<span><?php echo $this->Fused->countReceivedRequest(); ?></span></a></li>
			<?php } ?>


			<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/group_icon.png', array('alt'=>''));?> Groups<span>30</span></a></li>
			<li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/mail_icon.png', array('alt'=>''));?> Mail<span>50</span></a></li>
			<li><a href="<?php echo SITE_PATH.'favorites/listings/';?>" <?php if(($this->params['controller']=='favorites') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/favourit_icon.png', array('alt'=>''));?> Favorite<span id="fav_span"><?php echo $count; ?></span><?php echo $this->Form->hidden('fav_count', array('value'=>$count));?></a></li>
		</ul>
	</div>
</div>