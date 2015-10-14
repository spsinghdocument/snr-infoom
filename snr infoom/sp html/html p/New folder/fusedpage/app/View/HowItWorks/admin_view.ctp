<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Business Details</h3>
	<fieldset>
		
		<?php if($businessArr['HowItWork']['image'] != ''){
			$realImagePath = '../webroot/img/front_end/business/'.$businessArr['HowItWork']['image'];
			if(is_file($realImagePath)){
		?>
		<div class="fielddiv">
			<div class="fielddiv1">
				<?php echo $this->Image->resize('front_end/business/'.$businessArr['HowItWork']['image'], 100, 100, array('alt'=>'', 'style'=>'border:2px solid #CCCCCC;'));?>
			</div>
		</div>
		<div class="clear"></div>
		<?php }} ?>
		
		<div class="fielddiv">
			<div class="fielddiv1">Heading:</div>
			<div class="fielddiv2"><?php echo $businessArr['HowItWork']['heading'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">About Us:</div>
			<div class="fielddiv2"><?php echo nl2br($businessArr['HowItWork']['content']);?></div>
		</div>
		<div class="clear"></div>

		<!-- <div class="fielddiv">
			<div class="fielddiv1">Type:</div>
			<div class="fielddiv2"><?php echo $businessArr['HowItWork']['type'];?></div>
		</div>
		<div class="clear"></div> -->

		<div class="fielddiv">
			<div class="fielddiv1">Link:</div>
			<div class="fielddiv2"><?php echo $businessArr['HowItWork']['link'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($businessArr['HowItWork']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($businessArr['HowItWork']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>
		
	</fieldset>
</div>