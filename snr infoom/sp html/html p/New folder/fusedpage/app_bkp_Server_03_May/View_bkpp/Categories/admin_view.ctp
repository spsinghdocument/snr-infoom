<div id="main" style=" width:700px;">
	<h3>Category Details</h3>
	<fieldset>
		<?php if($categoryArr['Category']['parent_id'] != 0){?>
		<div class="fielddiv">
			<div class="fielddiv1">Parent Category:</div>
			<div class="fielddiv2"><?php $catArr = $this->Fused->fetchCategoryDetails($categoryArr['Category']['parent_id']); echo $catArr['Category']['name'];?></div>
		</div>
		<div class="clear"></div>
		<?php } ?>

		<div class="fielddiv">
			<div class="fielddiv1">Category:</div>
			<div class="fielddiv2"><?php echo $categoryArr['Category']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($categoryArr['Category']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else
					echo '<label style="color:#FF0000;">Inactive</label>';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Last Modified:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($categoryArr['Category']['modified']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>