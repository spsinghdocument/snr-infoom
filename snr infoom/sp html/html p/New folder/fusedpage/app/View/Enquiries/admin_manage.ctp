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
	<div class="mainHd">Manage Enquiries</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="20%">Name</td>
				<td width="18%">Email</td>
				<td width="37%">Message</td>
				<td width="15%" align="center">Date</td>
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
			<tr class="<?php echo $tableClass;?>" <?php if($listing['Enquiry']['view'] == '0'){echo 'style="font-weight:bold;"';}?>>
				<td><?php echo $listing['Enquiry']['first_name'].' '.$listing['Enquiry']['last_name'];?></td>
				<td><?php echo $listing['Enquiry']['email'];?></td>
				<td><?php echo $this->Text->truncate($listing['Enquiry']['message'], 80, array('ellipsis'=>'...', 'html'=>true, 'exact'=>true));?></td>
				<td align="center"><?php echo date('d M, Y', strtotime($listing['Enquiry']['created']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/enquiries/view/'.$listing['Enquiry']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//delete
					echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/enquiries/delete/'.$listing['Enquiry']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Enquiry?');
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
		<div style="text-align:center; color:#FF0000;">No Enquiries Made Yet!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>