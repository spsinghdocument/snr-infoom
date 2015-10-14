<!-- for fancybox Start -->
<?php
	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->


<?php 
	//$gallArr = $this->Fused->fetchAlbumPhotos($id, $post['photo_album']);
	//pr($gallArr);die;
	$count = (int)$post['total_photos'];
	if(!empty($gallArr)){
		foreach($gallArr as $gall){
			$photoClass = 'photoimgbox';
			$photoClrDiv = '';
			if($count%3 == 0){
				$photoClass = 'photoimgbox last';
				$photoClrDiv = '<div class="clr"></div>';
			}
?>
		<div class="<?php echo $photoClass;?>">
			<?php 
				$profileDefaultImage = 'front_end/groups/noimage.jpg';
				if($gall['GroupGallery']['image'] != ''){
					$profileRealImagePath = '../webroot/img/front_end/groups/'.$gall['GroupGallery']['image'];
					if(is_file($profileRealImagePath))
						$profileDefaultImage = 'front_end/groups/'.$gall['GroupGallery']['image'];
				}
				echo $this->Html->link($this->Image->resize($profileDefaultImage, 140, 142, array('alt'=>'')), '/group_galleries/view_content/i/'.$this->Fused->encrypt($gall['GroupGallery']['id']).'/', array('escape'=>false, 'class'=>'fancyclass'));
			?>
		</div>
<?php		echo $photoClrDiv;	
		$count++;
		}
	}
?>