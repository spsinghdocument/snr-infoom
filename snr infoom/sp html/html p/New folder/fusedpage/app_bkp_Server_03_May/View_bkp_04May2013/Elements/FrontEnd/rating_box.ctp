<?php if($this->Session->check('Auth.User.User.id')){?>
	<div class="ratingbox" id="rating_box">
		<?php
			if(($this->Fused->validateUserRating(base64_decode($this->params['pass'][0]))) == 0){ //do rating
				for($i=1; $i<=5; $i++){
					echo $this->Html->image('front_end/gray_star.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onClick'=>'return setRating('.$i.')'));
				}
			}else{ // show the user rating
				$endRated = $this->Fused->fetchUserRating(base64_decode($this->params['pass'][0]));
				for($i=1; $i<=5; $i++){
					if($i <= $endRated)
						echo $this->Html->image('front_end/rating_star.png', array('alt'=>''));
					else
						echo $this->Html->image('front_end/gray_star.png', array('alt'=>''));
				}
			}
		?>
	</div>	
	<div class="commentfltextin"><span>3  People </span>you know rated this:</div>
<?php	if(($this->Fused->validateUserRating(base64_decode($this->params['pass'][0]))) == 0){?>
		<div class="graybtn"><a href="javascript:void(0);">Rate This Business</a></div>
<?php }else{?>
		<div class="graybtn">&nbsp;</div>
<?php }} ?>

<script type="text/javascript">
function setOverAllRating(){
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
}

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