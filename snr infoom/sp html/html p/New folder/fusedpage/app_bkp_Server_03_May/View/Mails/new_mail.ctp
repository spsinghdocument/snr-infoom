<?php echo $this->Html->script('ajax_upload/ajaxupload');?>

<div class="userdeshboardmid">
	<div style="margin-bottom:10px;">
		<div class="messagehd"><a href="javascript:void(0);">New Message</a></div>
		<!-- <div class="photoadbox">
				<ul class="photoadlink">
					<li><a href="<?php echo SITE_PATH.'mails/new_mail/';?>">+ Compose</a></li>
					<li style="background:none;">
						<a href="javascript:void(0);"><?php
							echo $this->Html->image('front_end/action_icon.jpg', array('alt'=>'', 'style'=>'padding:2px 4px 0 0; vertical-align:top;')).'Actions'. $this->Html->image('front_end/blue_arrow_mail.jpg', array('alt'=>'', 'style'=>'padding:padding-left:3px;'));
						?></a>
					</li>
				</ul>
				<div class="clr"></div>	
			</div> -->
		<div class="clr"></div>		
	</div>	

	<!-- TO INPUT SECTION START -->
	<div style="border:1px #ccc solid; padding:15px; margin:10px 0 10px 0;">
		<div class="fl">To:</div>
			<div class="fl" style=" padding:0 0 0 10px; color:#ccc;">
				<input type="text" name="to" id="to" style="border:none; width:200px;" onkeyup="return autoSuggestData(this.value);"/>
			</div>
			<div class="clr"></div>
	</div>
	<!-- TO INPUT SECTION END -->

	<!-- SUGGESTION DIV START -->
	<div id="auto_suggest_container" style="display:none; border:1px solid #CCCCCC; z-index:10; width:348px;">
	</div>
	<!-- SUGGESTION DIV END -->

	<!-- MESSAGE TO START -->
	<div class="composetop" id="message_to_div"></div>
	<!-- MESSAGE TO END -->

	<?php if($post == ''){?>
	<div class="mailbtmboxbg">
		<div class="mailinbox">
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
	</div>
	<?php }else{ //for forwarded messages?>
	<div class="mailbtmboxbg">
		<div class="mailinbox">
			<div class="mailbtmbox">
				<?php echo $this->Form->textarea('message', array('class'=>'textarebox', 'placeholder'=>'Write a message...', 'style'=>'resize:none;'));?>
			</div>

			<!-- SECTION FOR FORWARDED MESSAGES START -->
			<div class="mailbtmbox">
				<div style="margin:10px;">Forwarded Messages</div>
				<div class="clr"></div>

				<?php
					$conversations = $this->Fused->fetchForwardedMessages($post);
					$count = 0;
					foreach($conversations as $msg){
				?>
				<div class="msgline" style="margin-top:5px;">
			<div class="senderimg">
				<a href="javascript:void(0);"><?php
					//PROFILE AVATAR START
					if($this->Session->read('Auth.User.User.gender') == '1')
						$avatar = 'front_end/users/male.jpg';
					else
						$avatar = 'front_end/users/female.jpg';

					if($msg['Sender']['image'] != ''){
						$realPath = '../webroot/img/front_end/users/profile/'.$msg['Sender']['image'];
						if(is_file($realPath)){
							$avatar = 'front_end/users/profile/'.$msg['Sender']['image'];
						}
					}

					echo $this->Html->link($this->Image->resize($avatar, 53, 53, array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));
					//PROFILE AVATAR END

				?></a>
			</div>
			<div class="senderTxt">
				<div class="upper">
					<div class="lower" style="width:290px;">
						<div class="hd">
							<div class="fl"><a href="javascript:void(0);"><?php echo $msg['Sender']['first_name'].' '.$msg['Sender']['last_name'];?></a></div>
							<div class="fr"><?php echo date('d M, Y, h:i A, D', strtotime($msg['Mail']['modified']));?></div>
							<div class="clr"></div>
						</div>
						<p><?php echo nl2br($msg['Mail']['message']);?></p>

						<!-- FOR ATTACHMENTS START -->
						<?php if($msg['Mail']['attachment_ids'] != ''){?>
						<div>
							<?php
								$expArr = explode(',', $msg['Mail']['attachment_ids']);
								if(!empty($expArr)){
									foreach($expArr as $att){
										$attArr = $this->Fused->fetchAttachmentDetails($att);
										if(!empty($attArr)){
							?>
										<div style="float:left; margin-left:10px;">
										<?php echo $this->html->link($this->Html->image('front_end/add_file_icon.png', array('alt'=>'')).' '.$attArr['Attachment']['file_name'], '/mails/download/'.$attArr['Attachment']['uploaded_name'].'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#2281C6;'));?>
										</div>
							<?php
										}
									}
								}
							?>
						</div>
						<?php } ?>
						<!-- FOR ATTACHMENTS END -->
					</div>
				</div>
			</div>
			<div class="clr"></div>	
		</div>
				<?php
					$count++;
					}
				?>


			</div>
			<div class="clr"></div>
			<!-- SECTION FOR FORWARDED MESSAGES END -->

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
					<?php echo $this->Form->submit('front_end/send_btn.jpg', array('div'=>false, 'onclick'=>'return submit_forward_message();'));?>
				</div>
				<div class="clr"></div>								
			</div>
		</div>				
	</div>
	<?php } ?>
</div>

<!-- HIDDEN FIELDS START -->
<?php
	echo $this->Form->hidden('send_ids');
	echo $this->Form->hidden('attachment_ids');
?>
<!-- HIDDEN FIELDS END -->

<script type="text/javascript">
function autoSuggestData(name){
	if(name != ''){
		var send_ids = $('#send_ids').val();
		$('#auto_suggest_container').html('<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?></div>');
		$('#auto_suggest_container').show();

		//send Ajax For fetching the users start
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/fetch_similar_users/';?>",
			data: "name="+name+"&send_ids="+send_ids,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?></div>';
				$('#auto_suggest_container').html(bSend);
			},
			success: function(response){
				$('#auto_suggest_container').html(response);
			}
		});
	}else{
		$('#auto_suggest_container').hide();
		return false;
	}
}

function make_listing(id, name){
	var send_ids = $('#send_ids').val();
	var new_ids = '';

	if(send_ids.length > 0)
		new_ids = send_ids+','+id;
	else
		new_ids = id;
	$('#send_ids').val(new_ids);

	//set the button view start
	var asend = '<div style="float:left; margin-right:5px;" id="email_to_'+id+'"><div class="composefl"><?php echo $this->Html->image("front_end/compose_fl.jpg", array("alt"=>""));?></div><div class="composemid">'+name+'<a href="javascript:void(0);" onclick="return delete_msg_to('+id+');"><?php echo $this->Html->image("front_end/close_icon.png", array("alt"=>""));?></a></div><div class="composefr"><?php echo $this->Html->image("front_end/compose_fr.jpg", array("alt"=>""));?></div></div>';

	$('#message_to_div').append(asend);
	$('#auto_suggest_container').html('');
	$('#auto_suggest_container').hide();
	$('#to').val('');
	//set the button view end



}

function delete_msg_to(id){
	if(id != ''){
		var send_ids = $('#send_ids').val();
		var send_ids_arr = send_ids.split(',');
		var new_send_ids = '';
		var count = 0;
		for(var i=0; i<=(send_ids_arr.length-1); i++){
			if(send_ids_arr[i] != id){// add the value
				if(count == 0){
					new_send_ids = 	send_ids_arr[i];
				}else{
					new_send_ids += ','+send_ids_arr[i];
				}
				count++;
			}else{// remove the div
				$('#email_to_'+id).remove();
			}
		}
		$('#send_ids').val(new_send_ids);
	}else
		return false;
}

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
</script>

<?php if($post == ''){?>
<script type="text/javascript">
function submit_user_message(){
	var receiver_id = $('#send_ids').val();
	var message = $('#message').val();
	var attachments_ids = $('#attachment_ids').val();

	if(receiver_id != '' && message != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/submit_multiple_messages/';?>",
			data: "receiver_id="+receiver_id+"&message="+message+"&attachments_ids="+attachments_ids,
			beforeSend:function(){
				var bSend = '<div align="center" style="width:200px; margin-top:5px;"><?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?></div>';
				$('#attachemntError').html(bSend);
			},
			success: function(response){
				$('#attachemntError').html('');
				$('#uploaded_attachments').html('');
				$('#message_to_div').html('');
				$('#message').val('');
				$('#send_ids').val('');
				var url = "<?php echo SITE_PATH.'mails/listing';?>";
				window.location.href = url;
			}
		});
	}else
		return false;
}
</script>
<?php }else{?>
<script type="text/javascript">
function submit_forward_message(){
	var receiver_id = $('#send_ids').val();
	var message = $('#message').val();
	var attachments_ids = $('#attachment_ids').val();
	var forward_ids = "<?php echo $post['Mail']['forwarded_ids'];?>";

	if(receiver_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/submit_forward_messages/';?>",
			data: "receiver_id="+receiver_id+"&message="+message+"&attachments_ids="+attachments_ids+"&forward_ids="+forward_ids,
			beforeSend:function(){
				var bSend = '<div align="center" style="width:200px; margin-top:5px;"><?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?></div>';
				$('#attachemntError').html(bSend);
			},
			success: function(response){
				$('#attachemntError').html('');
				$('#uploaded_attachments').html('');
				$('#message_to_div').html('');
				$('#message').val('');
				$('#send_ids').val('');
				var url = "<?php echo SITE_PATH.'mails/listing';?>";
				window.location.href = url;
			}
		});
	}else
		return false;

}
</script>
<?php } ?>