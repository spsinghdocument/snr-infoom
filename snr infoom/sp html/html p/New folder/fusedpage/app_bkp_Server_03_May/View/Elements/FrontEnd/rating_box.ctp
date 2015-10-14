<?php if($this->Session->check('Auth.User.User.id')){?>
	<!-- <div class="ratingbox" id="rating_box">
		<?php
			if(($this->Fused->validateUserRating($businessArr['Business']['id'])) == 0){ //do rating
		?>
				<span id="userRatingSpan">
		<?php
				for($i=1; $i<=5; $i++){
					/*echo $this->Html->image('front_end/gray_star.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onClick'=>'return setRating('.$i.')'));*/
					echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>''));
				}
		?>
				</span>
		<?php
			}else{ // show the user rating
				$endRated = $this->Fused->fetchUserRating($businessArr['Business']['id']);
				for($i=1; $i<=5; $i++){
					if($i <= $endRated)
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>''));
				}
			}
		?>
	</div> -->
	
	<div class="ratingbox" id="rating_box">
		<span id="userRatingSpan">
			<?php
				for($i=1; $i<=5; $i++){
					if($i <= $businessArr['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>''));
				}
			?>
		</span>
	</div>
	<!-- <div class="commentfltextin"><span>3  People </span>you know rated this:</div> -->
	<div class="commentfltextin">&nbsp;</div>
<?php	if(($this->Fused->validateUserRating($businessArr['Business']['id'])) == 0){
		if($businessArr['Business']['rating'] == 0){
?>
		<div class="graybtn1">
			<a href="javascript:void(0);" onclick="ShowHomeTab('pulic_5','a5')">Be the first to review this business</a>
		</div>
<?php
		}else{
?>
		<div class="graybtn">
			<a href="javascript:void(0);" onclick="ShowHomeTab('pulic_5','a5')">Rate This Business</a>
		</div>
<?php
		}
?>
		
<?php }else{?>
		<div class="graybtn">&nbsp;</div>
<?php }} ?>

<script type="text/javascript">
/* function setOverAllRating(){
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
		}
	});
} */

function setRating(rating){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'businesses/rate_business/';?>",
		data: "rating="+rating+"&overall_rating=<?php echo $businessArr['Business']['rating'];?>&business_id=<?php echo base64_decode($this->params['pass'][0]);?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#rating_box').html(bSend);
		},
		success: function(response){
			$('#rating_box').html(response);
			setOverAllRating();
		}
	});
}
</script>