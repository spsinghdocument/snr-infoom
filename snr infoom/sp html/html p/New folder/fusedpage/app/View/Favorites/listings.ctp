<?php //pr($viewListing); die;?>
<div class="insiderightbox">
	<!-- MAIN CONTAINER START -->
	<div class="multiplemidbox"> 				
		<div>
			<h1>My Favorites</h1>

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
						<div>
							<?php
								for($i=1; $i<=5; $i++){
									if($i <= $listing['Business']['rating'])
										echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
									else
										echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
								}
							?>

							<!-- REMOVE FROM FAVORITE START -->
						       <div class="btnimage" style="float:right; height:25px;">
							 <!-- <a href="javascript:void(0);" style="margin-left:25px; cursor:text;"><span>Remove</span></a> -->
							 <?php echo $this->Html->link('<span>Remove</span>', '/favorites/favorite_delete/'.$listing['Favorite']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Favorite Business?'); ?>
							<div class="clr"></div>
						       </div>
						       <div class="clr"></div>
						       <!-- REMOVE FROM FAVORITE END -->
						</div>

						<div class="busnisslisttext">
							<?php echo $this->Text->truncate($listing['Business']['tagline'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
						</div>

						<!-- <div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img3.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img3.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
						</div>
						<div class="busnisslistsmlimg">
							<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>''));?></a>
						</div> -->
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
						No Favorite List Available!!
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
	</div>
	<div class="clr"></div>
</div>

<script type="text/javascript">
/* $(window).scroll(function(){
	if($(window).scrollTop() >= ($(document).height() - $(window).height()))
		fetchData();
}); */

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