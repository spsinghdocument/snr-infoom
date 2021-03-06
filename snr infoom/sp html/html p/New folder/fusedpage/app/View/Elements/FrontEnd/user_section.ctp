<?php if($other_recent_member_id != ''){?>
<div id="display_messages_container" style="height:450px;">

<!-- CONVERSATION CAPTION START -->
<h2 class="blkhed">
		<span class="fl"><?php echo $this->Fused->fetchUserName($this->Session->read('Auth.User.User.id'));?>  -  <?php echo $this->Fused->fetchUserName($other_recent_member_id);?></span>
		<!-- <span class="messageNo"><?php echo $this->Fused->countTotalIndividualMessages($other_recent_member_id);?></span> -->
</h2>
<!-- CONVERSATION CAPTION END -->

<div class="scrollBox" id="scrollbar2">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
		<!-- MSG CONTENT START -->
		<?php
		$conversations = $this->Fused->fetchRecentIndividualConversations($other_recent_member_id);
		if(!empty($conversations)){
		?>
		<div id="main_messages">
		<?php
			foreach($conversations as $msg){ //pr($msg);
				if($msg['Sender']['id'] == $this->Session->read('Auth.User.User.id'))
					$class = 'msgline';
				else
					$class = 'msgline_2';
		?>
		<div class="<?php echo $class;?>">
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
					<div class="lower">
						<div class="hd">
							<div class="fl"><a href="javascript:void(0);"><?php echo $msg['Sender']['first_name'].' '.$msg['Sender']['last_name'];?></a></div>
							<div class="fr"><?php echo date('d M, Y, h:i A, D', strtotime($msg['Mail']['modified']));?></div>
							<div class="clr"></div>
						</div>
						<p><?php echo nl2br($msg['Mail']['message']);?></p>

						<!-- FOR FORWARDED MESSAGES START -->
						<?php if($msg['Mail']['forwards']){?>
						<div>
							<div><u>Forwarded Messages</u></div>
							<div class="clr"></div>
							
							<?php
								$forwards['Mail']['forwarded_ids'] = $msg['Mail']['forwards'];
								$forward = $this->Fused->fetchForwardedMessages($forwards);
								foreach($forward as $m){
							?>
								<div style="margin:5px 0 5px 0;">
								<div class="senderimg" style="float:left;">
									<a href="javascript:void(0);"><?php
										//PROFILE AVATAR START
										if($m['Sender']['gender'] == '1')
											$avatar = 'front_end/users/male.jpg';
										else
											$avatar = 'front_end/users/female.jpg';

										if($m['Sender']['image'] != ''){
											$realPath = '../webroot/img/front_end/users/profile/'.$m['Sender']['image'];
											if(is_file($realPath)){
												$avatar = 'front_end/users/profile/'.$m['Sender']['image'];
											}
										}

										echo $this->Html->link($this->Image->resize($avatar, 45, 44, array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));
										//PROFILE AVATAR END

									?></a>
								</div>
								<div style="float:left; margin-left:5px; width:260px;">
									<!-- NAME START -->
									<div style="float:left; font-weight:bold;"><?php echo $m['Sender']['first_name'].' '.$m['Sender']['last_name'];?></div>
									<!-- NAME END -->

									<!-- TIME SECTION START -->
									<div style="float:right;"><?php echo date('d M, Y, h:i A', strtotime($m['Mail']['modified']));?></div>
									<div class="clr"></div>
									<!-- TIME SECTION END -->

									<!-- CONTENT SECTION START -->
									<div>
										<p><?php echo nl2br($m['Mail']['message']);?></p>
									</div>
									<div class="clr"></div>
									<!-- CONTENT SECTION END -->

									<!-- ATTACHED FILES START -->
									<div>
		<?php if($m['Mail']['attachment_ids'] != ''){?>
		<div>
			<?php
				$expArr = explode(',', $m['Mail']['attachment_ids']);
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
									</div>
									<div class="clr"></div>
									<!-- ATTACHED FILES END -->
								</div>
								<div class="clr"></div>	
								</div>
								<div class="clr"></div>

							<?php
								}
							?>
							
						</div>
						<div class="clr"></div>
						<?php } ?>
						<!-- FOR FORWARDED MESSAGES END -->

						<!-- FOR ATTACHMENTS START -->
						<?php if($msg['Mail']['attachment_ids'] != ''){?>
<div>
	<?php
		$expArr = explode(',', $msg['Mail']['attachment_ids']);
		if(!empty($expArr)){ //pr($expArr);
			foreach($expArr as $att){
				$attArr = $this->Fused->fetchAttachmentDetails($att);
				if(!empty($attArr)){ //pr($attArr);die;
	?>
				<div style="float:left; margin-left:10px;">
					<?php 
					//if attachement is an image
					$fileExt = end(explode('.', $attArr['Attachment']['file_name']));
					$allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
					if(in_array($fileExt, $allowedTypes)){
					$attName = 'front_end/attachments/'.$attArr['Attachment']['uploaded_name'];
						echo $this->Html->link($this->Image->resize($attName, 40, 40, array('alt'=>'')), '/mails/download/'.$attArr['Attachment']['uploaded_name'].'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#2281C6;'));
					}else{
						echo $this->Html->link($this->Html->image('front_end/add_file_icon.png', array('alt'=>'')).' '.$this->Text->truncate($attArr['Attachment']['file_name'], 10, array('ending'=>'...')), '/mails/download/'.$attArr['Attachment']['uploaded_name'].'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#2281C6;'));
					}
					?>

				</div>
	<?php
				}
			}
		}
	?>
</div><div class="clr"></div>	
						<?php } ?>
						<!-- FOR ATTACHMENTS END -->
					</div>
				</div>
			</div>
			<div class="clr"></div>	
		</div>
		<?php 
			echo $this->Form->hidden('last_msg_id', array('value'=>$msg['Mail']['id'], 'class'=>'last_id_class'));
		} ?>
		</div>
		<?php
		}else{
		?>
			No Conversation Found!!
		<?php
		}
		?>
		<!-- MSG CONTENT END -->
			
		</div>
	</div>
</div>
</div>
<?php } ?>