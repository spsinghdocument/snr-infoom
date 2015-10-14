<?php echo $this->Html->script('rating/jRating.jquery');?>
<?php 
	if(!empty($dealsArr)){
	foreach($dealsArr as $deal){ //pr($deal);die;
		$usrRate = $this->Fused->validateOfferDealRating($deal['BusinessDeal']['id'], 'deal_id');
		$dealImage = 'front_end/business/noimage.jpg';
		if($deal['BusinessDeal']['image'] != ''){
			$offerImagePath = '../webroot/img/front_end/business/deals/'.$deal['BusinessDeal']['image'];
			if(is_file($offerImagePath))
				$dealImage = 'front_end/business/deals/'.$deal['BusinessDeal']['image'];
		}
?>
<div class="deshlistbox">
	<div class="dealdtlboxfl">
		<a href="javascript:void(0);"><?php echo $this->Image->resize($dealImage, 118, 93, array('alt'=>''));?></a>
	</div>
	<div class="dealdtlboxfr">
		<div class="busnissimgfrhd fl"><a href="javascript:void(0);"><?php echo $deal['BusinessDeal']['title'];?></a></div>

		<!-- RATING SECTION START -->
		<div class="price">
			<?php  $offerRating = $deal['BusinessDeal']['rating'];
				if($offerRating == '0.0'){
					$offerRating = '0';
				}

				$offerClass = 'exemple5';
				if($usrRate != '')
					$offerClass = 'exempleDis';
			?>
			<div id="rating_<?php echo $deal['BusinessDeal']['id'];?>" class="<?php echo $offerClass;?>" data="<?php echo $offerRating;?>_5"></div>
		</div>
		<!-- RATING SECTION START -->

		<div class="clr"></div>

		<div class="price" style="margin-top:5px;">Price:<span>$<?php echo $deal['BusinessDeal']['price'];?></span></div>
		<div class="clr"></div>

		<div class="tagline"><?php echo $deal['BusinessDeal']['tagline'];?></div>
		<div class="deshtextsml"><?php echo $deal['BusinessDeal']['description'];?></div>
		<div>
			<div class="viewdtlbtn"><a href="javascript:void(0);" onclick="return view_details('<?php echo $deal['BusinessDeal']['id'];?>');"><?php echo $this->Html->image('front_end/view_dtl_btn.png', array('alt'=>''));?></a></div>
			<?php if($deal['BusinessDeal']['start_date'] != ''){?>
				<div class="startdate">Start Date</div>
				<div class="sdateimg"><?php echo date('d M', strtotime($deal['BusinessDeal']['start_date']));?></div>
				<div class="enddate">End Date</div>
				<div class="edateimg"><?php echo date('d M', strtotime($deal['BusinessDeal']['end_date']));?></div>
			<?php } ?>
			<div class="clr"></div>
		</div>	
	</div>
	<div class="clr"></div>

	<!-- EDIT DELETE SECTION START -->
	<?php if($this->Fused->fetchBusinessOwner($deal['BusinessDeal']['business_id']) == $this->Session->read('Auth.User.User.id')){?>
	<div class="edittext" style="text-align:left;">
		<a title="Edit" href="javascript:void(0);" style="float:left;" onclick="return validateDealsTabs('edit', '<?php echo $deal['BusinessDeal']['id'];?>')"><img alt="" src="/fusedpage/img/front_end/edit_icon.png"></a>
		<!-- **************** -->
		<a title="Delete" href="javascript:void(0);" style="float:left; margin-left:10px;" onclick="return deleteBusinesDeal('<?php echo $deal['BusinessDeal']['id'];?>');"><img alt="" src="/fusedpage/img/admin/delete_icon.gif/"></a>
	</div>
	<div class="clr"></div>
	<?php } ?>
	<!-- EDIT DELETE SECTION END   -->

	<div class="deshboardwhitebox">
<!-- Recommended Start -->

				<div class="likeboxfl" id="deal_image1_<?php echo $deal['BusinessDeal']['id']; ?>">	
				<?php
				$UserImageArr = $this->Fused->fetchDealUserImage($deal['BusinessDeal']['id']);
				foreach($UserImageArr as $UserImage){
					$username = $UserImage['User']['username'];
				if($this->Session->read('Auth.User.User.gender') == '1')
							$businessImage = 'front_end/users/male.jpg';
						else
							$businessImage = 'front_end/users/female.jpg';
				if($UserImage['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$UserImage['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$UserImage['User']['image'];
						
				} ?>
				<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?></a>
				<?php } ?>
				</div>
<?php $countRecommended = $this->Fused->fetchDealRecommended($deal['BusinessDeal']['id']);?>
<?php $countUserImage = $this->Fused->fetchUserDeal($deal['BusinessDeal']['id'],$this->Session->read('Auth.User.User.id')); ?>
				<div class="likeboxfr">
				<?php if($countUserImage < 1){ ?>
				<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
				<span id="deal_like_<?php echo $deal['BusinessDeal']['id']; ?>">
					<?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'dealrecommended('.$deal['BusinessDeal']['id'].'), dealrecommendedImage('.$deal['BusinessDeal']['id'].', '.$this->Session->read('Auth.User.User.id').');'));?>
				</span>
				<?php } ?>
				<?php } ?>
					<span id="deal_recommended_<?php echo $deal['BusinessDeal']['id'];?>">
						<?php if($countRecommended > 0){
							echo $countRecommended.' person has recommended';
						} else {
							echo 'Be the first to recommended';
						} ?></span>
				</div>
				<span id="deal_roller1_<?php echo $deal['BusinessDeal']['id'];?>"></span>
				<div class="clr"></div>
<!-- Recommended End -->
	<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div class="coomentlinbox">
			<!-- <div class="commentfltext"><span>3  People </span>you know recommended this</div> -->
			<div class="commentfrlink">
			<?php if($countUserImage < 1){ ?>
				<span id="recshow_<?php echo $deal['BusinessDeal']['id'];?>">
				<?php echo $this->Html->link('Recommend', 'javascript:void(0);', array('onclick'=>'dealrecommended('.$deal['BusinessDeal']['id'].'), dealrecommendedImage('.$deal['BusinessDeal']['id'].', '.$this->Session->read('Auth.User.User.id').');')); ?>
				</span>
				<span id="rechide_<?php echo $deal['BusinessDeal']['id'];?>" style="display:none;">
				<a href="javaScript:void(0);">Recommend</a>
				</span>
			<?php } else { ?>
				<span>
				<a href="javaScript:void(0);">Recommend</a>
				</span>
			<?php } ?>
			</div>
			<div class="clr"></div>
		</div>
	<?php } ?>
<!-- Comment Start -->
				<div class="coomentlinbox" id="deal_comment_div_<?php echo $deal['BusinessDeal']['id'];?>" style="border:none;">
				<?php $commentArr = $this->Fused->fetchDealComments($deal['BusinessDeal']['id']); ?>
				<?php if(!empty($commentArr)){
				foreach($commentArr as $comment){
					$username = $comment['User']['username'];
				if($this->Session->read('Auth.User.User.gender') == '1')
							$businessImage = 'front_end/users/male.jpg';
						else
							$businessImage = 'front_end/users/female.jpg';
				if($comment['User']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/users/profile/'.$comment['User']['image'];
					if(is_file($imageRealPath))
						$businessImage = 'front_end/users/profile/'.$comment['User']['image'];
						
				}
				?>
				<table id="deal_<?php echo $comment['DealComment']['id'];?>" style="width:100%; background-color:#F2F2F2; border-bottom:1px solid #FFFFFF;">
				<tr>
					<td style="width:10%"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>''));?></a></td>

					<td><?php echo $comment['DealComment']['comment']; ?>
					<?php if($this->Session->read('Auth.User.User.id') == $comment['DealComment']['user_id']){ ?>
					<div class="listboxbg"><span style="float:right; margin-top:-10px;" id="delete_comment_<?php echo $comment['DealComment']['id'];?>"><a href="javascript:void(0);" title="Delete" onclick="return deleteDealComment('<?php echo $comment['DealComment']['id'];?>');"><?php echo $this->Html->image('front_end/delete.png', array('alt'=>''));?></a></span></div>
					<?php } ?>
					</td>

				</tr>
				</table>
				<?php } } ?>
				</div>
				<span id="deal_roller_<?php echo $deal['BusinessDeal']['id'];?>"></span>
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
				<div class="offcommetarrow">
					<?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?>
				</div>
				<textarea name="deal_comment" id="deal_comment_<?php echo $deal['BusinessDeal']['id'];?>" cols="" rows="" class="offcommentfrbox" style="resize:none;"></textarea>
			</div>
			<div class="clr"></div>

			<input type="hidden" id="deal_<?php echo $deal['BusinessDeal']['id'];?>" value="<?php echo $deal['BusinessDeal']['id'];?>" >

		<div class="pstbtn" onclick="saveDealComment('<?php echo $deal['BusinessDeal']['id'];?>');"><?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?></div>
		</div>
		<?php } ?>
	</div>
</div>
<?php }}else{ ?>
<div class="deshlistbox" style="text-align:center; color:#FF0000; margin-top:50px;">
	No Deals Available!!
</div>
<?php } ?>

<!-- HIDDEN FIELD START -->
<?php echo $this->Form->hidden('user_rating');?>
<!-- HIDDEN FIELD END -->


<script language="text/javascript">
function saveDealComment(deal_id){
	var comment = $('#deal_comment_'+deal_id).val();
	var deal_id = $('#deal_'+deal_id).val();
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/saveComment/';?>",
				data: "deal_id="+deal_id+"&user_id="+user_id+"&comment="+comment,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#deal_roller_'+deal_id).html(bSend);
				},
				success: function(response){
						$('#deal_roller_'+deal_id).html('');
						$('#deal_comment_'+deal_id).val('');
						$('#deal_comment_div_'+deal_id).append(response);
						
					}
			});
	}
}

function deleteDealComment(comment_id){
	if(comment_id != ''){
		var conf = confirm("Do you want to delete this Comment?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/delete_deal_comment/';?>",
				data: "comment_id="+comment_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#deal_roller_'+comment_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#deal_roller_'+comment_id).html('');
						$('#deal_'+comment_id).html('');
						$('#deal_'+comment_id).hide();
					}
				}
			});
			//send Ajax for Deleting End
		}
	}
}


function dealrecommended(deal_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/add_recommended/';?>",
				data: "deal_id="+deal_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#deal_roller1_'+deal_id).html(bSend);
					$('#recshow_'+deal_id).hide();
				},
				success: function(response){
						$('#deal_roller1_'+deal_id).html('');
						$('#deal_recommended_'+deal_id).html(response);
						$('#deal_like_'+deal_id).hide();
						$('#recshow_'+deal_id).hide();
						$('#rechide_'+deal_id).show();
						
				}
			});
	}
}

function dealrecommendedImage(deal_id, user_id){
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/fetch_user_image/';?>",
				data: "deal_id="+deal_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				},
				success: function(response){
						$('#image_'+deal_id).html('');
						$('#deal_image1_'+deal_id).append(response);
				}
			});
	}
}

</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.exemple5').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big'
		});

		$('.exempleDis').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big',
			isDisabled:true
		});
	});

$(document).ready(function(){
	$('.exemple5').click(function(){
		//alert($(this).attr('id'));
		var ratingDiv = ($(this).attr('id')).split('_');
		var ratingId = ratingDiv[1];
		var rating = $('#user_rating').val();
		if((ratingId != '') && (rating != '')){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/set_total_rating/';?>",
				data: "id="+ratingId+"&rating="+rating
			});
		}

	});
});

</script>