<div class="logofl">
	<?php echo $this->Html->link($this->Html->image('front_end/logo.jpg', array('alt'=>'', 'border'=>0)), SITE_PATH, array('escape'=>false));?>
</div>

<div class="logofr">
	<div class="fr">
		<div class="deshboardflbox">
		<?php echo $this->Form->create('Business', array('action'=>'search'));?>
			<?php echo $this->Form->input('Business.keyword', array('onkeyup'=>'header_autosuggation(this.value);','div'=>false, 'label'=>false, 'error'=>false, 'type'=>'text', 'class'=>'deshboartopinput', 'placeholder'=>'Find local businesses (i.e. caf&#233; or hotel or contractor, etc)')); ?>

			<div id="header_suggestions" style="border:1px solid #CDCDCD; width:357px; display:none; position:absolute; background-color:#FFFFFF; max-height:200px; overflow-x:hidden; overflow-y:scroll; z-index:10"></div>

			<?php echo $this->Form->select('Business.city', array($this->Fused->fetchAllBusinessCity()) ,array('div'=>false, 'label'=>false, 'empty'=>'City', 'class'=>'deshboardselbox', 'type'=>'select')); ?>
			<!-- <select name="" class="deshboardselbox"></select> -->
			<?php echo $this->Form->submit('front_end/search_icon.png', array('div'=>false));?>
		<?php echo $this->Form->end(); ?>
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
			<div class="usernamefr" onclick="validateSettingsBox();" style="cursor:pointer;"><?php echo $this->Session->read('Auth.User.User.first_name');?></div>	
			<div class="clr"></div>
			
			<!-- SETTINGS POP UP START -->
			<div class="usertoppopupbox" id="settings_box" style="z-index:10;">
					<div class="usertopshape">				
						<div class="userbtmshape">
							<div class="usermidbg">
								<!-- <div class="usertophd">Use Fusedpage as:</div> -->
								<ul class="userpopuplist">
									<li><a href="<?php echo SITE_PATH.'users/settings/';?>">Account Settings</a></li>
									<li><a href="<?php echo SITE_PATH.'users/sign_out/';?>">Logout</a></li>
									<li class="last"><a href="<?php echo SITE_PATH.'faqs/faq/';?>">Help</a></li>
									<?php if($this->Fused->fetchRefferalPayments() != ''){?>
									<li class="last"><a href="javascript:void(0);">Referral Credits: $<?php echo $this->Fused->fetchRefferalPayments();?></a></li>
									<?php } ?>
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

function header_autosuggation(searchkey){
	if(searchkey.length > 0){
		$('#searchbox').show();
		if(searchkey != ''){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'businesses/auto_data/';?>",
				data: "searchkey="+searchkey,
				beforeSend:function(){
				//alert(categoryId);
					var bSend = '<?php echo $this->Html->image("ajax/loading.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
					$('#header_suggestions').show();
					$('#header_suggestions').html(bSend);
				},
				success: function(response){
					$('#header_suggestions').html(response);
				}
			});
		}
	}else{
		$('#searchbox').hide();
		$('#header_suggestions').hide();
	}
}

function setData(name){
	$('#BusinessKeyword').val(name);
	$('#header_suggestions').hide();
}

function validateSettingsBox(){
	$('#settings_box').toggle();
}
</script>