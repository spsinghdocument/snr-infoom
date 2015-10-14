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

<h8><?php echo $offer['BusinessOffer']['name'];?></h8>
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
<!-- Recommended Start -->

				<div class="likeboxfl" id="offer_image1_<?php echo $offer['BusinessOffer']['id']; ?>">	
				<?php
				$UserImageArr = $this->Fused->fetchOfferUserImage($offer['BusinessOffer']['id']);
				foreach($UserImageArr as $UserImage){
				$businessImage = 'front_end/business/noimage.jpg';
				if($UserImage['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$UserImage['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$UserImage['User']['image'];
						
				} ?>
				<?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?>
				<?php } ?>
				</div>
<?php $countRecommended = $this->Fused->fetchOfferRecommended($offer['BusinessOffer']['id']);?>
<?php $countUserImage = $this->Fused->fetchUserOffer($offer['BusinessOffer']['id'],$this->Session->read('Auth.User.User.id')); ?>
				<div class="likeboxfr">
				<?php if($countUserImage < 1){ ?>
				<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
				<span id="offer_like_<?php echo $offer['BusinessOffer']['id']; ?>">
					<?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'offerrecommended('.$offer['BusinessOffer']['id'].'), offerrecommendedImage('.$offer['BusinessOffer']['id'].', '.$this->Session->read('Auth.User.User.id').');'));?>
				</span>
				<?php } ?>
				<?php } ?>
					<span id="offer_recommended_<?php echo $offer['BusinessOffer']['id'];?>"> <?php if($countRecommended > 0){ echo $countRecommended; } else { echo '0'; } ?> People</span> recommended this
				</div>
				<span id="offer_roller1_<?php echo $offer['BusinessOffer']['id'];?>"></span>
				<div class="clr"></div>
<!-- Recommended End -->
	<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div class="coomentlinbox">
			<div class="commentfltext"><span>3  People </span>you know recommended this</div>
			<div class="commentfrlink"><a href="javascript:void(0);">Recommend</a></div>
			<div class="clr"></div>
		</div>
	<?php } ?>
<!-- Comment Start -->
				<div class="coomentlinbox" id="offer_comment_div_<?php echo $offer['BusinessOffer']['id'];?>" style="border:none;">
				<?php $commentArr = $this->Fused->fetchOfferComments($offer['BusinessOffer']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
				$businessImage = 'front_end/business/noimage.jpg';
				if($comment['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$comment['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$comment['User']['image'];
						
				}
				?>
				<table id="offer_<?php echo $comment['OfferComment']['id'];?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
				<tr>
					<td style="width:10%"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?></td>

					<td><?php echo $comment['OfferComment']['comment']; ?>
					<?php if($this->Session->read('Auth.User.User.id') == $comment['OfferComment']['user_id']){ ?>
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['OfferComment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteOfferComment('<?php echo $comment['OfferComment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?>
					</td>

				</tr>
				</table>
				<?php } } ?>
				</div>
				<span id="offer_roller_<?php echo $offer['BusinessOffer']['id'];?>"></span>
<!-- Comment End -->
		<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div>
			<div class="commentflimg">
				<?php 
					//PROFILE AVATAR START
						if($this->Session->read('Auth.User.User.gender') == '1')
							$avatar = 'front_end/users/male.jpg';
						else
							$avatar = 'front_end/users/female.jpg';

						if(($this->Session->read('Auth.User.User.image')) != ''){
								$realPath = '../webroot/img/front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
							if(is_file($realPath)){
								$avatar = 'front_end/users/profile/'.$this->Session->read('Auth.User.User.image');
							}
						}

						echo $this->Image->resize($avatar, 32, 32, array('alt'=>''));
					//PROFILE AVATAR END
					?>
			</div>
			<div class="offcommentbox">
				<div class="offcommetarrow"><?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?></div>
				<textarea name="offer_comment" id="offer_comment_<?php echo $offer['BusinessOffer']['id'];?>" cols="" rows="" class="offcommentfrbox" style="resize:none;"></textarea>
			</div>
			<div class="clr"></div>
		</div>
		<?php } ?>
		<div class="clr"></div>

		<input type="hidden" id="offer_<?php echo $offer['BusinessOffer']['id'];?>" value="<?php echo $offer['BusinessOffer']['id'];?>" >
		<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div class="pstbtn" onclick="saveOfferComment('<?php echo $offer['BusinessOffer']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
		<?php } ?>
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


<script language="text/javascript">
function saveOfferComment(offer_id){
	var comment = $('#offer_comment_'+offer_id).val();
	var offer_id = $('#offer_'+offer_id).val();
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_offers/saveComment/';?>",
				data: "offer_id="+offer_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#offer_roller_'+offer_id).html(bSend);
				},
				success: function(response){
						$('#offer_roller_'+offer_id).html('');
						$('#offer_comment_'+offer_id).val('');
						
						$('#offer_comment_div_'+offer_id).append(response);
						
					}
			});
	}
}

function deleteOfferComment(comment_id){
	if(comment_id != ''){
		var conf = confirm("Do you want to delete this Comment?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_offers/delete_offer_comment/';?>",
				data: "comment_id="+comment_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#offer_roller_'+comment_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#offer_roller_'+comment_id).html('');
						$('#offer_'+comment_id).html('');
						$('#offer_'+comment_id).hide();
					}
				}
			});
			//send Ajax for Deleting End
		}
	}
}


function offerrecommended(offer_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_offers/add_recommended/';?>",
				data: "offer_id="+offer_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#offer_roller1_'+offer_id).html(bSend);
				},
				success: function(response){
						$('#offer_roller1_'+offer_id).html('');
						$('#offer_recommended_'+offer_id).html(response);
						$('#offer_like_'+offer_id).hide();
						
				}
			});
	}
}

function offerrecommendedImage(offer_id, user_id){
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_offers/fetch_user_image/';?>",
				data: "offer_id="+offer_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				},
				success: function(response){
						$('#image_'+offer_id).html('');
						$('#offer_image1_'+offer_id).append(response);
				}
			});
	}
}
</script>