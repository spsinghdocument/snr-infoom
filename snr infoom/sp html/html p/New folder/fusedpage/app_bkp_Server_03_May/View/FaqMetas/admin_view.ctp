<div id="main" style=" width:700px;">
	<h3>FAQ Meta Tags Details</h3>
	<fieldset>
		<div class="fielddiv">
			<div class="fielddiv1">Meta Title:</div>
			<div class="fielddiv2"><?php echo $metaArr['FaqMeta']['meta_title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Meta Keywords:</div>
			<div class="fielddiv2"><?php echo nl2br($metaArr['FaqMeta']['meta_keyword']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Meta Description:</div>
			<div class="fielddiv2"><?php echo nl2br($metaArr['FaqMeta']['meta_description']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Last Modified:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($metaArr['FaqMeta']['modified']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>