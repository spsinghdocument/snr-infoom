<?php if(!empty($fetchedData)){
?>
	<div>
		<input type="checkbox" id="select_all" onclick=" return validateSelectAll();" checked>
		<strong>Select Contacts</strong>
		<div style="border:1px solid #7F9DB9; height:130px; overflow-y:auto;">
			<?php foreach($fetchedData as $contact){?>
			<div> <input type="checkbox" class="invite_class" value="<?php echo $contact;?>" checked>
				<?php 
					echo $contact;
				?>
			</div>
			<?php } ?>
		</div>

		<div style="margin-top:10px;">
			<strong>Message</strong>
			<div>
				<?php echo $this->Form->textarea('Invite.message', array('rows'=>5, 'cols'=>80, 'style'=>'resize:none;'));?>
			</div>
		</div>

		<div style="margin-top:10px; width:450px;">
			<?php echo $this->Form->submit('front_end/send_btn.jpg', array('div'=>false, 'onclick'=>'send_invitations();'));?>

			<span id="result_span" style="color:#FF0000; float:right;"></span>
		</div>
	</div>
<?php }else{ ?>
	<div style="color:##FF0000;"> No Contacts Found!!</div>
<?php } ?>

<script type="text/javascript">
function validateSelectAll(){
	if($('#select_all').is(':checked'))
		$('.invite_class').attr('checked','checked');
	else
		$('.invite_class').removeAttr('checked');

}

function send_invitations(){
	var user_id = "<?php echo $inviter;?>";
	$('#result_span').html('');
	var emails = '';
	var count = 1;
	$('.invite_class').each(function(){
		if($(this).is(':checked')){
			if(count == 1)
				emails = $(this).val();
			else
				emails += ','+$(this).val();
			count++;
		}
	});

	var message = $('#InviteMessage').val();

	//validate the emails and message section
	if(emails == ''){
		$('#result_span').html('Contacts Required!');
		return false;
	}

	if(message == ''){
		$('#result_span').html('Message Required!');
		return false;
	}

	//send ajax for sending the invites start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'invites/send_invitations_register/';?>",
		data: "emails="+emails+"&message="+message+"&user_id="+user_id,
		beforeSend:function(){
			var bSend = '<div align="left"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "style"=>"margin-left:10px;"));?></div>';
			$('#result_span').html(bSend);
		},
		success: function(response){
			if(response == 'sent')
				$('#list_friends').html('<font color="green">Invitations  & Activation email sent successfully to your email! </font>');
			else
				$('#result_span').html('<font color="red">Error!! Please Try Later!</font>');
		}
	});
}
</script>