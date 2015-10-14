<?php
	for($i=1; $i<=5; $i++){
		if($i <= $new_rating)
			echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
		else
			echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
	}
?>