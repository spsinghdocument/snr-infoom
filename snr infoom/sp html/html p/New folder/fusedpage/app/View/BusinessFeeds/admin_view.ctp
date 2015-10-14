<?php //pr($userArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Business Feed Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Business</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Feed:</div>
			<div class="fielddiv2"><?php echo $businessArr['BusinessFeed']['message'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($businessArr['BusinessFeed']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($businessArr['BusinessFeed']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Registered On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($businessArr['BusinessFeed']['created']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>