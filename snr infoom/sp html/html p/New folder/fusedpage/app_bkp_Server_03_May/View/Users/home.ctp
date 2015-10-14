<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#UserHomeForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<!-- MAIN SEARCH CONTAINER START -->
<?php echo $this->Element('FrontEnd/main_search');?>
<!-- MAIN SEARCH CONTAINER END -->


<!-- PAGE MAIN CONTAINER START -->
<div class="midmain" id="main_header_search">
	<!-- PAGE SUB-CONTAINERS START -->
	<div class="midfl">
		<!-- RECENTLY UPDATED BUSINESS SECTION START -->
		<?php echo $this->Element('FrontEnd/recently_updated_business');?>
		<!-- RECENTLY UPDATED BUSINESS SECTION END   -->

		<!-- FEATURED BUSINESS SECTION START -->
		<?php echo $this->Element('FrontEnd/featured_business');?>
		<!-- FEATURED BUSINESS SECTION END   -->
		<div class="clr"></div>
	</div>
	<!-- PAGE SUB-CONTAINERS START -->

	<!-- REGISTRATION SECTION START -->
	<div class="midfr">
		<div class="howitworkbtn">
			<?php echo $this->Html->link($this->Html->image('front_end/how_it_work_new_btn.png', array('alt'=>'')), '/pages/page/how_it_works/', array('escape'=>false));?>
		</div>
		<div class="midfrfrom">
			<h2>Sign Up Now!</h2>			
			<div class="formfrtoptext">Find family, friends, and your favourite businesses</div>
			<div class="connectwith">Connect with <?php echo $this->Html->link($this->Html->image('front_end/face_book_logo.jpg', array('alt'=>'', 'class'=>'vAlign')), 'javascript:void(0);', array('escape'=>false));?></div>
			<div class="orbox">OR</div>
			<div class="forminsidebox">			
			<?php echo $this->Form->create('User', array('action'=>'home'));?>
				<div class="forminsidetoptext">Sign up with your email below:</div>
				<!-- ERROR MSG SECTION START -->
				<?php echo $this->Session->flash();?>
				<!-- ERROR MSG SECTION END   -->
				<div class="formlable">First Name:</div>
				<div class="formfield">
					<?php echo $this->Form->input('User.first_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required]', 'maxlength'=>'100', 'error'=>false, 'data-prompt-position'=>'topLeft', 'required'=>false));
					echo $this->Form->error('User.first_name');
					?>
				</div>
				<div class="clr"></div>

				<div class="formlable">Last Name:</div>
				<div class="formfield">
					<?php echo $this->Form->input('User.last_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required]', 'maxlength'=>'100', 'error'=>false, 'data-prompt-position'=>'topLeft', 'required'=>false));
					echo $this->Form->error('User.last_name');
					?>
				</div>
				<div class="clr"></div>

				<div class="formlable">Email:</div>
				<div class="formfield">
					<?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'forminput validate[required,custom[email],ajax[ajaxEmailCall]]', 'maxlength'=>'100', 'error'=>false, 'data-prompt-position'=>'topLeft', 'required'=>false));
					echo $this->Form->error('User.email');
					?>
				</div>
				<div class="clr"></div>

				<div class="formlable">Password:</div>
				<div class="formfield">
					<?php echo $this->Form->input('User.password_1', array('div'=>false, 'label'=>false, 'type'=>'password', 'class'=>'forminput validate[required]', 'maxlength'=>'50', 'error'=>false, 'data-prompt-position'=>'topLeft', 'required'=>false));
					echo $this->Form->error('User.password_1');
					?>
				</div>
				<div class="clr"></div>

				<div class="formlable">Confirm <br />Password:</div>
				<div class="formfield">
					<?php echo $this->Form->input('User.password_2', array('div'=>false, 'label'=>false, 'type'=>'password', 'class'=>'forminput validate[required]', 'maxlength'=>'50', 'error'=>false, 'data-prompt-position'=>'topLeft', 'required'=>false));
					echo $this->Form->error('User.password_2');
					?>
				</div>
				<div class="clr"></div>

				<div class="formlable">&nbsp;</div>
				<div class="privecytext">By clicking on sign up you agree to fusedpage <a href="<?php echo SITE_PATH.'pages/page/privacy_policy/';?>" target="_blank">Privacy Policy</a> and <a href="<?php echo SITE_PATH.'pages/page/terms_conditions/';?>" target="_blank">Terms &amp; Conditions</a></div>
				<div class="clr"></div>

				<div class="formlable">&nbsp;</div>
				<div class="formfield" style="background:none;">
					<?php echo $this->Form->submit('front_end/sign_up_btn.jpg', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<!-- REGISTRATION SECTION END   -->
	<div class="clr"></div>
</div>
<!-- PAGE MAIN CONTAINER END -->