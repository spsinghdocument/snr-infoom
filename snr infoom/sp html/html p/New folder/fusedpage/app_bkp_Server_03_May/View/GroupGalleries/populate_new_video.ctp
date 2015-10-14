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
	$class = 'photoimgbox';
	$dir = '';
	if($count%3 == 0){
		$class = 'photoimgbox last';
		$dir = '<div class="clr"></div>';
	}
?>

<div class="<?php echo $class;?>">
	<div class="vedioicon">
		<?php echo $this->Html->link($this->Html->image('front_end/vedio_play_icon.png', array('alt'=>'')), '/group_galleries/view_content/v/'.$this->Fused->encrypt($video['GroupGallery']['id']).'/', array('escape'=>false, 'class'=>'fancyclass'));?>
	</div>
	<?php 
		$defaultVideoImage = 'front_end/groups/noimage.jpg';
		if($video['GroupGallery']['video'] != ''){
			$vidImage = str_replace('.flv', '.jpg', $video['GroupGallery']['video']);
			$videoImg = '../webroot/img/front_end/groups/flv/images/'.$vidImage;
			if(is_file($videoImg))
				$defaultVideoImage = 'front_end/groups/flv/images/'.$vidImage;
		}
		echo $this->Image->resize($defaultVideoImage, 140, 142, array('alt'=>''));
	?>
</div>
<?php echo $dir;?>