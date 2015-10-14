<?php 
	if(!empty($dealsArr)){
		foreach($dealsArr as $deal){ //pr($deal);die;
?>

	<div class="Eventbox">
		<div class="Eventhd"><a href="#"><?php echo $deal['GroupEvent']['title']; ?></a><span><?php echo date('d M, Y', strtotime($deal['GroupEvent']['start_date']));?></span></div>
		<p><?php echo $deal['GroupEvent']['description']; ?></p>
		<div class="readmore"><a href="#">Read more...</a></div>
		
	<div class="clr"></div>

	<!-- EDIT DELETE SECTION START -->
	<?php if($this->Fused->validateUserForGroup($deal['GroupEvent']['group_id']) == $this->Session->read('Auth.User.User.id')){?>
	<div class="edittext" style="text-align:left;">
		<a title="Edit" href="javascript:void(0);" style="float:left;" onclick="return validateEventsTabs('edit', '<?php echo $deal['GroupEvent']['id'];?>')"><img alt="" src="/fusedpage/img/front_end/edit_icon.png"></a>
		<!-- **************** -->
		<a title="Delete" href="javascript:void(0);" style="float:left; margin-left:10px;" onclick="return deleteGroupEvent('<?php echo $deal['GroupEvent']['id'];?>');"><img alt="" src="/fusedpage/img/admin/delete_icon.gif/"></a>
	</div>
	<div class="clr"></div>
	<?php } ?>
	<!-- EDIT DELETE SECTION END   -->

	

	
</div>
<?php } } else{ ?>
<div class="deshlistbox" style="text-align:center; color:#FF0000; margin-top:50px;">
	No Events Available!!
</div>
<?php } ?>


