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
	<?php echo $this->Form->create('Business', array('action'=>'admin_search'));?>
	<div class="label"><strong>Search</strong></div>
	<table width="100%" cellpadding="5">
	<tr>
		<td width="10%" style="font-size:12px;"><strong>Title:</strong></td>
		<td width="90%"><?php echo $this->Form->input('Business.search_title', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false));?></td>
	</tr>

	<tr>
		<td style="font-size:12px;"><strong>Category:</strong></td>
		<td><?php echo $this->Form->select('Business.search_category', $this->Fused->fetchAllCategories(), array('div'=>false, 'empty'=>'Select', 'class'=>'formInput', 'error'=>false, 'style'=>'width:52%;'));?></td>
	</tr>

	<tr>
		<td width="10%" style="font-size:12px;"><strong>User Name:</strong></td>
		<td width="90%"><?php echo $this->Form->input('Business.name', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false));?></td>
	</tr>

	<tr>
		<td width="10%" style="font-size:12px;"><strong>Email:</strong></td>
		<td width="90%"><?php echo $this->Form->input('Business.email', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'formInput', 'error'=>false));?></td>
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
	<div class="mainHd">Manage Businesses</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="13%">Title</td>
				<td width="15%">Category</td>
				<td width="15%">Sub-Category</td>
				<td width="12%">Email</td>
				<td width="8%" align="center">Status</td>
				<td width="8%">Featured</td>
				<td width="15%" align="center">Claimed By</td>
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
				<td><?php echo $listing['Business']['title'];?></td>
				<td><?php echo $listing['Category']['name'];?></td>
				<td><?php echo $listing['Sub-Category']['name'];?></td>
				<td><?php if($listing['Business']['user_id'] != '')
						echo $listing['User']['email'];?></td>
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
					if($listing['Business']['featured'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Unfeatured';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Featured';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/businesses/featured_update/'.$listing['Business']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Business?');
				?></td>

				<td align="center"><?php 
					if(!empty($listing['User']['id']))
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
					//feedbacks
					echo $this->Html->link($this->Html->image('admin/feedback.png', array('alt'=>'', 'border'=>0)), '/admin/business_feedbacks/manage/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Feedbacks', 'style'=>'margin-left:5px;'));
					//feeds
					echo $this->Html->link($this->Html->image('admin/comments.png', array('alt'=>'', 'border'=>0)), '/admin/business_feeds/manage/'.$listing['Business']['id'].'/', array('escape'=>false, 'title'=>'Feeds', 'style'=>'margin-left:5px;'));
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