<h3>Sign Up</h3>
<?php //echo $this->Session->flash();?>
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

		<!-- GMAIL SECTION START -->
			<!-- GMAIL OUTER SECTION START -->
			<div id="gmail_outer" class="stetwomainbox outer" style="border-top:none; display:none;">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/gmail_logo.jpg', array('alt'=>''));?>Gmail</div>
				<div class="stetwofriendfr"><a onclick="return expand_email_section('gmail');" href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>
			</div>
			<!-- GMAIL OUTER SECTION END -->

			<!-- GMAIL INNER SECTION START -->
			<div id="gmail_inner" class="inviters">
				<div class="steplablefr"><?php echo $this->Html->image('front_end/gmail_logo.jpg', array('alt'=>''));?></div>
				<div class="step2fieldfr">
					<strong>Gmail</strong>
				</div>
				<div class="clr"></div>
				
				<div class="emaillable">Email:</div>
				<div class="steptwoemilbox">
					<input id="gmail_email" name="" type="text" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div class="emaillable">Password:</div>
				<div class="steptwoemilbox">
					<input id="gmail_password" name="" type="password" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div id="gmail_error" class="emaillable error_class" style="width:260px; color:#FF0000;"></div>
				<div align="right" class="findfriendbtn" onclick="return fetchProviderEmails('gmail');" style="width:80px;">
					<?php echo $this->Form->submit('front_end/find_friends_btn.jpg', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			</div>
			<!-- GMAIL INNER SECTION END -->
		<!-- GMAIL SECTION END -->

		<!-- HOTMAIL SECTION START -->
			<!-- HOTMAIL OUTER SECTION START -->
			<div class="stetwomainbox outer" id="hotmail_outer">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/hotmail_icon.jpg', array('alt'=>''));?>Windows Live Hotmail</div>
				<div class="stetwofriendfr"><a onclick="return expand_email_section('hotmail');" href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>		
			</div>
			<!-- HOTMAIL OUTER SECTION END -->

			<!-- HOTMAIL INNER SECTION START -->
			<div id="hotmail_inner" class="inviters" style="display:none; border-top:2px solid #F1F1F1; padding-top:10px;">
				<div class="steplablefr"><?php echo $this->Html->image('front_end/hotmail_icon.jpg', array('alt'=>''));?></div>
				<div class="step2fieldfr">
					<strong>Windows Live Hotmail</strong>
				</div>
				<div class="clr"></div>
				
				<div class="emaillable">Email:</div>
				<div class="steptwoemilbox">
					<input id="hotmail_email" name="" type="text" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div class="emaillable">Password:</div>
				<div class="steptwoemilbox">
					<input  id="hotmail_password" name="" type="password" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div id="hotmail_error" class="emaillable error_class" style="width:260px; color:#FF0000;"></div>
				<div align="right" class="findfriendbtn" onclick="return fetchProviderEmails('hotmail');" style="width:80px;">
					<?php echo $this->Form->submit('front_end/find_friends_btn.jpg', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			</div>
			<!-- HOTMAIL INNER SECTION END -->
		<!-- HOTMAIL SECTION END -->

		<!-- YAHOO SECTION START -->
			<!-- YAHOO OUTER SECTION START -->
			<div class="stetwomainbox outer" id="yahoo_outer">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/yahoo_icon.jpg', array('alt'=>''));?>Yahoo!</div>
				<div class="stetwofriendfr"><a onclick="return expand_email_section('yahoo');" href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>		
			</div>
			<!-- YAHOO OUTER SECTION END -->

			<!-- YAHOO INNER SECTION START -->
			<div id="yahoo_inner" class="inviters" style="display:none; border-top:2px solid #F1F1F1; padding-top:10px;">
				<div class="steplablefr"><?php echo $this->Html->image('front_end/yahoo_icon.jpg', array('alt'=>''));?></div>
				<div class="step2fieldfr">
					<strong>Yahoo!</strong>
				</div>
				<div class="clr"></div>
				
				<div class="emaillable">Email:</div>
				<div class="steptwoemilbox">
					<input id="yahoo_email" name="" type="text" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div class="emaillable">Password:</div>
				<div class="steptwoemilbox">
					<input id="yahoo_password" name="" type="password" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div id="yahoo_error" class="emaillable error_class" style="width:260px; color:#FF0000;"></div>
				<div align="right" class="findfriendbtn" onclick="return fetchProviderEmails('yahoo');" style="width:80px;">
					<?php echo $this->Form->submit('front_end/find_friends_btn.jpg', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			</div>
			<!-- YAHOO INNER SECTION END -->
		<!-- YAHOO SECTION END -->

		<!-- OTHER EMAILS SECTION START -->
			<!-- OTHER OUTER SECTION START -->
			<div class="stetwomainbox outer" id="other_outer">
				<div class="stetwoiconfl"><?php echo $this->Html->image('front_end/email_icon.jpg', array('alt'=>''));?>Other Email Services</div>
				<div class="stetwofriendfr"><a onclick="return expand_email_section('');" href="javascript:void(0);">Find Friends</a></div>
				<div class="clr"></div>	
			</div>
			<!-- OTHER OUTER SECTION END -->

			<!-- OTHER INNER SECTION START -->
			<div id="other_inner" class="inviters" style="display:none; border-top:2px solid #F1F1F1; padding-top:10px;">
				<div class="steplablefr"><?php echo $this->Html->image('front_end/email_icon.jpg', array('alt'=>''));?></div>
				<div class="step2fieldfr">
					<strong>Other Email Services</strong>
				</div>
				<div class="clr"></div>
				
				<div class="emaillable">Email:</div>
				<div class="steptwoemilbox">
					<input id="other_email" name="" type="text" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div class="emaillable">Password:</div>
				<div class="steptwoemilbox">
					<input id="other_password" name="" type="password" class="emailinput" />
				</div>
				<div class="clr"></div>

				<div class="emaillable">Provider:</div>
				<div class="steptwoemilbox">
					<?php echo $this->Form->select('Invite.provider', $this->Fused->fetchEmailProviders(), array('empty'=>'Select', 'class'=>'emailinput', 'style'=>'width:134px; padding:5px;', 'onchange'=>'return validate_email_provider(this.value);'));?>
				</div>
				<div class="clr"></div>

				<div id="other_error" class="emaillable error_class" style="width:260px; color:#FF0000;"></div>
				<div align="right" class="findfriendbtn" onclick="return fetchProviderEmails('');" style="width:80px;">
					<?php echo $this->Form->submit('front_end/find_friends_btn.jpg', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			</div>
			<!-- OTHER INNER SECTION START -->
		<!-- OTHER EMAILS SECTION END -->


		</div>
		<div class="skiptext"><a href="<?php echo SITE_PATH.'users/sign_in/';?>">Skip this step</a></div>
	</div>
</div>
<!--End step fl box -->

<!--Start step fr text -->
<div class="stepboxfr">
	<div class="steptwofrhd">Are your family and friends on fusedpage already?</div>
	It maybe possible that your friends and family may already have an account with us.  Searching your email Account is the fastest way to finding family and friends.  By connecting with them you get valuable insights Into which businesses they may have used and share/reviewed. 
	
	<!-- LIST FRIENDS SECTION START -->
	<div id="list_friends" style="margin-top:10px;"></div>
	<!-- LIST FRIENDS SECTION END -->
</div>
<div class="clr"></div>
<!--End step fr text -->

<!-- HIDDEN FIELDS START -->
<input type="hidden" value="gmail" id="email_provider"/>
<!-- HIDDEN FIELDS END -->

<script type="text/javascript">
function expand_email_section(provider){
	$('#email_provider').val(provider);
	$('.error_class').html('');

	//hide all divs first inviters
	$('.inviters').hide();
	$('.outer').show();

	//show the clicked div for expansion
	if(provider == '')
		provider = 'other';
	$('#'+provider+'_outer').hide(); //hide the outer div
	$('#'+provider+'_inner').show(); // show the inner div

	$('#'+provider+'_email').val('');
	$('#'+provider+'_password').val('');
}

function validate_email_provider(provider){
	if(provider != '')
		$('#email_provider').val(provider);
	else
		$('#email_provider').val('');
}

function fetchProviderEmails(provider){
	var selectedProvider = $('#email_provider').val();
	var user_id = "<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>";
	
	$('.error_class').html('');
	$('#list_friends').html('');

	var email = '';
	var password = '';

	if(provider == '')
		provider = 'other';

	email = $('#'+provider+'_email').val();
	password = $('#'+provider+'_password').val();

	if(selectedProvider != ''){ 
		
		//validate Email start
		if(email == ''){
			$('#'+provider+'_error').html('Email Required!');
			$('#'+provider+'_email').focus();
			return false;
		}else{
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(reg.test(email) == false){
				$('#'+provider+'_error').html('Invalid Email!');
				$('#'+provider+'_email').focus();
				return false;
			}
		}

		//Validate Email Password
		if(password == ''){
			$('#'+provider+'_error').html('Password Required!');
			$('#'+provider+'_password').focus();
			return false;
		}

		//fetch the data
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'invites/validate_invites_credentials/';?>",
			data: "email_provider="+selectedProvider+"&email="+email+"&password="+password+"&inviter="+user_id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>'; 
				$('#'+provider+'_error').html(bSend);
			},
			success: function(response){
				$('#'+provider+'_error').html('');
				if(response != 'OK')
					$('#'+provider+'_error').html(response);
				else
					fetchEmailContacts(provider);
			}		
		});
	}else{
		$('#'+provider+'_error').html('Email Provider Required!');
		return false;
	}
}

function fetchEmailContacts(provider){
	var selectedProvider = $('#email_provider').val();
	var email = $('#'+provider+'_email').val();
	var password = $('#'+provider+'_password').val();
	var user_id = "<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>";

	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'invites/invite_friends_invite/';?>",
		data: "email_provider="+selectedProvider+"&email="+email+"&password="+password+"&inviter="+user_id,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>'; 
			$('#list_friends').html(bSend);
		},
		success: function(response){
			$('#'+provider+'_email').val('');
			$('#'+provider+'_password').val('');
			$('#list_friends').html(response);
		}		
	});
}
</script>