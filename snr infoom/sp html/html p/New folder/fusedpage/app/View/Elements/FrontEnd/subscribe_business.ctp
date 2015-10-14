<div class="insidefrbox">	
	<!-- <div class="commentfltextin"><span>3  People </span>you know rated this:</div>
	<div class="commentfltextin">
		<span>3 People</span> you have know and <span>20 other people</span> recommended this business
	</div> -->
	
	<?php 
		$subscribersArr = $this->Fused->fetchBusinessSubscribers($this->Fused->decrypt($this->params['pass'][0]));
		if(!empty($subscribersArr)){
	?>
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
	if($this->Fused->fetchBusinessOwner($this->Fused->decrypt($this->params['pass'][0])) != $this->Session->read('Auth.User.User.id')){?>
	<div class="btnimage">
		<div id="subscribe_div">
			<?php
				$subscribeCount = $this->Fused->validateSubscribedBusiness($this->Fused->decrypt($this->params['pass'][0]));
				if($subscribeCount == 0){
			?>
			<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
			<a href="javascript:void(0);" onclick="return subscribe_business('subscribe')"><span>Subscribe</span></a>
			<?php } ?>
			<?php
			}else{
			?>
			<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
			<a href="javascript:void(0);" onclick="return subscribe_business('unsubscribe');"><span>Unsubscribe</span></a>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
	<?php }}?>
	<div class="clr"></div>
</div>


<script type="text/javascript">
function subscribe_business(type){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_subscribers/subscribe_business/';?>",
		data: "business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>"+"&type="+type,
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