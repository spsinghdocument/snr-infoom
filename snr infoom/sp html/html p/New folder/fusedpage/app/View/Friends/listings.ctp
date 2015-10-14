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
					<div class="insideflhd">Friends</div>
					<div class="searchfrbox">
					<?php echo $this->Form->input('Friend.search_keyword', array('onkeyup'=>'autosuggation(this.value);', 'label'=>false, 'div'=>false, 'class' =>'searchinputfr', 'error'=>false,'placeholder'=>'Search and add friends')); ?><?php echo $this->Html->image('front_end/search_icon_fr.jpg', array('alt'=>'', 'border'=>0, 'style'=>'cursor:pointer; vertical-align:bottom;', 'onclick'=>'return search_friend(this.value);')); ?>
					<div id="suggestions" style="border:1px solid #CDCDCD; width:337px; display:none; position:absolute; background-color:#FFFFFF; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
					</div>
					<div class="clr"></div>	
				</div>
<div id="search_div">
			<?php if(!empty($viewListing)){
			$i = 0;
				foreach($viewListing as $listing){
				if($listing['Friend']['request_sent'] != $this->Session->read('Auth.User.User.id'))
					$validModelType = 'Sent';
				else
					$validModelType = 'Received';

				$userImage = 'front_end/business/noimage.jpg';
					if($listing[$validModelType]['image'] != ''){
						$imageRealPath = '../webroot/img/front_end/users/profile/'.$listing[$validModelType]['image'];
						if(is_file($imageRealPath))
							$userImage = 'front_end/users/profile/'.$listing[$validModelType]['image'];
							
					}
				$username = $listing[$validModelType]['username'];
				
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
							<a href="<?php echo SITE_PATH.'users/profile/'.$username.'/';?>"><?php echo $listing[$validModelType]['first_name']." ".$listing[$validModelType]['last_name'].", ".$listing[$validModelType]['city']; ?></a>
						</div>
						<div class="friendsmltext">
							<?php echo $listing[$validModelType]['state'];?>
						</div>
						<?php if($listing['Friend']['friendship_status'] == '0'){ ?>
						<div class="friendsharelink">
							<a href="JavaScript:void(0);" style="padding-left:0; color:green;">Friend Requested</a>|<a href="JavaScript:void(0);" onclick="return unfriend('<?php echo $listing['Friend']['id']; ?>');" style="color:red;">Unfriend</a>
						</div>
						<?php } else { ?>
						<div class="friendsharelink">
							<a href="JavaScript:void(0);" onclick="return unfriend('<?php echo $listing['Friend']['id']; ?>');" style="color:red; padding-left:0;">Unfriend</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php echo $class1;?>
			<?php $i++; } } else { ?>
			<div style="pading-top:10px; color:red; padding-left:250px;"><strong>No Friends Availables!!</strong></div>
			<?php } ?>
</div>				
			</div>
			<!-- <div class="clr"></div> -->
<?php //echo $this->Form->end(); ?>		
			<!--End inside right part -->

<script type="text/javascript">
function search_friend(){
$('#suggestions').hide();
	var keyword = $('#FriendSearchKeyword').val();
	if(keyword != ''){
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

function autosuggation(searchkey){
	if(searchkey.length > 0){
		$('#searchbox').show();
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
	}else{
		$('#searchbox').hide();
		$('#suggestions').hide();
	}
}

function setData(name){
	$('#FriendSearchKeyword').val(name);
	$('#suggestions').hide();
}

function sent_request(sent_request){
	if(sent_request != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/sent_request/';?>",
			data: "sent_request="+sent_request,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#sent_request_'+sent_request).html(bSend);
				$('#sent_request1_'+sent_request).hide();
				
			},
			success: function(response){
				$('#sent_request_'+sent_request).hide();
				$('#sent_request_search_'+sent_request).hide();
				$('#sent_request1_'+sent_request).show();
				$('#sent_request1_search_'+sent_request).show();
				
			}
		});
	}
}


function unfriend(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'friends/unfriend/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/loading.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#accept_request').html(bSend);
				var redirectUrl = "<?php echo SITE_PATH.'friends/listings/';?>";
				window.location.href = redirectUrl;
			}
		});
	}
}
</script>
