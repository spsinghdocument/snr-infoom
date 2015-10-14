<?php pr($businessArr);die;
	//echo $type;die;
?>


<!-- PAGE LEFT PART START -->
<div class="popupflimg">
<?php
if($type == 'v'){ //For Video
	//validate Video
	$videoUrl = '../webroot/img/front_end/business/feeds/video/flv/'.$businessArr['BusinessFeed']['video'].'.flv';
	if(is_file($videoUrl)){
		echo $this->Html->script('flowplayer/flowplayer-3.2.6.min');
		$player = SITE_PATH.'js/flowplayer/swf/flowplayer-3.2.7.swf';

		$playerVideo = SITE_PATH.'img/front_end/business/feeds/video/flv/'.$businessArr['BusinessFeed']['video'].'.flv';

		//validate the Video Image
		$videoImageUrl = '../webroot/img/front_end/business/feeds/video/image/'.$businessArr['BusinessFeed']['video'].'.jpg';
		if(is_file($videoImageUrl))
			$playerVideoImage = SITE_PATH.'img/front_end/business/feeds/video/image/'.$businessArr['BusinessFeed']['video'].'.jpg';
		else
			$playerVideoImage = SITE_PATH.'img/front_end/business/noimage.jpg';
?>
<div id="player1" style="height:400px;"></div>

<script type="text/javascript">
flowplayer("player1", "<?php echo $player;?>",{
	playlist : [{
		url: "<?php echo $playerVideoImage;?>",
		scaling: 'fit'
	},
	{
		url: "<?php echo $playerVideo;?>",
		autoPlay: true,
		autoBuffering: true
	}]
});
</script>
<?php
		}else{
?>
<div style="text-align:center; color:#FF0000; margin:130px 0;">Sorry!! The video is not available!!</div>
<?php
		}
}else if($type == 'i'){
	//FOR IMAGE START
	$imageUrl = '../webroot/img/front_end/business/feeds/'.$businessArr['BusinessFeed']['image'];
	if(is_file($imageUrl)){
		$imagePath = 'front_end/business/feeds/'.$businessArr['BusinessFeed']['image'];		
?>
	<div style="width:100%; background-color:#FFFFFF; text-align:center;">
		<?php
			list($image_width, $image_height) = getimagesize($imageUrl);

			if($image_width > 490)
				echo $this->Image->resize($imagePath, 485, 450, array('alt'=>''));
			else
				echo $this->Html->image($imagePath, array('alt'=>''));
		?>
	</div>
<?php
	}else{
?>
<div style="text-align:center; color:#FF0000; margin:130px 0;">Sorry!! The image is not available!!</div>
<?php
	}
}
?>
</div>
<!-- PAGE LEFT PART END -->

<!-- PAGE RIGHT PART START -->
<div class="popupimgfr">
	<div class="fl">
		<?php 
			$businessImage = 'front_end/business/noimage.jpg';
			if($businessArr['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$businessArr['Business']['image'];
					
			}
			echo $this->Image->resize($businessImage, 59, 48, array('alt'=>''));
		?>
	</div>
	<div class="popupfrtextbox">
		<div class="popupfrtext"><a href="javascript:void(0);"><?php echo $businessArr['Business']['title'];?></a></div>
		<div class="graytext"><?php echo $businessArr['Business']['city'];?></div>
	</div>
	<div class="clr"></div>
	<div class="popupfrtotext">
		<?php echo $businessArr['BusinessFeed']['message'];?>
	</div>
	<div class="popupfrlink"><a href="javascript:void(0);">Recommend</a>|<a href="javascript:void(0);">Comment</a></div>
	<div class="inputboxmain">
		<div class="inputboxfllogo">
			<?php $businessImage = 'front_end/business/noimage.jpg';
			if($businessArr['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$businessArr['Business']['image'];
					
			}
			echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?>
		</div>
		<div class="inputboxlogofr"><input type="text" value="" /></div>
		<div class="clr"></div>
	</div>
</div>
<!-- PAGE RIGHT PART END -->
<div class="clr"></div>