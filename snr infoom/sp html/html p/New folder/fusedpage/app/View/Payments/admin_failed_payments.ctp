<?php //pr($viewListing);die;?>

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
	<?php echo $this->Form->create('Payment', array('action'=>'admin_failed_search'));?>
	<div class="label"><strong>Search</strong></div>
	<table width="100%" cellpadding="5">
	<tr>
		<td width="10%" style="font-size:12px;"><strong>Username:</strong></td>
		<td width="90%"><?php echo $this->Form->input('Search.username', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate', 'maxlength'=>100, 'error'=>false));?></td>
	</tr>

	<tr>
		<td style="font-size:12px;"><strong>Business Title:</strong></td>
		<td><?php echo $this->Form->input('Search.business_title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate', 'maxlength'=>200, 'error'=>false));?></td>
	</tr>

	<tr>
		<td style="font-size:12px;"><strong>Membership Plan:</strong></td>
		<td><?php echo $this->Form->input('Search.membership', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput validate', 'maxlength'=>200, 'error'=>false));?></td>
	</tr>

	<tr>
		<td style="font-size:12px;"><strong>Payment Type:</strong></td>
		<td><?php 
		echo $this->Form->select('Search.payment_type', array('Claim', 'Upgrade'), array('empty'=>'Select', 'class'=>'formInput validate', 'error'=>false, 'style'=>'width:20%'));?></td>
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
	<div class="mainHd">Failed Payments</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="25%">Business</td>
				<td width="14%">Membership</td>
				<td width="15%">User</td>
				<td width="12%">Amount</td>
				<td width="12%">Payment Type</td>
				<td width="14%">Made On</td>
				<td width="8%" align="center">Options</td>
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
				<td><?php echo $this->Html->link($listing['Business']['title'], '/admin/businesses/view/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
				?></td>
				<td><?php echo $listing['Membership']['name'];?></td>
				<td><?php echo $this->Html->link($listing['User']['first_name'].' '.$listing['User']['last_name'], '/admin/users/view/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
				?></td>
				<td align="center"><?php
					if($listing['Payment']['currency'] == 'USD')
						$curr = '$';
					echo $curr.$listing['Payment']['total_amount'];
				?></td>
				<td><?php echo $listing['Payment']['payment_type'];?></td>
				<td><?php echo date('d M, Y', strtotime($listing['Payment']['payment_date_time']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/payments/view/'.$listing['Payment']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
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
		<div style="text-align:center; color:#FF0000;">No Payment Failed Yet!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>

<script type="text/javascript">
function submitSearchForm(){
	var sub = 'false';

	$('.validate').each(function (){
		if(this.value != '')
			sub = 'true';
	});

	if(sub == 'true'){
		PaymentAdminFailedSearchForm.submit();
	}
}
</script>