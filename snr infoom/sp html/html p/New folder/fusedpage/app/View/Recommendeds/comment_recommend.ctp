<?php
	if($post['type'] == 'recommend'){
?>
	<a href="javascript:void(0);" class="recommendClass" onclick="return validateCommentRecommend('<?php echo $post['feed_id'];?>', '<?php echo $post['comment_id'];?>', 'unrecommend');">Unrecommend</a>

<?php
	}else{
?>
	<a href="javascript:void(0);" class="recommendClass" onclick="return validateCommentRecommend('<?php echo $post['feed_id'];?>', '<?php echo $post['comment_id'];?>', 'recommend');">Recommend</a>
<?php
	}
	$recm = $this->Fused->fetchUserRecommendedCommentCount($post['feed_id'], $post['comment_id'], 'all');
	if($recm > 0){?>
	<span class="recommendClass" style="float:right;"><?php 
	echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));
	echo '  '.$recm;?> people recommended</span>
<?php } ?>