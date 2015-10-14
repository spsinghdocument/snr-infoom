<?php
	for($i=1; $i<=5; $i++){
		if($i <= $new_rating)
			echo $this->Html->image('front_end/rating_star.png', array('alt'=>''));
		else
			echo $this->Html->image('front_end/gray_star.png', array('alt'=>''));
	}
?>