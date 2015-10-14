<?php
	$businessFeedbacks = $this->Fused->fetchBusinessFeedbacks(base64_decode($this->params['pass'][0]));
	$businessFeedbacksCounts = $this->Fused->fetchBusinessFeedbacksCount(base64_decode($this->params['pass'][0]));
?>
<div id="pulic_5" style="display:none;">			
	<h5>Feedback</h5>
	<?php //if($businessFeedbacksCounts == 0){?>
	<!-- FEEDBACK POST SECTION START -->
	<div class="feedlistmian" id="post_feedback" style="display:block;">
		<div class="feddimgbox">
			<?php //echo $this->Html->image('front_end/feed_img1.jpg', array('alt'=>''));
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

				echo $this->Image->resize($avatar, 57, 57, array('alt'=>''));
				//PROFILE AVATAR END
			?>
		</div>
		<div class="feddimgboxfr" style="overflow:visible;">
			<div class="feddimgname"><a href="javscript:void(0);"><?php echo $this->Session->read('Auth.User.User.first_name');?></a></div>
			<div class="feedsmltext"><?php echo $this->Session->read('Auth.User.User.city');?>
				<div id="result_feedback" style="float:right; margin-right:100px;"></div>
			</div>
			<div class="postfeedtext">
				<div style="float:left;">
				<?php echo $this->Form->textarea('Business.feedback', array('div'=>false, 'label'=>false, 'rows'=>1, 'cols'=>55, 'style'=>'resize:none; border:1px solid #DFDFDF; color:#909090; font-size:12px;'));?>
				</div>
				<div class="btnimage fr" style="float:right; padding-top:12px;">
					<a href="javascript:void(0);" onclick="return validateFeedback();"><span style="color:#FFFFFF;">Post</span></a>
				</div>
				<div class="clr"></div>
			</div>
			
		</div>
		<div class="clr"></div>
	</div>
	<!-- FEEDBACK POST SECTION END -->
	<!-- <div align="right" class="graybtn" id="post_your_feedback">
		<a href="javascript:void(0);" onclick="return postFeedback();">Post your Feedback</a>
	</div> -->
	<?php //} ?>

	<div id="feedbacks">
	<?php 
	if(!empty($businessFeedbacks)){
		foreach($businessFeedbacks as $feedback){ //pr($feedback);
	?>
	<div class="feedlistmian">
		<div class="feddimgbox">
			<?php //PROFILE AVATAR START
			if($feedback['User']['usertype'] == '1')
				$avatar = 'front_end/users/male.jpg';
			else
				$avatar = 'front_end/users/female.jpg';

			if($feedback['User']['image'] != ''){
				$realPath = '../webroot/img/front_end/users/profile/'.$feedback['User']['image'];
				if(is_file($realPath)){
					$avatar = 'front_end/users/profile/'.$feedback['User']['image'];
				}
			}

			echo $this->Image->resize($avatar, 57, 57, array('alt'=>''));
			//PROFILE AVATAR END
		?>
		</div>
		<div class="feddimgboxfr">
			<div class="feddimgname"><a href="javscript:void(0);"><?php echo $feedback['User']['first_name']?>,</a></div>
			<div class="feedsmltext"><?php echo $feedback['User']['city'];?></div>
			<div class="postfeedtext">
				<?php echo nl2br($feedback['BusinessFeedback']['feedback']);?>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<?php }} ?>
	</div>
</div>

<div id="result"></div>

<script type="text/javascript">
function postFeedback(){
	//$('#post_your_feedback').hide();
	$('#post_feedback').show();
}

function validateFeedback(){
	var feedback = $('#BusinessFeedback').val();
	if(feedback != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_feedbacks/post_feedback/';?>",
			data: "feedback="+feedback+"&business_id=<?php echo $this->params['pass'][0];?>",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#result_feedback').html(bSend);
			},
			success: function(response){
				//$('#post_feedback').hide();
				$('#result_feedback').html('<font color="green">Feedback Posted Successfully!!</font>');
				$('#BusinessFeedback').val('');
				$('#feedbacks').append(response);
			}
		});
	}
}
</script>