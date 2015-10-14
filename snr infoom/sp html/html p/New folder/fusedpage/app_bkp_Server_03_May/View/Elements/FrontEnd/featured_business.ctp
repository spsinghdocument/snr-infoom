<?php $featuredBusinessArr = $this->Fused->featuredBusiness();?>
<div class="midfrinbox">
	<h1>Featured Business</h1>
	<?php if(!empty($featuredBusinessArr)){ 
		foreach($featuredBusinessArr as $listing){ //pr($listing);die;
			$businessImage = 'front_end/business/noimage.jpg';
			if($listing['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$listing['Business']['image'];
			}
	?>
	<div class="midfrimgbox">
		<div class="featurebussbox">
			<?php echo $this->Html->link($this->Image->resize($businessImage, 216, 124, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="featureimgname"><?php echo $this->Text->truncate($listing['Business']['about_us'], 30, array('ending'=>'...', 'exact'=>true, 'html'=>true));?></div>
	</div>

	<?php } } ?>
</div>