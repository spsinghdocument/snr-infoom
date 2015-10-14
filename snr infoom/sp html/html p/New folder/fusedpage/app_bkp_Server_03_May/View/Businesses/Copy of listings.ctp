<div class="insiderightbox">
	<div class="multiplemidbox">
		<!-- BREADCRUMB START -->
		<?php //echo $this->Element('FrontEnd/Inner/breadcrumb');?>
		<!-- BREADCRUMB END -->

		<?php //validate user whether he has claimed the business or not
			$claimed = $this->Fused->validateUserForBusiness();


			if(!empty($viewListing)){
				foreach($viewListing as $listing){ //pr($listing);die;
					$businessImage = 'front_end/business/noimage.jpg';
					if($listing['Business']['image'] != ''){
						$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
						if(is_file($imageRealPath))
							$businessImage = 'front_end/business/'.$listing['Business']['image'];
							
					}
				$page = 1;
				$claimUrl = SITE_PATH.'businesses/membership_plans/'.base64_encode($listing['Business']['id']).'/'
		?>
		<div id="main_data_container">
			<div class="busnissinmianbox">
				<div class="busnissimgfl">
					<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
				</div>

				<div class="multipalflbox">
					<div class="multipalhd">
						<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>

					<div class="multipaltextsml"><?php
						echo $listing['Business']['street'].', '.$listing['Business']['city'],', '.$listing['Business']['country']
					?></div>
					<div class="phoneandmail">
						<?php 
						if($listing['Business']['phone'] != ''){
							echo $this->Html->image('front_end/phone_icon.jpg', array('alt'=>''));?>
							<strong><?php echo $listing['Business']['phone'];?></strong>
						<?php }
						if($listing['Business']['email'] != ''){
						?>
						<span class="miltibusinessmail">
							<?php
								echo $this->Html->image('front_end/mail_icon.jpg', array('alt'=>''));
								echo $this->Html->link($listing['Business']['email'], 'mailto:'.$listing['Business']['email'], array('escape'=>false));
							?>
						</span>
						<?php } ?>
					</div>
					<div class="commenlink">
						<?php echo $this->Html->link($listing['Business']['website'], $listing['Business']['website'], array('escape'=>false, 'target'=>'_blank'));?>
					</div>
					<div class="findouttext">Find out more about this business...visit page</div>
					<div>
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>	
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img3.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="deshboardsmlimg last">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="clr"></div>
					</div>
					<div class="hotellisttextbck">20 people recommended this business</div>
				</div>

				<div class="multipalfrbox">
					<div class="ratingstaryellow">
						<?php
							for($i=1; $i<=5; $i++){
								if($i <= $listing['Business']['rating'])
									echo $this->Html->image('front_end/rating_star_yellow.png', array('alt'=>'', 'border'=>0));
								else
									echo $this->Html->image('front_end/rating_star_gray.png', array('alt'=>'', 'border'=>0));
							}
						?>
					</div>	
					<div class="ratingtext">Category: <span>Hotels</span></div>
					<!-- CLAIM BUSINESS START -->
					<div class="btnimage" style="margin-top:10px; height:25px;">
						<?php if($this->Fused->fetchBusinessClaimStatus($listing['Business']['id']) == ''){
							if($claimed == ''){
						?>
						<a href="<?php echo $claimUrl;?>" style="margin-left:25px;"><span>Claim</span></a>
						<?php }}else{ ?>
							<a href="javascript:void(0);" style="margin-left:25px; cursor:text;"><span>Claimed</span></a>
						<?php } ?>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
					<!-- CLAIM BUSINESS END -->
					<div class="graybtnbig" style="padding-top:60px;">
						<?php echo $this->Html->link('Visit Page', '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<?php		}
		?>
			<!-- LOAD MORE START -->
			<div id="load_more" align="center" style="display:none; margin-top:10px;">
				<?php 
					echo '<span id="loader_span">'.$this->Html->image('ajax/pic-loader.gif', array('alt'=>'', 'border'=>0)).' Loading More</span>';
					echo $this->Form->hidden('lastViewedPage', array('div'=>false, 'label'=>false, 'value'=>$page));
				?>
			</div>
			<!-- LOAD MORE END -->
		<?php
			}else{?>
				<div class="busnissinmianbox" style="text-align:center; color:#FF0000;">
					No Business Available!!
				</div>
		<?php } ?>
	</div>

	<!-- SIDE POPULAR BUSINESSES START -->
	<?php echo $this->Element('FrontEnd/Inner/popular_businesses');?>
	<!-- SIDE POPULAR BUSINESSES END -->
	
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