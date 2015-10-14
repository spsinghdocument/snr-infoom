<?php if(!empty($businessArr)){ ?>
<div id="lft_nav_res">
						<?php foreach($businessArr as $business){
							$page = 1;
							$businessImage = 'front_end/business/noimage.jpg';
							if($business['Business']['image'] != ''){
								$imageRealPath = '../webroot/img/front_end/business/'.$business['Business']['image'];
								if(is_file($imageRealPath))
								$businessImage = 'front_end/business/'.$business['Business']['image'];
								
							}
				?>
				<div class="busnissinmianbox">
					<div class="busnissimgfl">
						<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($business['Business']['id']).'/'.$business['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>

					<div class="busnisshomeinfr">
						<div class="busnissimgfrhd">
							<?php echo $this->Html->link($this->Text->truncate($business['Business']['title'], 45, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($business['Business']['id']).'/'.$business['Business']['alias_name'].'/', array('escape'=>false));?>
						</div>

						<div style="font-size:11px;">
							<?php echo $business['Business']['city'],', '.$business['Business']['state_code'];?></div>
						<div>

						<?php
							for($i=1; $i<=5; $i++){
								if($i <= $business['Business']['rating'])
									echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
								else
									echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
							}
							?>
						</div>

						<div class="busnisslisttext">
							<?php echo $this->Text->truncate($business['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
						</div>

						<?php
						$BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($business['Business']['id']);
							foreach($BusinessUserImageArr as $BusinessUserImage){
								$businessImage = 'front_end/business/noimage.jpg';
									if($BusinessUserImage['User']['image'] != ''){
										$imageRealPath = '../webroot/img/front_end/users/profile/'.$BusinessUserImage['User']['image'];
									if(is_file($imageRealPath))
										$businessImage = 'front_end/users/profile/'.$BusinessUserImage['User']['image'];
									}
						?>
						<div class="busnisslistsmlimg">
							<?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?>
						</div>
						
					</div>
					<?php } ?>
					<div class="clr"></div>
				</div>
					<div class="clr"></div>
				</div>
				<?php } ?>
<?php } else 
			echo 'END'; ?>