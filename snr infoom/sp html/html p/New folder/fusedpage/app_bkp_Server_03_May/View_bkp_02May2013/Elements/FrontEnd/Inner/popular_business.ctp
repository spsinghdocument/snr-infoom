<div class="insidefrhdbg">
	<div class="fl"><h4>Popular Business</h4></div>
	<div class="morelink"><a href="javascript:void(0);">More</a></div>
	<div class="clr"></div>
</div>

<?php for($i=1; $i<=3; $i++){?>
<div class="bussinessinmain" <?php if($i==1){?>style="padding-top:0;"<?php } ?>>
	<div class="bussimgfl">
		<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/popular_bussinss_sml_img.jpg', array('alt'=>''));?></a>
	</div>

	<div class="busnissfrbox">
		<div class="busnissimgfrinhd">
			<a href="javascript:void(0);">Coffee one, Toronto...</a>
		</div>

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