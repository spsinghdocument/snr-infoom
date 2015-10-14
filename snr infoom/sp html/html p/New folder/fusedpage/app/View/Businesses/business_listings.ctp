<?php //pr($this->params); ?>
<div class="insiderightbox">
	<!-- MAIN CONTAINER START -->
	<div class="multiplemidbox"> 				
		<div>
			<div style="border-bottom:1px solid #F3F3F3;">
			<?php //echo $this->Form->create('Business', array('action'=>'business_search'));?>
			<?php echo $this->Form->input('Business.searchkeyword', array('onkeyup'=>'business_autosuggation(this.value);','div'=>false, 'label'=>false, 'error'=>false, 'type'=>'text', 'style'=>'width:315px;', 'class'=>'passinput', 'placeholder'=>'Search Business', 'autocomplete'=>'off')); ?>

			<div id="business_suggestions" style="border:1px solid #CDCDCD; width:315px; display:none; position:absolute; background-color:#FFFFFF; max-height:200px; overflow-x:hidden; overflow-y:scroll; z-index:10"></div>
		

			<!-- <select name="" class="deshboardselbox"></select> -->
			<?php echo $this->Form->submit('front_end/search_icon.png', array('div'=>false, 'onclick'=>'return business_search();'));?>
			<?php //echo $this->Form->end(); ?>
			</div>
			<?php //validate user whether he has claimed the business or not
				$claimed = $this->Fused->validateUserForBusiness();


				if(!empty($viewListing)){
			?>
			<div id="main_data_container">
			<?php
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
								for($i=1; $i<=5; $i++){
									if($i <= $listing['Business']['rating'])
										echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
									else
										echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
								}
							?>

							<!-- SUBSCRIBE SECTION START -->
							<?php
							if($this->Session->check('Auth.User.User.id')){
								if($this->Fused->validateSubscribedBusiness($listing['Business']['id']) == 0)
									$subscribe = 'subscribe';
								else
									$subscribe = 'unsubscribe';
							?>
							<div class="btnimage" style="float:right; height:25px;">
								<div id="subscribe_div_<?php echo $listing['Business']['id'];?>">
									<a href="javascript:void(0);" onclick="return subscribe_business('<?php echo $subscribe;?>','<?php echo $listing['Business']['id'];?>')"><span><?php echo ucwords($subscribe);?></span></a>
								</div>
							</div>
							<?php
							}
							?>
							<div class="clr"></div>
							<!-- SUBSCRIBE SECTION END -->
						</div>
						<div class="busnisslisttext">
							<?php echo $this->Text->truncate($listing['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
						</div>

						<div id="business_id_<?php echo $listing['Business']['id']; ?>">
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
							<?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?>
						</div>
						<?php } ?>
						</div>
					</div>
					<div class="clr"></div>
				</div>
			<?php } ?>
			</div>
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
						No Recently Business Available!!
					</div>
			<?php } ?>
		</div>
	</div>				
	<!-- MAIN CONTAINER END -->

	<div class="deshboardfr">

		<div class="addcailmbtn">
			<?php echo $this->Html->link($this->Html->image('front_end/add_or_claim_btn.jpg'), '/businesses/add_business/', array('escape'=>false));?>
		</div>
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

function subscribe_business(type, id){ //alert(type+', '+id); return false;
	var fav_count = parseInt($('#fav_count').val());
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_subscribers/subscribe_business/';?>",
		data: "business_id="+id+"&type="+type+"&view=listing",
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>';
			$('#subscribe_div_'+id).html(bSend);
		},
		success: function(response){
			if(type == 'subscribe'){
				$('#fav_count').val(fav_count + 1);
				$('#fav_span').html(fav_count + 1);
			}else{
				if(fav_count > 0){
					$('#fav_count').val(fav_count - 1);
					$('#fav_span').html(fav_count - 1);
				}
			}
			$('#subscribe_div_'+id).html(response);
		}
	});
}
</script>



<script type="text/javascript">

function business_autosuggation(businesskey){
	if(businesskey.length > 0){
		$('#businessbox').show();
		if(businesskey != ''){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'businesses/auto_business_data/';?>",
				data: "businesskey="+businesskey,
				beforeSend:function(){
				//alert(categoryId);
					var bSend = '<?php echo $this->Html->image("ajax/loading.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
					$('#business_suggestions').show();
					$('#business_suggestions').html(bSend);
				},
				success: function(response){
					$('#business_suggestions').html(response);
				}
			});
		}
	}else{
		$('#businessbox').hide();
		$('#business_suggestions').hide();
	}
}

function setBusinessData(name){
	$('#BusinessSearchkeyword').val(name);
	$('#business_suggestions').hide();
}

function validateSettingsBox(){
	$('#settings_box').toggle();
}


function business_search(){
	var searchkeyword = $('#BusinessSearchkeyword').val();
	if(searchkeyword != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'businesses/business_search/';?>",
				data: "searchkeyword="+searchkeyword,
				beforeSend:function(){
				//alert(categoryId);
					var bSend = '<?php echo $this->Html->image("ajax/loading.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
					$('#main_data_container').html(bSend);
				},
				success: function(response){
					$('#main_data_container').html(response);
				}
			});
	}
}
</script>