<?php
	$popularBusinessArr = $this->Fused->fetchPopularBusinesses();
	if(!empty($popularBusinessArr)){
?>
<div class="deshboardfr">
	<div class="insidefrhdbg">
		<div class="fl"><h4>Popular Business</h4></div>
		<!-- <div class="morelink"><a href="javascript:void(0);">More</a></div> -->
		<div class="clr"></div>
	</div>
	

	<?php foreach($popularBusinessArr as $listing){ //pr($listing);die;
		$businessImage = 'front_end/business/noimage.jpg';
		if($listing['Business']['image'] != ''){
			$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
			if(is_file($imageRealPath))
				$businessImage = 'front_end/business/'.$listing['Business']['image'];
				
		}
	?>
	<div class="insidefrbox">
		<div class="feddimgbox">
			<?php echo $this->Html->link($this->Image->resize($businessImage, 57, 57, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>

		<div class="bussinesflbox">
			<div class="multipalhd">
				<?php echo $this->Html->link($this->Text->truncate($listing['Business']['title'], 15, array('ending'=>'...', 'exact'=>true, 'html'=>true)), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
			</div>
			<div class="bussinessmltext"><?php echo $listing['Business']['street'].', '.$listing['Business']['city'],', '.$listing['Business']['country'];?></div>
		</div>
		<div class="clr"></div>

		<div class="phoneandmailfr">
			<?php echo $this->Html->image('front_end/phone_icon.jpg', array('alt'=>''));?><strong><?php echo $listing['Business']['phone'];?></strong>
			<!-- <span class="miltibusinessmail">
				<img src="images/mail_icon.jpg" alt="" /><a href="mailto:info@flexsin.com">info@flexsin.com</a>
			</span> -->
		</div>

		<div class="commenlink">
			<?php echo $this->Html->link($listing['Business']['website'], $listing['Business']['website'], array('escape'=>false, 'target'=>'_blank'));?>
		</div>

		<div>
			<div class="deshboardsmlimg">
				<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
			</div>
			<div class="deshboardsmlimg">
				<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
			</div>
			<div class="deshboardsmlimg">
				<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img3.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
			</div>
			<div class="deshboardsmlimg">
				<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
			</div>
			<div class="clr"></div>
		</div>

		<div>
			<div class="hotellisttextbck">20 people recommended this business</div>
			<div class="hotellisttextsml">3 people you know recommenede this</div>
			<div class="hotellisttextsml">3 people you know checked into this</div>

			<?php if(!$this->Session->check('Auth.User.User.id')){?>
			<div class="findoutfamily">Find out if your family or friends know this 
			business... <a href="<?php echo SITE_PATH;?>">Sign up!</a></div>
			<?php } ?>

			<div class="visitpage"><?php echo $this->Html->link('Visit Page', '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?></div>
			<div class="clr"></div>
		</div>
	</div>
	<?php } ?>
	
				



</div>
<div class="clr"></div>
<?php } ?>