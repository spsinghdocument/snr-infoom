<?php
	$albumsArr = $this->Fused->ShowAlbumData($album_id);
	if(!empty($albumsArr)){
		$albCount = 1;
		foreach($albumsArr as $album){ //pr($album);die;
			$albumClass = 'albumbox';
			$div = '';
			if($albCount%3 == 0){
				$albumClass = 'albumbox last';
				$div = '<div class="clr"></div>';
			}

			$totalPhotos = (int)$this->Fused->countAlbumPhotos($album_id);

?>
<div id="album_id_<?php echo $album_id;?>" class="<?php echo $albumClass;?>">
	<a href="javascript:void(0);" onclick="setAlbumData('<?php echo $album['GroupAlbum']['id'];?>')">
		<?php 
		$defaultImage = 'front_end/groups/noimage.jpg';
		if($totalPhotos > 0)
			$defaultImage = 'front_end/groups/'.$album['GroupGallery']['image'];
		echo $this->Image->resize($defaultImage, 140, 142, array('alt'=>''));
		//echo $this->Html->image('front_end/photo_img1.jpg', array('alt'=>''));
		?>
	</a>
	<div class="albumetitle">
		<a href="javascript:void(0);"><?php echo $album['GroupAlbum']['name'];?></a>
		<span><?php echo $totalPhotos.' Photos';?></span>
	</div>
	<div class="albumedit">
		<?php echo $this->Html->link($this->Html->image('front_end/delete.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Delete', 'onclick'=>"deleteAlbum('".$album['GroupAlbum']['id']."')"));?>
	</div>
	<div class="clr"></div>
</div>
<?php echo $div;
	$albCount++;
		}
	}
?>