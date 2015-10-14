<div id="pulic_2" class="businessintab" style="display:none;">			
<h5>About us 
	
	<?php /*if($this->Fused->validateUserForBusiness() == base64_decode($this->params['pass'][0])){*/
		if($this->Fused->validateUserForBusiness($this->Fused->decrypt($this->params['pass'][0])) == 'true'){
	?>
		<div class="editinlink"><a href="javascript:void(0);" onclick="return validateAboutsUsTabs();">Edit</a></div>
		<div class="clr"></div>
	<?php } ?>
</h5>

<!-- ORIGINAL CONTENT START -->
<div id="original_aboutUs_content">
	<?php 
		if($businessArr['Business']['image'] != ''){
			$imageFile = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
			if(is_file($imageFile)){
				echo $this->Image->resize('front_end/business/'.$businessArr['Business']['image'], 200, 200, array('alt'=>'', 'style'=>'margin:5px 0 10px 10px;', 'align'=>'right'));
			}
		}
	?>


<div style="font-weight:bold; padding-bottom:5px;"><?php echo $businessArr['Business']['tagline'];?></div>
<?php echo nl2br($businessArr['Business']['about_us']);?></div>
<!-- ORIGINAL CONTENT END -->

<!-- UPDATE CONTENT START -->
<div id="update_aboutUs_content" style="display:none;">
	<div>
		<?php echo $this->Form->textarea('aboutUs.message', array('rows'=>25, 'cols'=>80, 'value'=>$businessArr['Business']['about_us']));?>
	</div>
	<div class="clr"></div>

	<div class="btnimage" style="float:left; padding-top:12px;">
		<a href="javascript:void(0);" onclick="return validateAboutUsContent();"><span style="color:#FFFFFF;">Post</span></a>
	</div>
	<div class="clr"></div>
	<div id="result_about_us_div"></div>
</div>
<!-- UPDATE CONTENT END -->

<?php echo $this->Form->hidden('hiddenAboutUsVal', array('value'=>0));?>
</div>

<?php /*if($this->Fused->validateUserForBusiness() == base64_decode($this->params['pass'][0])){*/
	if($this->Fused->validateUserForBusiness($this->Fused->decrypt($this->params['pass'][0])) == 'true'){
?>
<script type="text/javascript">
function nl2br (str, is_xhtml){   
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function validateAboutsUsTabs(){
	if($('#hiddenAboutUsVal').val() == '0'){
		$('#hiddenAboutUsVal').val('1');
		$('#original_aboutUs_content').hide();
		$('#update_aboutUs_content').show();
	}else{
		$('#hiddenAboutUsVal').val('0');
		$('#original_aboutUs_content').show();
		$('#update_aboutUs_content').hide();
	}
}

function validateAboutUsContent(){
	var aboutUsMessage = $('#aboutUsMessage').val();
	if(aboutUsMessage != ''){
		//send Ajax for saving the data
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/post_about_us_content/';?>",
			data: "aboutUsMessage="+aboutUsMessage+"&business_id=<?php echo base64_decode($this->params['pass'][0]);?>",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#result_about_us_div').html(bSend);
			},
			success: function(response){
				if(response == 'saved'){
					$('#result_about_us_div').html('');
					$('#hiddenAboutUsVal').val('0');
					$('#original_aboutUs_content').html(nl2br(aboutUsMessage));
					$('#original_aboutUs_content').show();
					$('#update_aboutUs_content').hide();
				}else{
					$('#result_about_us_div').html(response);
				}
			}
		});
	}else{
		return false;
	}
}
</script>
<?php } ?>