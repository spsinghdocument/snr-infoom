<?php //pr($viewListing);?>

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
	<div class="mainHd">New Platinum Enquiries</div>

	<?php if(!empty($viewListing)){ ?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="20%">Name</td>
				<td width="18%">Business</td>
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
			<tr class="<?php echo $tableClass;?>" <?php if($listing['PremiumRequest']['viewed'] == '0'){echo 'style="font-weight:bold;"';}?>>
				<td><?php echo $this->Html->link($listing['User']['first_name'].' '.$listing['User']['last_name'], '/admin/users/view/'.$listing['User']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));?></td>
				<td><?php echo $this->Html->link($listing['Business']['title'], '/admin/businesses/view/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));?></td>
				<td><?php echo $this->Text->truncate($listing['PremiumRequest']['message'], 80, array('ellipsis'=>'...', 'html'=>true, 'exact'=>true));?></td>
				<td align="center"><?php echo date('d M, Y', strtotime($listing['PremiumRequest']['created']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/premium_requests/view/'.$listing['PremiumRequest']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));

					//send the payment request
					if($listing['PremiumRequest']['status'] == '1'){ //for received request
					?>
					<label id="request_<?php echo $listing['PremiumRequest']['id'];?>">
					<?php
					echo $this->Html->image('admin/doller.jpg', array('alt'=>'', 'title'=>'Request Payment', 'style'=>'margin-left:5px; cursor:pointer;', 'onclick'=>"validatePayment('".$listing['PremiumRequest']['id']."')"));
					?></label>
					<?php }elseif($listing['PremiumRequest']['status'] == '2'){
						echo '<font color="green">Payment Request Sent!</font>';
					}elseif($listing['PremiumRequest']['status'] == '3'){
						echo '<font color="red">Request Cancelled!</font>';
					}elseif($listing['PremiumRequest']['status'] == '4'){
						echo '<font color="green">Paid!</font>';
					}
					?>
				</td>
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

<script type="text/javascript">
function validatePayment(id, user_id){
	if(id != ''){
		var conf = confirm("Do you want to allow this user for purchasing the Platinum plan?");
		if(conf == true){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'admin/premium_requests/set_payment_status/';?>",
				data: "request_id="+id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>';
					$('#request_'+id).html(bSend);
				},
				success: function(response){
					$('#request_'+id).html(response);
				}
			});
		}
	}else
		return false;
}
</script>