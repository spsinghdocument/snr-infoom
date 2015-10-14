<?php $featuredBusinessArr = $this->Fused->featuredBusiness();
echo $this->Html->css('rating/jRating.jquery');
?>
<?php if(!empty($featuredBusinessArr)){ ?>
<div class="insidefrhdbg">
	<h4>Featured Businesses</h4>	
</div>
<?php } ?>
<?php //for($i=1; $i<=6; $i++){?>
<?php if(!empty($featuredBusinessArr)){ 
	$i = '';
	foreach($featuredBusinessArr as $featuredBusiness){
	$businessImage = 'front_end/business/noimage.jpg';
			if($featuredBusiness['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$featuredBusiness['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$featuredBusiness['Business']['image'];
					
			}?>
<div class="bussinessinmain" style="padding-top:0;">
	<div class="bussimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($featuredBusiness['Business']['id']).'/'.$featuredBusiness['Business']['alias_name'].'/', array('escape'=>false));?>
	</div>
	<div class="busnissfrbox">
		<div class="busnissimgfrinhd" style="padding-bottom:0px;">
			<?php echo $this->Html->link($this->Text->truncate($featuredBusiness['Business']['title'], 20, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($featuredBusiness['Business']['id']).'/'.$featuredBusiness['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="bussinessmltext" style="padding-top:0px;">
			<?php echo $featuredBusiness['Business']['city'].', '.$featuredBusiness['Business']['state_code'];?>
		</div>
		<div class="clr"></div>
		<div>
			<?php
				/* for($i=1; $i<=5; $i++){
					if($i <= $featuredBusiness['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
				} */
			?>

			<div class="exemple">
				<div class="exemplefeabusi" data="<?php echo $featuredBusiness['Business']['rating'];?>_5"></div>
			</div>
		</div>
		<!-- TAGLINE / DESCRIPTION START -->
		<?php 
			$textt = $featuredBusiness['Business']['about_us'];
			if($featuredBusiness['Business']['tagline'] != '')
				$textt = $featuredBusiness['Business']['tagline'];
			echo $this->Text->truncate($textt, 40, array('ending'=>'...', 'exact'=>true, 'html'=>true));
		?>
		<!-- TAGLINE / DESCRIPTION END -->
	</div>
	<div class="clr"></div>
</div>
<?php } }?>
<div class="smallgap" ></div>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplefeabusi').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>