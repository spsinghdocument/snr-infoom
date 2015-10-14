<div id="album_photos_listing_container">
<?php 
	$totalPhotos = count($gallArr);
	if(!empty($gallArr)){
		$count = 1;
		foreach($gallArr as $gall){
			$photoClass = 'photoimgbox';
			$photoClrDiv = '';
			if($count%3 == 0){
				$photoClass = 'photoimgbox last';
				$photoClrDiv = '<div class="clr"></div>';
			}
?>
		<div id="photo_container_<?php echo $gall['GroupGallery']['id'];?>" class="<?php echo $photoClass;?>">
			<?php 
				$profileDefaultImage = 'front_end/groups/noimage.jpg';
				if($gall['GroupGallery']['image'] != ''){
					$profileRealImagePath = '../webroot/img/front_end/groups/'.$gall['GroupGallery']['image'];
					if(is_file($profileRealImagePath))
						$profileDefaultImage = 'front_end/groups/'.$gall['GroupGallery']['image'];
				}
				echo $this->Html->link($this->Image->resize($profileDefaultImage, 140, 142, array('alt'=>'')), '/group_galleries/view_content/i/'.$this->Fused->encrypt($gall['GroupGallery']['id']).'/', array('escape'=>false, 'class'=>'fancyclass'));

				if($gall['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){
			?>
			<div class="photo_del_box">
				<?php echo $this->Html->link($this->Html->image('front_end/delete.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'onclick'=>"deletePhoto('".$gall['GroupGallery']['id']."', 'photo')"));?>
			</div>
			<?php } ?>
		</div>
<?php		echo $photoClrDiv;	
		$count++;
		}
	}
?>
</div>