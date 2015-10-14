<?php
	$popularGroupsArr = $this->Fused->fetchPopularGroups(); //pr($popularGroupsArr);
	if(!empty($popularGroupsArr)){
?>
<div class="insidefrhdbg">
	<div class="fl"><h4>Popular Groups</h4></div>
	<div class="morelink"><a href="#">More</a></div>
	<div class="clr"></div>
</div>
<?php foreach($popularGroupsArr as $listing){ //pr($listing);die;
		$businessImage = 'front_end/business/noimage.jpg';
		if($listing['Group']['image'] != ''){
			$imageRealPath = '../webroot/img/front_end/groups/'.$listing['Group']['image'];
			if(is_file($imageRealPath))
				$businessImage = 'front_end/groups/'.$listing['Group']['image'];
				
		}
?>
<div style="padding-top:0;" class="bussinessinmain">
	<div class="bussimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/groups/details/'.$this->Fused->encrypt($listing['Group']['id']).'/', array('escape'=>false));?>
	</div>
	<div class="busnissfrbox">
	<div class="busnissimgfrinhd"><a href="#"><?php echo $this->Text->truncate($listing['Group']['title'], 40, array('ending'=>'...')); ?></a></div>
	<div>
	<?php echo $this->Html->link($this->Html->image('front_end/star_rating_orange.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
	<?php echo $this->Html->link($this->Html->image('front_end/star_rating_orange.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
	<?php echo $this->Html->link($this->Html->image('front_end/star_rating_orange.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
	<?php echo $this->Html->link($this->Html->image('front_end/star_rating_orange.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
	<?php echo $this->Html->link($this->Html->image('front_end/star_rating_orange.png', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
	
	</div>		
	</div>
	<div class="clr"></div>
</div>

<?php } ?>
<?php } ?>