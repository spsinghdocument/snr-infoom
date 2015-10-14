<div class="footerinside">
	<div class="footerfl">
		<ul class="footerlink">
			<li><?php echo $this->Html->link('Home', SITE_PATH, array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('About us', SITE_PATH.'pages/page/about_us/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Terms &amp; Condition', SITE_PATH.'pages/page/terms_conditions/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Private Policy', SITE_PATH.'pages/page/privacy_policy/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('FAQ', SITE_PATH.'faqs/faq/', array('escape'=>false));?></li>
			<li><?php echo $this->Html->link('Contact Us', SITE_PATH.'enquiries/contact_us/', array('escape'=>false));?></li>
			<li class="last"><?php echo $this->Html->link('How it works', SITE_PATH.'pages/page/how_it_works/', array('escape'=>false));?></li>
		</ul>
		<div class="clr"></div>
	</div>

	<div class="copyright">
		<div class="copyrightintext">Copyright &copy; <?php echo date('Y');?> <a href="<?php echo SITE_PATH;?>">Fusedpage</a>. All rights reserved</div>
		<div class="websitedesign"><a href="http://www.flexsin.com/" target="_blank">Website design</a> &amp; <a href="http://www.flexsin.com/" target="_blank">developed</a> by Flexsin</div>
	</div>
	<div class="clr"></div>
</div>