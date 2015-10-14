<h3>Member Referral Program</h3>
<div class="memberrefferbox">
	<div class="earncemainbox">
		<div class="earncashbox">
		<div class="earncashd">Refer people! Earan Cash!</div>
		<div>Earn up to $100 when someone you refer signs up for a paid account.Cash out, apply it as credit for purchases or send the amount to your favourite charity.</div>
	</div>
		<div class="earncashfrbox">
		For every referral that results in standard installation, service repair and/or protection plan agreement, referring customer will be credited $25
		<div class="sociallogo">
			<script type="text/javascript">var switchTo5x=true;</script>
			<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
			<script type="text/javascript">stLight.options({publisher: "fbfeddae-3c26-4625-9774-9726836a48cf", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
			<span class='st_facebook_hcount' displayText='Facebook' st_title=''></span>
			<span class='st_twitter_hcount' displayText='Tweet' st_title=''></span>
			<span class='st_email_hcount' displayText='Email' st_title=''></span>
			<!-- <?php
				echo $this->Html->link($this->Html->image('front_end/face_book_logo_member.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));

				echo $this->Html->link($this->Html->image('front_end/twitter_logo_member.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));

				echo $this->Html->link($this->Html->image('front_end/email_icon_member.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));
			?> -->

		</div>
	</div>
		<div class="clr"></div>
	</div>
	<div>
		<div class="whatisthishd">What is this?</div>
		<div class="whatisthistext">What is thisLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vehicula sapien mauris, sed laoreet turpis. Vivamus ac nunc id risus posuere ultricies. Nullam quis magna ac quam tempor molestie a sed eros. Donec ultricies sapien in ipsum vehicula posuere semper tortor malesuada. Etiam viverra, nunc a aliquam ultrices, felis neque pellentesque diam, porttitor fermentum velit mauris nec metus. Morbi ultricies scelerisque lectus in molestie.</div>
	</div>
	<!-- <div class="signupreffer">
		<?php echo $this->Form->submit('front_end/sign_up_to_refer_btn.jpg', array('div'=>false));?>
	</div> -->

	<!-- SECTION FOR INVITE FRIENDS START -->
	<div class="midinsidemain" style="width:800px;">
		<div>
			<div class="mailtophdbox">
				<div class="insideflhd">Invite Friends</div>
				<div class="clr"></div>	
			</div>
		</div>

		<div class="accwhitebox">
			<div class="formlablebig">Email Address:</div>
			<div>
				<?php echo $this->Form->textarea('Invite.invitee_email', array('div'=>false, 'label'=>false, 'style'=>'border:1px solid #CDCDCD; resize:none;', 'rows'=>3, 'cols'=>50));?> (Comma seperated, Max 5)
				<div id="invitee_email_error"></div>
			</div>
			<div class="clr"></div>

			<div class="formlablebig" style="margin-top:10px;">Message:</div>
			<div style="margin-top:10px;">
				<?php echo $this->Form->textarea('Invite.message', array('div'=>false, 'label'=>false, 'style'=>'border:1px solid #CDCDCD; resize:none;', 'rows'=>4, 'cols'=>50));?>
				<div id="message_error"></div>
			</div>
			<div class="clr"></div>

			<div class="formlablebig" style="margin-top:10px;">&nbsp;</div>
			<div style="margin-top:10px;">
				<?php echo $this->Form->submit('front_end/send_btn.jpg', array('div'=>false, 'onclick'=>'send_invitations();'));?>
			</div>			
			<div class="clr"></div>

			<div id="result_container"></div>
		</div>
	</div>
	<!-- SECTION FOR INVITE FRIENDS END -->
	<div class="memberbtmbox">&nbsp;</div>
</div>

<script type="text/javascript">
function validateEmail(email){
	if(email != ''){
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
		if(emailPattern.test(email) == true)
			return 'true';
		else
			return 'false';
	}else{
		return 'false';
	}
}

function validateEnteredEmails(){
	var yourEmail = "<?php echo $this->Session->read('Auth.User.User.email');?>";
	var emails = $('#InviteInviteeEmail').val();

	if(emails != ''){
		var enteredEmailsArr = emails.split(',');
		var totalElements = enteredEmailsArr.length - 1;
		var counter = 0;
		if(totalElements > 4)
			totalElements = 4;

		var setEmails = '';

		for(i=0; i<=totalElements; i++){
			if(enteredEmailsArr[i] == yourEmail)
				enteredEmailsArr[i] = '';
			var returnValue = '';
			returnValue = validateEmail(enteredEmailsArr[i]);
			if(returnValue == 'true'){
				if(counter == 0)
					setEmails = enteredEmailsArr[i];
				else
					setEmails = setEmails+','+enteredEmailsArr[i];
				counter++;
			}
		}
		$('#InviteInviteeEmail').val(setEmails);
	}
}

function send_invitations(){
	var emails = $('#InviteInviteeEmail').val();
	var message = $('#InviteMessage').val();

	validateEnteredEmails();

	//for invitee emails
	if(emails == ''){
		$('#InviteInviteeEmail').css('border', '1px solid #FF0000');
		$('#InviteInviteeEmail').focus();
		return false;
	}else{
		validateEnteredEmails();
		emails = $('#InviteInviteeEmail').val();
	}

	// for message
	if(message == ''){
		$('#InviteMessage').css('border', '1px solid #FF0000');
		$('#InviteMessage').focus();
		return false;
	}else
		$('#InviteMessage').css('border', '1px solid #CDCDCD');

	//send ajax for sending the invitations start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'invites/send_invitations/';?>",
		data: "emails="+emails+"&message="+message,
		beforeSend:function(){
			var bSend = '<div align="left"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "style"=>"margin-left:10px;"));?></div>';
			$('#result_container').html(bSend);
		},
		success: function(response){
			if(response == 'sent'){
				$('#result_container').html('Invitation Sent successfully!');
				$('#InviteInviteeEmail').val('');
				$('#InviteMessage').val('');
			}else
				$('#result_container').html(response);
		}
	});

	

	
}
</script>