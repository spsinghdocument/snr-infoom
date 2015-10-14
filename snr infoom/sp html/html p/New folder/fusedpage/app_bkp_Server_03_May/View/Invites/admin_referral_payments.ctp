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
	<div class="mainHd">Manage Refferal Payments</div>

	<?php
		if(!empty($viewListing)){ //pr($viewListing);die;
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="22%">Invitee</td>
				<td width="22%">Amount</td>
				<td width="30%">Business</td>
				<td width="16%">Date</td>
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
				<td><?php echo $listing['Inviter']['first_name'].' '.$listing['Inviter']['last_name'];?></td>
				<td><?php echo $listing['ReferralPayment']['amount'];?></td>
				<td><?php echo $listing['Business']['title'];?></td>
				<td><?php echo date('d M, Y', strtotime($listing['ReferralPayment']['created']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/invites/referpayment_payment_view/'.$listing['ReferralPayment']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
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
		<div style="text-align:center; color:#FF0000;">No Credited Refferal Amount</div>
	<?php } ?>
	<div class="clr"></div>
</div>