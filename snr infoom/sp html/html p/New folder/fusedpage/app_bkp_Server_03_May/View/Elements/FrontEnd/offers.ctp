<div id="pulic_3" style="display:none;">
	<h5>Offers
		
	<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){?>
		<div class="editinlink" id="OffersTabNavigate">
			<a href="javascript:void(0);" onclick="return validateOffersTabs('category');">Add "What Offered" Category</a>
			<a href="javascript:void(0);" onclick="return validateOffersTabs('add');">Add an Offer</a>
		</div>
		<div class="clr"></div>
	<?php } ?>
	</h5>

	<?php echo $this->Form->hidden('offer_listing_value', array('value'=>'0'));?>

<!-- SECTION FOR ADDING A NEW CATEGORY START -->
<div id="offer_add_category" style="display:none;">
	<span class="insidehd" style="font-size:15px;">Add "What Offered" Category</span>
	<div class="contactwebsitename">&nbsp;</div>

	<div class="contectflbox" style="width:400px;">
		<div class="contactlable" style="width:85px;">Name:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessOffer.name', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>200));?>
			<div id="offerNameError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">Name:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessOffer.name', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>50));?>
			<div id="offerNameError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">&nbsp;</div>
		<div class="contactfield" style="padding-top:10px; float:left;">
			<div style="float:left; width:130px;">
				<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false, 'onclick'=>'validateAddOfferForm();'));?>
			</div>
			<div id="post_enquiry" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;">
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	<div id="resultAddOfferDiv" align="center"></div>
</div>
<!-- SECTION FOR ADDING A NEW CATEGORY END -->

<!-- CONTENT ADDING SECTION START -->
<div id="offer_add_container" style="display:none;">
	<span class="insidehd" style="font-size:15px;">Add New Offer</span>
	<div class="contactwebsitename">&nbsp;</div>

	<div class="contectflbox" style="width:400px;">
		<div class="contactlable" style="width:85px;">Name:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessOffer.name', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>50));?>
			<div id="offerNameError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">Title:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessOffer.title', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>60));?>
			<div id="offerTitleError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">Description:</div>
		<div class="contacttextfied" style="float:left; height:auto;">
			<?php echo $this->Form->textarea('BusinessEnquiry.description', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea addOfferClass', 'rows'=>'', 'cols'=>''));?>
			<div id="offerDescriptionError" style="color:#FF0000; font-size:13px;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">Price:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessOffer.price', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass'));?>
			<div id="offerPriceError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="contactlable" style="width:85px;">Upload Image:</div>
		<div class="contactfield" style="float:left;">
			<?php 
				echo $this->Form->file('BusinessOffer.image1', array('div'=>false, 'label'=>false, 'style'=>'margin-top:12px;'));
				echo $this->Form->hidden('BusinessOffer.image', array('value'=>''));
			?>
			<div id="OfferImageError" style="color:#FF0000;"></div>
		</div>
		<div id="showuploading" style="float:right; width:100px;"></div>
		<div class="clr"></div>		

		<div class="contactlable" style="width:85px;">&nbsp;</div>
		<div class="contactfield" style="padding-top:10px; float:left;">
			<div style="float:left; width:130px;">
				<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false, 'onclick'=>'validateAddOfferForm();'));?>
			</div>
			<div id="post_enquiry" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;">
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	<div id="resultAddOfferDiv" align="center"></div>
</div>
<!-- CONTENT ADDING SECTION END -->

<!-- CONTENT EDITINGING SECTION START -->
<div id="offer_edit_container" style="display:none;">
	<div style="text-align:center; color:#0171C3; margin-top:50px;">
		<?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong>
	</div>
</div>
<!-- CONTENT EDITINGING SECTION END -->


<!-- CONTENT LISTING SECTION START -->
<div id="main_offers_listing_container">
	<div style="text-align:center; color:#0171C3; margin-top:50px;">
		<?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong>
	</div>
</div>	
<!-- CONTENT LISTING SECTION END -->
</div>

<script type="text/javascript">
function validateOffersTabs(type){
	if(type == 'category'){
		$('#resultAddOfferDiv').html(''); //reset main ajax div
		$('#showuploading').html(''); // reset image uploading div
		$('#main_offers_listing_container').hide();
		$('#offer_add_category').show();
		$('#OffersTabNavigate').html('<a href="javascript:void(0);" onclick="return validateOffersTabs(\'category\');">Add "What Offered" Category</a><a href="javascript:void(0);" onclick="return validateOffersTabs(\'list\');">List Offer</a>');
	}else if(type == 'add'){
		$('#resultAddOfferDiv').html(''); //reset main ajax div
		$('#showuploading').html(''); // reset image uploading div
		$('#main_offers_listing_container').hide();
		$('#offer_add_container').show();
		$('#OffersTabNavigate').html('<a href="javascript:void(0);" onclick="return validateOffersTabs(\'list\');">List Offer</a>');
	}else if(type == 'list'){
		$('#offer_add_container').hide();
		$('#offer_edit_container').hide();
		$('#main_offers_listing_container').show();
		$('#offer_add_category').hide();
		$('#OffersTabNavigate').html('<a href="javascript:void(0);" onclick="return validateOffersTabs(\'add\');">Add New Offer</a>');
	}else{
		$('#main_offers_listing_container').hide();
		$('#offer_edit_container').show();
		$('#OffersTabNavigate').html('<a href="javascript:void(0);" onclick="return validateOffersTabs(\'list\');">List Offer</a>');

		//fetch the content for editing
		fetchTheOffersEditableContent(type, 'load', '');
	}
	
}
function loadOffersDataForListing(){
	//load all the offers listing in the corresponding Div
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_offers/fetch_business_offers/';?>",
		data: "business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
		success: function(response){
			$('#main_offers_listing_container').html(response);
		}
	});
}
function load_offers_listing(){
	if($('#offer_listing_value').val() == '0'){
		loadOffersDataForListing();
		$('#offer_listing_value').val('1');
	}
}

function fetchFurtherDataForOfferListing(){
	//fetch the pagination data for offers listing
	var lastViewedOfferListingPageId = parseInt($('#lastViewedOfferListingPageId').val());
	/*if(lastViewedOfferListingPageId != 0)
		$('#lastViewedOfferListingPageId').val((lastViewedOfferListingPageId + 1)); */
	if(lastViewedOfferListingPageId != '0'){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_offers/fetch_business_offers_listing_data/';?>",
			data: "last_viewed_page="+lastViewedOfferListingPageId+"&business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
			beforeSend:function(){
				$('#load_offers_listing_more').show();
			},
			success: function(response){
				if(response != 'Complete'){
					$('#lastViewedOfferListingPageId').val((lastViewedOfferListingPageId + 1));
					$('#offersListingDivToAppend').append(response);
					$('#load_offers_listing_more_span').hide();
				}else{
					$('#lastViewedOfferListingPageId').val('0');
					$('#load_offers_listing_more_span').html('<font color="red">No More Content To List</font>');
				}
			}
		});
	}else
		return false;
}

$(window).scroll(function(){
	if($(window).scrollTop() >= ($(document).height() - $(window).height()))
		fetchFurtherDataForOfferListing();
});
</script>

<?php if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){?>
<script type="text/javascript">
function validateOfferImageExtention(ext){
	var ret = '';
	if((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

$(document).ready(function(){
	var button = $('#BusinessOfferImage1'), interval;
	new AjaxUpload(button, {
		action: "<?php echo SITE_PATH.'business_offers/upload_image/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var ret = validateOfferImageExtention(ext);
			if(ret == '0'){
				$('#OfferImageError').html('<font color="red">*.jpg, *.gif, *.png image only!!</font>');
				return false;
			}else
				$('#OfferImageError').html('');
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#showuploading').html(bSend);
		},
		onComplete: function(file, response){
			$('#BusinessOfferImage').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/offers/'+response+'" style="height:50px; width:50px;"/>';
				$('#showuploading').html(aSend);
			}
		}
	});
});



function fetchTheOffersEditableContent(id, type, variables){
	if(variables == '')
		var dataToSend = "id="+id+"&type=load";
	else
		var dataToSend = variables;
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_offers/edit_business_offer/';?>",
		data: dataToSend,
		success: function(response){
			if(response == 'saved'){
				$('.addOfferClass').val('');
				$('#resultEditOfferDiv').html('<font color="green">Offer Updated Successfully!!</font>');
				setTimeout(function(){
				      validateOffersTabs('list');
				}, 1000);
				
				//load the listing again
				$('#main_offers_listing_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				loadOffersDataForListing();
			}else{
				$('#offer_edit_container').html(response);
			}
		}
	});
	
}

function validateAddOfferForm(){	
	var BusinessOfferImage = $('#BusinessOfferImage').val();

	var BusinessOfferName = $('#BusinessOfferName').val();
	if(BusinessOfferName == ''){
		$('#offerNameError').html('Required');
		$('#BusinessOfferName').focus();
		return false;
	}else
		$('#offerNameError').html('');

	var BusinessOfferTitle = $('#BusinessOfferTitle').val();
	if(BusinessOfferTitle == ''){
		$('#offerTitleError').html('Required');
		$('#BusinessOfferTitle').focus();
		return false;
	}else
		$('#offerTitleError').html('');

	var BusinessEnquiryDescription = $('#BusinessEnquiryDescription').val();
	if(BusinessEnquiryDescription == ''){
		$('#offerDescriptionError').html('Required');
		$('#BusinessEnquiryDescription').focus();
		return false;
	}else
		$('#offerDescriptionError').html('');

	var BusinessOfferPrice = $('#BusinessOfferPrice').val();
	if(BusinessOfferPrice == ''){
		$('#offerPriceError').html('Required');
		$('#BusinessOfferPrice').focus();
		return false;
	}else{
		var reg = /^[\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/;
		if(reg.test(BusinessOfferPrice) == false){
			$('#offerPriceError').html('Invalid Price');
			return false;
		}else
			$('#offerPriceError').html('');
	}

	//send Ajax for saving the offer
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_offers/add_new_offer/';?>",
		data: "BusinessOfferName="+BusinessOfferName+"&BusinessOfferTitle="+BusinessOfferTitle+"&BusinessEnquiryDescription="+BusinessEnquiryDescription+"&BusinessOfferPrice="+BusinessOfferPrice+"&BusinessOfferImage="+BusinessOfferImage+"&BusinessOfferImage="+BusinessOfferImage+"&business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#resultAddOfferDiv').html(bSend);
		},
		success: function(response){
			if(response == '1'){
				$('.addOfferClass').val('');
				$('#resultAddOfferDiv').html('<font color="green">Offer Added Successfully!!</font>');
				setTimeout(function(){
				      validateOffersTabs('list');
				}, 2000);
				
				//load the listing again
				$('#main_offers_listing_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
				loadOffersDataForListing();
			}else
				$('#resultAddOfferDiv').html(response);
		}
	});
}

function validateEditOfferForm(){
	//var BusinessOfferImage = $('#BusinessOfferImage').val();

	var BusinessOfferIdEdit = $('#BusinessOfferIdEdit').val();

	var BusinessOfferNameEdit = $('#BusinessOfferNameEdit').val();
	if(BusinessOfferNameEdit == ''){
		$('#offerNameEditError').html('Required');
		$('#BusinessOfferNameEdit').focus();
		return false;
	}else
		$('#offerNameEditError').html('');

	var BusinessOfferTitleEdit = $('#BusinessOfferTitleEdit').val();
	if(BusinessOfferTitleEdit == ''){
		$('offerTitleEditError').html('Required');
		$('#BusinessOfferTitleEdit').focus();
		return false;
	}else
		$('offerTitleEditError').html('');

	var BusinessEnquiryDescriptionEdit = $('#BusinessEnquiryDescriptionEdit').val();
	if(BusinessEnquiryDescriptionEdit == ''){
		$('#offerDescriptionEditError').html('Required');
		$('#BusinessEnquiryDescriptionEdit').focus();
		return false;
	}else
		$('#offerDescriptionEditError').html('');

	var BusinessOfferPriceEdit = $('#BusinessOfferPriceEdit').val();
	if(BusinessOfferPriceEdit == ''){
		$('#offerPriceEditError').html('Required');
		$('#BusinessOfferPriceEdit').focus();
		return false;
	}else{
		var reg = /^[\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/;
		if(reg.test(BusinessOfferPriceEdit) == false){
			$('#offerPriceEditError').html('Invalid Price');
			return false;
		}else
			$('#offerPriceEditError').html('');
	}

	var dataToSend = "type=save&id="+BusinessOfferIdEdit+"&name="+BusinessOfferNameEdit+"&title="+BusinessOfferTitleEdit+"&description="+BusinessEnquiryDescriptionEdit+"&price="+BusinessOfferPriceEdit;

	//save the data
	fetchTheOffersEditableContent(BusinessOfferIdEdit, 'save', dataToSend)
}

//delete the offer
function deleteBusinesOffer(id){
	var conf = confirm('Do you really want to delete this Offer?');
	if(conf == true){
		//delete the offer
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'business_offers/delete_offer/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Deleting... Please Wait...</strong></div>';
				$('#main_offers_listing_container').html(bSend);
			},
			success: function(response){
				if(response == 'deleted'){
					//load the listing again
					$('#main_offers_listing_container').html('<div style="text-align:center; color:#0171C3; margin-top:50px;"><?php echo $this->Html->image("ajax/google_loader.gif", array("alt"=>""));?> <strong>Loading... Please Wait...</strong></div>');
					loadOffersDataForListing();
				}else
					$('#main_offers_listing_container').html('<font>Please Try Later!!</font>');
			}
		});

	}else
		return false;
}
</script>
<?php } ?>