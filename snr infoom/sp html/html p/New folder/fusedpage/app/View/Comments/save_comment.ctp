<?php if(!empty($commentArr)){ ?>
<?php 
	$username = $this->Session->read('Auth.User.User.username');
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
<table id="business_comment_<?php echo $last_id;?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
<tr>
	<td style="width:10%"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($avatar, 32, 32, array('alt'=>'')); ?></a></td>
	<td><label><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>" style="color:#006EBD; text-decoration:none; font-weight:bold;"><?php echo $this->Session->read('Auth.User.User.first_name').' '.$this->Session->read('Auth.User.User.last_name');?></a></label>
	<?php echo $comment;?><?php if($this->Session->read('Auth.User.User.id') == $userr_id){ ?>
		<div class="listboxbg" style="float:right;"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $last_id;?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteCommentFeed('<?php echo $last_id;?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
		<?php } ?>
	<!-- RECOMMEND COMMENT SECTION START -->
	<div id="recommend_comment_<?php echo $last_id;?>">
		<a href="javascript:void(0);" class="recommendClass" onclick="return validateCommentRecommend('<?php echo $post['business_feeds_id'];?>', '<?php echo $last_id;?>', 'recommend');">Recommend</a>
	</div>
	<!-- RECOMMEND COMMENT SECTION END -->
	</td>
</tr>
</table>
<?php } ?>