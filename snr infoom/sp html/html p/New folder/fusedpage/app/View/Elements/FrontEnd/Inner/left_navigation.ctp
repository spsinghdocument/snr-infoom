<?php 
if(isset($this->params['id']) && $this->params['id'] != 'profile')
	$page = $this->params['id'];
else
	$page = '';
$this->set('page', $page);

$profileUser = $this->Fused->fetchProfileUser($page);

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
<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
<div class="userdeshboadfl">
	<div class="userdeshboardflin">
	<?php //if(!empty($profileUser)){ echo 'if';?>
		<!-- <div class="userimgbox">
			<?php 
				//PROFILE AVATAR START
				if($this->Session->read('Auth.User.User.gender') == '1')
					$avatar = 'front_end/users/male.jpg';
				else
					$avatar = 'front_end/users/female.jpg';

				if($profileUser['User']['image'] != ''){
					$realPath = '../webroot/img/front_end/users/profile/'.$profileUser['User']['image'];
					if(is_file($realPath)){
						$avatar = 'front_end/users/profile/'.$profileUser['User']['image'];
					}
				}

				echo $this->Html->link($this->Image->resize($avatar, 57, 57, array('alt'=>'')), SITE_PATH, array('escape'=>false));
				//PROFILE AVATAR END
			?>
		</div>
	
		<div class="userfrbox">
			<a href="<?php echo SITE_PATH;?>"><?php echo $profileUser['User']['first_name'].' '.$profileUser['User']['last_name'];?></a>
		</div> -->

	<?php //} else {?>

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
		<div class="userfrbox">
			<a href="<?php echo SITE_PATH;?>"><?php echo $this->Session->read('Auth.User.User.first_name').' '.$this->Session->read('Auth.User.User.last_name');?></a> <br/><br/>

			<a style="font-size:10px;" href="<?php echo SITE_PATH.'users/settings/';?>">Edit Profile</a>
		</div>
	<?php //} ?>

		<div class="clr"></div>
		<ul class="deshboardfllist">
			<li><a href="<?php echo SITE_PATH;?>" <?php if(($this->params['controller']=='users') && ($this->params['action']=='dashboard')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/feed_icon.png', array('alt'=>''));?> Feed</a></li>
			<li><a href="<?php echo SITE_PATH.'businesses/listings/';?>" <?php if(($this->params['controller']=='businesses') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/business_icon.png', array('alt'=>''));?> Business</a></li>
			<?php if($businesscount != ''){ ?>
			<li><a href="<?php echo SITE_PATH.'businesses/my_business/';?>" <?php if(($this->params['controller']=='businesses') && ($this->params['action']=='my_business')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/business_icon.png', array('alt'=>''));?> My Business</a></li>
			<?php } ?>
			<!-- <li><a href="javascript:void(0);"><?php echo $this->Html->image('front_end/search_user_icon.png', array('alt'=>''));?> Search User</a></li> -->

			<li><a href="<?php echo SITE_PATH.'friends/listings/';?>" <?php if(($this->params['controller']=='friends') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/friend_icon.png', array('alt'=>''));?> Friends<span><?php echo $this->Fused->countUserFriend(); ?></span></a></li>
 
			<?php if($this->Fused->countReceivedIgnoredRequest() != '0'){ ?>
			<li><a href="<?php echo SITE_PATH.'friends/received_requests/';?>" <?php if(($this->params['controller']=='friends') && ($this->params['action']=='received_requests')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/friend_icon.png', array('alt'=>''));?> Received Request<span><?php 
				$reqstsReceived = $this->Fused->countReceivedRequest();
				if($reqstsReceived != '0')
					echo $reqstsReceived;
			?></span></a></li>
			<?php } ?>

			<!-- GROUP SECTION START -->
			<?php $groupCount = $this->Fused->countGroup();?>
 
			<li><a href="<?php echo SITE_PATH.'groups/listings/';?>" <?php if(($this->params['controller']=='groups') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/group_icon.png', array('alt'=>''));?> Groups<span><?php if($groupCount > 0){ echo $groupCount; } else { echo '0'; }?></span></a></li>
			<!-- GROUP SECTION END -->

			<li><a href="<?php echo SITE_PATH.'mails/listing/';?>"><?php echo $this->Html->image('front_end/mail_icon.png', array('alt'=>''));?> Mail <?php $mailsCount = $this->Fused->countTotalInboxMessages(); if($mailsCount > 0){?><span id="left_navigation_inbox"><?php echo $mailsCount;?></span><?php } ?></a></li>

			<li><a href="<?php echo SITE_PATH.'favorites/listings/';?>" <?php if(($this->params['controller']=='favorites') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/favourit_icon.png', array('alt'=>''));?> Favorite<span id="fav_span"><?php echo $count; ?></span><?php echo $this->Form->hidden('fav_count', array('value'=>$count));?></a></li>

			<li><a href="<?php echo SITE_PATH.'invites/invite_friends/';?>" <?php if(($this->params['controller']=='invites') && ($this->params['action']=='listings')){echo 'class="sel"';}?>><?php echo $this->Html->image('front_end/favourit_icon.png', array('alt'=>''));?> Invite Friends</a></li>
		</ul>
	</div>
</div>
<?php } else { ?>
	<div class="userdeshboadfl">
		<div class="userdeshboardflin">	
		<?php $categoryArr = $this->Fused->fetchAllBusinessCategories();?>
			<ul class="deshboardfllist">
			<?php foreach($categoryArr as $category){?>
				<li><a class="sel" href="javaScript:void(0);" onclick="searchcategory('<?php echo $category['Category']['id']; ?>')"><?php echo $category['Category']['name']; ?></a></li>
			<?php } ?>
			</ul>
		</div>
	</div>

<script type="text/javascript">
function searchcategory(cat_id){

	if(cat_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/category_search/';?>",
			data: "cat_id="+cat_id,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#category_search').html(bSend);
			},
			success: function(response){
				$('#category_search').html(response);
			}
		});
	}
}
</script>
<?php } ?>