<?php //pr($viewListing); ?>
<!-- for fancybox Start -->
<?php
	echo $this->Html->css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->
<?php //pr($viewListing); die; ?>

<!--Start inside right part -->
<?php //echo $this->Form->create('Friend', array('action'=>'search_friends'));?>
			<div class="insiderightbox">
				<div class="insidehdmain">
					<div class="insideflhd">Received Requests</div>
					<div class="searchfrbox">
					<?php echo $this->Form->input('Friend.search_keyword', array('onkeyup'=>'autosuggation(this.value);', 'label'=>false, 'div'=>false, 'class' =>'searchinputfr', 'error'=>false,'value'=>'Search and add friends', 'onfocus'=>'clearText(this)', 'onblur'=>'replaceText(this)')); ?><?php echo $this->Html->image('front_end/search_icon_fr.jpg', array('alt'=>'', 'border'=>0, 'style'=>'cursor:pointer; vertical-align:bottom;', 'onclick'=>'return search_friend(this.value);')); ?>
					<div id="suggestions" style="border:1px solid #CDCDCD; width:337px; display:none; position:absolute; background-color:#FFFFFF; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
					</div>
					<div class="clr"></div>	
				</div>
<div id="search_div">
			<?php if(!empty($viewListing)){
			$i = 0;
				foreach($viewListing as $listing){
				$userImage = 'front_end/business/noimage.jpg';
					if($listing['Sent']['image'] != ''){
						$imageRealPath = '../webroot/img/front_end/users/profile/'.$listing['Sent']['image'];
						if(is_file($imageRealPath))
							$userImage = 'front_end/users/profile/'.$listing['Sent']['image'];
							
					}
					$username = $listing['Sent']['username'];
				if($i%2 == 0){
				$class = "friendmainbox";
				$class1 = '';
				} else {
				$class = "friendmainbox last";
				$class1 = '<div class="clr"></div>';
				}
			?>
				<div class="<?php echo $class; ?>">
					<div class="friendimgbox">
						<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a>
					</div>
					<div class="friendfrbox">
						<div class="friendhd">
							<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $listing['Sent']['first_name']." ".$listing['Sent']['last_name'].", ".$listing['Sent']['city']; ?></a>
						</div>
						<div class="friendsmltext">
							<?php echo $listing['Sent']['state'];?>
						</div>
						<div class="friendsharelink" id="accept_request_<?php echo $listing['Friend']['id'];?>">
							<a href="JavaScript:void(0);" style="padding-left:0;" onclick="return accept_request('<?php echo $listing['Friend']['id'];?>');">Accept Request</a>|<a href="JavaScript:void(0);" onclick="deny_friend('<?php echo $listing['Friend']['id'];?>');">Ignore</a>
						</div>
					</div>
				</div>
				<?php echo $class1; ?>
				
			<?php } }else{ ?>
			<div style="pading-top:10px; color:red; padding-left:250px;">No Friends Requests Available!!</div>
			<?php } ?>
</div>				
			</div> <!-- <div class="clr"></div> -->
<?php //echo $this->Form->end(); ?>		
			<!--End inside right part -->


<!-- SECTION FOR IGNORED FRIENDS START -->
<?php
	$ignoredArr = $this->Fused->ignoredFriends();
	if(!empty($ignoredArr)){
?>
<div class="insiderightbox" style="margin-top:30px;">
	<div class="insidehdmain">
		<div class="insideflhd">Ignored Friend Requests</div>
		<div class="clr"></div>	
	</div>
</div>

<?php	$i = 0;
	foreach($ignoredArr as $listing){
	$userImage = 'front_end/business/noimage.jpg';
	if($listing['Sent']['image'] != ''){
		$imageRealPath = '../webroot/img/front_end/users/profile/'.$listing['Sent']['image'];
		if(is_file($imageRealPath))
			$userImage = 'front_end/users/profile/'.$listing['Sent']['image'];
			
	}
	$username = $listing['Sent']['username'];
	if($i%2 == 0){
	$class = "friendmainbox";
	$class1 = '';
	} else {
	$class = "friendmainbox last";
	$class1 = '<div class="clr"></div>';
	}
?>
	<div class="<?php echo $class; ?>">
		<div class="friendimgbox"><a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $this->Image->resize($userImage, 71, 58, array('alt'=>'')); ?></a></div>
		<div class="friendfrbox">
			<div class="friendhd">
				<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $listing['Sent']['first_name']." ".$listing['Sent']['last_name'].", ".$listing['Sent']['city']; ?></a>
			</div>
			<div class="friendsmltext">
				<?php echo $listing['Sent']['state']; ?> 
			</div>
			<div class="friendsharelink" id="accept_request_<?php echo $listing['Friend']['id'];?>">
				<a href="javascript:void(0);" style="padding-left:0;" onclick="return accept_request('<?php echo $listing['Friend']['id'];?>');">Accept Request</a>|<a href="javascript:void(0);" onclick="delete_friend_request('<?php echo $listing['Friend']['id']; ?>');">Decline</a>
			</div>
		</div>
	</div>
	<?php echo $class1; ?>

<?php }} ?>
<!-- SECTION FOR IGNORED FRIENDS END -->

<script type="text/javascript">
function search_friend(){
$('#suggestions').hide();
	var keyword = $('#FriendSearchKeyword').val();
	if(keyword != 'Search and add friends'){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/search_friend/';?>",
			data: "keyword="+keyword,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader1.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#search_div').html(bSend);
			},
			success: function(response){
				$('#search_div').html(response);
			}
		});
	}
}

function autosuggation(){
	$('#searchbox').show();
	var searchkey = $('#FriendSearchKeyword').val();
	if(searchkey != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/auto_data/';?>",
			data: "searchkey="+searchkey,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/loading.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#suggestions').show();
				$('#suggestions').html(bSend);
			},
			success: function(response){
				$('#suggestions').html(response);
			}
		});
	}
}

function setData(name){
	$('#FriendSearchKeyword').val(name);
	$('#suggestions').hide();
}

function accept_request(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/accept_request/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif",array("alt"=>""));?>'; 
				$('#accept_request_'+id).html(bSend);
				
			},
			success: function(response){
				$('#accept_request_'+id).html('<font color="green">Request Accepted!!</font>');
				var redirectUrl = "<?php echo SITE_PATH.'friends/listings/';?>";
				window.location.href = redirectUrl;
				
			}
		});
	}
}

function deny_friend(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/deny_friend/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif",array("alt"=>""));?>'; 
				$('#accept_request_'+id).html(bSend);
				
			},
			success: function(response){
				$('#accept_request_'+id).html('<font color="green">Request Ignored!!</font>');
				var redirectUrl = "<?php echo SITE_PATH.'friends/listings/';?>";
				//window.location.href = redirectUrl;
				window.location.reload();
				
			}
		});
	}
}

function delete_friend_request(id){
	if(id != ''){
		var conf = confirm('Do you want to delete this friend request?');
		if(conf == true){
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'friends/delete_friend_request/';?>",
				data: "id="+id,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif",array("alt"=>""));?>'; 
					$('#accept_request_'+id).html(bSend);
				},
				success: function(response){
					if(response == 'error'){
						$('#accept_request_'+id).html('<font color="red">Error!!</font>');
					}else{
						$('#accept_request_'+id).html('<font color="green">Deleted!</font>');
						window.location.reload();
					}
				}
			});
		}else
			return false;
	}else
		return false;
}
</script>
