<div class="deshboardfr">
	<!-- MAP IT SECTION START -->
	<div class="mapitbox">
		<div class="btnimage fr"><a href="javascript:void(0);" id="a7" onclick="ShowHomeTab('pulic_7','a7'), load_map()"><span>Map It</span></a></div>
		<div class="clr"></div>
	</div>
	<!-- MAP IT SECTION END -->

	<!-- RECOMMEND SECTION START -->
	<div class="insidefrbox">
		<!-- RATING SECTION START -->
		<?php echo $this->Element('FrontEnd/rating_box');?>
		<!-- RATING SECTION END -->

		<!-- <div class="commentfltextin">
			<span>3 People</span> you have know and <span>20 other people</span> recommended this business
		</div> -->	
		<div class="peopeimgbox">
			<div class="peopleinsidebox" id="business_recommend">
			<?php $BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($this->Fused->decrypt($this->params['pass'][0]));
								foreach($BusinessUserImageArr as $BusinessUserImage){
								$businessImage = 'front_end/business/noimage.jpg';
									if($BusinessUserImage['User']['image'] != ''){
										$imageRealPath = '../webroot/img/front_end/users/profile/'.$BusinessUserImage['User']['image'];
									if(is_file($imageRealPath))
										$businessImage = 'front_end/users/profile/'.$BusinessUserImage['User']['image'];
									} ?>
				<div class="peopleimgboxsml">
					<?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?>
				</div>
				<?php } ?>
				<div class="clr"></div>
			</div>

			<!-- <div class="peopleinsidebox">
				<div class="peopleimgboxsml">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img1.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img2.jpg', array('alt'=>''));?></a>
				</div>
				<div class="peopleimgboxsml">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img3.jpg', array('alt'=>''));?></a>
				</div>
				<div class="peopleimgboxsml">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img4.jpg', array('alt'=>''));?></a>
				</div>
				<div class="peopleimgboxsml">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img5.jpg', array('alt'=>''));?></a>
				</div>
				<div class="peopleimgboxsml">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/people_img6.jpg', array('alt'=>''));?></a>
				</div>						
				<div class="clr"></div>
			</div> -->
		</div>	
		<?php if($this->Fused->fetchCountBusinessRecommend($this->Fused->decrypt($this->params['pass'][0])) < 1){ ?>
		<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div class="btnimage" id="recommend"><a href="javascript:void(0);" onclick="return business_recommend('<?php echo $this->Fused->decrypt($this->params['pass'][0]); ?>')"><span>Recommend</span></a></div>
		<?php } ?>
		<?php } ?>
		<span id="business_roller"></span>
		<div class="clr"></div>
	</div>

	<!-- SUBSCRIBE SECTION START -->
	<?php echo $this->element('FrontEnd/subscribe_business');?>
	<!-- SUBSCRIBE SECTION END -->
	
	<!-- RECOMMEND SECTION END -->

	<!-- POPULAR FEED START -->
	<div class="popularhd">
		<div class="fl"><h4>Popular Feed</h4></div>
		<div class="morelink"><a href="javascript:void(0);">More</a></div>
		<div class="clr"></div>
	</div>

	<div class="popularbox">
		<ul class="popularfeed">
			<li><a href="javascript:void(0);">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
			<li><a href="javascript:void(0);">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
			<li><a href="javascript:void(0);">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
			<li><a href="javascript:void(0);">Lorem ipsum dolor sit amet Duis diamquam, mollis vitae dictum sit amet...</a></li>
		</ul>
	</div>
	<!-- POPULAR FEED END -->
</div>


<script type="text/javascript">
function business_recommend(business_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'businesses/add_business_recommend/';?>",
				data: "business_id="+business_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#business_roller').html(bSend);
				},
				success: function(response){
						$('#business_roller').html('');
						$('#business_recommend').append(response);
						$('#recommend').hide();
						//$('#unrecommend').show();
						
				}
			});
	}
}
</script>