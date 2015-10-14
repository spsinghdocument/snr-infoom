<?php $business_know = $this->Fused->business_you_may_know(); 
echo $this->Html->css('rating/jRating.jquery');
?>
<div class="insidefrhdbg" style="padding-bottom:10px;">
	<h4>Businesses you may know</h4>	
</div>

<?php //for($i=1; $i<=6; $i++){?>
<?php if(!empty($business_know)){ 
	$i = '';
	foreach($business_know as $pop_business){
	$businessImage = 'front_end/business/noimage.jpg';
			if($pop_business['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$pop_business['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$pop_business['Business']['image'];
					
			}?>
<div class="bussinessinmain" style="padding-top:0;">
	<div class="bussimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
	</div>
	<div class="busnissfrbox">
		<div class="busnissimgfrinhd" style="padding-bottom:0px;">
			<?php echo $this->Html->link($this->Text->truncate($pop_business['Business']['title'], 20, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="bussinessmltext" style="padding-top:0px;">
			<?php echo $pop_business['Business']['city'].', '.$pop_business['Business']['state_code'];?>
		</div>
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
				<div class="exempleyou" data="<?php echo $pop_business['Business']['rating'];?>_5"></div>
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
	</div>
	<div class="clr"></div>
</div>
<?php } }?>
<div class="smallgap" ></div>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exempleyou').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>