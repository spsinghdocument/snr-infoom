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

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Manage Membership Plans</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="40%">Plan Name</td>
				<!-- <td width="20%" align="center">Status</td> -->
				<td width="20%" align="center">Last Modified</td>
				<td width="20%" align="center">Options</td>
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
				<td><?php echo $listing['Membership']['name'];?></td>
				<!-- <td align="center"><?php
					if($listing['Membership']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '2';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/memberships/status_update/'.$listing['Membership']['alias_name'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Plan?');
				?></td> -->
				<td align="center"><?php echo date('d M, Y', strtotime($listing['Membership']['modified']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/memberships/view/'.$listing['Membership']['alias_name'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/memberships/edit/'.$listing['Membership']['alias_name'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
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