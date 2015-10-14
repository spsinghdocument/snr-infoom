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
	<div class="mainHd">Manage Business Feedbacks</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="20%">Business</td>
				<td width="30%">Feedback</td>
				<td width="10%">Rating</td>
				<td width="20%">Given By</td>
				<td width="10%" align="center">Status</td>
				<td width="10%" align="center">Options</td>
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
				<td><?php echo $listing['Business']['title'];?></td>
				<td><?php echo $listing['BusinessFeedback']['feedback'];?></td>
				<td><?php
					if($listing['BusinessFeedback']['rating'] != '')
						echo $listing['BusinessFeedback']['rating'].'/5';
					else
						echo '-';
				?></td>
				<td><?php echo $listing['User']['first_name'].' '.$listing['User']['last_name'];?></td>
				<td align="center"><?php
					if($listing['BusinessFeedback']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Disapprove';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Approve';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/business_feedbacks/status_update/'.$listing['BusinessFeedback']['id'].'/'.$newStatus.'/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Business?');
				?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_feedbacks/view/'.$listing['BusinessFeedback']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//delete
					/*echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_feedbacks/delete/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Feedback?');*/
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
		<div style="text-align:center; color:#FF0000;">No Business Found!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>