<?php
	$businessFeedbacks = $this->Fused->fetchBusinessFeedbacks($this->Fused->decrypt($this->params['pass'][0]));
	$businessFeedbacksCounts = $this->Fused->fetchBusinessFeedbacksCount($this->Fused->decrypt($this->params['pass'][0]));

	//call the jquery star rating css file
	echo $this->Html->css('rating/jRating.jquery');
?>
<div id="pulic_5" style="display:none;">			
	<h5>Feedback</h5>
	<?php //if($businessFeedbacksCounts == 0){?>
	<!-- FEEDBACK POST SECTION START -->
	<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
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
			<div class="feddimgname">
				<a href="javascript:void(0);"><?php echo $this->Session->read('Auth.User.User.first_name');?></a>
				<?php if(($this->Fused->validateUserRating($businessArr['Business']['id'])) == 0){?>
				<!-- <div style="float:right; margin-right:88px;" id="user_rating_div">
					<span id="user_stars"><?php
						for($i=1; $i<=5; $i++){
							echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'style'=>'cursor:pointer; margin-right:2px;', 'onClick'=>'return setUserRating('.$i.')'));
						}
					?></span>
				</div> -->
				<div class="exemple" style="float:right;"><div class="exemple5" data="0_5"></div></div>
				<?php } 
				echo $this->Form->hidden('user_rating');?>
			</div>
			<div class="feedsmltext"><?php echo $this->Session->read('Auth.User.User.city');?>
				<div id="result_feedback" style="float:right; margin-right:100px;"></div>
			</div>
			<div class="postfeedtext">
				<div style="float:left;">
				<?php echo $this->Form->textarea('Business.feedback', array('div'=>false, 'label'=>false, 'rows'=>1, 'cols'=>50, 'style'=>'resize:none; border:1px solid #DFDFDF; color:#909090; font-size:12px;'));?>
				</div>
				<div class="btnimage fr" style="float:right; padding-top:12px;">
					<a href="javascript:void(0);" onclick="return validateFeedback();"><span style="color:#FFFFFF;">Post</span></a>
				</div>
				<div class="clr"></div>
			</div>
			
		</div>
		<div class="clr"></div>
	</div>
	<?php } ?>
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
			<div class="feddimgname">
				<a href="javscript:void(0);"><?php echo $feedback['User']['first_name'];?>,</a>
				<?php if($feedback['BusinessFeedback']['rating'] != ''){?>
				<div style="float:right;">
					<?php
						/* for($i=1; $i<=5; $i++){
							if($i <= $feedback['BusinessFeedback']['rating'])
								echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'style'=>'margin-right:2px;'));
							else
								echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'style'=>'margin-right:2px;'));
						} */
					?>
			<div class="exemple" style="float:right;">
				<div style="float:left;" class="exemple4" data="<?php echo $feedback['BusinessFeedback']['rating'];?>_5"></div>
				<div style="float:right; padding-left:10px; color:#696969;" class="postfeedtext">(<?php echo $feedback['BusinessFeedback']['rating'];?>)</div>
			</div>
				</div>
				<?php } ?>
			</div>
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
	var rating = $('#user_rating').val();
	var membershipPlan = "<?php echo $businessPlan;?>";
	if(feedback != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_feedbacks/post_feedback/';?>",
			data: "feedback="+feedback+"&business_id=<?php echo $businessArr['Business']['id'];?>&rating="+rating+"&previous_rating=<?php echo $businessArr['Business']['rating'];?>",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#result_feedback').html(bSend);
			},
			success: function(response){ //$('#result_feedback').html(response);
				//$('#post_feedback').hide();
				var msg = 'Administrator would approve!!';
				$('#BusinessFeedback').val('');
				if(membershipPlan != '1'){
					$('#feedbacks').append(response);
					msg = 'Feedback Posted Successfully!!';
				}
				$('#result_feedback').html('<font color="green">'+msg+'</font>');
				if(rating != ''){
					$('#user_rating_div').html('');
					$('#user_rating').val('');
					setOverAllRating(rating);
				}
				//alert(response);
			}
		});
	}
}

function setUserRating(rating){
	$('#user_rating').val(rating);
	var newrating = '';
	//var siderating = '';
	for(var i=1; i<=5; i++){
		if(i <= rating){
			newrating += '<img src="<?php echo SITE_PATH;?>img/front_end/star_rating_orange.png" style="margin-right:2px; cursor:pointer;" onclick="return setUserRating('+i+');"/>';
			//siderating += '<img src="<?php echo SITE_PATH;?>img/front_end/star_rating_orange.png" />';
		}else{
			newrating += '<img src="<?php echo SITE_PATH;?>img/front_end/star_rating_gray.png" style="margin-right:2px; cursor:pointer;" onclick="return setUserRating('+i+');"/>';
			//siderating += '<img src="<?php echo SITE_PATH;?>img/front_end/star_rating_gray.png" />';
		}
	}
	$('#user_stars').html(newrating);
	//$('#userRatingSpan').html(siderating);
}

function setOverAllRating(rating){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'businesses/set_overallrating/';?>",
		data: "business_id=<?php echo base64_decode($this->params['pass'][0]);?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#overAllRatingBox').html(bSend);
		},
		success: function(response){
			$('#overAllRatingBox').html(response);
			$('#userRatingSpan').html(response);
		}
	});
}
</script>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemple5').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big'
		});

		$('.exemple4').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big',
			isDisabled:true
		});
	});
</script>