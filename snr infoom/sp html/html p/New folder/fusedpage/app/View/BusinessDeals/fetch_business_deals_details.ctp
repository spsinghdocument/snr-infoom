<?php echo $this->Html->script('rating/jRating.jquery');?>
<?php //pr($dealsArr);
if(!empty($dealsArr)){

$highlightsStr = str_replace(array(". ", "\r\n", "\r", "\n"), "<br />", $dealsArr['BusinessDeal']['high_lights']);
if($highlightsStr != '')
	$highlightsArr = explode('<br />', $highlightsStr);
?>


<h7><?php echo $dealsArr['BusinessDeal']['title'];?></h7>
<div style="float:right;">
	<?php  $offerRating = $dealsArr['BusinessDeal']['rating'];
		$usrRate = $this->Fused->validateOfferDealRating($dealsArr['BusinessDeal']['id'], 'deal_id');
		if($offerRating == '0.0'){
			$offerRating = '0';
		}

		$offerClass = 'exemple5';
		if($usrRate != '')
			$offerClass = 'exempleDis';
	?>
	<div id="rating_<?php echo $dealsArr['BusinessDeal']['id'];?>" class="<?php echo $offerClass;?>" data="<?php echo $offerRating;?>_5"></div>
</div>
<div class="clr"></div>


<div class="offertopbox">
	<div class="offerdtlfrinside"  style="float:left; width:470px;">
		<div>
		<?php 
			$dealImage = 'front_end/business/noimage.jpg';
			if($dealsArr['BusinessDeal']['image'] != ''){
				$dealRealImage = '../webroot/img/front_end/business/deals/'.$dealsArr['BusinessDeal']['image'];
				if(is_file($dealRealImage))
					$dealImage = 'front_end/business/deals/'.$dealsArr['BusinessDeal']['image'];
				echo $this->Image->resize($dealImage, 470, 320, array('alt'=>''));
			}
		?>
		</div>

		<div class="buynowboxmainin" style="border-bottom:none;">
			<div class="onlypayflinside" style="width:150px;">Pay: <span style="color:#1562A3;">$<?php echo $dealsArr['BusinessDeal']['price'];?></span></div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>

		<div class="buynowboxmainin" style="border-bottom:none;">
			<?php 
				if($dealsArr['BusinessDeal']['tagline'] != '')
					echo '<strong>'.$dealsArr['BusinessDeal']['tagline'].'</strong><br/>';


				echo $dealsArr['BusinessDeal']['description'];
			?>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>

<div class="offerbtnbox">
	<div class="offertabbox">
		<ul class="offedtlbtmtab">
			<li><a href="javascript://" id="b1" onclick="ShowHomeTabin('pulicone_1','b1')" class="select">Highlights</a></li>
			<li><a href="javascript://" id="b2" onclick="ShowHomeTabin('pulicone_2','b2')">Fine Print</a></li>
		</ul>
		<div class="clr"></div>							
	</div>
	<div class="offerbtmlistbox">
		<div id="pulicone_1">

			<?php if(!empty($highlightsArr)){?>
			<div class="offerbtlmboxfl" style="width:425px;">
				<ul class="offerbtmlist">
				<?php
					foreach($highlightsArr as $highlight){
						if($highlight != ''){
				?>
					<li><?php echo trim($highlight);?></li>
				<?php
					}}
				?>
				</ul>		
			</div>
			<?php }else{
				echo 'No Highlights Available!!';
			}?>
			
			<div class="clr"></div>
		</div>
		<div id="pulicone_2" style="display:none;">
			<div><?php echo nl2br($dealsArr['BusinessDeal']['fine_prints']);?></div>
		</div>
	</div>
	<!-- <div class="legaldesclaimer">Legal Disclaimer</div>
	<div class="legaldiscription">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born</div> -->
</div>





<?php
}else
	echo 'No Deal Data Available!!';
?>

<!-- HIDDEN FIELD START -->
<?php echo $this->Form->hidden('user_rating');?>
<!-- HIDDEN FIELD END -->

<script type="text/javascript">
	$(document).ready(function(){
		$('.exemple5').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big'
		});

		$('.exempleDis').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big',
			isDisabled:true
		});
	});

$(document).ready(function(){
	$('.exemple5').click(function(){
		//alert($(this).attr('id'));
		var ratingDiv = ($(this).attr('id')).split('_');
		var ratingId = ratingDiv[1];
		var rating = $('#user_rating').val();
		if((ratingId != '') && (rating != '')){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'business_deals/set_total_rating/';?>",
				data: "id="+ratingId+"&rating="+rating
			});
		}

	});
});

</script>