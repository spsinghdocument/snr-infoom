<!-- for fancybox Start -->
<?php
	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<!-- MIDDLE CONTAINER START -->
<div class="userdeshboardmid">
	<!-- POST COMMENTS START -->
	<?php echo $this->Element('FrontEnd/Inner/comments');?>
	<!-- POST COMMENTS END -->

	<!-- FILTER SECTION START -->
	<?php echo $this->Element('FrontEnd/Inner/filter');?>
	<!-- FILTER SECTION END -->

	<!-- PAGE MAIN CONTENT START -->
	<?php echo $this->Element('FrontEnd/Inner/page_content');?>
	<!-- PAGE MAIN CONTENT END -->	
</div>
<!-- MIDDLE CONTAINER END -->

<!-- RIGHT SECTION START -->
<div class="deshboardfr">
	<!-- ADD/ CLAIM BUSINESS START -->
	<?php echo $this->Element('FrontEnd/Inner/add_claim_business');?>
	<!-- ADD/ CLAIM BUSINESS END -->

	<!-- POPULAR BUSINESS START -->
	<?php echo $this->Element('FrontEnd/Inner/popular_business');?>
	<!-- POPULAR BUSINESS END -->

	<!-- POPULAR FEEDS START -->
	<?php echo $this->Element('FrontEnd/Inner/popular_feeds');?>
	<!-- POPULAR FEEDS END -->
</div>
<!-- RIGHT SECTION END -->