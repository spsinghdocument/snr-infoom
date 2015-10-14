<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#UserSignInForm").validationEngine()
	});	
</script>
<!-- VALIDATION ENGINE END -->

<div class="logofl">
	<?php echo $this->Html->link($this->Html->image('front_end/logo.jpg', array('alt'=>'', 'border'=>0)), SITE_PATH, array('escape'=>false));?>
</div>

<div class="logofr">
	<div class="headertopfrinbox">
	<?php echo $this->Form->create('User', array('action'=>'sign_in'));?>
		<div class="topfrinputmain">
			<?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'topfrinput validate[required,custom[email]]', 'maxlength'=>'50', 'required'=>false, 'onfocus'=>'clearText(this)', 'onblur'=>'replaceText(this)', 'value'=>'Your Email', 'data-prompt-position'=>'bottomLeft'));?>
		</div>
		<div class="topfrinputmain">
			<?php echo $this->Form->input('User.password_1', array('div'=>false, 'label'=>false, 'type'=>'password', 'class'=>'topfrinput last validate[required]', 'maxlength'=>'70', 'required'=>false, 'onfocus'=>'clearText(this)', 'onblur'=>'replaceText(this)', 'value'=>'Your Email', 'data-prompt-position'=>'bottomLeft'));?>
		</div>
		<div class="signinbox">
			<?php 
				echo $this->Form->hidden('User.remember', array('value'=>'0'));
				echo $this->Form->submit('front_end/sign_in_btn.gif', array('div'=>false));
			?>
			<span class="forgetpass"><?php echo $this->Html->link('Forgot Password?', '/users/forgot_password/', array('escape'=>false));?></span>
		</div>
	<?php echo $this->Form->end();?>
	</div>
</div>
<div class="clr"></div>