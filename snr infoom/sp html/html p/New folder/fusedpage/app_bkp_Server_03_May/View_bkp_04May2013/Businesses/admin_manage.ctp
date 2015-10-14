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
				<td width="18%">Title</td>
				<td width="20%">Category</td>
				<td width="20%">Sub-Category</td>
				<td width="8%" align="center">Status</td>
				<td width="20%" align="center">Claimed By</td>
				<td width="14%" align="center">Options</td>
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
				<td><?php echo $listing['Category']['name'];?></td>
				<td><?php echo $listing['Sub-Category']['name'];?></td>
				<td align="center"><?php
					if($listing['Business']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/businesses/status_update/'.$listing['Business']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Business?');
				?></td>
				<td align="center"><?php 
					if($listing['Business']['user_id'] != '')
						echo $listing['User']['first_name'].' '.$listing['User']['last_name'];
					else
						echo '<font color="red">Not Yet!!</font>';
						
				?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/businesses/view/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/businesses/edit/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
					//delete
					echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/businesses/delete/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Business?');
					//banner
					echo $this->Html->link($this->Html->image('admin/image_icon.jpg', array('alt'=>'', 'border'=>0)), '/admin/business_banners/manage/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Banner', 'style'=>'margin-left:5px;'));
					//offers
					echo $this->Html->link($this->Html->image('admin/offer.gif', array('alt'=>'', 'border'=>0)), '/admin/business_offers/manage/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Offers', 'style'=>'margin-left:5px;'));
					//deals
					echo $this->Html->link($this->Html->image('admin/deal.png', array('alt'=>'', 'border'=>0)), '/admin/business_deals/manage/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Deals', 'style'=>'margin-left:5px;'));

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