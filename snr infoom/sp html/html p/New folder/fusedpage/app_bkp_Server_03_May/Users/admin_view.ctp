<div id="main" style=" width:700px;">
	<h3>User Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Name:</div>
			<div class="fielddiv2"><?php echo $userArr['User']['first_name'].' '.$userArr['User']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">User Type:</div>
			<div class="fielddiv2"><?php 
				if($userArr['User']['usertype'] == '1')
					echo 'Normal User';
				else
					echo 'Business User';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Email:</div>
			<div class="fielddiv2"><?php echo $userArr['User']['email'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">State:</div>
			<div class="fielddiv2"><?php echo $userArr['State']['state'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Suburb:</div>
			<div class="fielddiv2"><?php echo $userArr['Suburb']['suburb'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Postcode:</div>
			<div class="fielddiv2"><?php echo $userArr['User']['postcode'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Phone:</div>
			<div class="fielddiv2"><?php echo $userArr['User']['phone'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Gender:</div>
			<div class="fielddiv2"><?php
				if($userArr['User']['gender'] == '1')
					echo 'Male';
				else
					echo 'Female';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Date of Birth:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($userArr['User']['date_of_birth']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($userArr['User']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($userArr['User']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Registered On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($userArr['User']['created']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>