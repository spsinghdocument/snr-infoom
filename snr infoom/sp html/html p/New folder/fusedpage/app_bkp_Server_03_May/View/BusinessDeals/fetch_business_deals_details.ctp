<?php //pr($dealsArr);
if(!empty($dealsArr)){

$highlightsStr = str_replace(array(". ", "\r\n", "\r", "\n"), "<br />", $dealsArr['BusinessDeal']['high_lights']);
if($highlightsStr != '')
	$highlightsArr = explode('<br />', $highlightsStr);
?>


<h7><?php echo $dealsArr['BusinessDeal']['title'];?></h7>
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

