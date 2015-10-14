<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#signIn").validationEngine()
	});	
</script>
<!-- VALIDATION ENGINE END -->

<?php echo $this->Session->flash();?>

<div style="min-height:444px;">
	<h3>Login</h3>
	<?php echo $this->Form->create('User', array('action'=>'sign_in', 'id'=>'signIn'));?>
		<div class="contactmainbox">
			<div class="loginbox">
				<div class="contactfrmin">
					<div class="logiontogap">&nbsp;</div>
					<div class="cotactformlable">Email Address:</div>
					<div class="formfield">
						<?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required,custom[email]]', 'maxlength'=>'50', 'required'=>false));?>
					</div>
					<div class="clr"></div>

					<div class="cotactformlable">Password:</div>
					<div class="formfield">
						<?php echo $this->Form->input('User.password_1', array('div'=>false, 'label'=>false, 'type'=>'password', 'class'=>'forminput validate[required]', 'maxlength'=>'70', 'required'=>false));?>
						<div class="loginforgetpass">
							<span class="loginforgetpass" style="float:left; margin-top:5px; font-size:11px; color:#1F1F1F;"><?php echo $this->Form->checkbox('User.remember', array('value'=>'1')).' Remember Me';?></span>
							<span style="float:right;"><a href="<?php echo SITE_PATH.'users/forgot_password/';?>">Forgot My Password?</a></span>
						</div>
					</div>
					<div class="clr"></div>

					<div class="formfield" style="background:none;">
						<?php echo $this->Form->submit('front_end/login_btn.png', array('label'=>false, 'div'=>false));?>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end();?>
	<div class="clr"></div>
</div>
<div class="clr"></div>