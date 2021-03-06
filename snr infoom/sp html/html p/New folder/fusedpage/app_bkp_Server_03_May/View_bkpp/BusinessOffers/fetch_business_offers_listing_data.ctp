<?php 
	if(!empty($offersArr)){
		foreach($offersArr as $offer){ //pr($offer);
			$offerImage = 'front_end/business/noimage.jpg';
			if($offer['BusinessOffer']['title'] != ''){
				$offerImagePath = '../webroot/img/front_end/business/offers/'.$offer['BusinessOffer']['image'];
				if(is_file($offerImagePath))
					$offerImage = 'front_end/business/offers/'.$offer['BusinessOffer']['image'];
			}
?>

<h8><?php echo $offer['BusinessOffer']['name'];?></h8>
<div class="deshlistbox">
	<div class="offermain">
		<div class="offermgbox">
			<a href="javascript:void(0);"><?php echo $this->Image->resize($offerImage, 59, 59, array('alt'=>''));?></a>
		</div>
		<div class="edittext">
			<?php if($this->Fused->validateUserForBusiness() == $offer['BusinessOffer']['business_id']){?>
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/edit_icon.png', array('alt'=>''));?> Edit</a>
			<?php } ?>
		</div>
	</div>

	<div class="deshboarlistfrbox">
		<div class="offeritemfltext">
			<div class="busnissimgfrhd">
				<a href="javascript:void(0);"><?php echo $offer['BusinessOffer']['title'];?></a>
			</div>
			<div class="deshboardbluetext">
				<?php echo $this->Text->truncate($offer['BusinessOffer']['description'], 150, array('ending'=>'...', 'html'=>true, 'exact'=>true));?>
			</div>
		</div>
		<div class="offeritemflbutton">$<?php echo $offer['BusinessOffer']['price']?></div>
		<div class="clr"></div>
	</div>					
	<div class="clr"></div>

	<div class="deshboardwhitebox">
		<div class="likeboxfl">
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img1.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img3.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>''));?></a>
			</div>
		</div>

		<div class="offerlikeboxfr">
			<?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));?><span>20 People</span> recommended this
		</div>
		<div class="clr"></div>

		<div class="coomentlinbox">
			<div class="commentfltext"><span>3  People </span>you know recommended this</div>
			<div class="commentfrlink"><a href="javascript:void(0);">Recommend</a></div>
			<div class="clr"></div>
		</div>

		<div>
			<div class="commentflimg">
				<?php echo $this->Html->image('front_end/comment_fl_img.jpg', array('alt'=>''));?>
			</div>
			<div class="offcommentbox">
				<div class="offcommetarrow"><?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?></div>
				<textarea name="" cols="" rows="" class="offcommentfrbox"></textarea>
			</div>
			<div class="clr"></div>
		</div>
	</div>
</div>
<?php } ?>

<?php }else{ 
	echo 'Complete';
}?>