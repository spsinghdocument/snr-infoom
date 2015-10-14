<?php
	if(!empty($viewListing)){
		foreach($viewListing as $listing){ //pr($listing);die;
			$businessImage = 'front_end/business/noimage.jpg';
			if($listing['Business']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
				if(is_file($imageRealPath))
					$businessImage = 'front_end/business/'.$listing['Business']['image'];
					
			}
?>
			<div class="busnissinmianbox">
				<div class="busnissimgfl">
					<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
				</div>

				<div class="multipalflbox">
					<div class="multipalhd">
						<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>

					<div class="multipaltextsml"><?php
						echo $listing['Business']['street'].', '.$listing['Business']['city'],', '.$listing['Business']['country']
					?></div>
					<div class="phoneandmail">
						<?php 
						if($listing['Business']['phone'] != ''){
							echo $this->Html->image('front_end/phone_icon.jpg', array('alt'=>''));?>
							<strong><?php echo $listing['Business']['phone'];?></strong>
						<?php }
						if($listing['Business']['email'] != ''){
						?>
						<span class="miltibusinessmail">
							<?php
								echo $this->Html->image('front_end/mail_icon.jpg', array('alt'=>''));
								echo $this->Html->link($listing['Business']['email'], 'mailto:'.$listing['Business']['email'], array('escape'=>false));
							?>
						</span>
						<?php } ?>
					</div>
					<div class="commenlink">
						<?php echo $this->Html->link($listing['Business']['website'], $listing['Business']['website'], array('escape'=>false, 'target'=>'_blank'));?>
					</div>
					<div class="findouttext">Find out more about this business...visit page</div>
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
						<div class="deshboardsmlimg">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="deshboardsmlimg last">
							<?php echo $this->Html->link($this->Html->image('front_end/busniss_dtl_sml_img2.jpg', array('alt'=>'')), 'javascript:void(0);', array('escape'=>false));?>
						</div>
						<div class="clr"></div>				
					</div>
					<div class="hotellisttextbck">20 people recommended this business</div>
				</div>

				<div class="multipalfrbox">
					<div class="ratingstaryellow">
						<?php
							for($i=1; $i<=5; $i++){
								if($i <= $listing['Business']['rating'])
									echo $this->Html->image('front_end/rating_star_yellow.png', array('alt'=>'', 'border'=>0));
								else
									echo $this->Html->image('front_end/rating_star_gray.png', array('alt'=>'', 'border'=>0));
							}
						?>
					</div>	
					<div class="ratingtext">Category: <span>Hotels</span></div>
					<div class="graybtnbig">
						<?php echo $this->Html->link('Visit Page', '/businesses/details/'.base64_encode($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>
				</div>
				<div class="clr"></div>
			</div>
<?php
		}
	}else
		echo 'Complete';
?>