<?php foreach($locationArr as $location){
		if(!empty($location['Business']['city'])){?>
		<li>
			<a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $location['Business']['city'];?>','location');"><?php echo $location['Business']['city'];?></a>
		</li>
<?php } }?>
