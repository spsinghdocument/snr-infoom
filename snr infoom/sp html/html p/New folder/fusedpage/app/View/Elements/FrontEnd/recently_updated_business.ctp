<?php $recentUpdateBusinessArr = $this->Fused->recentlyUpdateBusiness(); 
echo $this->Html->css('rating/jRating.jquery');
?>
<div class="midflibox">
	<h1>Recently Updated Business</h1>
	<?php if(!empty($recentUpdateBusinessArr)){ 
		foreach($recentUpdateBusinessArr as $listing){ //pr($listing);die;
			$businessImage = 'front_end/business/noimage.jpg';
			if($listing['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$listing['Business']['image'];
			}
	?>
	<div class="busnissinmianbox">
		<div class="busnissimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="busnissimgfr">
			<div class="busnissimgfrhd">
			<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false)).", ";?>
			</div>
			<?php echo $listing['Business']['city'],', '.$listing['Business']['state_code'];?>
			<div>
				<?php
					/*for($i=1; $i<=5; $i++){
						if($i <= $listing['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
					} */
				?>

				<div class="exemple">
					<div class="exemplerecent" data="<?php echo $listing['Business']['rating'];?>_5"></div>
				</div>
			</div>
			<div class="busnisslisttext"><?php 
				$textt = $listing['Business']['about_us'];
				if($listing['Business']['tagline'] != '')
					$textt = $listing['Business']['tagline'];
				echo $this->Text->truncate($textt, 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));
			?></div>
			<!-- <div id="business_id_<?php echo $listing['Business']['id']; ?>">
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
				<div class="busnisslistsmlimg"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?></div>
				<?php } ?>
			</div> -->
		</div>
		<div class="clr"></div>
	</div>
	<?php } } ?>
</div>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplerecent').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>