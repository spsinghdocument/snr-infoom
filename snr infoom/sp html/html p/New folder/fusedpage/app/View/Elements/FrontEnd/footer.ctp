<?php
	$sitePath = SITE_PATH;
	if($this->params['action'] == 'membership_plans'){
		$sitePath = str_replace('https://', 'http://', SITE_PATH);
	}
?>
<div class="footerinside">
	<div class="footerfl">
		<ul class="footerlink">
			<li><?php echo $this->Html->link('Home', $sitePath, array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('About us', $sitePath.'pages/page/about_us/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Terms &amp; Condition', $sitePath.'pages/page/terms_conditions/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Private Policy', $sitePath.'pages/page/privacy_policy/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('FAQ', $sitePath.'faqs/faq/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Contact Us', $sitePath.'enquiries/contact_us/', array('escape'=>false));?></li>
			<li class="last"><?php echo $this->Html->link('How it works', $sitePath.'how_it_works/', array('escape'=>false));?></li>
		</ul>
		<div class="clr"></div>
	</div>

	<div class="copyright">
		<div class="copyrightintext">Copyright &copy; <?php echo date('Y');?> <a href="<?php echo $sitePath;?>">Fusedpage</a>. All rights reserved</div>
		<div class="websitedesign"><a href="http://www.flexsin.com/" target="_blank">Website design</a> &amp; <a href="http://www.flexsin.com/" target="_blank">developed</a> by Flexsin</div>
	</div>
	<div class="clr"></div>
</div>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-42124452-1', 'fusedpage.com');
ga('send', 'pageview');

</script><?php //echo $this->Element('sql_dump');?>