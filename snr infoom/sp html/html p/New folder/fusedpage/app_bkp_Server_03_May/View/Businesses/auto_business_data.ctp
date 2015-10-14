<?php if(!empty($businessArr)){ ?>
<div>
	<?php foreach($businessArr as $businessArr){ ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<a href="javascript:void(0);" onclick="setBusinessData('<?php echo $businessArr['Business']['title']; ?>');" style="text-decoration:none;"><?php echo $businessArr['Business']['title']; ?></a>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
	<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>