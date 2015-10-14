<div id="main" style=" width:700px;">
	<h3>FAQ Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Question:</div>
			<div class="fielddiv2"><?php echo $pageArr['Faq']['question'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Answer:</div>
			<div class="fielddiv2"><?php echo nl2br($pageArr['Faq']['answer']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($pageArr['Faq']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else
					echo '<label style="color:#FF0000;">Inactive</label>';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Last Modified:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($pageArr['Faq']['modified']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>