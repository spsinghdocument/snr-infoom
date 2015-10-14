<?php //validate user whether he has claimed the business or not
	//$claimed = $this->Fused->validateUserForBusiness();
	echo $this->Html->css('rating/jRating.jquery');


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
					<div class="exemplefetch" data="<?php echo $listing['Business']['rating'];?>_5"></div>
				</div>
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
				<?php echo $this->Text->truncate($listing['Business']['tagline'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
			</div>

			<div id="business_id_<?php echo $listing['Business']['id']; ?>">
			<?php
					$BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($listing['Business']['id']);
					foreach($BusinessUserImageArr as $BusinessUserImage){
								
								if($BusinessUserImage['User']['gender'] == '1')
									$businessImage = 'front_end/users/male.jpg';
								else
									$businessImage = 'front_end/users/female.jpg';

									if($BusinessUserImage['User']['image'] != ''){
										$imageRealPath = '../webroot/img/front_end/users/profile/'.$BusinessUserImage['User']['image'];
									if(is_file($imageRealPath))
										$businessImage = 'front_end/users/profile/'.$BusinessUserImage['User']['image'];
									}
						?>
						<div class="busnisslistsmlimg">
							<?php echo $this->Html->link($this->Image->resize($businessImage, 32, 32, array('alt'=>'')), '/users/profile/'.$BusinessUserImage['User']['username'].'/', array('escape'=>false, 'title'=>$BusinessUserImage['User']['first_name'].' '.$BusinessUserImage['User']['last_name'])).' ';?>
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

<?php }else
	echo 'Complete';
?>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplefetch').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>