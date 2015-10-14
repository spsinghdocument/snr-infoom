<?php if(!empty($searchArr)){?>
<div>
	<?php foreach($searchArr as $businessArr){ ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<?php 
		if($businessArr['Business']['city'] != ''){
			$country = ", ".$businessArr['Business']['country'];
		} else {
			$country = $businessArr['Business']['country'];
		}
	?>
	<a href="javascript:void(0);" onclick="setCityData('<?php echo $businessArr['Business']['city']; ?>');" style="text-decoration:none;"><?php echo $businessArr['Business']['city'].$country; ?></a>
	</div>
	<?php } ?>
</div>
<?php } else 
		echo 'END'; ?>