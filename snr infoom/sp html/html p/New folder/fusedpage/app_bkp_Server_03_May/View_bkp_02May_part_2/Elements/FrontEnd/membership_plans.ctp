<div class="pricetableboxmain">
	<div class="pricetotabbg">
		<ul class="pricetablink">
			<li><a href="javascript:void(0);" class="hmSel" style="cursor:text;">Compare Plans</a></li>
			<li><a href="javascript:void(0);" onclick="return validatePlan('basic');">Basic</a></li>
			<li><a href="javascript:void(0);" onclick="return validatePlan('basic_plus');">Basic+</a></li>
			<li><a href="javascript:void(0);" onclick="return validatePlan('premium');" class="sel">Premium</a></li>
			<li class="last"><a href="javascript:void(0);" onclick="return validatePlan('premium_plus');" class="hmSellast">Premium+</a></li>	
		</ul>
		<div class="clr"></div>
	</div>

	<div class="priceboxmid">
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
		  <tr class="lightbue">
			<td width="20%">Pricing</td>
			<td width="20%">Free</td>
			<td width="20%">$24.95/MO</td>
			<td width="20%" class="yellowlight">49.95/MO</td>
			<td width="20%">Contact Us</td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Search Visibility (info button)</td>
			<td width="20%">Limited</td>
			<td width="20%">High</td>
			<td width="20%" class="yellowdark">Really High</td>
			<td width="20%">Highlighted and top three</td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Managed Profile (info button)</td>
			<td width="20%">No</td>
			<td width="20%">Yes</td>
			<td width="20%" class="yellowlight">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		   <tr class="bluebg">
			<td width="20%">Publish Deals (info button)</td>
			<td width="20%">No</td>
			<td width="20%">Yes</td>
			<td width="20%" class="yellowdark">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Subscribe Button (info button)</td>
			<td width="20%">No</td>
			<td width="20%">Yes</td>
			<td width="20%" class="yellowlight">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Analytics (info button)</td>
			<td width="20%">No</td>
			<td width="20%">Yes</td>
			<td width="20%" class="yellowdark">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Advanced Analytics (info button)</td>
			<td width="20%">No</td>
			<td width="20%">No</td>
			<td width="20%" class="yellowlight">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		   <tr class="bluebg">
			<td width="20%">Fusedpage Verified (info)</td>
			<td width="20%">No</td>
			<td width="20%">No</td>
			<td width="20%" class="yellowdark">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		   <tr class="lightbue">
			<td width="20%">Fusedpage Rating (info)</td>
			<td width="20%">No</td>
			<td width="20%">No</td>
			<td width="20%" class="yellowlight">Yes</td>
			<td width="20%">Yes</td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Push marketing (info)</td>
			<td width="20%">x</td>
			<td width="20%">x</td>
			<td width="20%" class="yellowdark">100/MO</td>
			<td width="20%">Custom</td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Advanced priority support</td>
			<td width="20%">within 7 days</td>
			<td width="20%">within 7 days</td>
			<td width="20%" class="yellowlight">Within 24 hours</td>
			<td width="20%">Within 1 hour</td>
		  </tr>
	  </table>
	</div>				
</div>

<script type="text/javascript">
function validatePlan(alias_name){
	if((alias_name == 'basic_plus') || (alias_name == 'premium')){
		//hide the card payment div
		$('#upgrade').show();
		$('#business_plans').show();
		$('#card_payment').hide();
		$('#free_plan').hide();
		$('#premium_plus_plan').hide();

		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'memberships/fetch_membership_data/';?>",
			data: "alias_name="+alias_name,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#fetchPlansDiv').html(bSend);
			},
			success: function(response){
				$('#fetchPlansDiv').html(response);
			}
		});
	}else{
		$('#upgrade').hide();
		$('#card_payment').hide();
		$('#business_plans').hide();
		$('#free_plan').hide();
		$('#premium_plus_plan').hide();

		if(alias_name == 'basic'){
			$('#free_plan').show();
			return false;
		}else{
			$('#premium_plus_plan').show();
			return false;
		}
	}
}
</script>