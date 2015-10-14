<?php
	//pr($profileArr);die;
	//pr($frndArr);die;

	$friend_id = '';
	if(!empty($frndArr))
		$friend_id = $frndArr['Friend']['id'];
?>

<!-- for fancybox Start -->
<?php
	echo $this->Html->Css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->Script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<div>
	<!-- FOR USER NAME START -->
	<div class="userfrbox" style="float:left; width:130px;">
		<?php echo $profileArr['User']['first_name'].' '.$profileArr['User']['last_name'];?>
	</div>
	<!-- FOR USER NAME END -->

	<!-- SCTION FOR FRIEND REQUEST ACCEPT/ IGNORE/ ADD START -->
	<div id="request_main_container"  style="float:right; font-weight:normal;">
		<?php
			if(!empty($frndArr)){
				if($frndArr['Friend']['friendship_status'] == '0'){ // request sent/ received
					if($frndArr['Friend']['request_received'] == $this->Session->read('Auth.User.User.id')){
				?>
						<!-- ACCEPT START -->
						<span class="norbtn">
							<a href="javascript:void(0);" onclick="return validateRequest('accept');">Accept Request</a>
						</span>
						<!-- ACCEPT END -->

						<!-- IGNORE START -->
						<span class="norbtn">
							<a href="javascript:void(0);" onclick="return validateRequest('ignore');">Ignore</a>
						</span>
						<!-- IGNORE END -->
				<?php
					}else{ // request sent
				?>
						<!-- REQUEST SENT START -->
						<span class="norbtn">
							<a href="javascript:void(0);" style="cursor:text">Friend Request Sent</a>
						</span>
						<!-- REQUEST SENT END -->
				<?php
					}
				}elseif($frndArr['Friend']['friendship_status'] == '1'){ // if friend
			?>
					<!-- UNFRIEND START -->
					<span class="norbtn">
						<a href="javascript:void(0);" onclick="return validateRequest('unfriend');">Unfriend</a>
					</span>
					<!-- UNFRIEND START -->
			<?php
				}elseif($frndArr['Friend']['friendship_status'] == '2'){
			?>
				<!-- ACCEPT START -->
				<span class="norbtn">
					<a href="javascript:void(0);" onclick="return validateRequest('accept');">Accept Request</a>
				</span>
				<!-- ACCEPT END -->

				<!-- DELETE START -->
				<span class="norbtn">
					<a href="javascript:void(0);" onclick="return validateRequest('delete');">Decline</a>
				</span>
				<!-- DELETE END -->
			<?php
				}
			}else{ // add friend
		?>
			<!-- ADD FRIEND SECTION START -->
			<span class="norbtn">
				<a href="javascript:void(0);" onclick="return validateRequest('add');">Add Friend</a>
			</span>
			<!-- ADD FRIEND SECTION END -->
		<?php
			}
		?>

		<!-- SEND MAIL SECTION START -->
		<span class="norbtn">
			<?php echo $this->Html->link('Send Mail', '/mails/send_email/'.$profileArr['User']['id'].'/', array('escape'=>false, 'class'=>'fancyclass'));?>
		</span>
		<!-- SEND MAIL SECTION END   -->
	</div>
	<div class="clr"></div>
	<!-- SCTION FOR FRIEND REQUEST ACCEPT/ IGNORE/ ADD END -->
</div>
<div class="clr"></div>

<script type="text/javascript">
function validateRequest(type){
	if(type != 'add'){ // for accept, ignore, delete, unfriend
		var id = "<?php echo $friend_id;?>";
	}else{ // for send frnd rqst
		var id = "<?php echo $profileArr['User']['id'];?>";
	}

	var msg = "Do you want to "+type+" this user?";
	var conf = confirm(msg);
	if(conf == false){
		return false;
	}

	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'friends/other_profile_data/';?>",
		data: "id="+id+"&type="+type,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>'; 
			$('#request_main_container').html(bSend);
		},
		success: function(response){
			$('#request_main_container').html(response);
		}
	});
}
</script>