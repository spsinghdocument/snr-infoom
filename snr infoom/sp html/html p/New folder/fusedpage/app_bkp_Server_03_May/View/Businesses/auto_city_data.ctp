<?php if(!empty($cityArr)){ ?>
<div>
	<?php foreach($cityArr as $cityArr){ ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<a href="javascript:void(0);" onclick="setCityData('<?php echo $cityArr['Business']['city']; ?>');" style="text-decoration:none;"><?php echo $cityArr['Business']['city']; ?></a>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
	<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>