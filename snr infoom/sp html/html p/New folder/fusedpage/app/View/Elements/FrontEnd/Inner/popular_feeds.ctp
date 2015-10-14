<?php $populaFeedArr = $this->Fused->fetchMostPopularFeed(); //pr($populaFeedArr);?>
<?php if(!empty($populaFeedArr)){ ?>
<div class="popularhd">
	<div class="fl"><h4>Popular Feed</h4></div>
	<!-- <div class="morelink"><a href="javascript:void(0);">More</a></div> -->
	<div class="clr"></div>
</div>
<?php } ?>
<div class="popularbox">
	<ul class="popularfeed">
		 <?php if(!empty($populaFeedArr)){ 
		   foreach($populaFeedArr as $populaFeed) { ?>
		   <li><a href="javascript:void(0);"><?php echo $this->Text->truncate($populaFeed['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?></a></li>
	   <?php } } ?>
	</ul>
</div>



