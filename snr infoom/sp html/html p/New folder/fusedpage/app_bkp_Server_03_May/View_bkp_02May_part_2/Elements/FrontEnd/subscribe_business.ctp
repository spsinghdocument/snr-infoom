<div class="insidefrbox">	
	<!-- <div class="commentfltextin"><span>3  People </span>you know rated this:</div>
	<div class="commentfltextin">
		<span>3 People</span> you have know and <span>20 other people</span> recommended this business
	</div> -->	
	<div class="peopeimgbox">
		<div class="peopleinsidebox">
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
		</div>

		<div class="peopleinsidebox">
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
		</div>
	</div>

	<!-- BUSINESS OWNER CANNOT SEE THE SUBSCRIBE BUTTON -->
	<?php 
	if($this->Session->check('Auth.User.User.id')){
	if($this->Fused->fetchBusinessOwner($this->Fused->decrypt($this->params['pass'][0])) != $this->Session->read('Auth.User.User.id')){?>
	<div class="btnimage">
		<div id="subscribe_div">
			<?php
				$subscribeCount = $this->Fused->validateSubscribedBusiness($this->Fused->decrypt($this->params['pass'][0]));
				if($subscribeCount == 0){
			?>
			<a href="javascript:void(0);" onclick="return subscribe_business('subscribe')"><span>Subscribe</span></a>
			<?php
			}else{
			?>
			<a href="javascript:void(0);" onclick="return subscribe_business('unsubscribe');"><span>Subscribed</span></a>
			<?php } ?>
		</div>
	</div>
	<?php }}?>
	<div class="clr"></div>
</div>


<script type="text/javascript">
function subscribe_business(type){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'business_subscribers/subscribe_business/';?>",
		data: "business_id=<?php echo $this->Fused->decrypt($this->params['pass'][0]);?>"+"&type="+type,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>';
			$('#subscribe_div').html(bSend);
		},
		success: function(response){
			$('#subscribe_div').html(response);
		}
	});
}
</script>