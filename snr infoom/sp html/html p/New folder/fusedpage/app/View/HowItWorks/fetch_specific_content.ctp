<?php
	if(!empty($listing)){ //pr($listing);die;
?>
	See how <span><?php echo $listing['HowItWork']['heading'];?>,</span>
	<?php echo nl2br($listing['HowItWork']['content']);?>
<?php
	}else
		echo '<div align="center">No Content Available!</div>';
?>