<?php //pr($viewListing); 
echo $this->Html->css('rating/jRating.jquery');
?>
<div class="insiderightbox">
	<!-- MAIN CONTAINER START -->
	<div class="multiplemidbox"> 				
		<div>
			<h1>My Business</h1>

			<?php //validate user whether he has claimed the business or not
				//$claimed = $this->Fused->validateUserForBusiness();


				if(!empty($viewListing)){
					foreach($viewListing as $listing){ //pr($listing);die;
						$businessImage = 'front_end/business/noimage.jpg';
						if($listing['Business']['image'] != ''){
							$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
							if(is_file($imageRealPath))
								$businessImage = 'front_end/business/'.$listing['Business']['image'];
								
						}
					$page = 1;
					$claimUrl = SITE_PATH.'businesses/membership_plans/'.$this->Fused->encrypt($listing['Business']['id']).'/'
			?>
			<div id="main_data_container">
				<div class="busnissinmianbox">
					<div class="busnissimgfl">
						<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>
					<div class="busnisshomeinfr">
						<div class="busnissimgfrhd">
							<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
						</div>
						<div><?php echo $listing['Business']['city'],', '.$listing['Business']['state_code'];?></div>
						<div class="clr"></div>
						<div>
							<?php
								/* for($i=1; $i<=5; $i++){
									if($i <= $listing['Business']['rating'])
										echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
									else
										echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
								} */
							?>
							<div class="exemple">
								<div class="exemplemy" data="<?php echo $listing['Business']['rating'];?>_5"></div>
							</div>
							<div class="clr"></div>

							<!-- CURRENT PLAN START -->
							<div style="float:left; margin-top:3px;">
								<span style="font-weight:bold;">Current Plan:</span> <label><?php 
								$businessPlan = (int)$this->Fused->fetchBusinessMembershipPlan($listing['Business']['id']);
								$arr = $this->Fused->fetchAllPlansNames();
								echo $arr[$businessPlan];
								?></label>
							</div>
							<!-- CURRENT PLAN END -->

							<!-- EDIT SECTION START -->
							<div class="btnimage" style="float:right; height:25px;">
								<label id="add_favorite"><a href="<?php echo str_replace('http://', 'https://', SITE_PATH).'businesses/membership_plans/'.$this->Fused->encrypt($listing['Business']['id']).'/';?>" style="margin-right:10px;"><span>Upgrade</span></a></label>

								<!-- <a href="<?php echo SITE_PATH.'businesses/edit_business/'.$listing['Business']['id'].'/';?>"><span>Edit</span></a> -->
								<a href="<?php echo SITE_PATH.'businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/';?>"><span>Edit</span></a>
								<div class="clr"></div>
							</div>
							<div class="clr"></div>
							<!-- EDIT SECTION END -->
						</div>
						<div class="busnisslisttext">
							<?php echo $this->Text->truncate($listing['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
						</div>

						<div id="business_id_<?php echo $listing['Business']['id'];?>">
						<?php
							$BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($listing['Business']['id']);
							foreach($BusinessUserImageArr as $BusinessUserImage){
							$businessImage = 'front_end/business/noimage.jpg';
								if($BusinessUserImage['User']['image'] != ''){
									$imageRealPath = '../webroot/img/front_end/users/profile/'.$BusinessUserImage['User']['image'];
								if(is_file($imageRealPath))
									$businessImage = 'front_end/users/profile/'.$BusinessUserImage['User']['image'];
								}
						?>
						<div class="busnisslistsmlimg">
							<?php echo $this->Html->link($this->Image->resize($businessImage, 32, 32, array('alt'=>'')), '/users/profile/'.$BusinessUserImage['User']['username'].'/', array('escape'=>false)).' ';?>
						</div>
						<?php } ?>
						</div>
					</div>
					<div class="clr"></div>
				</div>
			</div>
			<?php } ?>
			<!-- LOAD MORE START -->
			<div id="load_more" align="center" style="display:none; margin-top:10px;">
				<?php 
					echo '<span id="loader_span">'.$this->Html->image('ajax/pic-loader.gif', array('alt'=>'', 'border'=>0)).' Loading More</span>';
					echo $this->Form->hidden('lastViewedPage', array('div'=>false, 'label'=>false, 'value'=>$page));
				?>
			</div>
			<!-- LOAD MORE END -->

			<?php }else{?>
					<div class="busnissinmianbox" style="text-align:center; color:#FF0000;">
						Administrator would approve the business soon!!
					</div>
			<?php } ?>
		</div>
	</div>				
	<!-- MAIN CONTAINER END -->

	<div class="deshboardfr">
		<!-- BUSINESS YOU MAY KNOW START -->
		<?php echo $this->Element('FrontEnd/business_you_may_know');?>
		<!-- BUSINESS YOU MAY KNOW END -->

		<!-- BUSINESS YOU MAY KNOW START -->
		<?php echo $this->Element('FrontEnd/featured_businesses');?>
		<!-- BUSINESS YOU MAY KNOW END -->

		<!-- INVITE FRIEND START -->
		<?php
			if($this->Fused->checkInviteFriends($this->Session->read('Auth.User.User.id')) < 1){
				echo $this->Element('FrontEnd/Inner/invite_friend');
			}
		?>
		<!-- INVITE FRIEND END -->

	</div>
	<div class="clr"></div>
</div>

<script type="text/javascript">
$(window).scroll(function(){
	if($(window).scrollTop() >= ($(document).height() - $(window).height()))
		fetchData();
});

function fetchData(){
	var lastViewedPage = parseInt($('#lastViewedPage').val());
	if(lastViewedPage != 0)
		$('#lastViewedPage').val((lastViewedPage + 1));
	if(lastViewedPage != '0'){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/fetch_business_listing_data/';?>",
			data: "last_viewed_page="+lastViewedPage,
			beforeSend:function(){
				$('#load_more').show();
			},
			success: function(response){
				if(response != 'Complete'){
					$('#main_data_container').append(response);
					$('#load_more').hide();
				}else{
					$('#lastViewedPage').val('0');
					$('#loader_span').html('<font color="red">No More Content To List</font>');
				}
			}
		});
	}else
		return false;
}
</script>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplemy').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>