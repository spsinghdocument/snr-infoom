<script type="text/javascript">
	$(document).ready(function(){
		$('#scrollbar2').tinyscrollbar();
		$('#scrollbar2').tinyscrollbar_update('bottom');
	});
</script>

<?php
	$senderArr = $this->Fused->fetchUserDetails($this->Session->read('Auth.User.User.id')); //5/13/2013pr($senderArr);
?>
<div class="msgline">
	<div class="senderimg">
		<a href="javascript:void(0);"><?php
			//PROFILE AVATAR START
			if($senderArr['User']['gender'] == '1')
				$avatar = 'front_end/users/male.jpg';
			else
				$avatar = 'front_end/users/female.jpg';

			if($senderArr['User']['image'] != ''){
				$realPath = '../webroot/img/front_end/users/profile/'.$senderArr['User']['image'];
				if(is_file($realPath)){
					$avatar = 'front_end/users/profile/'.$senderArr['User']['image'];
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
					<div class="fl"><a href="javascript:void(0);"><?php echo $senderArr['User']['first_name'].' '.$senderArr['User']['last_name'];?></a></div>
					<div class="fr"><?php echo date('d M, Y, h:i A, D');?></div>
					<div class="clr"></div>
				</div>
				<p><?php echo nl2br($post['message']);?></p>

<!-- FOR ATTACHMENTS START -->
<?php if($post['attachments_ids'] != ''){?>
<div>
	<?php
		$expArr = explode(',', $post['attachments_ids']);
		if(!empty($expArr)){
			foreach($expArr as $att){
				$attArr = $this->Fused->fetchAttachmentDetails($att);
				if(!empty($attArr)){
	?>
				<?php 
					//if attachement is an image
					$fileExt = end(explode('.', $attArr['Attachment']['file_name']));
					$allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
					if(in_array($fileExt, $allowedTypes)){
					$attName = 'front_end/attachments/'.$attArr['Attachment']['uploaded_name'];
						echo $this->Html->link($this->Image->resize($attName, 40, 40, array('alt'=>'')), '/mails/download/'.$attArr['Attachment']['uploaded_name'].'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#2281C6; margin-left:5px;'));
					}else{
						echo $this->Html->link($this->Html->image('front_end/add_file_icon.png', array('alt'=>'')).' '.$this->Text->truncate($attArr['Attachment']['file_name'], 10, array('ending'=>'...')), '/mails/download/'.$attArr['Attachment']['uploaded_name'].'/', array('escape'=>false, 'target'=>'_blank', 'style'=>'text-decoration:none; color:#2281C6; margin-left:5px;'));
					}
				?>
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