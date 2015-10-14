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
		<div class="feddimgname"><a href="javscript:void(0);"><?php echo $this->Session->read('Auth.User.User.first_name');?>,</a></div>
		<div class="feedsmltext"><?php echo $this->Session->read('Auth.User.User.city');?></div>
		<div class="postfeedtext">
			<?php echo nl2br($set['feedback']);?>
		</div>
	</div>
	<div class="clr"></div>
</div>