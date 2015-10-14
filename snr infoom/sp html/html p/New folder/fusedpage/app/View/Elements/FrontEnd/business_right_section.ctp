<div class="deshboardfr">
	<!-- MAP IT SECTION START -->
	<div class="mapitbox">
		<div class="btnimage fr"><a href="javascript:void(0);" id="a7" onclick="ShowHomeTab('pulic_7','a7'), load_map()"><span>Map It</span></a></div>
		<div class="clr"></div>
	</div>
	<!-- MAP IT SECTION END -->

	<!-- RECOMMEND SECTION START -->
	<div class="insidefrbox">
	<span style="color:#006EBD;"><strong>Business Rating</strong></span>
		<!-- RATING SECTION START -->
		<?php echo $this->Element('FrontEnd/rating_box');?>
		<!-- RATING SECTION END -->

		<!-- <div class="commentfltextin">
			<span>3 People</span> you have know and <span>20 other people</span> recommended this business
		</div> -->	
		<span style="color:#006EBD;"><strong>Recommended Friends</strong></span>
		<div class="peopeimgbox">
			<div class="peopleinsidebox" id="business_recommend">
			<?php $BusinessUserImageArr = $this->Fused->fetchBusinessUserImage($this->Fused->decrypt($this->params['pass'][0]));
								foreach($BusinessUserImageArr as $BusinessUserImage){
									$username = $BusinessUserImage['User']['username'];
								$businessImage = 'front_end/business/noimage.jpg';
									if($BusinessUserImage['User']['image'] != ''){
										$imageRealPath = '../webroot/img/front_end/users/profile/'.$BusinessUserImage['User']['image'];
									if(is_file($imageRealPath))
										$businessImage = 'front_end/users/profile/'.$BusinessUserImage['User']['image'];
									} ?>
				<div class="peopleimgboxsml">
					<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($businessImage, 32, 32, array('alt'=>'')).' '; ?></a>
				</div>
				<?php } ?>
				<div class="clr"></div>
			</div>
		</div>	
		<?php if($this->Fused->fetchCountBusinessRecommend($this->Fused->decrypt($this->params['pass'][0])) < 1){ ?>
		<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
		<div class="btnimage" id="recommend"><a href="javascript:void(0);" onclick="return business_recommend('<?php echo $this->Fused->decrypt($this->params['pass'][0]); ?>')">
		<?php if($this->Fused->fetchCountTotalBusinessRecommend($this->Fused->decrypt($this->params['pass'][0])) < 1){ ?>
		<span>Be the first to Recommend this...</span>
		<?php } else { ?>
		<span>Recommend</span>
		<?php } ?>
		</a></div>
		<?php } ?>
		<?php } ?>
		<span id="business_roller"></span>
		<div class="clr"></div>
	</div>


	<!-- SUBSCRIBE SECTION START -->
	<span style="color:#006EBD;"><strong>Subscribers</strong></span>
	<?php echo $this->element('FrontEnd/subscribe_business');?>
	<!-- SUBSCRIBE SECTION END -->

	<!-- INVITE FRIEND START -->
		<?php
			if($this->Fused->checkInviteFriends($this->Session->read('Auth.User.User.id')) < 1){
				echo $this->Element('FrontEnd/Inner/invite_friend');
			}
		?>
	<!-- INVITE FRIEND END -->
	
	<!-- RECOMMEND SECTION END -->

	<!-- POPULAR FEED START -->
	<!-- <?php $populaFeedArr = $this->Fused->fetchMostPopularFeed(); ?>
	<?php if(!empty($populaFeedArr)){ ?>
	<div class="popularhd">
		<div class="fl"><h4>Popular Feed</h4></div>
		<div class="clr"></div>
	</div>
	<?php } ?>
	<div class="popularbox">
		<ul class="popularfeed">
		<?php if(!empty($populaFeedArr)){ 
		   foreach($populaFeedArr as $populaFeed) { ?>
			 <li><?php echo $this->Html->link($populaFeed['Business']['title'], '/businesses/details/'.$this->Fused->encrypt($populaFeed['Business']['id']).'/'.$populaFeed['Business']['alias_name'].'/', array('escape'=>false));?></li>
			<?php } } ?>
		</ul>
	</div> -->
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