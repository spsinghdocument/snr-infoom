<?php //pr($profileArr); ?>
<div>
	<div class="userfrbox" style="width:120px;">
		<?php echo $profileArr['User']['first_name'].' '.$profileArr['User']['last_name'];?>
	</div>
	<span id="loder"></span>
	<div class="userfrbox" style="float:right; font-weight:normal;">
	<?php
		if(!empty($frndArr)){ //pr($frndArr);die;
			if($frndArr['Friend']['friendship_status'] == '1'){
	?>
			<span id="unfriend">
			<a href="JavaScript:void(0);" onclick="return unfriendother('<?php echo $profileArr['User']['id']; ?>');">Unfriend</a></span>
	<?php
			}elseif($frndArr['Friend']['friendship_status'] == '0'){
				if($frndArr['Friend']['request_sent'] == $this->Session->read('Auth.User.User.id')){
	?>
				<span id="request_sent">Friend Request Sent</span>
	<?php
				}else{
	?>
				<span id="request_receive" onclick="return accpet_request('<?php echo $frndArr['Friend']['id'];?>');" style="cursor:pointer;">Accept Request<span>
	<?php
				}
			}else{ ?>
				<span id="add_friend"><a href="JavaScript:void(0);" onclick="sent_request('<?php echo $profileArr['User']['id']; ?>');" style="padding-left:0;">Add as Friend</a></span>
			<?php }
		}else{ ?>
			<span id="add_friend"><a href="JavaScript:void(0);" onclick="sent_request('<?php echo $profileArr['User']['id']; ?>');" style="padding-left:0;">Add as Friend</a></span>
		<?php }
	?>
	<!-- FOR RESPONCE -->
		<span id="add_friend" style="display:none;">
			<a href="JavaScript:void(0);" onclick="sent_request('<?php echo $profileArr['User']['id']; ?>');" style="padding-left:0;">Add as Friend</a>
		</span>
		<span id="request_sent" style="display:none;">Request Sent</span>
		<span id="unfriend" style="display:none;">
			<a href="JavaScript:void(0);" onclick="return unfriendother('<?php echo $profileArr['User']['id']; ?>');">Unfriend</a>
		</span>

	<!-- FOR RESPONCE -->
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>



<script type="text/javascript">
function sent_request(sent_request){
	if(sent_request != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/sent_request/';?>",
			data: "sent_request="+sent_request,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#loder').html(bSend);
				$('#add_friend').hide();
				
			},
			success: function(response){
				$('#loder').html('');
				$('#add_friend').hide();
				$('#request_sent').show();
			}
		});
	}
}


function unfriendother(id){
	if(id != ''){
		//alert(id); return false;
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/unfriendother/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#loder').html(bSend);
			},
			success: function(response){
				$('#loder').html('');
				$('#unfriend').hide();
				$('#add_friend').show();
			}
		});
	}
}

function accpet_request(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/accept_request/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif",array("alt"=>""));?>'; 
				$('#request_receive').html(bSend);
				
			},
			success: function(response){
				$('#request_receive').html(response);
				$('#add_friend').show();
				/* var redirectUrl = "<?php echo SITE_PATH.'friends/listings/';?>";
				window.location.href = redirectUrl; */
				
			}
		});
	}
}
</script>