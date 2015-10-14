<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Viewed User Details</h3>
	<fieldset>
		<?php if(!empty($viewArr)){?>
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="20%">&nbsp;</td>
				<td width="21%"><strong>User</strong></td>
				<td width="17%"><strong>State</strong></td>
				<td width="20%"><strong>City</strong></td>
				<td width="5%"><strong>Views</strong></td>
				<td width="17%"><strong>Last Visited</strong></td>
				
			</tr>

		<?php
			foreach($viewArr as $listing){ //pr($listing);die;
				if($listing['User']['gender'] == '1')
					$avatar = 'front_end/users/male.jpg';
				else
					$avatar = 'front_end/users/female.jpg';

				if($listing['User']['image'] != ''){
					$realPath = '../webroot/img/front_end/users/profile/'.$listing['User']['image'];
					if(is_file($realPath)){
						$avatar = 'front_end/users/profile/'.$listing['User']['image'];
					}
				}
				$profileLink = SITE_PATH.'users/profile/'.$listing['User']['username'].'/';
		?>

			<tr style="margin-top:5px;">
				<td align="center"><a href="<?php echo $profileLink;?>"><?php echo $this->Image->resize($avatar, 50, 50, array('alt'=>''));?></a></td>
				<td><a href="<?php echo $profileLink;?>"><?php echo $listing['User']['first_name'].' '.$listing['User']['last_name'];?></a></td>
				<!-- <td><?php echo $this->Fused->calculateAge($listing['User']['date_of_birth']).' years';?></td> -->
				<td><?php echo $listing['User']['state'];?></td>
				<td><?php echo $listing['User']['city'];?></td>
				<td><?php echo $listing[0]['total'];?></td>
				<td><?php echo date('d M, Y', strtotime($listing['BusinessView']['created']));?></td>
			</tr>
		<?php } ?>
		</table>
		<?php } ?>
	</fieldset>
</div>