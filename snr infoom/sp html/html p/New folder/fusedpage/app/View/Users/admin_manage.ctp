<!-- for fancybox Start -->
<?php
	echo $this->Html->Css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->Script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<!-- SEARCH SECTION START -->
<div class="mainHd" style="font-size:15px;">
	<?php echo $this->Form->create('User', array('action'=>'search'));?>
	<div class="label"><strong>Search</strong></div>
	<table width="100%" cellpadding="5">
	<tr>
		<td width="10%" style="font-size:12px;"><strong>Name:</strong></td>
		<td width="90%"><?php echo $this->Form->input('User.search_name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate', 'maxlength'=>100, 'error'=>false));?></td>
	</tr>

	<tr>
		<td style="font-size:12px;"><strong>Postcode:</strong></td>
		<td><?php echo $this->Form->input('User.search_postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate', 'error'=>false, 'style'=>'width:20%;'));?></td>
	</tr>


	<tr>
		<td width="10%" style="font-size:12px;"><strong>Email:</strong></td>
		<td width="90%"><?php echo $this->Form->input('User.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false));?></td>
	</tr>

	<tr>
		<td width="10%" style="font-size:12px;"><strong>User Type:</strong></td>
		<td width="90%">
			<?php
				$arr_type=array('1'=>'Normal User', '2'=>'Business User');
				echo $this->Form->select('User.usertype', $arr_type, array('div'=>false, 'empty'=>'Select User Type', 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false));
			?>
		</td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $this->Html->image('front_end/search_btn.jpg', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'return submitSearchForm();'));?></td>
	</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>
<!-- SEARCH SECTION END -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Manage Users</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="18%">Name</td>
				<td width="14%">User Type</td>
				<td width="15%">Postcode</td>
				<td width="12%">City</td>
				<td width="12%" align="center">Status</td>
				<td width="14%">Registered On</td>
				<td width="15%" align="center">Options</td>
			</tr>
			
			<?php
				$counter = 0;
				foreach($viewListing as $listing){ //pr($listing);die;
					if($counter%2 == 0)
						$tableClass = 'rpFirstRow';
					else
						$tableClass = 'rpSecRow';
			?>
			<tr class="<?php echo $tableClass;?>">
				<td><?php echo $listing['User']['first_name'].' '.$listing['User']['last_name'];?></td>
				<td><?php
					if($listing['User']['usertype'] == '1')
						echo 'Normal User';
					else
						echo 'Business User';
				?></td>
				<td><?php echo $listing['User']['postcode'];?></td>
				<td><?php echo $listing['User']['city'];?></td>
				<td align="center"><?php
					if($listing['User']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '2';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/users/status_update/'.$listing['User']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this User?');
				?></td>
				<td><?php echo date('d M, Y', strtotime($listing['User']['created']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/users/view/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/users/edit/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
					//delete
					echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/users/delete/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this User?');
					//reset
					echo $this->Html->link($this->Html->image('admin/reset.png', array('alt'=>'', 'border'=>0)), '/admin/users/reset_password/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'Reset Passowrd', 'style'=>'margin-left:5px;'), 'Do You Really Want to Reset this User\'s Password?');
				?></td>
			</tr>
			<?php
					$counter++;
				}
			?>
		</table>
	</div>
	<?php 
		echo $this->Element('admin/pagination');
	      }else{ ?>
		<div style="text-align:center; color:#FF0000;">No Users Registered Yet!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>

<script type="text/javascript">
function submitSearchForm(){
	var subForm = 'false';
	$('.formInput').each(function(){
		if(this.value != '')
			subForm = 'true';
	});

	if(subForm == 'true')
		UserSearchForm.submit();
}
</script>