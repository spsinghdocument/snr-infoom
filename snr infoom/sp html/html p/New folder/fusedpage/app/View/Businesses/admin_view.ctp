<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Business Details</h3>
	<fieldset>
		
		<?php if($businessArr['Business']['image'] != ''){
			$realImagePath = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
			if(is_file($realImagePath)){
		?>
		<div class="fielddiv">
			<div class="fielddiv1">
				<?php echo $this->Image->resize('front_end/business/'.$businessArr['Business']['image'], 100, 100, array('alt'=>'', 'style'=>'border:2px solid #CCCCCC;'));?>
			</div>
		</div>
		<div class="clear"></div>
		<?php }} ?>
		
		<div class="fielddiv">
			<div class="fielddiv1">Title:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Tagline:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['tagline'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Tags:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['tags'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Main Category:</div>
			<div class="fielddiv2"><?php echo $businessArr['Category']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Category:</div>
			<div class="fielddiv2"><?php echo $businessArr['Sub-Category']['name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Email:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['email'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Street:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['street'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">City:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['city'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">State:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['state_code'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Zip:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['zip'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Phone:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['phone'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Website:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['website'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Hours:</div>
			<div class="fielddiv2"><?php echo nl2br($businessArr['Business']['hours']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">About Us:</div>
			<div class="fielddiv2"><?php echo nl2br($businessArr['Business']['about_us']);?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($businessArr['Business']['status'] == '1')
					echo '<label style="color:green;">Active</label>';
				else if($businessArr['Business']['status'] == '2')
					echo '<label style="color:#FF0000;">Deactivated by Administrator</label>';
				else
					echo '<label style="color:#FF0000;">Inactive';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Rating:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['rating'].'/5';?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Claimed By:</div>
			<div class="fielddiv2"><?php 
				if($businessArr['Business']['user_id'] != '')
					echo $businessArr['User']['first_name'].' '.$businessArr['User']['last_name'];
				else
					echo '<font color="red">Not Yet!!</font>';
			?></div>
		</div>
		<div class="clear"></div>

		<?php if($businessArr['Business']['user_id'] != ''){?>
		<div class="fielddiv">
			<div class="fielddiv1">Current Membership Plan:</div>
			<div class="fielddiv2"><?php 
			$plans = array('1'=>'Free', '2'=>'Premium', '3'=>'Premium+', '4'=>'Platinum');
			echo $plans[$this->Fused->fetchBusinessMembershipPlan($businessArr['Business']['id'])];
			?></div>
		</div>
		<div class="clear"></div>
		<?php } ?>

		<div class="fielddiv">
			<div class="fielddiv1">Added On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($businessArr['Business']['created']));?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>