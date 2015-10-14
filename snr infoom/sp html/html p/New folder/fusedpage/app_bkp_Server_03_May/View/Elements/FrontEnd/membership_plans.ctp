<?php 
	$plansArr = $this->Fused->fetchMembershipPackages();
	$searchVisilibility = array('1'=>'Limited', '2'=>'High', '3'=>'Really High', '4'=>'Highlighted and Top Three');
	$yes_no = array('0'=>'No', '1'=>'Yes');
	$advancePrioritySupport = array('1'=>'1 Hour', '2'=>'24 Hours', '3'=>'7 Days');
?>


<div class="pricetableboxmain">
	<div class="pricetotabbg">
		<ul class="pricetablink">
			<li><a href="javascript:void(0);" class="hmSel" style="cursor:text;">Compare Plans</a></li>
			<li><a id="heading_1" href="javascript:void(0);" class="plan_heading" onclick="validatePlan('basic'), validateSel('b','1')"><?php echo $plansArr[0]['Membership']['name'];?></a></li>
			<li><a id="heading_2" href="javascript:void(0);" class="plan_heading" onclick="validatePlan('basic_plus'), validateSel('bp','2')"><?php echo $plansArr[1]['Membership']['name'];?></a></li>
			<li><a id="heading_3" href="javascript:void(0);" class="plan_heading" onclick="validatePlan('premium'), validateSel('p','3')"><?php echo $plansArr[2]['Membership']['name'];?></a></li>
			<li class="last"><a id="heading_4" href="javascript:void(0);" onclick="validatePlan('premium_plus'), validateSel('pp','4')" class="hmSellast plan_heading"><?php echo $plansArr[3]['Membership']['name'];?></a></li>	
		</ul>
		<div class="clr"></div>
	</div>

	<div class="priceboxmid">
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
		  <tr class="lightbue">
			<td width="20%">Pricing</td>
			<td width="20%" id="b_1" class="plan_details"><?php echo $plansArr[0]['Membership']['pricing_month'];?></td>
			<td width="20%" id="bp_1" class="plan_details">$<?php echo $plansArr[1]['Membership']['pricing_month'];?>/MO</td>
			<td width="20%" id="p_1" class="plan_details">$<?php echo $plansArr[2]['Membership']['pricing_month'];?>/MO</td>
			<td width="20%" id="pp_1" class="plan_details"><?php echo $plansArr[3]['Membership']['pricing_month'];?></td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Search Visibility (info button)</td>
			<td width="20%" id="b_2" class="plan_details"><?php echo $searchVisilibility[$plansArr[0]['Membership']['search_visibility']];?></td>
			<td width="20%" id="bp_2" class="plan_details"><?php echo $searchVisilibility[$plansArr[1]['Membership']['search_visibility']];?></td>
			<td width="20%" id="p_2" class="plan_details"><?php echo $searchVisilibility[$plansArr[2]['Membership']['search_visibility']];?></td>
			<td width="20%" id="pp_2" class="plan_details"><?php echo $searchVisilibility[$plansArr[3]['Membership']['search_visibility']];?></td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Managed Profile (info button)</td>
			<td width="20%" id="b_3" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['managed_profile']];?></td>
			<td width="20%" id="bp_3" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['managed_profile']];?></td>
			<td width="20%" id="p_3" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['managed_profile']];?></td>
			<td width="20%" id="pp_3" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['managed_profile']];?></td>
		  </tr>
		   <tr class="bluebg">
			<td width="20%">Publish Deals (info button)</td>
			<td width="20%" id="b_4" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['publish_deals']];?></td>
			<td width="20%" id="bp_4" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['publish_deals']];?></td>
			<td width="20%" id="p_4" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['publish_deals']];?></td>
			<td width="20%" id="pp_4" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['publish_deals']];?></td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Subscribe Button (info button)</td>
			<td width="20%" id="b_5" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['subscribe_button']];?></td>
			<td width="20%" id="bp_5" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['subscribe_button']];?></td>
			<td width="20%" id="p_5" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['subscribe_button']];?></td>
			<td width="20%" id="pp_5" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['subscribe_button']];?></td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Analytics (info button)</td>
			<td width="20%" id="b_6" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['analytics_info']];?></td>
			<td width="20%" id="bp_6" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['analytics_info']];?></td>
			<td width="20%" id="p_6" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['analytics_info']];?></td>
			<td width="20%" id="pp_6" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['analytics_info']];?></td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Advanced Analytics (info button)</td>
			<td width="20%" id="b_7" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['advanced_analytics']];?></td>
			<td width="20%" id="bp_7" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['advanced_analytics']];?></td>
			<td width="20%" id="p_7" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['advanced_analytics']];?></td>
			<td width="20%" id="pp_7" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['advanced_analytics']];?></td>
		  </tr>
		   <tr class="bluebg">
			<td width="20%">Fusedpage Verified (info)</td>
			<td width="20%" id="b_8" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['fusedpage_verified']];?></td>
			<td width="20%" id="bp_8" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['fusedpage_verified']];?></td>
			<td width="20%" id="p_8" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['fusedpage_verified']];?></td>
			<td width="20%" id="pp_8" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['fusedpage_verified']];?></td>
		  </tr>
		   <tr class="lightbue">
			<td width="20%">Fusedpage Rating (info)</td>
			<td width="20%" id="b_9" class="plan_details"><?php echo $yes_no[$plansArr[0]['Membership']['fusedpage_rating']];?></td>
			<td width="20%" id="bp_9" class="plan_details"><?php echo $yes_no[$plansArr[1]['Membership']['fusedpage_rating']];?></td>
			<td width="20%" id="p_9" class="plan_details"><?php echo $yes_no[$plansArr[2]['Membership']['fusedpage_rating']];?></td>
			<td width="20%" id="pp_9" class="plan_details"><?php echo $yes_no[$plansArr[3]['Membership']['fusedpage_rating']];?></td>
		  </tr>
		  <tr class="bluebg">
			<td width="20%">Push marketing (info)</td>
			<td width="20%" id="b_10" class="plan_details"><?php echo $plansArr[0]['Membership']['push_marketing'];?></td>
			<td width="20%" id="bp_10" class="plan_details"><?php echo $plansArr[1]['Membership']['push_marketing'];?></td>
			<td width="20%" id="p_10" class="plan_details">$<?php echo $plansArr[2]['Membership']['push_marketing'];?>/MO</td>
			<td width="20%" id="pp_10" class="plan_details"><?php echo $plansArr[3]['Membership']['push_marketing'];?></td>
		  </tr>
		  <tr class="lightbue">
			<td width="20%">Advanced priority support</td>
			<td width="20%" id="b_11" class="plan_details">within <?php echo $advancePrioritySupport[$plansArr[0]['Membership']['advanced_priority_support']];?></td>
			<td width="20%" id="bp_11" class="plan_details">within <?php echo $advancePrioritySupport[$plansArr[1]['Membership']['advanced_priority_support']];?></td>
			<td width="20%" id="p_11" class="plan_details">Within <?php echo $advancePrioritySupport[$plansArr[2]['Membership']['advanced_priority_support']];?></td>
			<td width="20%" id="pp_11" class="plan_details">Within <?php echo $advancePrioritySupport[$plansArr[3]['Membership']['advanced_priority_support']];?></td>
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

function validateSel(plan, id){
	//unselect all heading select
	$('.plan_heading').removeClass('sel');
	$('#heading_'+id).addClass('sel');

	//for plan values select
	$('.plan_details').removeClass('yellowlight').removeClass('yellowdark');
	var clas = '';
	for(var i=1; i<=11; i++){
		if(i%2 != 0)
			clas = 'yellowlight';
		else
			clas = 'yellowdark';
		$('#'+plan+'_'+i).addClass(clas);
	}

}

validateSel('p', '3');
</script>