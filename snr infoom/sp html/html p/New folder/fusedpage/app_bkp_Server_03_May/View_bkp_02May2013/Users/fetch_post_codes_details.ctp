<?php
	if(!empty($postCodeArr)){ pr($postCodeArr);die;
?>
<div>
<?php
		foreach($postCodeArr as $city){ //pr($city);die;
?>
			<div style="margin:2px; cursor:pointer;" onclick="return validateCity('<?php echo $city;?>');"><?php echo $city;?></div>
<?php
		}
?>
</div>
<?php	
	}else{
		echo '***';
	}
?>
