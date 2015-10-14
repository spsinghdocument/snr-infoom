<?php foreach($categoryArr as $category){
		if(!empty($category['Category']['name'])){?>
		<li>
			<a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $category['Category']['id'];?>','category');"><?php echo $category['Category']['name']; ?></a>
		</li>
<?php } }?>
