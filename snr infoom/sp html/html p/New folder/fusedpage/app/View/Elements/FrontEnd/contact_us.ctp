<script language = "Javascript">
/**
 * DHTML textbox character counter script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */

maxL=500;
var bName = navigator.appName;
function taLimit(taObj) {
	if (taObj.value.length==maxL) return false;
	return true;
}

function taCount(taObj,Cnt) { 
	objCnt=createObject(Cnt);
	objVal=taObj.value;
	if (objVal.length>maxL) objVal=objVal.substring(0,maxL);
	if (objCnt) {
		if(bName == "Netscape"){	
			objCnt.textContent=maxL-objVal.length;}
		else{objCnt.innerText=maxL-objVal.length;}
	}
	return true;
}
function createObject(objId) {
	if (document.getElementById) return document.getElementById(objId);
	else if (document.layers) return eval("document." + objId);
	else if (document.all) return eval("document.all." + objId);
	else return eval("document." + objId);
}
</script>

<?php //pr($businessArr);?>
<div id="pulic_6" class="deshlistbox" style="display:none;">	
	<span class="insidehd"><?php echo $businessArr['Business']['title'];?></span>
	<div class="contactwebsitename">
		<!-- <a href="<?php echo $businessArr['Business']['website'];?>" target="_blank"><?php echo $businessArr['Business']['website'];?></a> -->
	</div>

	<div class="contectflbox" style="width:400px;">
		<div class="passlable" style="padding-left:4px;">Subject:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessEnquiry.subject', array('div'=>false, 'label'=>false, 'class'=>'passinput'));?>
			<div id="subjectError" style="color:#FF0000;"></div>
		</div>
		<div class="clr"></div>

		<div class="passlable" style="padding-left:4px;">Phone:</div>
		<div class="contactfield" style="float:left;">
			<?php echo $this->Form->text('BusinessEnquiry.phone', array('div'=>false, 'label'=>false, 'class'=>'passinput'));?>
		</div>
		<div class="clr"></div>

		<div class="passlable" style="padding-left:4px;">Message:</div>
		<div class="contacttextfied" style="float:left; margin-bottom:2px; width:310px;">
			<?php echo $this->Form->textarea('BusinessEnquiry.message', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea', 'onKeyPress'=>'return taLimit(this)', 'onKeyUp'=>'return taCount(this,"myCounter")', 'onblur'=>'return taCount(this,"myCounter")', 'rows'=>'', 'cols'=>''));?>
			<div id="messageError" style="color:#FF0000; font-size:13px;"></div>
		</div>
		<br><br><br><br>
<SPAN style="margin-left:310px;" id="myCounter">500</SPAN> characters
		<div class="clr"></div>

		<div class="contactlable">&nbsp;</div>
		<div class="contactfield" style="padding-top:10px; float:left;">
			<div style="float:left; width:130px;">
				<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false, 'onclick'=>'validateEnquiryForm();'));?>
			</div>
			<div id="post_enquiry" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;">
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>

<script type="text/javascript">
function validateEnquiryForm(){
	var subject = $('#BusinessEnquirySubject').val();
	var message = $('#BusinessEnquiryMessage').val();
	var phone = $('#BusinessEnquiryPhone').val();

	if(subject == ''){
		$('#subjectError').html('Required');
		$('#BusinessEnquirySubject').focus();
		return false;
	}

	if(message == ''){
		$('#messageError').html('Required');
		$('#BusinessEnquiryMessage').focus();
		return false;
	}

	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_feedbacks/post_enquiry/';?>",
		data: "subject="+subject+"&business_id=<?php echo base64_decode($this->params['pass'][0]);?>&message="+message+"&phone="+phone,
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#post_enquiry').html(bSend);
		},
		success: function(response){
			if(response == '1'){
				$('#BusinessEnquirySubject').val('');
				$('#BusinessEnquiryMessage').val('');
				$('#BusinessEnquiryPhone').val('');
				$('#post_enquiry').html('<font color="green">Enquiry Posted Successfully!!</font>');
			}else
				$('#post_enquiry').html('<font color="red">Please Try Later!!</font>');
		}
	});
}
</script>