<?php
	/*for($i=1; $i<=5; $i++){
		if($i <= $new_rating)
			echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
		else
			echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
	} */


	echo $this->Html->css('rating/jRating.jquery');
?>


<div class="exemple" style="float:right;"><div class="exemple5" data="<?php echo $new_rating;?>_5"></div></div>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemple5').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big',
			isDisabled:true
		});
	});
</script>