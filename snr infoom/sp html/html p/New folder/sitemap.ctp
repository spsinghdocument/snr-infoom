
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	
<url>
		<loc><?php echo Router::url('/',true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>
    
    <url>
		<loc><?php echo Router::url('/researchjournal',true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>
	
	
	
	<!-- static pages -->	
	<?php foreach ($site as $post):?>

	<url>
		<loc><?php echo Router::url('/categories/'.strtolower($post['Category']['seo_name']),true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>


	<?php endforeach; ?>
	<?php foreach ($site1 as $post):?>

	<url>
		<loc><?php echo Router::url('/view/'.$post['Article']['year'].'/'.$utility->monthToEnglishString($post['Article']['month']).'/'.strtolower($post['Article']['seo_name']),true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>


	<?php endforeach; ?>
	
	<?php foreach ($site2 as $post):?>

	<url>
		<loc><?php echo Router::url('/view/'.$post['Issue']['year'].'/'.$utility->monthToEnglishString($post['Issue']['month']),true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>


	<?php endforeach; ?>
    
    
    
    
    <?php foreach ($site3 as $post):?>

	<url>
		<loc><?php echo Router::url('/researchcategories/'.strtolower($post['Category']['seo_name']),true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>


	<?php endforeach; ?>
	<?php foreach ($site4 as $post):?>

	<url>
		<loc><?php echo Router::url('/researchview/'.$post['Article']['year'].'/'.$utility->monthToEnglishString($post['Article']['month']).'/'.strtolower($post['Article']['seo_name']),true); ?></loc>
        	<lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
	
		
	</url>


	<?php endforeach; ?>
	
	<?php foreach ($site5 as $post):?>

	<url>
		<loc><?php echo Router::url('/researchview/'.$post['Issue']['year'].'/'.$utility->monthToEnglishString($post['Issue']['month']),true); ?></loc>
        <lastmod><?php echo ($today); ?></lastmod>
		<changefreq>Weekly</changefreq>
		<priority>1.0</priority>
		
		
	</url>


	<?php endforeach; ?>




</urlset>