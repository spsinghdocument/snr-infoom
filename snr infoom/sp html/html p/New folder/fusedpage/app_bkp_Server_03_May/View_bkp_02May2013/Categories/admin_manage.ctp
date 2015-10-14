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
	<div class="mainHd">Manage Categories</div>

	<?php
		if(!empty($viewListing)){
	?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="30%">Category</td>
				<td width="30%" align="center">Sub-Categories</td>
				<td width="20%" align="center">Status</td>
				<td width="20%" align="center">Options</td>
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
				<td><?php echo $listing['Category']['name'];?></td>
				<td align="center"><?php
					if($listing['Category']['count'] > 0)
						echo $this->html->link($listing['Category']['count'], '/admin/categories/sub_categories_manage/'.$listing['Category']['id'].'/', array('escape'=>false));
					else
						echo $listing['Category']['count'];
				?></td>
				<td align="center"><?php
					if($listing['Category']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/categories/status_update/'.$listing['Category']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this Category?');
				?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/categories/view/'.$listing['Category']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/categories/edit/'.$listing['Category']['id'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
					//delete
					echo $this->Html->link($this->Html->image('admin/delete_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/categories/delete/'.$listing['Category']['id'].'/', array('escape'=>false, 'title'=>'Delete', 'style'=>'margin-left:5px;'), 'Do You Really Want to Delete this Category?');
					//add sub-category
					echo $this->Html->link($this->Html->image('admin/add_more.png', array('alt'=>'', 'border'=>0)), '/admin/categories/add_sub_category/'.$listing['Category']['id'].'/', array('escape'=>false, 'title'=>'Add Sub-Category', 'style'=>'margin-left:5px;'));
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
		<div style="text-align:center; color:#FF0000;">No Categories Found!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>