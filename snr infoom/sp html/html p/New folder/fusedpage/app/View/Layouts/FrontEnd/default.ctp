<?php
	$metaTitle = 'FusedPage';
	$metaDescription = 'FusedPage';
	$metaKeywords = 'FusedPage';

	if($this->params['controller'] == 'pages' && $this->params['action'] == 'page'){
		$metaTitle = $pageArr['Page']['meta_title'];
		$metaDescription = $pageArr['Page']['meta_description'];
		$metaKeywords = $pageArr['Page']['meta_keywords'];
	}

	if($this->params['controller'] == 'faqs' && $this->params['action'] == 'faq'){
		$metaTitle = $faqMetaArr['FaqMeta']['meta_title'];
		$metaDescription = $faqMetaArr['FaqMeta']['meta_description'];
		$metaKeywords = $faqMetaArr['FaqMeta']['meta_keyword'];
	}

	if($this->params['controller'] == 'users' && $this->params['action'] == 'home'){
		$tagsArr = $this->Fused->fetchMetaTags($this->params['controller'], $this->params['action']);

		$metaDescription = $tagsArr['MetaTag']['meta_description'];
		$metaKeywords = $tagsArr['MetaTag']['meta_keywords'];
	}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $metaTitle;?></title>
	<meta name="description" content="<?php echo $metaDescription;?>" />
	<meta name="keywords" content="<?php echo $metaKeywords;?>" />
	<meta name="thumbnail" content="<?php echo SITE_PATH.'img/image_cache/80x80_eX32htSRzkYwTlT.jpg';?>"/>
	<meta name="rating" content="5" />

	<?php
		echo $this->Html->css('FrontEnd/style');
		echo $this->Html->css('FrontEnd/custom');
		echo $this->Html->script('FrontEnd/function');

		//VALIDATION ENGINE START
		echo $this->Html->css('validation/validationEngine.jquery');
		echo $this->Html->css('validation/template');
		echo $this->Html->css('validation/customMessages.css');
		echo $this->Html->script('validation/jquery-1.7.2.min');
		echo $this->Html->script('validation/languages/jquery.validationEngine-en');
		echo $this->Html->script('validation/jquery.validationEngine');
		//VALIDATION ENGINE END
	?>
</head>
<body>
<!-- MAIN CONTAINER START -->
<div id="wrapper">
	<!-- SUB-CONTAINER START -->
	<div class="insidemain">
		<!-- HEADER START -->
		<div class="headerpart">
			<?php 
				if($this->Session->check('Auth.User.User.id'))
					echo $this->Element('FrontEnd/Inner/header');
				else
					echo $this->Element('FrontEnd/header');
			?>
		</div>
		<!-- HEADER END -->

		<!-- PAGE MAIN CONTAINER START -->
		<?php if($this->params['action'] != 'home'){?>
		<div class="midinsidemain">
		<?php }
			echo $content_for_layout;
		if($this->params['action'] != 'home'){?>
		</div>
		<?php } ?>
		<!-- PAGE MAIN CONTAINER END -->
	</div>
	<!-- SUB-CONTAINER END -->

	<!-- FOOTER SECTION START -->
	<div class="footerbg">
		<?php echo $this->Element('FrontEnd/footer');?>
	</div>
	<!-- FOOTER SECTION END -->
</div>
<!-- MAIN CONTAINER END -->
</body>
</html>