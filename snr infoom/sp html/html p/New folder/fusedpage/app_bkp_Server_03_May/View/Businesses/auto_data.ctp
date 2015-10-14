<?php if(!empty($searchArr)){ ?>
<div>
	<?php foreach($searchArr as $searchArr){ ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<a href="javascript:void(0);" onclick="setData('<?php echo $searchArr['Business']['title']; ?>');" style="text-decoration:none;"><?php echo $searchArr['Business']['title']; ?></a>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
	<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>