<div id="main" style=" width:700px;">
	<h3>Page Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Page Name:</div>
			<div class="fielddiv2"><?php echo $pageArr['Page']['page_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Meta Title:</div>
			<div class="fielddiv2"><?php echo $pageArr['Page']['meta_title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Meta Description:</div>
			<div class="fielddiv2"><?php echo $pageArr['Page']['meta_description'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Meta Keywords:</div>
			<div class="fielddiv2"><?php echo $pageArr['Page']['meta_keywords'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Description:</div>
			<div class="fielddiv2"><?php echo nl2br($pageArr['Page']['description']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($pageArr['Page']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else
					echo '<label style="color:#FF0000;">Inactive</label>';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Last Modified:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($pageArr['Page']['modified']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>