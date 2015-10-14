<?php if(!empty($searchArr)){ ?>
<div>
<?php 
		foreach($searchArr as $searchArr){ //pr($listing);die;
?>
			<div style="margin:2px; cursor:pointer;" onclick="return setData('<?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name'];?>');"><?php echo $searchArr['User']['first_name']." ".$searchArr['User']['last_name']; ?></div>
<?php
		}
?>
</div>
<?php } else { ?>
<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>