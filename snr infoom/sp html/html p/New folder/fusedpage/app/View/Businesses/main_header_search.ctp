<?php echo $this->Html->css('rating/jRating.jquery');?>
		<div class="deshboadmidmian">			
			<!--Start deshboard fl part -->
			<?php echo $this->Element('FrontEnd/Inner/left_navigation'); ?>
			<!-- <div class="userdeshboadfl">
				<div class="userdeshboardflin">	
				<?php $categoryArr = $this->Fused->fetchAllBusinessCategories();?>
					<ul class="deshboardfllist">
					<?php foreach($categoryArr as $category){?>
						<li><a class="sel" href="javaScript:void(0);" onclick="searchcategory('<?php echo $category['Category']['id']; ?>')"><?php echo $category['Category']['name']; ?></a></li>
					<?php } ?>
					</ul>
				</div>
			</div> -->
			<!--End deshboard fl part -->
			<!--Start deshboard mid part -->
			<div class="userdeshboardmid" id="category_search">
				<div class="multiplemidbox"> 				
				<div>
				<h1>Search Result</h1>
				<?php
					if(!empty($businessArr)){
						foreach($businessArr as $business){
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
							/* for($i=1; $i<=5; $i++){
								if($i <= $business['Business']['rating'])
									echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
								else
									echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
							} */
							?>

							<div class="exemple">
								<div class="exempleheader" data="<?php echo $business['Business']['rating'];?>_5"></div>
							</div>
						</div>

						<div class="busnisslisttext">
							<?php //echo $this->Text->truncate($business['Business']['about_us'], 50, array('ending'=>'...', 'exact'=>true, 'html'=>true));
								echo $business['Business']['tagline'];
							?>
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
							<?php echo $this->Html->link($this->Image->resize($businessImage, 32, 32, array('alt'=>'')), '/users/profile/'.$BusinessUserImage['User']['username'].'/', array('escape'=>false)).' ';?>
						</div>
						
					</div>
					<?php } ?>
					<div class="clr"></div>
				</div>
					<div class="clr"></div>
				</div>
				<?php } } else { ?>
				<div>No Result Found!</div>
				<?php } ?>
				
			</div>
				</div>
			</div>			
			<!--End deshboard mid part -->
			<!--Start deshboard fr part -->
			<div class="deshboardfr">				
					<div class="insidefrhdbg">
					<div class="fl"><h4>Popular Business</h4></div>
					<!-- <div class="morelink"><a href="#">More</a></div> -->
					<div class="clr"></div>
				</div>
					
					<?php
					$popular_business = $this->Fused->fetchPopularBusiness();
					if(!empty($popular_business)){
					foreach($popular_business as $pop_business){
					$businessImage = 'front_end/business/noimage.jpg';
						if($pop_business['Business']['image'] != ''){
							$imageRealPath = '../webroot/img/front_end/business/'.$pop_business['Business']['image'];
							if(is_file($imageRealPath))
								$businessImage = 'front_end/business/'.$pop_business['Business']['image'];
								
						}
					?>
					<div class="bussinessinmain">
						<div class="bussimgfl">
							<?php echo $this->Html->link($this->Image->resize($businessImage, 71, 58, array('alt'=>'')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
						</div>

						<div class="busnissfrbox">
							<div class="busnissimgfrinhd">
								<?php echo $this->Html->link($this->Text->truncate($pop_business['Business']['title'], 20, array('ending'=>'...')), '/businesses/details/'.$this->Fused->encrypt($pop_business['Business']['id']).'/'.$pop_business['Business']['alias_name'].'/', array('escape'=>false));?>
							</div>

							<div style="font-size:11px;">
								<?php echo $pop_business['Business']['city'],', '.$pop_business['Business']['state_code'];?>
							</div>
						<div class="clr"></div>

						<div>
							<?php
							/* for($i=1; $i<=5; $i++){
								if($i <= $pop_business['Business']['rating'])
									echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
								else
									echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
							} */
							?>

							<div class="exemple">
								<div class="exempleheader" data="<?php echo $pop_business['Business']['rating'];?>_5"></div>
							</div>
						</div>
						<?php echo $this->Text->truncate($pop_business['Business']['tagline'], 20, array('ending'=>'...'));?>	
						</div>
						<div class="clr"></div>
					</div>
				<?php } }?>

					<!-- <div class="popularhd">
						<div class="fl"><h4>Popular Feed</h4></div>
						<div class="morelink"><a href="#">More</a></div>
						<div class="clr"></div>
					</div>
					<div class="popularbox">
						<ul class="popularfeed">
						<li><a href="#">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
						<li><a href="#">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
						<li><a href="#">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
						<li><a href="#">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
					</ul>
					</div> -->
					
						
			</div>
			<!--End deshboard fr part -->
			<div class="clr"></div>
			</div>


<script type="text/javascript">
function searchcategory__(cat_id){
	if(cat_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/category_search/';?>",
			data: "cat_id="+cat_id,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#category_search').html(bSend);
			},
			success: function(response){
				$('#category_search').html(response);
			}
		});
	}
}
</script>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exempleheader').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'small',
			isDisabled:true
		});
	});
</script>
	