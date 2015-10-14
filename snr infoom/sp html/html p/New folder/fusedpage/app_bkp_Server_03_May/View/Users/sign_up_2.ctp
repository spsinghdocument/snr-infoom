<h3>Sign Up</h3>
<?php echo $this->Session->flash();?>
<div class="pleasetext">Last step before you're at your personal page</div>

<!--Start step fl box -->
<div class="stepboxfl">
	<ul class="steptab">
		<li>Step 1</li>
		<li class="sel">Step 2</li>
	</ul>
	<div class="clr"></div>

	<div class="stepinsidebox">
		<div class="stepboinside">
			<div class="gap">&nbsp;</div>
			<div class="steplablefr"><?php echo $this->Html->image('front_end/gmail_logo.jpg', array('alt'=>''));?></div>

			<div class="step2fieldfr">
				<strong>Gmail</strong>
			</div>
			<div class="clr"></div>		
			<div class="emaillable">Your Email:</div>
			<div class="steptwoemilbox">
				<input name="" type="text" class="emailinput" />
			</div>
			<div class="clr"></div>

			<div class="emaillable">&nbsp;</div>
			<div align="right" class="findfriendbtn">
				<?php echo $this->Form->submit('front_end/find_friends_btn.jpg', array('div'=>false));?>
			</div>
			<div class="clr"></div>

			<div class="stetwomainbox">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/hotmail_icon.jpg', array('alt'=>''));?>Windows Live Hotmail</div>
				<div class="stetwofriendfr"><a href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>		
			</div>

			<div class="stetwomainbox">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/yahoo_icon.jpg', array('alt'=>''));?>Yahoo!</div>
				<div class="stetwofriendfr"><a href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>		
			</div>

			<div class="stetwomainbox">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/email_icon.jpg', array('alt'=>''));?>Other Email Services</div>
				<div class="stetwofriendfr"><a href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>	
			</div>
		</div>
		<div class="skiptext"><a href="<?php echo SITE_PATH.'users/sign_in/';?>">Skip this step</a></div>
	</div>
</div>
<!--End step fl box -->

<!--Start step fr text -->
<div class="stepboxfr">
	<div class="steptwofrhd">Are your family and friends on fusedpage already?</div>
	It maybe possible that your friends and family may already have an account with us.  Searching your email Account is the fastest way to finding family and friends.  By connecting with them you get valuable insights Into which businesses they may have used and share/reviewed. 
	</div>
<div class="clr"></div>
<!--End step fr text -->