<!-- LOAD AJAX IMAGE UPLOAD FILE END -->
<?php  /*if($this->Fused->validateUserForBusiness() == $this->Fused->decrypt($this->params['pass'][0])){*/
	if($this->Fused->validateUserForBusiness($this->Fused->decrypt($this->params['pass'][0])) == 'true'){
		echo $this->Html->script('ajax_upload/ajaxupload');
	}
	echo $this->Html->css('rating/jRating.jquery');
?>
<!-- LOAD AJAX IMAGE UPLOAD FILE START -->
<?php //pr($businessArr);die;?>
<!-- for fancybox Start -->
<?php
	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	var k = jQuery.noConflict();
	k(document).ready(function(){
		k("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->


<?php echo $this->Html->script('FrontEnd/jquery-1.js'); ?>
<?php echo $this->Html->script('FrontEnd/loopedslider'); ?>
<script type="text/javascript">
var j = jQuery.noConflict();
	j(function(){
		j('#loopedSlider').loopedSlider({
			autoStart: 5000,
			restart: 5000
		});
	j('#newsSlider').loopedSlider({
		autoHeight: 400
	});
 });
</script>

<!-- FETCH THE MEMBERSHIP PLAN FOR THE CORRESPONDING BUSINESS START -->
<?php  $businessPlan = (int)$this->Fused->fetchBusinessMembershipPlan($businessArr['Business']['id']);
	$this->set('businessPlan', $businessPlan);
?>
<!-- FETCH THE MEMBERSHIP PLAN FOR THE CORRESPONDING BUSINESS END -->

<div class="insiderightbox" id="category_search">
	<div class="insidetopflbox">
		<div><span class="insidehd"><?php echo $businessArr['Business']['title'];?></span></div>

		<!-- BUSINESS SECTION START -->
		<?php 
			if($businessArr['Business']['image'] != ''){
				$imageFile = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
				if(is_file($imageFile)){
		?>
		<a href="javascript:void(0);" style="width:80px; border:solid 1px #DFDFDF; margin:5px 10px 5px 0; height:80px; float:left; vertical-align:middle; display:inline-block; cursor:default;">
			<?php echo $this->Image->resize('front_end/business/'.$businessArr['Business']['image'], 80, 80, array('alt'=>''));?>
		</a>
		<?php }} ?>
		<!-- BUSINESS SECTION END -->

		<div style="width:200px; float:left;">
			<?php
				if($businessArr['Business']['street'] != '')
					echo '<p>'.$businessArr['Business']['street'].'</p>';
				if($businessArr['Business']['city'] != '')
					echo '<p>'.$businessArr['Business']['city'].', '.$businessArr['Business']['state_code'].', '.$businessArr['Business']['country'].'</p>';
				if($businessArr['Business']['phone'] != '')
					echo '<p>'.$businessArr['Business']['phone'].'</p>';
			?>
			
			<!-- BUSINESS VIEWS START 5/31/2013 -->
			<?php
				if($this->Fused->fetchBusinessOwner($businessArr['Business']['id']) == $this->Session->read('Auth.User.User.id')){ //if business owner
				if($businessPlan > 1){ // if business plan not equal to FREE
			?>
			<div style="float:left; margin-top:10px;">
				<strong>Total views:</strong>
				<?php 
					if($businessPlan > 2){
						echo $this->Html->link($businessArr['Business']['views'], '/businesses/viewed_business/'.$businessArr['Business']['id'], array('escape'=>false, 'style'=>'text-decoration:none; color:blue;', 'class'=>'fancyclass'));
					}else{
						echo $businessArr['Business']['views'];
					}
				?>
			</div>
			<?php } ?>
			<!-- BUSINESS VIEWS END  5/31/2013 -->
			<?php } ?>
		</div>
		

		<!-- SECTION FOR CURRENT PLAN START -->
		<?php	if($this->Session->check('Auth.User.User.id')){
			if($this->Fused->fetchBusinessOwner($businessArr['Business']['id']) == $this->Session->read('Auth.User.User.id')){ //if business owner
		?>
		<div style="float:right; margin-top:70px;">
			<strong>Current Plan:</strong> <?php
			$arr = $this->Fused->fetchAllPlansNames();
			echo $arr[$businessPlan];
			?>
		</div>
		<?php }} ?>
		<!-- SECTION FOR CURRENT PLAN END -->
		

		<div class="clr"></div>
		<!-- DISPLAY FAVORITE MESSAGE START -->
		<?php if($this->Session->check('Auth.User.User.id')){?>
		<div style="float:left;">
			<div class="btnimage fr">
				<a href="<?php echo SITE_PATH.'businesses/edit_business/'.$businessArr['Business']['id'].'/'.$this->params->pass[0].'/';?>"><span>Edit</span></a>
			</div>
		</div>
		<?php } ?>
		<div id="favorite_div" style="margin-top:10px; color:red; float:left"></div>
		<!-- DISPLAY FAVORITE MESSAGE END -->
	</div>

	<!-- FUSEDPAGE RATING START -->
	<div class="insidetopfr" style="width:210px;">
	
		<!-- FOR PREMIUM+ AND ABOVE START 5/31/2013 -->
		<?php if($businessPlan > 2){?>
		<div class="ratingbox" id="overAllRatingBox" style="padding-bottom:8px;">
			Fusedpage rating:
			<?php
				/* for($i=1; $i<=5; $i++){
					if($i <= $businessArr['Business']['rating'])
						echo $this->Html->image('front_end/star_rating_orange.png', array('alt'=>'', 'border'=>0));
					else
						echo $this->Html->image('front_end/star_rating_gray.png', array('alt'=>'', 'border'=>0));
				} */
			?>
			<div class="exemple" style="float:right;"><div class="exemplefused" data="<?php echo $businessArr['Business']['rating'];?>_5"></div></div>
		</div>
		<?php } ?>
		<!-- FOR PREMIUM+ AND ABOVE END 5/31/2013 -->

		<!-- FOR ALL PLANS EXCEPT THE FREE PLAN START 5/31/2013 -->
		<?php if($businessPlan > 1){?>
			<div class="ratingbtmtext">Fusedpage Verified Business</div>
		<?php } ?>
		<!-- FOR ALL PLANS EXCEPT THE FREE PLAN END 5/31/2013 -->


		<!-- CLAIM/ FAVORITE/ EDIT SECTION START -->
		<?php
			if($this->Session->read('Auth.User.User.id') != ''){
				if($this->Fused->fetchBusinessOwner($businessArr['Business']['id']) == $this->Session->read('Auth.User.User.id')){
		?>
			<div class="btnimage fr" style="margin-top:15px;">
				<?php if($this->Fused->fetchMembershipPlan($businessArr['Business']['id']) == 'show'){ ?>
				<label id="add_favorite"><a href="<?php echo str_replace('http://', 'https://', SITE_PATH).'businesses/membership_plans/'.$this->Fused->encrypt($businessArr['Business']['id']).'/';?>" style="margin-right:10px;"><span>Upgrade</span></a></label>
				<?php } ?>
				<label><a href="<?php echo SITE_PATH.'invites/invite_friends/';?>" style="margin-right:10px;"><span>Invite Friends</span></a></label>
			</div>
		<?php		$margin = '15px 10px 0 0;';
				}else{
			?>
			<div class="btnimage fr" style="margin-top:15px;"> <?php //pr($businessArr);die;?>
				<?php if($this->Fused->countFavorite($businessArr['Business']['id']) == 0){ ?>
				<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
				<label id="add_favorite"><a href="JavaScript:void(0);" onclick="return add_favorite(this.value);" style="margin-right:10px;"><span>Add to Favorite</span></a></label>
				<?php } ?>
				<?php } ?>
				
				<?php // for claim section
				    if(empty($businessArr['Business']['user_id'])){?>
					<a href="<?php echo str_replace('http://', 'https://', SITE_PATH).'businesses/membership_plans/'.$this->params->pass[0].'/';?>"><span>Claim</span></a>
				<?php } ?>

			</div>
			<?php  $margin = '15px 0 0 0;';
				}
			}else{
		?>
		<!-- <div class="btnimage fr" style="margin-top:15px;">
			<?php if($this->Fused->countFavorite($businessArr['Business']['id']) == 0){ ?>
			<?php if($this->Session->read('Auth.User.User.id') != ''){ ?>
			<label id="add_favorite"><a href="JavaScript:void(0);" onclick="return add_favorite(this.value);" style="margin-right:10px;"><span>Add to Favorite</span></a></label>
			<?php } ?>
			<?php } ?>

			<a href="<?php echo SITE_PATH.'businesses/membership_plans/'.$this->params->pass[0].'/';?>"><span>Claim</span></a>
		</div> -->
		<?php } ?>
		<!-- CLAIM/ FAVORITE/ EDIT SECTION END -->
	</div>
	<div class="clr"></div>
	<!-- FUSEDPAGE RATING END -->

	<!-- BUSINESS BANNER START -->
	<?php echo $this->Element('FrontEnd/business_banners');?>
	<!-- BUSINESS BANNER END -->



	<!-- MIDDLE PART START -->
	<div class="userdeshboardmid">

		<!-- PAGE MIDDLE NAVIGATION START -->
		<?php echo $this->Element('FrontEnd/business_middle_navigation');?>
		<!-- PAGE MIDDLE NAVIGATION END -->

		<!-- BUSINESS RECENT ACTIVITY START -->
		<?php echo $this->Element('FrontEnd/recent_activity');?>
		<!-- BUSINESS RECENT ACTIVITY END -->

		<!-- BUSINESS ABOUT US START -->
		<?php echo $this->Element('FrontEnd/about_us');?>
		<!-- BUSINESS ABOUT US END -->

		<!-- BUSINESS OFFERS START -->
		<?php echo $this->Element('FrontEnd/offers');?>
		<!-- BUSINESS OFFERS END -->

		<!-- BUSINESS DEALS START -->
		<?php echo $this->Element('FrontEnd/deals');?>
		<!-- BUSINESS DEALS END -->

		<!-- BUSINESS FEEDBACK START -->
		<?php echo $this->Element('FrontEnd/feedback');?>
		<!-- BUSINESS FEEDBACK END -->

		<!-- BUSINESS CONTACT US START -->
		<?php echo $this->Element('FrontEnd/contact_us');?>
		<!-- BUSINESS CONTACT US END -->

		<!-- BUSINESS LOCATION ON MAP START -->
		<?php echo $this->Element('FrontEnd/map');?>
		<!-- BUSINESS LOCATION ON MAP END -->
	</div>			
	<!-- MIDDLE PART START -->

	<!-- PAGE RIGHT SECTION START  -->
	<?php echo $this->Element('FrontEnd/business_right_section');?>
	<!-- PAGE RIGHT SECTION END  -->

	<div class="clr"></div>
</div>

<script type="text/javascript">
function add_favorite(){
	business_id = "<?php echo $businessArr['Business']['id'];?>";

	if(business_id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH;?>favorites/add_to_favorite/",
			data: "business_id="+business_id,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/opc-ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:200px;"));?>'; 
				$('#favorite_div').html(bSend);
			},
			success: function(response){
				$('#favorite_div').html(response);
				$('#add_favorite').hide();
			}
		});
	}
}


function saveComment(feed_id){
	var comment = $('#user_comment_'+feed_id).val();
	var business_feeds_id = $('#business_feeds_'+feed_id).val();
	var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	var membershipPlan = "<?php echo $businessPlan;?>";
	if(comment != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/saveComment/';?>",
				data: "business_feeds_id="+business_feeds_id+"&user_id="+user_id+"&comment="+comment+"&membershipPlan="+membershipPlan,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>"", "style"=>"margin-left:150px;"));?>';
					$('#roller_'+feed_id).html(bSend);
				},
				success: function(response){
						$('#roller_'+feed_id).html('');
						$('#user_comment_'+feed_id).val('');
						$('#comment_div_'+feed_id).append(response);
						
					}
			});
	}
}


function deleteCommentFeed(comment_id){
	if(comment_id != ''){
		var conf = confirm("Do you want to delete this Comment?");
		if(conf == true){
			//send Ajax for Deleting Start
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'comments/delete_comment_data/';?>",
				data: "comment_id="+comment_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#roller_'+comment_id).html(bSend);
				},
				success: function(response){
					if(response == 'deleted'){
						$('#roller_'+comment_id).html('');
						$('#business_comment_'+comment_id).html('');
						$('#business_comment_'+comment_id).hide();
					}
				}
			});
			//send Ajax for Deleting End
		}
	}
}

function recommended(recommended_id){
var user_id = "<?php echo $this->Session->read('Auth.User.User.id'); ?>";
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'recommendeds/add_recommended/';?>",
				data: "recommended_id="+recommended_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
					$('#roller1_'+recommended_id).html(bSend);
					$('#recshow_'+recommended_id).hide();
				},
				success: function(response){
						$('#roller1_'+recommended_id).html('');
						$('#recommended_'+recommended_id).html(response);
						$('#like_'+recommended_id).hide();
						$('#recshow_'+recommended_id).hide();
						$('#rechide_'+recommended_id).show();
						
				}
			});
	}
}

function recommendedImage(feed_id, user_id){
	if(user_id != ''){
		$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'recommendeds/fetch_user_image/';?>",
				data: "feed_id="+feed_id+"&user_id="+user_id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif", array("alt"=>""));?>';
				},
				success: function(response){
						$('#image_'+feed_id).html('');
						$('#image1_'+feed_id).append(response);
				}
			});
	}
}
</script>

<?php echo $this->Html->script('rating/jRating.jquery');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.exemplefused').jRating({
			step:false, // for half star
			length:5, // no. of stars to display
			decimalLength:1, // for decimal length
			rateMax:5, // max stars for rating
			type:'big',
			isDisabled:true
		});
	});
</script>