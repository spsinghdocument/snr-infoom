<?php
	if(!empty($postCodeArr)){
?>
<div>
<?php
		foreach($postCodeArr as $city){
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
