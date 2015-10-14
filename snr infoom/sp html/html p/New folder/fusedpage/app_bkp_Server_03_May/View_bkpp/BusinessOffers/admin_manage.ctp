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
	<div class="mainHd">Manage Business Offers</div>
	<div style="float:right;"><?php echo $this->Html->link($this->Html->image('admin/add_more.png', array('alt'=>'', 'border'=>0)), '/admin/business_offers/add/'.$this->params['pass'][0].'/', array('escape'=>false, 'title'=>'Add New Offer'));?></div>

	<?php
		if(!empty($viewListing)){ //pr($viewListing);die;
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="25%">Category</td>
				<td width="30%">Title</td>
				<td width="15%">Price</td>
				<td width="15%" align="center">Status</td>
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
				<td><?php echo $this->Fused->fetchCorrespondingOfferCategory($listing['BusinessOffer']['name']);?></td>
				<td><?php echo $listing['BusinessOffer']['title'];?></td>
				<td><?php echo '$'.$listing['BusinessOffer']['price'];?></td>
				<td align="center"><?php
					if($listing['BusinessOffer']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/business_offers/status_update/'.$listing['BusinessOffer']['business_id'].'/'.$listing['BusinessOffer']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Offer?');
				?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_offers/view/'.$listing['BusinessOffer']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_offers/edit/'.$listing['BusinessOffer']['business_id'].'/'.$listing['BusinessOffer']['id'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
					//delete
					echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/business_offers/delete/'.$listing['BusinessOffer']['business_id'].'/'.$listing['BusinessOffer']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Business?');

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
		<div style="text-align:center; color:#FF0000;">No Offers Found!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>