<div class="pricetopfr">
	<?php if($businessPlan > 1){?>
	<!-- FOR FUSEDPAGE SUPPORT START -->
	<div>
		<?php if($businessPlan > 1){?>
		<div class="priceinhd" style="font-size:20px;">Fusedpage Email Support</div>
		<div class="contectflbox">
			<div class="contacttextfied" style="float:left;">
				<?php echo $this->Form->textarea('Business.support', array('div'=>false, 'label'=>false, 'class'=>'contacttextarea', 'rows'=>'', 'cols'=>'', 'style'=>'resize:none;'));?>
				<div id="messageError" style="color:#FF0000; font-size:13px;"></div>
			</div>
			<div class="clr"></div>

			<div class="contactfield" style="float:left;">
				<div class="btnimage">
					<a href="javascript:void(0);" onclick="return validatePostEnquiry();"><span>Post</span></a>
				</div>
				<div id="post_support" style="float:left; margin-top:5px; text-align:center; width:190px; font-size:12px;"></div>
			</div>
			<div class="clr"></div>
		</div>

		<?php if($businessPlan > 2){?>
		<!-- CONTACT SECTION START -->
		<div class="contectflbox">
			<div class="priceinhd" style="font-size:20px;">Fusedpage Support on Call</div>
			<div>Please call: <?php echo $this->Fused->fetchSupportContact();?></div>
		</div>
		<!-- CONTACT SECTION END -->
		<?php }} ?>
	</div>
	<div class="clr"></div>
	<!-- FOR FUSEDPAGE SUPPORT END -->
	<?php } ?>
</div>
<div class="clr"></div>

<!-- CITY SELECTION SECTION START -->
<?php echo $this->Element('FrontEnd/business_cities');?>
<!-- CITY SELECTION SECTION END -->


<script type="text/javascript">
function validatePostEnquiry(){
	var enq = $('#BusinessSupport').val();
	if(enq != ''){
		//send the ajax for sending the enquiry start
		$.ajax({
			type: "POST",
			url: "<?php echo $https_site_path.'businesses/post_business_enquiry/';?>",
			data: "enquiry="+enq+"&business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>&business_plan=<?php echo $businessPlan;?>",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#post_support').html(bSend);
			},
			success: function(response){
				$('#post_support').html(response);
				$('#BusinessSupport').val('');
			}
		});
	}else
		return false;
}
</script>