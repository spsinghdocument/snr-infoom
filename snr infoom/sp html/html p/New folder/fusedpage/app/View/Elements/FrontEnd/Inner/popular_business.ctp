<?php $popular_business = $this->Fused->fetchPopularBusiness();
echo $this->Html->css('rating/jRating.jquery');
?>
<div class="insidefrhdbg">
	<div class="fl"><h4>Popular Business</h4></div>
	<!-- <div class="morelink"><a href="javascript:void(0);">More</a></div> -->
	<div class="clr"></div>
</div>

<?php //for($i=1; $i<=3; $i++){?>
<?php if(!empty($popular_business)){
	$i = '';
	foreach($popular_business as $pop_business){
	$businessImage = 'front_end/business/noimage.jpg';
			if($pop_business['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$pop_business['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$pop_business['Business']['image'];
					
			}
	?>
<div class="bussinessinmain" <?php if($i==1){?>style="padding-top:0;"<?php } ?>>
	<div class="bussimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
	</div>

	<div class="busnissfrbox">
		<div class="busnissimgfrinhd">
			<?php echo $this->Html->link($this->Text->truncate($pop_business['Business']['title'], 20, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div style="font-size:11px;"><?php echo $pop_business['Business']['city'],', '.$pop_business['Business']['state_code'];?></div>
		<div class="clr"></div>

		<div>
			<?php
				/* for($i=1; $i<=5; $i++){
					if($i <= $pop_business['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
				} */
			?>

			<div class="exemple">
				<div class="exemplepopular" data="<?php echo $pop_business['Business']['rating'];?>_5"></div>
			</div>
		</div>		
	</div>
	<!-- TAGLINE / DESCRIPTION START -->
	<?php 
		$textt = $pop_business['Business']['about_us'];
		if($pop_business['Business']['tagline'] != '')
			$textt = $pop_business['Business']['tagline'];
		echo $this->Text->truncate($textt, 40, array('ending'=>'...', 'exact'=>true, 'html'=>true));
	?>
	<!-- TAGLINE / DESCRIPTION END -->
	<div class="clr"></div>
</div>
<?php } }?>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplepopular').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>