<?php 
	foreach($locationArr as $location){
		if(!empty($location['fp_businesses']['city'])){?>
		<li>
			<a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $location['fp_businesses']['city'];?>','location');"><?php echo $location['fp_businesses']['city'];?></a>
		</li>
<?php } }?>
