<div class="logofl">
	<?php echo $this->Html->link($this->Html->image('front_end/logo.jpg', array('alt'=>'', 'border'=>0)), SITE_PATH, array('escape'=>false));?>
</div>

<div class="logofr">
	<div class="fr">
		<div class="deshboardflbox">
			<input name="" type="text" class="deshboartopinput" value="Find local businesses (i.e. caf&#233; or hotel or contractor, etc)" onfocus="clearText(this)" onblur="replaceText(this)" /><select name="" class="deshboardselbox"></select><?php echo $this->Form->submit('front_end/search_icon.png', array('div'=>false));?>
		</div>

		<div class="deshboardfrimgbox">
			<div class="deshboardtopfrimg">
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

					echo $this->Image->resize($avatar, 32, 32, array('alt'=>''));
					//PROFILE AVATAR END

					echo $this->Html->link($this->Html->image('front_end/deshboardtop_imgdrowpdown.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'onclick'=>'validateSettingsBox();'));
				?>
			</div>
			<div class="usernamefr"><?php echo $this->Session->read('Auth.User.User.first_name');?></div>	
			<div class="clr"></div>
			
			<!-- SETTINGS POP UP START -->
			<div class="usertoppopupbox" id="settings_box">
					<div class="usertopshape">				
						<div class="userbtmshape">
							<div class="usermidbg">
								<!-- <div class="usertophd">Use Fusedpage as:</div> -->
								<ul class="userpopuplist">
									<li><a href="<?php echo SITE_PATH.'users/settings/';?>">Account Settings</a></li>
									<li><a href="<?php echo SITE_PATH.'users/sign_out/';?>">Logout</a></li>
									<li class="last"><a href="<?php echo SITE_PATH.'faqs/faq/';?>">Help</a></li>
								</ul>
							</div>
						</div>
					</div>				
				</div>
			<!-- SETTINGS POP UP END -->
		</div>
	</div>
</div>
<div class="clr"></div>

<script type="text/javascript">
function validateSettingsBox(){
	$('#settings_box').toggle();
}
</script>