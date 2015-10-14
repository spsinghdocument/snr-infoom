<!-- for fancybox Start --> 
<?php //pr($viewListing);die;
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
	<div class="mainHd">Manage Business Feedback Comments</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="30%">User</td>
				<td width="55%">Comment</td>
				<td width="15%" align="center">Status</td>
				<!-- <td width="15%" align="center">Options</td> -->
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
				<td><?php echo $listing['Comment']['comment'];?></td>
				<td align="center"><?php
					if($listing['Comment']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Disapprove';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Approve';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/comments/status_update/'.$listing['Comment']['id'].'/'.$newStatus.'/'.$listing['Comment']['feed_id'].'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Comment?');
				?></td>
				<!-- <td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/comments/view/'.$listing['Comment']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//delete
					/*echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/comments/delete/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Business?');*/
				?></td> -->
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
		<div style="text-align:center; color:#FF0000;">No Comments Found!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>