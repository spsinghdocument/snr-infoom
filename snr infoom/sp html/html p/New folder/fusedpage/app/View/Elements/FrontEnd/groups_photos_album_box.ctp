<div id="album_link_container" style="display:none;">
	<div id="main_albums_listing_container">
	<?php 
		$albumsArr = $this->Fused->fetchGroupsAlbums($grpArr['Group']['id']); 
		if(!empty($albumsArr)){
			$albCount = 1;
			foreach($albumsArr as $album){ //pr($album);
				$albumClass = 'albumbox';
				$div = '';
				if($albCount%3 == 0){
					$albumClass = 'albumbox last';
					$div = '<div class="clr"></div>';
				}

				$totalPhotos = (int)$this->Fused->countAlbumPhotos($album['GroupAlbum']['id']);

	?>
	<div id="album_id_<?php echo $album['GroupAlbum']['id'];?>" class="<?php echo $albumClass;?>">
		<a href="javascript:void(0);" onclick="setAlbumData('<?php echo $album['GroupAlbum']['id'];?>')">
			<?php 
			$newAlbumArr = $this->Fused->ShowAlbumData_one($album['GroupAlbum']['id']);
			$defaultImage = 'front_end/groups/noimage.jpg';
			if($totalPhotos > 0)
				$defaultImage = 'front_end/groups/'.$newAlbumArr['GroupGallery']['image'];
			echo $this->Image->resize($defaultImage, 140, 142, array('alt'=>''));
			?>
		</a>
		<div class="albumetitle">
			<a href="javascript:void(0);"><?php echo $album['GroupAlbum']['name'];?></a>
			<span><?php echo $totalPhotos.' Photos';?></span>
		</div>
		<div class="albumedit">
			<?php 
			if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){
				echo $this->Html->link($this->Html->image('front_end/delete.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false, 'title'=>'Delete', 'onclick'=>"deleteAlbum('".$album['GroupAlbum']['id']."')"));
			}
			?>
		</div>
		<div class="clr"></div>
	</div>
	<?php echo $div;
		$albCount++;
			}
		}
	?>
	</div>
</div>

<!-- Album Photos Start -->
<div id="album_div_container" style="display:none;"></div>
<!-- Album Photos END -->

<?php if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){?>
<script type="text/javascript">
function deleteAlbum(del_id){
	var conf = confirm('Do you really want to delete this album?');
	if(conf == true){
		//send Ajax for Album Deletion
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'group_galleries/delete_album/';?>",
			data: "album_id="+del_id,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
				$('#album_id_'+del_id).html(bSend);
			},
			success: function(response){
				$('#album_id_'+del_id).remove();
			}
		});
	}
}
</script>
<?php } ?>

<script type="text/javascript">
function setAlbumData(album_id){
	//hide albums listing container and show the images
	$('#album_link_container').hide();
	$('#album_div_container').show();

	//set current album
	$('#photo_album').val(album_id);

	//send ajax for fetching the data start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'group_galleries/fetch_album_data/';?>",
		data: "album_id="+album_id,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/opc-ajax-loader.gif", array("alt"=>""));?></div>';
			$('#album_div_container').html(bSend);
		},
		success: function(response){
			$('#album_div_container').html(response);
		}
	});
}
</script>