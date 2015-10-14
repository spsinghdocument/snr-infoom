<span style="color:#0273C4;"><strong>Subscribers</strong></span>
<?php 
		$subscribersArr = $this->Fused->fetchGroupSubscribers($this->Fused->decrypt($this->params['pass'][0]));
		if(!empty($subscribersArr)){
	?>
<div class="insidefrbox">	
	<!-- <div class="commentfltextin"><span>3  People </span>you know rated this:</div>
	<div class="commentfltextin">
		<span>3 People</span> you have know and <span>20 other people</span> recommended this business
	</div> -->
	
	
	<div class="peopeimgbox">
		<div class="peopleinsidebox">
		<?php
			$count = 1;
			foreach($subscribersArr as $subscriber){ //pr($subscriber);die;
				//PROFILE AVATAR START
				$username = $subscriber['User']['username'];
				if($subscriber['User']['gender'] == '1')
					$avatar = 'front_end/users/male.jpg';
				else
					$avatar = 'front_end/users/female.jpg';

				if($subscriber['User']['image'] != ''){
					$realPath = '../webroot/img/front_end/users/profile/'.$subscriber['User']['image'];
					if(is_file($realPath)){
						$avatar = 'front_end/users/profile/'.$subscriber['User']['image'];
					}
				}
				//PROFILE AVATAR END
		?>
			<div class="peopleimgboxsml">
				<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($avatar, 32, 32, array('alt'=>'', 'title'=>$subscriber['User']['first_name'].' '.$subscriber['User']['last_name']));?></a>
			</div>
			
		<?php if($count%6 == 0){?>						
			<div class="clr"></div>
		</div>

		<div class="peopleinsidebox">
		<?php } 
			$count++;} ?>
			<div class="clr"></div>
		</div>
	</div>
	<?php } ?>

	<!-- BUSINESS OWNER CANNOT SEE THE SUBSCRIBE BUTTON -->
	<?php 
	if($this->Session->check('Auth.User.User.id')){
	if($this->Fused->fetchGroupOwner($this->Fused->decrypt($this->params['pass'][0])) != $this->Session->read('Auth.User.User.id')){?>
	<div class="btnimage" id="subscribe_div">
		<div>
			<?php
				$subscribeCount = $this->Fused->validateSubscribedGroup($this->Fused->decrypt($this->params['pass'][0]));
				if($subscribeCount == 0){
			?>
			<a href="javascript:void(0);" onclick="return subscribe_group('subscribe')"><span>Subscribe</span></a>
			<?php
			}else{
			?>
			<a href="javascript:void(0);" onclick="return subscribe_group('unsubscribe');"><span>Unsubscribe</span></a>
			<?php } ?>
		</div>
	</div>
	<?php }}?>
	<div class="clr"></div>
</div>


<script type="text/javascript">
function subscribe_group(type){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_subscribers/subscribe_group/';?>",
		data: "group_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>"+"&type="+type,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>';
			$('#subscribe_div').html(bSend);
		},
		success: function(response){
			$('#subscribe_div').html(response);
		}
	});
}
</script>