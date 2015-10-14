<?php 
	if(!empty($offersArr)){
		$offerListingPageNumber = 1;
?>
<div id="offersListingDivToAppend">
<?php
		foreach($offersArr as $offer){ //pr($offer);
			$offerImage = 'front_end/business/noimage.jpg';
			if($offer['BusinessOffer']['title'] != ''){
				$offerImagePath = '../webroot/img/front_end/business/offers/'.$offer['BusinessOffer']['image'];
				if(is_file($offerImagePath))
					$offerImage = 'front_end/business/offers/'.$offer['BusinessOffer']['image'];
			}
?>

<h8><?php echo $this->Fused->fetchCorrespondingOfferCategory($offer['BusinessOffer']['name']);?></h8>
<div class="deshlistbox">
	<div class="offermain">
		<div class="offermgbox">
			<a href="javascript:void(0);"><?php echo $this->Image->resize($offerImage, 59, 59, array('alt'=>''));?></a>
		</div>
		<div class="edittext">
			&nbsp;
		</div>
	</div>

	<div class="deshboarlistfrbox">
		<!-- EDIT/ DELETE SECTION START -->
		<?php if($this->Fused->fetchBusinessOwner($offer['BusinessOffer']['business_id']) == $this->Session->read('Auth.User.User.id')){?>
		<span style="float:right;">
			<a href="javascript:void(0);" onclick="return validateOffersTabs('<?php echo $offer['BusinessOffer']['id'];?>');" title="Edit"><?php echo $this->Html->image('front_end/edit_icon.png', array('alt'=>''));?></a>
			<!-- ********************** -->
			<a href="javascript:void(0);" title="Delete" onclick="return deleteBusinesOffer('<?php echo $offer['BusinessOffer']['id'];?>');"><?php echo $this->Html->image('admin/delete_icon.gif', array('alt'=>''));?></a>
		</span>
		<?php } ?>
		<!-- EDIT/ DELETE SECTION END -->

		<div class="offeritemfltext">
			<div class="busnissimgfrhd">
				<a href="javascript:void(0);"><?php echo $offer['BusinessOffer']['title'];?></a>
			</div>
			<div class="deshboardbluetext" style="color:#000000;">
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
</div>
<!-- LOAD MORE START -->
<div id="load_offers_listing_more" align="center" style="display:none; margin-top:10px;">
	<?php 
		echo '<span id="load_offers_listing_more_span">'.$this->Html->image('ajax/pic-loader.gif', array('alt'=>'', 'border'=>0)).' Loading More</span>';

		echo $this->Form->hidden('lastViewedOfferListingPageId', array('div'=>false, 'label'=>false, 'value'=>$offerListingPageNumber));
	?>
</div>
<!-- LOAD MORE END -->
<?php }else{ ?>
<div class="deshlistbox" style="text-align:center; color:#FF0000; margin-top:50px;">
	No Offers Available!!
</div>
<?php } ?>