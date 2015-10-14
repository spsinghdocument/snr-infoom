<?php
	echo $this->Html->script('FrontEnd/jquery.tinyscrollbar.min.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#scrollbar1').tinyscrollbar();
		$('#scrollbar2').tinyscrollbar();
		$('#scrollbar2').tinyscrollbar_update('bottom');
		$('#scrollbar3').tinyscrollbar();	
	});
</script>
<?php echo $this->Html->script('ajax_upload/ajaxupload');?>

<!-- for fancybox Start -->
<?php
	echo $this->Html->Css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->Script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<div class="userdeshboardmid">
	<div style="margin-bottom:10px;">
		<div class="messagehd"><!-- <a href="javascript:void(0);">New Message</a> --></div>
		<div class="photoadbox">
				<ul class="photoadlink">
					<li><a href="<?php echo SITE_PATH.'mails/new_mail/';?>">+ Compose</a></li>
					<li style="background:none;">
						<a href="javascript:void(0);" onclick="return validateActionsBox();"><?php
							echo $this->Html->image('front_end/action_icon.jpg', array('alt'=>'', 'style'=>'padding:2px 4px 0 0; vertical-align:top;')).'Actions'. $this->Html->image('front_end/blue_arrow_mail.jpg', array('alt'=>'', 'style'=>'padding:padding-left:3px;'));
						?></a>
					</li>
				</ul>
				<div class="clr"></div>
				<div id="actions_div" onblur="return validateActionsBox();" style="position:relative; z-index:10; background-color:#FFFFFF; border:1px solid #CDCDCD; width:125px; margin:2px 0 0 34px; display:none;">
					<ul class="userpopuplist">
						<li id="read_unread_li"><?php
							if($this->Fused->countTotalInboxMessages($other_recent_member_id) > 0){
								$action = 'read';
								$msg = 'Mark as read';
							}else{
								$action = 'unread';
								$msg = 'Mark as Unread';
							}
						?>
						<a href="javascript:void(0);" onclick="return validateActions('<?php echo $action;?>');"><?php echo $msg;?></a></li>
						<li><a href="javascript:void(0);" onclick="return validateActions('delete');">Delete Messages</a></li>
						<li><a href="javascript:void(0);" onclick="return validateActions('archive');">Archive</a></li>
						<li><a href="javascript:void(0);" onclick="return validateActions('forward');">Forward</a></li>
						<li><a href="javascript:void(0);" onclick="return validateActions('move');">Move</a></li>
						<li><a href="<?php echo SITE_PATH.'mails/create_custom_directory/';?>" class="fancyclass">Create Directory</a></li>
					</ul>
				</div>
			</div>
		<div class="clr"></div>		
	</div>	

	<!-- CHAT SECTION START -->
	<?php echo $this->Element('FrontEnd/user_section');?>
	<!-- CHAT SECTION END -->


	<div class="mailbtmboxbg">
		<div class="mailinbox" id="compose_section">
			<div class="mailbtmbox">
				<?php echo $this->Form->textarea('message', array('class'=>'textarebox', 'placeholder'=>'Write a message...', 'style'=>'resize:none;'));?>
			</div>
			<div>
			
			<!-- SECTION FOR SHOWING THE ATTACHMENTS START -->
			<div id="uploaded_attachments">
			</div>
			<div class="clr"></div>
			<!-- SECTION FOR SHOWING THE ATTACHMENTS END -->



				<div class="mailbtmfl">
					<ul class="mailbtmlink">
						<li><?php echo $this->Html->link($this->Html->image('front_end/add_file_icon.jpg', array('alt'=>'')).'Add Files', 'javascript:void(0);', array('escape'=>false, 'id'=>'add_file'));?></li>

						<!-- <li><?php echo $this->Html->link($this->Html->image('front_end/add_photo-icon.jpg', array('alt'=>'')).'Add Photos', 'javascript:void(0);', array('escape'=>false));?></li> -->
					</ul>
					<div class="clr"></div>
				</div>
				<div id="attachemntError" style="float:left;"></div>
				<div class="mailbtmfrsendtn">
					<?php echo $this->Form->submit('front_end/send_btn.jpg', array('div'=>false, 'onclick'=>'return submit_user_message();'));?>
				</div>
				<div class="clr"></div>								
			</div>
		</div>
		
		<div id="compose_other_section" style="display:none; text-align:center; width:200px; margin:auto;"></div>
	</div>
</div>

<!-- HIDDEN FIELDS START -->
<?php 
echo $this->Form->hidden('receiver_id', array('value'=>$other_recent_member_id));
echo $this->Form->hidden('attachment_ids');
echo $this->Form->hidden('directory', array('value'=>'1'));

//form for submitting the forward messages to compose page strat
echo $this->Form->create('Mail', array('action'=>'new_mail'));
echo $this->Form->hidden('forwarded_ids');
echo $this->Form->end();
?>
<!-- HIDDEN FIELDS END -->

<script type="text/javascript">
$(document).ready(function(){
	var button = $('#add_file'), interval;
	new AjaxUpload(button, {
		action: "<?php echo SITE_PATH.'mails/upload_attachment/';?>",
		name: "Attachment",
		onSubmit : function(file, ext){
			if(ext == 'exe'){
				$('#attachemntError').html('<font color="red">No *.exe allowed!!</font>');
				return false;
			}else
				$('#attachemntError').html('');

			var total_uploads = $('#attachment_ids').val();
			var count = 0;
			if(total_uploads != ''){
				var total_uploadsArr = total_uploads.split(',');
				var totalLength = total_uploadsArr.length;
				if(totalLength > 4){
					$('#attachemntError').html('Max 5 only!');
					return false;
				}
			}

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#attachemntError').html(bSend);
		},
		onComplete: function(file, response){
			var splittedArr = response.split('*');
			if(splittedArr['1'] != ''){
				var newVal = '';
				var preVal = $('#attachment_ids').val();
				if(preVal != '')
					newVal = preVal+','+splittedArr['0'];
				else
					newVal = splittedArr['0'];				
				$('#attachment_ids').val(newVal);
				$('#attachemntError').html('');

				//show the attached file start
				var attachedFile = '<div class="mailbtmbox1"><img src="<?php echo SITE_PATH;?>img/front_end/add_file_icon.png"/>'+splittedArr['1']+'</div>';
				$('#uploaded_attachments').append(attachedFile);
				//show the attached file end
			}else{
				$('#attachemntError').html(response);
			}
		}
	});
});

function submit_user_message(){
	var receiver_id = $('#receiver_id').val();
	var message = $('#message').val();
	var attachments_ids = $('#attachment_ids').val();

	if(receiver_id != '' && message != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/submit_user_message/';?>",
			data: "receiver_id="+receiver_id+"&message="+message+"&attachments_ids="+attachments_ids,
			beforeSend:function(){
				var bSend = '<div align="center" style="width:200px; margin-top:5px;"><?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?></div>';
				$('#attachemntError').html(bSend);
			},
			success: function(response){
				$('#attachemntError').html('');
				$('#uploaded_attachments').html('');
				$('#message').val('');
				$('#main_messages').append(response);
			}
		});
	}else
		return false;
}

function fetchChatMessages(){
	setInterval(function(){
		var receiver_id = $('#receiver_id').val();
		if(receiver_id != ''){
			fetchChatBox(receiver_id);
		}
	}, 3000);
}

//fetchChatMessages();

/*----------- FOR ACTIONS SECTION START -------------------*/
function fetch_checked_ids(){
	var del_ids = [];
	$('.custom_check_class').each(function(){
		if($(this).is(':checked')){
			del_ids.push(this.value);
		}
	});
	return del_ids;
}

function validateActionsBox(){
	$('#actions_div').toggle();
}

function validateActions(type){
	var receiver_id = $('#receiver_id').val();
	var directory = $('#directory').val();

	$('#actions_div').hide();

	if(receiver_id != ''){
		//FOR UNREAD/READ SECTION STRAT
		if(type == 'unread'){
			markUnreadRead('unread', receiver_id);
			$('#read_unread_li').html('<a href="javascript:void(0);" onclick="return validateActions(\'read\');">Mark as Read</a>');
		}
		if(type == 'read'){
			markUnreadRead('read', receiver_id);
			$('#read_unread_li').html('<a href="javascript:void(0);" onclick="return validateActions(\'unread\');">Mark as Unread</a>');
		}
		//FOR UNREAD/READ SECTION END

		//FOR DELETING THE MESSAGES START
		if(type == 'delete'){
			fetchConversationWithCheckBoxes();
			
			var aSend = '<div class="btnimage"><a href="javascript:void(0);" onclick="return delete_conversation('+receiver_id+','+directory+');"><span>Delete</span></a></div> <div style="width:50px; float:left; display:block;">&nbsp;</div><div class="btnimage"><a href="javascript:void(0);" onclick="return cancel_actions('+receiver_id+');"><span>Cancel</span></a></div><div class="clr"></div>';

			$('#compose_other_section').html(aSend);


			$('#compose_section').hide(); //hide the compose section
			$('#compose_other_section').show(); //show the other section
		}
		//FOR DELETING THE MESSAGES END

		//FOR ARCHIVING THE MESSAGES START
		if(type == 'archive'){
			fetchConversationWithCheckBoxes();

			var aSend = '<div class="btnimage"><a href="javascript:void(0);" onclick="return archive_conversation('+receiver_id+');"><span>Archive</span></a></div> <div style="width:50px; float:left; display:block;">&nbsp;</div><div class="btnimage"><a href="javascript:void(0);" onclick="return cancel_actions('+receiver_id+');"><span>Cancel</span></a></div><div class="clr"></div>';

			$('#compose_other_section').html(aSend);


			$('#compose_section').hide(); //hide the compose section
			$('#compose_other_section').show(); //show the other section
		}
		//FOR ARCHIVING THE MESSAGES END

		//FOR MOVING THE MESSAGES START
		if(type == 'move'){
			fetchConversationWithCheckBoxes();

			var aSend = '<div style="text-align:left;"><select id="move_folder_ids" style="margin:0 0 5px 0; width:150px;"><?php echo $this->Fused->fetchUserDirectories('+directory+');?></select></div><div class="btnimage"><a href="javascript:void(0);" onclick="return move_conversation('+receiver_id+');"><span>Move</span></a></div> <div style="width:50px; float:left; display:block;">&nbsp;</div><div class="btnimage"><a href="javascript:void(0);" onclick="return cancel_actions('+receiver_id+');"><span>Cancel</span></a></div><div class="clr"></div>';

			$('#compose_other_section').html(aSend);


			$('#compose_section').hide(); //hide the compose section
			$('#compose_other_section').show(); //show the other section
		}
		//FOR MOVING THE MESSAGES END

		//FOR FORWARDING START
		if(type == 'forward'){
			fetchConversationWithCheckBoxes();

			var aSend = '<div class="btnimage"><a href="javascript:void(0);" onclick="return forward_conversation('+receiver_id+');"><span>Forward</span></a></div> <div style="width:50px; float:left; display:block;">&nbsp;</div><div class="btnimage"><a href="javascript:void(0);" onclick="return cancel_actions('+receiver_id+');"><span>Cancel</span></a></div><div class="clr"></div>';

			$('#compose_other_section').html(aSend);


			$('#compose_section').hide(); //hide the compose section
			$('#compose_other_section').show(); //show the other section
		}
		//FOR FORWARDING END
	}else
		return false;
}

/* FOR CANCELLING THE CONVERSATION START */
function cancel_actions(sender_id){
	var directory = $('#directory').val();
	//send ajax for normal view
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'mails/fetch_sender_messages/';?>",
		data: "sender_id="+sender_id+"&directory="+directory,
		success: function(response){
			$('#display_messages_container').html(response);
			$('#compose_section').show(); //show the compose section
			$('#compose_other_section').hide(); //hide the other section
		}
	});
}
/* FOR CANCELLING THE CONVERSATION END */

/* FOR DELETING THE CONVERSATION START */
function delete_conversation(sender_id, directory){
	var del_ids = fetch_checked_ids();

	if(del_ids.length > 0){
		//send ajax for deleting start
		var conf = confirm('Do you really want to delete these conversation?');
		if(conf == true){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'mails/move_conversation_to_trash/';?>",
				data: "sender_id="+sender_id+"&del_ids="+del_ids+"&directory="+directory,
				beforeSend:function(){
					var bSend = '<div align="center"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?></div>';
					$('#display_messages_container').html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						cancel_actions(sender_id);
					}else{
						$('#display_messages_container').html(response);
					}
				}
			});
		}else
			return false;
	}
}
/* FOR DELETING THE CONVERSATION END */

/* FOR ARCHIVING THE CONVERSATION START */
function archive_conversation(sender_id){
	var arcv_ids = fetch_checked_ids();

	if(arcv_ids.length > 0){
		//send ajax for deleting start
		var conf = confirm('Do you really want to Archive these conversation?');
		if(conf == true){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'mails/move_conversation_to_archive/';?>",
				data: "sender_id="+sender_id+"&arcv_ids="+arcv_ids,
				beforeSend:function(){
					var bSend = '<div align="center"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?></div>';
					$('#display_messages_container').html(bSend);
				},
				success: function(response){
					if(response == 'archived'){
						cancel_actions(sender_id);
					}else{
						$('#display_messages_container').html(response);
					}
				}
			});
		}else
			return false;
	}
}
/* FOR ARCHIVING THE CONVERSATION END */

/* FOR MOVING THE CONVERSATION START */
function move_conversation(sender_id){
	var checked_ids = fetch_checked_ids();
	var move_folder_id = $('#move_folder_ids').val();

	if((checked_ids.length > 0) && (move_folder_id != '')){
		//send ajax for moving the data to the required folder
		var conf = confirm('Do you really want to move these conversation?');
		if(conf == true){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'mails/move_conversation_to_folder/';?>",
				data: "sender_id="+sender_id+"&checked_ids="+checked_ids+"&move_folder_id="+move_folder_id,
				beforeSend:function(){
					var bSend = '<div align="center"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?></div>';
					$('#display_messages_container').html(bSend);
				},
				success: function(response){
					if(response == 'moved'){
						cancel_actions(sender_id);
					}else{
						$('#display_messages_container').html(response);
					}
				}
			});
		}else
			return false;
	}
}
/* FOR MOVING THE CONVERSATION END */

/* FOR FORWARDING THE CONVERSATION START */
function forward_conversation(sender_id){
	var checked_ids = fetch_checked_ids();
	if(checked_ids.length > 0){
		$('#MailForwardedIds').val(checked_ids);
		$('#MailNewMailForm').submit();
	}else
		return false;
}
/* FOR FORWARDING THE CONVERSATION END */

function fetchConversationWithCheckBoxes(){
	var sender_id = $('#receiver_id').val();
	var directory = $('#directory').val();

	if(sender_id != ''){
		//send ajax
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/fetch_sender_messages_with_checkboxes/';?>",
			data: "sender_id="+sender_id+"&directory="+directory,
			success: function(response){
				$('#display_messages_container').html(response);
			}
		});
	}
}
/*----------- FOR ACTIONS SECTION END -------------------*/
</script>