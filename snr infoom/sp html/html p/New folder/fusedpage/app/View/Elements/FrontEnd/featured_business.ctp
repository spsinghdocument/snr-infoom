<?php $featuredBusinessArr = $this->Fused->featuredBusiness();
echo $this->Html->css('rating/jRating.jquery');
?>
<div class="midfrinbox">
<?php if(!empty($featuredBusinessArr)){ ?>
	<h1>Featured Business</h1>
	<?php
		foreach($featuredBusinessArr as $listing){ //pr($listing);die;
			$businessImage = 'front_end/business/noimage.jpg';
			if($listing['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$listing['Business']['image'];
			}
	?>
	<!-- <div class="midfrimgbox">
		<div class="featurebussbox">
			<?php echo $this->Html->link($this->Image->resize($businessImage, 216, 124, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="featureimgname"><?php echo $this->Text->truncate($listing['Business']['about_us'], 30, array('ending'=>'...', 'exact'=>true, 'html'=>true));?></div>
	</div> -->

	<div class="busnissinmianbox">
		<div class="busnissimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="busnissimgfr" style="width:130px;">
			<div class="busnissimgfrhd">
			<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false)).", ";?>
			</div>
			<?php echo $listing['Business']['city'],', '.$listing['Business']['state_code'];?>
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
					<div class="exemplefeatured" data="<?php echo $listing['Business']['rating'];?>_5"></div>
				</div>
			</div>
			<div class="busnisslisttext"><?php 
				$textt = $listing['Business']['about_us'];
				if($listing['Business']['tagline'] != '')
					$textt = $listing['Business']['tagline'];
				echo $this->Text->truncate($textt, 30, array('ending'=>'...', 'exact'=>true, 'html'=>true));
			?></div>
		</div>
		<div class="clr"></div>
	</div>

	<?php } } ?>
</div>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplefeatured').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>