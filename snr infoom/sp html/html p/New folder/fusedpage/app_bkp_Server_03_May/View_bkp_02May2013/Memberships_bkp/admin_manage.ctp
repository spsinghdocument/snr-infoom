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
	<div class="mainHd">Manage Membership Plans</div>

	<?php if(!empty($viewListing)){ ?>
	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="20%">Name</td>
				<td width="15%">Price</td>
				<td width="15%">Validity</td>
				<td width="10%" align="center">Status</td>
				<td width="20%" align="center">Last Modified</td>
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
				<td><?php echo $listing['Membership']['name'];?></td>
				<td><?php 
					if(substr(strstr($listing['Membership']['price'], '.'), -2) == '00')
						echo '$'.strstr($listing['Membership']['price'], '.', true);
					else
						echo '$'.$listing['Membership']['price'];
				?></td>
				<td><?php 
					if(($listing['Membership']['valid_year'] != '') || ($listing['Membership']['valid_year'] > 0)){
						if($listing['Membership']['valid_year'] > 1)
							$ext = ' years ';
						else
							$ext = ' year ';
						echo $listing['Membership']['valid_year'].$ext;
					}
					if($listing['Membership']['valid_month'] != ''){
						if($listing['Membership']['valid_month'] > 1)
							$extMnth = ' months';
						else
							$extMnth = ' month';
						echo $listing['Membership']['valid_month'].$extMnth;
					}
				?></td>
				<td align="center"><?php
					if($listing['Membership']['status'] == '1'){
						$statusImage = 'admin/success.png';
						$newStatus = '0';
						$message = 'Deactivate';
					}else{
						$statusImage = 'admin/error.png';
						$newStatus = '1';
						$message = 'Activate';
					}
					echo $this->Html->link($this->Html->image($statusImage, array('alt'=>'', 'border'=>0)), '/admin/memberships/status_update/'.$listing['Membership']['id'].'/'.$newStatus.'/', array('escape'=>false, 'title'=>$message), 'Do You Really Want to '.$message.' this FAQ?');
				?></td>
				<td align="center"><?php echo date('d M, Y', strtotime($listing['Membership']['modified']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/memberships/view/'.$listing['Membership']['id'].'/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/memberships/edit/'.$listing['Membership']['id'].'/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
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
		<div style="text-align:center; color:#FF0000;">No Memberships Plans Available!!</div>
	<?php } ?>
	<div class="clr"></div>
</div>