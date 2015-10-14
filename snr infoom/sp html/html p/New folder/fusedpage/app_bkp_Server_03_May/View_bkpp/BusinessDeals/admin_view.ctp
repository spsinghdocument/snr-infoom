<?php //pr($dealArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Deal Details</h3>
	<fieldset>
		
		<?php if($dealArr['BusinessDeal']['image'] != ''){
			$realImagePath = '../webroot/img/front_end/business/deals/'.$dealArr['BusinessDeal']['image'];
			if(is_file($realImagePath)){
		?>
		<div class="fielddiv">
			<div class="fielddiv1">
				<?php echo $this->Image->resize('front_end/business/deals/'.$dealArr['BusinessDeal']['image'], 100, 100, array('alt'=>'', 'style'=>'border:2px solid #CCCCCC;'));?>
			</div>
		</div>
		<div class="clear"></div>
		<?php }} ?>

		<div class="fielddiv">
			<div class="fielddiv1">Business:</div>
			<div class="fielddiv2"><?php echo $dealArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Title:</div>
			<div class="fielddiv2"><?php echo $dealArr['BusinessDeal']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Price:</div>
			<div class="fielddiv2"><?php echo '$'.$dealArr['BusinessDeal']['price'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Tagline:</div>
			<div class="fielddiv2"><?php echo $dealArr['BusinessDeal']['tagline'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Description:</div>
			<div class="fielddiv2"><?php echo nl2br($dealArr['BusinessDeal']['description']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Fine Prints:</div>
			<div class="fielddiv2"><?php echo nl2br($dealArr['BusinessDeal']['fine_prints']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">High Lights:</div>
			<div class="fielddiv2"><?php echo nl2br($dealArr['BusinessDeal']['high_lights']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Start Date:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($dealArr['BusinessDeal']['start_date']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">End Date:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($dealArr['BusinessDeal']['end_date']));?></div>
		</div>
		<div class="clear"></div>
		
		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($dealArr['BusinessDeal']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($dealArr['BusinessDeal']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Added On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($dealArr['BusinessDeal']['created']));?></div>
		</div>
		<div class="clear"></div>
		</fieldset>
</div>