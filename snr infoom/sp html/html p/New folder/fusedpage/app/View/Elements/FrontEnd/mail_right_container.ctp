<div class="deshboardfr">
	<div class="mailtopinbox">
		<div class="mailinnerindex">
			<a href="javascript:void(0);">
				<strong>Inbox</strong><label id="page_header_inbox"><?php 
					$mailsCount = $this->Fused->countTotalInboxMessages();
					if($mailsCount > 0)
						echo '('.$mailsCount.')';
				
			?></label></a>
			<!-- <span><a href="javascript:void(0);">Other (8)</a></span> -->
		</div>
		<div class="mailmorefr"><a href="javascript:void(0);" onclick="return validateMoreBox();">More</a></div>
		<div class="clr"></div>

		<!-- MORE START -->
		<div id="more_div" onblur="return validateActionsBox();" style="position:absolute; z-index:10; background-color:#FFFFFF; border:1px solid #CDCDCD; width:75px; margin:2px 0 0 140px; display:none;">
			<ul class="userpopuplist">
				<li><a id="dir_1" href="javascript:void(0);" style="padding:3px 0 3px 15px;" onclick="return validateMores('1');" class="directory_class">Inbox</a></li>
				<li><a id="dir_2" href="javascript:void(0);" style="padding:3px 0 3px 15px;" onclick="return validateMores('2');" class="directory_class">Trash</a></li>
				<li><a  id="dir_3" href="javascript:void(0);" style="padding:3px 0 3px 15px;" onclick="return validateMores('3');" class="directory_class">Archive</a></li>

				<!-- FETCH CUSTOM FOLDERS START -->
				<?php 
					$directoriesArr = $this->Fused->fetchCustomDirectories();
					if($directoriesArr != ''){
						foreach($directoriesArr as $id => $folder){
				?>
				<li><a id="dir_<?php echo $id;?>" href="javascript:void(0);" style="padding:3px 0 3px 15px;" onclick="return validateMores('<?php echo $id;?>');" class="directory_class"><?php echo $folder;?></a></li>
				<?php
						}
					}
				?>
				<!-- FETCH CUSTOM FOLDERS END -->
			</ul>
		</div>
		<!-- MORE END -->
	</div>

	<div id="container">
		<div id="wn">
			<div id="lyr1">
				<div class="mailtopinbox">
					<input name="" type="text" class="mailsearchtop" placeholder="Search" /><input type="image" src="<?php echo SITE_PATH.'img/front_end/';?>search_icon_fr.jpg" />
				</div>

				<?php
					$msgsArr = $this->Fused->fetchMailsListing();
					$count = 0;
					if(!empty($msgsArr)){
					foreach($msgsArr as $msg){ //pr($msg);die;
						//fetch required User details
						$userArr = $this->Fused->fetchMessageUserDetails($msg['fp_mails']['sender_id']);
						if(!empty($userArr)){
				?>
				<div class="mialfrlistmain" id="sender_container_<?php echo $msg['fp_mails']['sender_id'];?>" <?php if($count==0){?>style="padding-top:0;"<?php } ?>>
					<div class="mailflimg">
						<?php 
							//PROFILE AVATAR START
							if($userArr['User']['gender'] == '1')
								$avatar = 'front_end/users/male.jpg';
							else
								$avatar = 'front_end/users/female.jpg';

							if($userArr['User']['image'] != ''){
								$realPath = '../webroot/img/front_end/users/profile/'.$userArr['User']['image'];
								if(is_file($realPath)){
									$avatar = 'front_end/users/profile/'.$userArr['User']['image'];
								}
							}

							echo $this->Html->link($this->Image->resize($avatar, 45, 44, array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'onclick'=>"return validateChatBox('".$userArr['User']['id']."');"));
							//PROFILE AVATAR END
						?>
					</div>
					<div class="mailfrlist">
						<div class="mailfrinfl">
							<a href="javascript:void(0);"><?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?></a>
							<span><a href="javascript:void(0);"><?php echo $this->Text->truncate($msg['fp_mails']['message'], 40, array('ending'=>'...'));?></a></span>
						</div>

						<div class="mailfrinffr">
							<?php echo date('M d', strtotime($msg['fp_mails']['created']));
							$userCount = $this->Fused->countTotalInboxMessages($msg['fp_mails']['sender_id']);
							?>
							<span id="new_mail_span_<?php echo $msg['fp_mails']['sender_id'];?>"><?php if($userCount > 0){echo $userCount.' new';}?></span>
						</div>
						<div class="clr"></div>	

						<div class="iconimg">
							<?php
								if($userCount > 0)
									$mark = 'read';
								else
									$mark = 'unread';
								?>
								<label id="msg_mark_<?php echo $msg['fp_mails']['sender_id'];?>"><?php echo $this->Html->link($this->Html->image('front_end/circle_icon.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Mark as '.ucwords($mark), 'onclick'=>"markUnreadRead('".$mark."', '".$msg['fp_mails']['sender_id']."')"));?></label>

							<?php	echo $this->Html->link($this->Html->image('front_end/crose_icon.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Archive', 'onclick'=>"archiveSender('".$msg['fp_mails']['sender_id']."')"));
							?>

						</div>
					</div>
					<div class="clr"></div>
				</div>
				<?php $count++; }}} ?>

				
			</div>
		</div>
		<div id="scrollbar"></div>  
	</div>
</div>

<script type="text/javascript">
function archiveSender(sender_id){
	if(sender_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/arhive_sender/';?>",
			data: "sender_id="+sender_id,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?></div>';
				$('#sender_container_'+sender_id).html(bSend);
			},
			success: function(response){
				if(response == 'archived'){
					$('#sender_container_'+sender_id).hide();
					setUnreadCounter();
				}else
					$('#sender_container_'+sender_id).html(response);				
			}
		});
	}else
		return false;
}

function markUnreadRead(type, sender_id){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'mails/mark_read_unread/';?>",
		data: "type="+type+"&sender_id="+sender_id,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?></div>';
			$('#new_mail_span_'+sender_id).html(bSend);
		},
		success: function(response){
			if(type == 'read'){
				if(response == 'read'){
					$('#new_mail_span_'+sender_id).html('');
					var mark = '<a onclick="markUnreadRead(\'unread\', '+sender_id+')" title="Mark as Unread" href="javascript:void(0);"><img alt="" src="<?php echo SITE_PATH;?>img/front_end/circle_icon.png"></a>';
					$('#msg_mark_'+sender_id).html(mark);
					setUnreadCounter();
				}else
					$('#new_mail_span_'+sender_id).html(response);
			}else{
				if(response == 'unread'){
					$('#new_mail_span_'+sender_id).html('1 new');
					var mark = '<a onclick="markUnreadRead(\'read\', '+sender_id+')" title="Mark as Read" href="javascript:void(0);"><img alt="" src="<?php echo SITE_PATH;?>img/front_end/circle_icon.png"></a>';
					$('#msg_mark_'+sender_id).html(mark);
					setUnreadCounter();
				}else
					$('#new_mail_span_'+sender_id).html(response);
			}
		}
	});
}

function setUnreadCounter(){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'mails/fetch_total_unread_msgs/';?>",
		success: function(response){
			if(response != '0'){
				$('#page_header_inbox').html('('+response+')');
				$('#left_navigation_inbox').html(response);
			}else{
				$('#page_header_inbox').html('');
				$('#left_navigation_inbox').html('');
			}
		}
	});
}

function validateChatBox(sender_id){
	if(sender_id != ''){
		$('#receiver_id').val(sender_id);
		var directory = $('#directory').val();
		//send Ajax For Messages section
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/fetch_sender_messages/';?>",
			data: "sender_id="+sender_id+"&directory="+directory,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?></div>';
				$('#display_messages_container').html(bSend);
			},
			success: function(response){
				$('#display_messages_container').html(response);
				setActionsReadUnreadContainer();
			}
		});
	}else
		return false;
}

function setActionsReadUnreadContainer(){
	var sender_id = $('#receiver_id').val();
	if(sender_id != ''){
		//send ajax to know the mseeage status
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/know_msg_status/';?>",
			data: "sender_id="+sender_id,
			success: function(response){
				if(response == '0'){
					$('#read_unread_li').html('<a href="javascript:void(0);" onclick="return validateActions(\'unread\');">Mark as Unread</a>');
				}else{
					$('#read_unread_li').html('<a href="javascript:void(0);" onclick="return validateActions(\'read\');">Mark as Read</a>');
				}
			}
		});
	}else
		return false;
}

/*-----------------  MORE FUNCTIONALITY START ------------------------------*/
function validateMoreBox(){
	$('#more_div').toggle();
}

function validateMores(type){
	var sender_id = $('#receiver_id').val();

	//for selected secrtion start
	$('.directory_class').css('font-weight', 'lighter');
	$('#dir_'+type).css('font-weight', 'bold');
	//for selected secrtion end

	$('#directory').val(type);

	$('#more_div').hide();

	//send ajax for listing
	if(sender_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/show_directory_data/';?>",
			data: "sender_id="+sender_id+"&folder_id="+type,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?></div>';
				$('#display_messages_container').html(bSend);
			},
			success: function(response){
				$('#display_messages_container').html(response);
			}
		});
	}else
		return false;
}
/*-----------------  MORE FUNCTIONALITY END  ------------------------------*/
</script>