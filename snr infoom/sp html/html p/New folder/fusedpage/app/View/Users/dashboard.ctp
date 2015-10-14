<?php 
if(isset($this->params['id']) && $this->params['id'] != 'profile')
	$page = $this->params['id'];
else
	$page = '';
$this->set('page', $page);
?>

<?php	if($page != ''){
		$profileArr = $this->Fused->fetchUserDetails($page);// pr($profileArr);die;
		$frndArr = $this->Fused->fetch_friendship_details($profileArr['User']['id']);

		$this->set('profileArr', $profileArr);
		$this->set('frndArr', $frndArr);
	}
?>

<!-- for fancybox Start -->
<?php
	echo $this->Html->script('ajax_upload/ajaxupload');

	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<!-- MIDDLE CONTAINER START -->
<div class="userdeshboardmid">
	<!-- FOR NAME & FRIEND/ UNFRIEND SECTION START -->
	<?php
	if($page != ''){
		echo $this->Element('FrontEnd/Inner/other_profile');		
	}
	?>
	<!-- FOR NAME & FRIEND/ UNFRIEND SECTION END -->

	<!-- POST COMMENTS START -->
	<?php if($page == ''){
		echo $this->Element('FrontEnd/Inner/comments');
	}else{
		if((!empty($frndArr)) && ($frndArr['Friend']['friendship_status'] == '1')){
			echo $this->Element('FrontEnd/Inner/comments');
		}
	}
	?>
	<!-- POST COMMENTS END -->

	<!-- FILTER SECTION START -->
	<?php if($page == ''){ ?>
	<?php echo $this->Element('FrontEnd/Inner/filter');?>
	<?php } ?>
	<!-- FILTER SECTION END -->

	<!-- FILTER SECTION START (Saurabh 5/6/2013) -->
	<?php echo $this->Element('FrontEnd/Inner/user_comment');?>
	<!-- FILTER SECTION END (saurabh 5/6/2013)-->

	<!-- PAGE MAIN CONTENT START -->
	<?php if($page == ''){ ?>
	<?php //echo $this->Element('FrontEnd/Inner/page_content');?>
	<?php } ?>
	<!-- PAGE MAIN CONTENT END -->	
</div>
<!-- MIDDLE CONTAINER END -->

<!-- RIGHT SECTION START -->
<div class="deshboardfr">
	<!-- ADD/ CLAIM BUSINESS START -->
	<?php if($page == ''){ ?>
	<?php echo $this->Element('FrontEnd/Inner/add_claim_business');?>
	<?php } ?>
	<!-- ADD/ CLAIM BUSINESS END -->

	<!-- POPULAR BUSINESS START -->
	<?php echo $this->Element('FrontEnd/Inner/popular_business');?>
	<!-- POPULAR BUSINESS END -->

	<!-- POPULAR FEEDS START -->
	<?php if($page == ''){ ?>
	<?php //echo $this->Element('FrontEnd/Inner/popular_feeds');?>
	<?php } ?>
	<!-- POPULAR FEEDS END -->

	<!-- INVITE FRIEND START -->
	<?php if($page == ''){
		if($this->Fused->checkInviteFriends($this->Session->read('Auth.User.User.id')) < 1){;
		?>
	<?php echo $this->Element('FrontEnd/Inner/invite_friend');?>
	<?php } }?>
	<!-- INVITE FRIEND END -->
</div>
<!-- RIGHT SECTION END -->