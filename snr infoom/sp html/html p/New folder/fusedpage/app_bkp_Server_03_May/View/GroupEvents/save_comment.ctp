<?php 
					//PROFILE AVATAR START
	if($this->Session->read('Auth.User.User.gender') == '1')
		$avatar = 'front_end/users/male.jpg';
	else
		$avatar = 'front_end/users/female.jpg';

	if(($this->Session->read('Auth.User.User.image')) != ''){
			$realPath = '../webroot/img/front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
		if(is_file($realPath)){
			$avatar = 'front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
		}
	}


					//PROFILE AVATAR END
?>
<table id="event_<?php echo $last_id;?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
<tr>
	<td style="width:10%"><?php echo $this->Image->resize($avatar, 32, 32, array('alt'=>'')); ?></td>
	<td><?php echo $comment;?><?php if($this->Session->read('Auth.User.User.id') == $userr_id){ ?>
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $last_id;?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteEventComment('<?php echo $last_id;?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?></td>
</tr>
</table>