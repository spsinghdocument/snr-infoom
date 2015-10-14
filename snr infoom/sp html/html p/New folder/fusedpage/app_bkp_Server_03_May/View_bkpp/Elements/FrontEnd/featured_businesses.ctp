<div class="insidefrhdbg">
	<h4>Featured Businesses</h4>	
</div>

<?php for($i=1; $i<=4; $i++){?>
<div class="bussinessinmain" style="padding-top:0;">
	<div class="bussimgfl">
		<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/popular_bussinss_sml_img.jpg', array('alt'=>''));?></a>
	</div>
	<div class="busnissfrbox">
		<div class="busnissimgfrinhd">
			<a href="javascript:void(0);">Coffee one, Toronto...</a>
		</div>		
		<div class="bussinessmltext">1190 Rue Saint-Jean Quebec, Quebec</div>
		<div class="clr"></div>
		<div>
			<?php 
				echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
				echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
				echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
				echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>''));
				echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>''));
			?>
		</div>	
	</div>
	<div class="clr"></div>
</div>
<?php } ?>