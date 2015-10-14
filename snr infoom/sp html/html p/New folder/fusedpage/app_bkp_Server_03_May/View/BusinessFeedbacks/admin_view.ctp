<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Business Feedback Detail </h3>
	<fieldset>
		
		<div class="fielddiv">
			<div class="fielddiv1">Business:</div>
			<div class="fielddiv2"><?php echo $businessArr['Business']['title'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Feedback:</div>
			<div class="fielddiv2"><?php echo $businessArr['BusinessFeedback']['feedback'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Rating:</div>
			<div class="fielddiv2"><?php
				if($businessArr['BusinessFeedback']['rating'] != '')
					echo $businessArr['BusinessFeedback']['rating'].'/5';
				else
					echo '-';
			?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Given by:</div>
			<div class="fielddiv2"><?php echo $businessArr['User']['first_name'].' '.$businessArr['User']['last_name'];?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Given On:</div>
			<div class="fielddiv2"><?php echo date('d M, Y', strtotime($businessArr['BusinessFeedback']['created']));?></div>
		</div>
		<div class="clear"></div>

		<div class="fielddiv">
			<div class="fielddiv1">Status:</div>
			<div class="fielddiv2"><?php 
				if($businessArr['BusinessFeedback']['status'] == '1')
					echo '<label style="color:green;">Approved</label>';
				else
					echo '<label style="color:#FF0000;">Unapproved</label>';
			?></div>
		</div>
		<div class="clear"></div>
	</fieldset>
</div>