<div id="main" style=" width:700px;">
	<h3>Subscriber Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Email:</div>
			<div class="fielddiv2"><?php echo $subscriberArr['Newsletter']['email'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($subscriberArr['Newsletter']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else
					echo '<label style="color:#FF0000;">Inactive</label>';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Subscribed On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($subscriberArr['Newsletter']['created']));?></div>
		</div>
		<div class="clear"></div>

				
	</fieldset>
</div>