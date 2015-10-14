<?php //pr($planArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Membership Plan Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Name:</div>
			<div class="fielddiv2"><?php echo $planArr['Membership']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Pricing:</div>
			<div class="fielddiv2"><?php 
				if(($planArr['Membership']['id'] == 2) || ($planArr['Membership']['id'] == 3))
					echo '$';
				echo $planArr['Membership']['pricing_month'];
				if(($planArr['Membership']['id'] == 2) || ($planArr['Membership']['id'] == 3))
					echo '/MO';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Search Visibility:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['search_visibility']){
					case '1': echo 'Limited'; break;
					case '2': echo 'High'; break;
					case '3': echo 'Really High'; break;
					case '4': echo 'Highlighted and Top Three'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Managed Profile:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['managed_profile']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Publish Deals:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['publish_deals']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Subscribe Button:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['subscribe_button']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Analytics Info:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['analytics_info']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Advanced Analytics:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['advanced_analytics']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Fusedpage Verified:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['fusedpage_verified']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Fusedpage Rating:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['fusedpage_rating']){
					case '0': echo 'No'; break;
					case '1': echo 'Yes'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Push Marketing:</div>
			<div class="fielddiv2"><?php 
				echo $planArr['Membership']['push_marketing'];
				if($planArr['Membership']['id'] == '3')
					echo '/MO';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Advanced Priority Support:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['advanced_priority_support']){
					case '1': echo '1 Hour'; break;
					case '2': echo '24 Hours'; break;
					case '3': echo '7 Days'; break;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<!-- <div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				switch($planArr['Membership']['status']){
					case '0': echo '<font color="red">Inactive</font>'; break;
					case '1': echo '<font color="green">Active</font>'; break;
					case '2': echo '<font color="red">Inactive</font>'; break;
				}
			?></div>
		</div>
		<div class="clear"></div> -->
		
		
	</fieldset>
</div>