<?php //pr($businessArr);die;?>
<div id="main" style=" width:700px;">
	<h3>Viewed User Details</h3>
	<fieldset>
		<?php if(!empty($viewArr)){?>
		<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="20%">&nbsp;</td>
				<td width="30%"><strong>User</strong></td>
				<td width="25%"><strong>State</strong></td>
				<td width="25%"><strong>City</strong></td>
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
		?>

			<tr style="margin-top:5px;">
				<td align="center"><?php echo $this->Image->resize($avatar, 50, 50, array('alt'=>''));?></td>
				<td><?php echo $listing['User']['first_name'].' '.$listing['User']['last_name'];?></td>
				<td><?php echo $listing['User']['state'];?></td>
				<td><?php echo $listing['User']['city'];?></td>
			</tr>
		<?php } ?>
		</table>
		<?php } ?>
	</fieldset>
</div>