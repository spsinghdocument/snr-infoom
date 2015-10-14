<?php $featuredBusinessArr = $this->Fused->featuredBusiness();?>
<div class="insidefrhdbg">
	<h4>Featured Businesses</h4>	
</div>

<?php //for($i=1; $i<=6; $i++){?>
<?php if(!empty($featuredBusinessArr)){ 
	$i = '';
	foreach($featuredBusinessArr as $featuredBusiness){
	$businessImage = 'front_end/business/noimage.jpg';
			if($featuredBusiness['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$featuredBusiness['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$featuredBusiness['Business']['image'];
					
			}?>
<div class="bussinessinmain" style="padding-top:0;">
	<div class="bussimgfl">
		<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($featuredBusiness['Business']['id']).'/'.$featuredBusiness['Business']['alias_name'].'/', array('escape'=>false));?>
	</div>
	<div class="busnissfrbox">
		<div class="busnissimgfrinhd">
			<?php echo $this->Html->link($this->Text->truncate($featuredBusiness['Business']['title'], 20, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($featuredBusiness['Business']['id']).'/'.$featuredBusiness['Business']['alias_name'].'/', array('escape'=>false));?>
		</div>
		<div class="bussinessmltext">
			<?php echo $featuredBusiness['Business']['city'].', '.$featuredBusiness['Business']['state_code'];?>
		</div>
		<div class="clr"></div>
		<div>
			<?php
				for($i=1; $i<=5; $i++){
					if($i <= $featuredBusiness['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
				}
			?>
		</div>
	</div>
	<div class="clr"></div>
</div>
<?php } }?>
<div class="smallgap" ></div>