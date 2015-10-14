<?php if(!empty($offerArr)){?>
<span class="insidehd" style="font-size:15px;">Edit Offer</span>
<div class="contactwebsitename">&nbsp;</div>

<?php echo $this->Form->hidden('BusinessOffer.id_edit', array('value'=>$offerArr['BusinessOffer']['id']));?>
<div class="contectflbox" style="width:400px;">
	<div class="contactlable" style="width:85px;">Name:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessOffer.name_edit', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>50, 'value'=>$offerArr['BusinessOffer']['name']));?>
		<div id="offerNameEditError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Title:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessOffer.title_edit', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>60, 'value'=>$offerArr['BusinessOffer']['title']));?>
		<div id="offerTitleEditError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Description:</div>
	<div class="contacttextfied" style="float:left; height:auto;">
		<?php echo $this->Form->textarea('BusinessEnquiry.description_edit', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea addOfferClass', 'rows'=>'', 'cols'=>'', 'value'=>$offerArr['BusinessOffer']['description']));?>
		<div id="offerDescriptionEditError" style="color:#FF0000; font-size:13px;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Price:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessOffer.price_edit', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'value'=>$offerArr['BusinessOffer']['price']));?>
		<div id="offerPriceEditError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<!-- <div class="contactlable" style="width:85px;">Upload Image:</div>
	<div class="contactfield" style="float:left;">
		<?php 
			echo $this->Form->file('BusinessOffer.image2', array('div'=>false, 'label'=>false, 'style'=>'margin-top:12px;'));
			echo $this->Form->hidden('BusinessOffer.image_edit', array('value'=>$offerArr['BusinessOffer']['image']));
		?>
		<div id="OfferImageEditError" style="color:#FF0000;"></div>
	</div>
	<div id="showuploadingEdit" style="float:right; width:100px;"></div>
	<div class="clr"></div>	 -->	

	<div class="contactlable" style="width:85px;">&nbsp;</div>
	<div class="contactfield" style="padding-top:10px; float:left;">
		<div style="float:left; width:130px;">
			<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false, 'onclick'=>'validateEditOfferForm();'));?>
		</div>
		<div id="post_offer_edit" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;">
		</div>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<div id="resultEditOfferDiv" align="center"></div>
<?php }else{?>
<div class="deshlistbox" style="text-align:center; color:#FF0000; margin-top:50px;">
	Invalid Business Offer Chosen!!
</div>
<?php } ?>