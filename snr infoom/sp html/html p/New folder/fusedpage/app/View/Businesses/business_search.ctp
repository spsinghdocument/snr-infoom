<?php 
foreach($searchArr as $listing){ //pr($listing);die;
	$businessImage = 'front_end/business/noimage.jpg';
						if($listing['Business']['image'] != ''){
							$imageRealPath = '../webroot/img/front_end/business/'.$listing['Business']['image'];
							if(is_file($imageRealPath))
								$businessImage = 'front_end/business/'.$listing['Business']['image'];
								
						}
?>
<div class="busnissinmianbox">
					<div class="busnissimgfl">
						<?php echo $this->Html->link($this->Image->resize($businessImage, 90, 90, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
					</div>
					<div class="busnisshomeinfr">
						<div class="busnissimgfrhd">
							<?php echo $this->Html->link($listing['Business']['title'], '/businesses/details/'.$this->Fused->encrypt($listing['Business']['id']).'/'.$listing['Business']['alias_name'].'/', array('escape'=>false));?>
						</div>

						<div><?php echo $listing['Business']['city'],', '.$listing['Business']['state_code'];?></div>
						<div class="clr"></div>

						<div>
							<?php
								for($i=1; $i<=5; $i++){
									if($i <= $listing['Business']['rating'])
										echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
									else
										echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
								}
							?>

							<!-- SUBSCRIBE SECTION START -->
							<?php
							if($this->Session->check('Auth.User.User.id')){
								if($this->Fused->validateSubscribedBusiness($listing['Business']['id']) == 0)
									$subscribe = 'subscribe';
								else
									$subscribe = 'unsubscribe';
							?>
							<div class="btnimage" style="float:right; height:25px;">
								<div id="subscribe_div_<?php echo $listing['Business']['id'];?>">
									<a href="javascript:void(0);" onclick="return subscribe_business('<?php echo $subscribe;?>','<?php echo $listing['Business']['id'];?>')"><span><?php echo ucwords($subscribe);?></span></a>
								</div>
							</div>
							<?php
							}
							?>
							<div class="clr"></div>
							<!-- SUBSCRIBE SECTION END -->
						</div>
						<div class="busnisslisttext">
							<?php echo $this->Text->truncate($listing['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));?>
						</div>

						<div id="business_id_<?php echo $listing['Business']['id']; ?>">
						<?php
								$BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($listing['Business']['id']);
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
						<?php } ?>
						</div>
					</div>
					<div class="clr"></div>
				</div>
<?php } ?>