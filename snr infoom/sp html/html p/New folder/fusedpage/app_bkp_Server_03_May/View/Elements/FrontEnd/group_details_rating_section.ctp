<div class="insidefrbox">

	<!-- <div class="ratingbox"><img style="padding-left:0;" alt="" src="../../../img/front_end/rating_star.png"><img alt="" src="../../../img/front_end/rating_star.png"><img alt="" src="../../../img/front_end/rating_star.png"><img alt="" src="../../../img/front_end/rating_star.png"><img alt="" src="../../../img/front_end/rating_star.png"></div>
	<div class="commentfltextin"><span>3  People </span>you know rated this:</div>
	<div class="graybtn"><a href="#">Rate This Business</a></div>
	<div class="commentfltextin"><span>3 People</span> you have know and <span>20 other people</span> recommended this business</div>	 -->

	<div class="peopeimgbox">
			<div class="peopleinsidebox" id="group_recommend">
			<?php $GroupUserImageArr = $this->Fused->fetchGroupUserImage($this->Fused->decrypt($this->params['pass'][0]));
								foreach($GroupUserImageArr as $GroupUserImage){
								$groupImage = 'front_end/business/noimage.jpg';
									if($GroupUserImage['User']['image'] != ''){
										$imageRealPath = '../webroot/img/front_end/users/profile/'.$GroupUserImage['User']['image'];
									if(is_file($imageRealPath))
										$groupImage = 'front_end/users/profile/'.$GroupUserImage['User']['image'];
									} ?>
			
				<div class="peopleimgboxsml">
					<?php echo $this->Image->resize($groupImage, 32, 32, array('alt'=>'')).' '; ?>
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
		
	<?php if($this->Fused->fetchCountGroupRecommend($this->Fused->decrypt($this->params['pass'][0])) < 1){ ?>
		<div class="btnimage" id="recommend"><a href="javascript:void(0);" onclick="return group_recommend('<?php echo $this->Fused->decrypt($this->params['pass'][0]); ?>')"><span>Recommend</span></a></div>
		<?php } ?>
		<span id="group_roller"></span>
		<div class="clr"></div>
</div>

<script type="text/javascript">
function group_recommend(group_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'groups/add_group_recommend/';?>",
				data: "group_id="+group_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#group_roller').html(bSend);
				},
				success: function(response){
						$('#group_roller').html('');
						$('#group_recommend').append(response);
						$('#recommend').hide();
						//$('#unrecommend').show();
						
				}
			});
	}
}
</script>