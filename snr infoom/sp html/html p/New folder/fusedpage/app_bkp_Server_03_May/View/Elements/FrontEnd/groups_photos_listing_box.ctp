<div id="photo_link_container">
	<div id="main_listing_photos_container">
	<?php 
		$gallArr = $this->Fused->fetchAlbumPhotos($grpArr['Group']['id'], '0');
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

					if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){
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
</div>

<?php
/*----- HIDDEN FIELD START ------*/
echo $this->Form->hidden('total_photos', array('value'=>$totalPhotos));
echo $this->Form->hidden('photo_album', array('value'=>0));
/*----- HIDDEN FIELD END ------*/
?>

<script type="text/javascript">
function deletePhoto(id, type){
	if(id != ''){
		var conf = confirm('Do you really want to delete this '+type+'?');
		if(conf == true){
			//send ajax for photo delete
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'group_galleries/delete_record/';?>",
				data: "id="+id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#photo_container_'+id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#photo_container_'+id).remove();
					}else
						alert(response);
				}
			});
		}else
			return false;
	}else
		return false;
}
</script>