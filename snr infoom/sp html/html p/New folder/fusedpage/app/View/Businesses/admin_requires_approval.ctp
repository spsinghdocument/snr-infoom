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
	<div class="mainHd">Manage Businesses</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="50%">Business Title</td>
				<td width="10%">Status</td>
				<td width="20%">Updated By</td>
				<td width="20%">Updated On</td>
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
				<td><?php
					$statusImage = 'admin/error.png';
					$newStatus = '1';
					$message = 'Activate';
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/businesses/user_business_status_update/'.$listing['Business']['id'].'/'.$listing['BusinessEdit']['id'].'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Business?');
				?></td>

				

				<td><?php echo $this->Html->link($this->Fused->fetchUserName($listing['BusinessEdit']['edited_by']), '/admin/users/view/'.$listing['BusinessEdit']['edited_by'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
				?></td>
				<td><?php echo date('d M, Y', strtotime($listing['BusinessEdit']['created']));?></td>
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

<script type="text/javascript">
function submitSearchForm(){
	var subForm = 'false';
	$('.formInput').each(function(){
		if(this.value != '')
			subForm = 'true';
	});

	if(subForm == 'true')
		BusinessAdminSearchForm.submit();
}
</script>