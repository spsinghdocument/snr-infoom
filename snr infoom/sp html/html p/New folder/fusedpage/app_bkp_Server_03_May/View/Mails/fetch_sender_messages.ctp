<?php
	echo $this->Html->script('FrontEnd/jquery.tinyscrollbar.min.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#scrollbar2').tinyscrollbar();
		$('#scrollbar2').tinyscrollbar_update('bottom');
	});
</script>

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
		$conversations = $this->Fused->fetchRecentIndividualConversations($other_recent_member_id, $directory);
		if(!empty($conversations)){
		?>
		<div id="main_messages">
		<?php
			foreach($conversations as $msg){ //pr($msg);die;
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
							<div class="fr"><?php echo date('d M, Y, h:i A, D', strtotime($msg['Mail']['created']));?></div>
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
			echo $this->Form->hidden('last_msg_id', array('value'=>$msg['Mail']['id'], 'class'=>'last_id_class'));
		}
		?>
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