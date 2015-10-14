<?php if(!empty($searchArr)){?>
<div>
	<?php foreach($searchArr as $businessArr){ ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<a href="javascript:void(0);" onclick="setData('<?php echo $businessArr['Business']['title']; ?>');" style="text-decoration:none;"><?php echo $businessArr['Business']['title']; ?></a>
	</div>
	<?php } ?>
</div>
<?php } else 
		echo 'END'; ?>