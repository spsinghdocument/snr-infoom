<?php
if($type == ''){ // FOR VIDEO
	//call the flowplayer
	echo $this->Html->script('flowplayer/flowplayer-3.2.6.min');

	$player = SITE_PATH.'js/flowplayer/swf/flowplayer-3.2.7.swf';

//validate Video
$videoUrl = '../webroot/img/front_end/groups/recents/video/flv/'.$video.'.flv';
if(is_file($videoUrl)){
	$playerVideo = SITE_PATH.'img/front_end/groups/recents/video/flv/'.$video.'.flv';

	//validate the Video Image
	$videoImageUrl = '../webroot/img/front_end/groups/recents/video/image/'.$video.'.jpg';
	if(is_file($videoImageUrl))
		$playerVideoImage = SITE_PATH.'img/front_end/groups/recents/video/image/'.$video.'.jpg';
	else
		$playerVideoImage = SITE_PATH.'img/front_end/business/noimage.jpg';
?>


<div id="player1" style="text-align:center; margin:4px 0 0 12px; width:600px; height:400px;"></div>



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
<?php }else{ ?>
	<div style="text-align:center; color:#FF0000;">Sorry!! The video has been moved away!!</div>
<?php }
}elseif($type == 'image'){ // FOR IMAGE
	$expArr = explode('***', $video);
	$imageName = $expArr[0].'.'.$expArr[1];

	$imageRealPath = '../webroot/img/front_end/groups/recents/'.$imageName;

	if(is_file($imageRealPath)){
		echo $this->Html->image('front_end/groups/recents/'.$imageName, array('alt'=>''));
	}else{
?>
	<div style="text-align:center; color:#FF0000;">Sorry!! The image has been moved away!!</div>
<?php
	}
}?>