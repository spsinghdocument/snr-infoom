
<?php 
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


					//PROFILE AVATAR END
?>

	<?php echo $this->Image->resize($avatar, 32, 32, array('alt'=>'')); ?>
