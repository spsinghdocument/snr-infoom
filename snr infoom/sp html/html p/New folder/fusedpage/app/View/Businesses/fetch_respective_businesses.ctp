<?php
	if(!empty($businessesArr)){ //pr($businessesArr);
		foreach($businessesArr as $business){
?>
		<div style="margin:3px 0 0 5px;"><a href="javascript:void(0);" style="text-decoration:none;" onclick="return validateResult('<?php echo addslashes($business);?>');"><?php echo $business;?></a></div>
		<div class="clr"></div>
<?php
		}
	}else{
?>
	<script type="text/javascript">
		validateResult('');
	</script>
<?php
	}
?>