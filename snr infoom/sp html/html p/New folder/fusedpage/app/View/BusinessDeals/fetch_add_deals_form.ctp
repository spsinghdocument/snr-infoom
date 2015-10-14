<!-- CALL CALENDER FILES START -->
<?php
	echo $this->Html->Script('calender/jscal2.js');
	echo $this->Html->Script('calender/lang/en.js');
	echo $this->Html->Css('calender/jscal2.css');
	echo $this->Html->Css('calender/border-radius.css');
	echo $this->Html->Css('calender/steel/steel.css');
?>
<!-- CALL CALENDER FILES END -->

<span class="insidehd" style="font-size:15px;">Add New Deal</span>
<div class="contactwebsitename">&nbsp;</div>

<div class="contectflbox" style="width:400px;">
	<div class="contactlable" style="width:85px;">Title:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessDeal.title', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>200));?>
		<div id="DealTitleError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Price:</div>
	<div class="contactfield" style="float:left;">
		<?php echo '$ '.$this->Form->text('BusinessDeal.price', array('div'=>false, 'label'=>false, 'class'=>'contactinput_1 addOfferClass'));?>
		<div id="DealPriceError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Tagline(opt):</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessDeal.tagline', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>255));?>
		<div id="DealTaglineError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Description:</div>
	<div class="contacttextfied" style="float:left; height:auto;">
		<?php echo $this->Form->textarea('BusinessDeal.description', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea addOfferClass', 'rows'=>'', 'cols'=>''));?>
		<div id="dealDescriptionError" style="color:#FF0000; font-size:13px;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Upload Image:</div>
	<div class="contactfield" style="float:left;">
		<?php 
			echo $this->Form->file('BusinessDeal.image1', array('div'=>false, 'label'=>false, 'style'=>'margin-top:12px;'));
			echo $this->Form->hidden('BusinessDeal.image', array('value'=>''));
		?>
		<div id="DealImageError" style="color:#FF0000;"></div>
	</div>
	<div id="showDealUploading" style="float:right; width:100px;"></div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Fine Prints:</div>
	<div class="contacttextfied" style="float:left; height:auto;">
		<?php echo $this->Form->textarea('BusinessDeal.fine_prints', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea addOfferClass', 'rows'=>'', 'cols'=>''));?>
		<div id="dealFinePrintsError" style="color:#FF0000; font-size:13px;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Highlights:</div>
	<div class="contacttextfied" style="float:left; height:auto;">
		<?php echo $this->Form->textarea('BusinessDeal.high_lights', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea addOfferClass', 'rows'=>'', 'cols'=>''));?>
		<div id="dealHighlightsError" style="color:#FF0000; font-size:13px;"></div>
	</div>
	<div class="clr"></div>

	<div class="contactlable" style="width:85px;">Start Date(opt):</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessDeal.start_date', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>255, 'readonly'=>'readonly'));?>
		<div id="DealStartDateError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>

	<script type="text/javascript">
		var cal = Calendar.setup({
			onSelect: function(cal) { cal.hide() }
		});
		cal.manageFields("BusinessDealStartDate", "BusinessDealStartDate", "%Y-%m-%d");
	</script>

	<div class="contactlable" style="width:85px;">End Date:</div>
	<div class="contactfield" style="float:left;">
		<?php echo $this->Form->text('BusinessDeal.end_date', array('div'=>false, 'label'=>false, 'class'=>'contactinput addOfferClass', 'maxlength'=>255, 'readonly'=>'readonly'));?>
		<div id="DealEndDateError" style="color:#FF0000;"></div>
	</div>
	<div class="clr"></div>
	<script type="text/javascript">
		var cal = Calendar.setup({
			onSelect: function(cal) { cal.hide() }
		});
		cal.manageFields("BusinessDealEndDate", "BusinessDealEndDate", "%Y-%m-%d");
	</script>

	<div class="contactlable" style="width:85px;">&nbsp;</div>
	<div class="contactfield" style="padding-top:10px; float:left;">
		<div style="float:left; width:130px;">
			<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false, 'onclick'=>'validateAddDealsForm();'));?>
		</div>
		<div id="post_enquiry" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;">
		</div>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<div id="resultAddDealDiv" align="center"></div>

<script type="text/javascript">
$(document).ready(function(){ //alert('test');
	var BusinessDealImage1 = $('#BusinessDealImage1'), interval;
	new AjaxUpload(BusinessDealImage1, {
		action: "<?php echo SITE_PATH.'business_deals/upload_image/';?>",
		name: "image",
		onSubmit : function(file, ext){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#showDealUploading').html(bSend);
		},
		onComplete: function(file, response){
			$('#BusinessDealImage').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>/img/front_end/business/deals/'+response+'" style="height:50px; width:50px;"/>';
				$('#showDealUploading').html(aSend);
			}
		}
	});
});
</script>