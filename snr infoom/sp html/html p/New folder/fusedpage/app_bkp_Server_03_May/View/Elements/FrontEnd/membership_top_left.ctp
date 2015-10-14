<div class="pricetopfl">
	<div class="priceinhd">Be found more easily...</div>
	<div class="pricebtmtext">Great search visibility</div>
	<div class="pricebox">
		<ul class="pricelist">
			<li>Understand and target users who</li>
			<li>are interested in your business</li>
			<li>More more more to come...</li>
			<li>More more more to come...</li>
		</ul>
	</div>

	<div id="business_plans">
		<div id="fetchPlansDiv">
			<!-- LIST DETAIL OF PLAN PREMIUM START -->
			<?php 
			echo $this->Form->hidden('Membership.id', array('value'=>'3'));
			if($membershipArr[2]['Membership']['pricing_year'] != ''){?>
				<div class="yearlybox">
					<input name="plan_type" type="radio" value="year" checked="checked" style="margin:0 6px 3px 0;" />Yearly $<?php echo number_format($membershipArr[2]['Membership']['pricing_year'], 2);?>

					<?php if($membershipArr[2]['Membership']['pricing_tagline'] != ''){?>
						<span>(<?php echo $membershipArr[2]['Membership']['pricing_tagline'];?>)</span>
					<?php } ?>
				</div>
			<?php } ?>

			<?php if($membershipArr[2]['Membership']['pricing_month'] != ''){?>
				<div class="yearlybox">
					<input name="plan_type" type="radio" value="month" style="margin:0 6px 3px 0;" />Monthly $<?php echo number_format($membershipArr[2]['Membership']['pricing_month'], 2);?>
					<span>(Yearly  $<?php echo number_format((($membershipArr[2]['Membership']['pricing_month'])*12),2);?>)</span>
				</div>
			<?php } ?>
		</div>
		<div class="enrollmebox">
			<input name="enroll" id="enroll" type="checkbox" checked="checked" style="margin:0 6px 3px 0;" />Enroll me in the Referral Program
		</div>

		<!-- CARD DETAILS SECTION START -->
		<div style="display:none;" id="card_payment">
			<div style="padding:12px 0 20px 0;"><h4>Secure Credit Card Payment</h4></div>
			<div class="passlable" style="width:110px;">Card Type:</div>
			<div class="stepfieldfr fl">
				<?php echo $this->Form->select('Payment.card_type', array('VISA'=>'VISA', 'Master Card'=>'Master Card', 'American Express'=>'American Express'), array('div'=>false, 'label'=>false, 'class'=>'passinput', 'empty'=>'Select', 'style'=>'width:254px; padding:6px 5px 6px 5px;'));?>
				<span style="color:#FF0000;" id="card_type_error"></span>
			</div>
			<div class="clr"></div>

			<div class="passlable" style="width:110px;">Card Number:</div>
			<div class="stepfieldfr fl">
				<?php echo $this->Form->text('Payment.card_number', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'maxlength'=>16));?>
				<span style="color:#FF0000;" id="card_number_error"></span>
			</div>
			<div class="clr"></div>

			<div class="passlable" style="width:110px;">Expiry Month:</div>
			<div class="stepfieldfr fl">
				<?php echo $this->Form->select('Payment.exp_month', array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December'), array('div'=>false, 'label'=>false, 'class'=>'passinput', 'empty'=>'Select', 'style'=>'width:254px; padding:6px 5px 6px 5px;'));?>
				<span style="color:#FF0000;" id="exp_month_error"></span>
			</div>
			<div class="clr"></div>

			<div class="passlable" style="width:110px;">Expiry Year:</div>
			<div class="stepfieldfr fl">
				<?php 
					$expYearArr = '';
					$presentYear = (int)date('Y');
					for($i=0; $i<=4; $i++){
						$year = ($presentYear + $i);
						$expYearArr[$year] = $year;
					}
					echo $this->Form->select('Payment.exp_year', $expYearArr, array('div'=>false, 'label'=>false, 'class'=>'passinput', 'empty'=>'Select', 'style'=>'width:254px; padding:6px 5px 6px 5px;'));
				?>
				<span style="color:#FF0000;" id="exp_year_error"></span>
			</div>
			<div class="clr"></div>

			<div class="passlable" style="width:110px;">Secure Code:</div>
			<div class="stepfieldfr fl">
				<?php echo $this->Form->text('Payment.secure_code', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'maxlength'=>3));?>
				<span style="color:#FF0000;" id="secure_code_error"></span>
			</div>
			<div class="clr"></div>

			<div class="passlable">&nbsp</div>
			<div class="stepfieldfr fl" id="payment_result">
				<div class="btnimage" style="margin-left:25px;">
					<a href="javascript:void(0);" onclick="return validatePayment();"><span>Make Payment</span></a>
				</div>
			</div>
			<div class="clr"></div>

		</div>
		<div class="clr"></div>
		<!-- CARD DETAILS SECTION END -->

		<div class="btnimage" id="upgrade">
			<a href="javascript:void(0);" onclick="return showPaymentDiv();"><span>Upgrade</span></a>
		</div>
		<?php echo $this->Form->hidden('Business.alias_name', array('value'=>$this->Fused->fetchAliasName(base64_decode($this->params['pass'][0]))));?>
	</div>

	<!-- FOR FREE SECTION START -->
	<div id="free_plan" style="display:none;"><strong>Free</strong></div>
	<!-- FOR FREE SECTION END -->

	<!-- PREMIUM PLUS PLAN START -->
	<div id="premium_plus_plan" style="display:none;">
		<div class="contectflbox">
			<div class="contactlable"><strong>Message:</strong></div>
			<div class="contacttextfied" style="float:left;">
				<?php echo $this->Form->textarea('Business.message', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea', 'rows'=>'', 'cols'=>'', 'style'=>'resize:none;'));?>
				<div id="messageError" style="color:#FF0000; font-size:13px;"></div>
			</div>
			<div class="clr"></div>

			<div class="contactlable">&nbsp;</div>
			<div class="contactfield" style="padding-top:10px;">
				<div style="float:left; width:130px;">
				<div class="btnimage" id="contactButton">
					<a href="javascript:void(0);" onclick="return validateContactForm();"><span>Submit</span></a>
				</div>
				</div>
				<div id="post_enquiry" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;"></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	<!-- PREMIUM PLUS PLAN END -->
</div>

<script type="text/javascript">
function showPaymentDiv(){
	$('#upgrade').hide();
	$('#card_payment').show();
}

function navigate_user(){
	var alias_name = $('#BusinessAliasName').val();
	var navigationUrl = "<?php echo SITE_PATH.'businesses/details/'.$this->params['pass'][0].'/';?>"+alias_name+"/";
	setTimeout(function(){window.location.href = navigationUrl},3000);
}

function validatePayment(){
	var plan_id = $('#MembershipId').val();
	var plan_type = $('[name=plan_type]:CHECKED').val();
	var enroll = $('#enroll').is(":checked");
	var business_id = "<?php echo base64_decode($this->params['pass'][0]);?>";
	
	//fetch the card details start
	var card_type = $('#PaymentCardType').val();
	if(card_type == ''){
		$('#card_type_error').html('Required');
		$('#PaymentCardType').focus();
		return false;
	}else
		$('#card_type_error').html('');

	var card_number = $('#PaymentCardNumber').val();
	if(card_number == ''){
		$('#card_number_error').html('Required');
		$('#PaymentCardNumber').focus();
		return false;
	}else{
		if(isNaN(card_number)){
			$('#card_number_error').html('Invalid Card Number');
			$('#PaymentCardNumber').focus();
			return false;
		}else
			$('#card_number_error').html('');
	}

	var exp_month = $('#PaymentExpMonth').val();
	if(exp_month == ''){
		$('#exp_month_error').html('Required');
		$('#PaymentExpMonth').focus();
		return false;
	}else
		$('#exp_month_error').html('');

	var exp_year = $('#PaymentExpYear').val();
	if(exp_year == ''){
		$('#exp_year_error').html('Required');
		$('#PaymentExpYear').focus();
		return false;
	}else
		$('#exp_year_error').html('');

	var secure_code = $('#PaymentSecureCode').val();
	if(secure_code == ''){
		$('#secure_code_error').html('Required');
		$('#PaymentSecureCode').focus();
		return false;
	}else{
		if(isNaN(secure_code)){
			$('#secure_code_error').html('Invalid Secure Code');
			$('#PaymentSecureCode').focus();
			return false;
		}else
			$('#secure_code_error').html('');
	}

	//send AJAX for payment start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'payments/purchase_membership/';?>",
		data: "plan_id="+plan_id+"&plan_type="+plan_type+"&enroll="+enroll+"&card_type="+card_type+"&card_number="+card_number+"&exp_month="+exp_month+"&exp_year="+exp_year+"&secure_code="+secure_code+"&business_id="+business_id,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?> Your Payment In Process, Please Do Not Refresh!!</div>';
			$('#payment_result').html(bSend);
		},
		success: function(response){
			if(response == '<font color="green">Your payment was successful!! The payment details have been sent to your email address.</font>'){
				$('#card_payment').html(response);
				navigate_user();
			}else{
				$('#payment_result').html(response);
			}
		}
	});
}

function validateContactForm(){
	var message = $('#BusinessMessage').val();
	if(message == ''){
		$('#messageError').html('Required');
		$('#BusinessMessage').focus();
		return false;
	}else{
		$('#messageError').html('');
	}

	//send AJAX for payment start
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'premium_requests/premium_plus_message/';?>",
		data: "message="+message+"&business_id=<?php echo base64_decode($this->params['pass'][0]);?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#contactButton').html(bSend);
		},
		success: function(response){
			if(response == '<font color="green">Request Sent Successfully!!</font>'){
				var spanTi = '<span style="color:green;">Request Sent to Administrator Successfully!!</span>';
				$('#premium_plus_plan').html(spanTi);
			}else{
				$('#contactButton').html(response);
			}
		}
	});
}
</script>