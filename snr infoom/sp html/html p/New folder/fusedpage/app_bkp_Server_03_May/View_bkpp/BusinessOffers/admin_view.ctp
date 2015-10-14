<?php //pr($offerArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Offer Details</h3>
	<fieldset>
		
		<?php if($offerArr['BusinessOffer']['image'] != ''){
			$realImagePath = '../webroot/img/front_end/business/offers/'.$offerArr['BusinessOffer']['image'];
			if(is_file($realImagePath)){
		?>
		<div class="fielddiv">
			<div class="fielddiv1">
				<?php echo $this->Image->resize('front_end/business/offers/'.$offerArr['BusinessOffer']['image'], 100, 100, array('alt'=>'', 'style'=>'border:2px solid #CCCCCC;'));?>
			</div>
		</div>
		<div class="clear"></div>
		<?php }} ?>

		<div class="fielddiv">
			<div class="fielddiv1">Business:</div>
			<div class="fielddiv2"><?php echo $offerArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Category:</div>
			<div class="fielddiv2"><?php echo $this->Fused->fetchCorrespondingOfferCategory($offerArr['BusinessOffer']['name']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Title:</div>
			<div class="fielddiv2"><?php echo $offerArr['BusinessOffer']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Description:</div>
			<div class="fielddiv2"><?php echo nl2br($offerArr['BusinessOffer']['description']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Price:</div>
			<div class="fielddiv2"><?php echo '$'.$offerArr['BusinessOffer']['price'];?></div>
		</div>
		<div class="clear"></div>
		
		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($offerArr['BusinessOffer']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($offerArr['BusinessOffer']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Added On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($offerArr['BusinessOffer']['created']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>