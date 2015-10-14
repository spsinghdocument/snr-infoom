<?php
	echo $this->Html->css('rating/jRating.jquery');
?>
<div class="feedlistmian">
	<div class="feddimgbox">
		<?php //PROFILE AVATAR START
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
	<div class="feddimgboxfr">
		<div class="feddimgname">
			<a href="javscript:void(0);"><?php echo $this->Session->read('Auth.User.User.first_name');?>,</a>
			<?php if($rating != ''){?>
			<div style="float:right;">
				<div class="exemple" style="float:right;">
					<div style="float:left;" class="exemple5" data="<?php echo $rating;?>_5"></div>
					<div style="float:right; padding-left:10px; color:#696969;" class="postfeedtext">(<?php echo $rating;?>)</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="feedsmltext"><?php echo $this->Session->read('Auth.User.User.city');?></div>
		<div class="postfeedtext">
			<?php echo nl2br($set['feedback']);?>
		</div>
	</div>
	<div class="clr"></div>
</div>

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