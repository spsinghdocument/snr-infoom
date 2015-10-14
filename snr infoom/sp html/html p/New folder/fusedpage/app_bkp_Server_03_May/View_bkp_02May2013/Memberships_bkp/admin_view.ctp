<div id="main" style=" width:700px;">
	<h3>Membership Plan Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Name:</div>
			<div class="fielddiv2"><?php echo $membershipDetails['Membership']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Description:</div>
			<div class="fielddiv2"><?php echo nl2br($membershipDetails['Membership']['description']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Price:</div>
			<div class="fielddiv2"><?php echo '$'.$membershipDetails['Membership']['price'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Validity:</div>
			<div class="fielddiv2"><?php 
				if(($membershipDetails['Membership']['valid_year'] != '') || ($membershipDetails['Membership']['valid_year'] > 0)){
					if($membershipDetails['Membership']['valid_year'] > 1)
						$ext = ' years ';
					else
						$ext = ' year ';
					echo $membershipDetails['Membership']['valid_year'].$ext;
				}
				if($membershipDetails['Membership']['valid_month'] != ''){
					if($membershipDetails['Membership']['valid_month'] > 1)
						$extMnth = ' months';
					else
						$extMnth = ' month';
					echo $membershipDetails['Membership']['valid_month'].$extMnth;
				}
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($membershipDetails['Membership']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else
					echo '<label style="color:#FF0000;">Inactive</label>';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Last Modified On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($membershipDetails['Membership']['modified']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>