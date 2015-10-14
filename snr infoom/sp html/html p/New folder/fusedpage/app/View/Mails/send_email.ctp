<?php echo $this->Html->script('ajax_upload/ajaxupload');?>

<div class="userdeshboardmid">
	<div style="margin-bottom:10px;">
		<div class="messagehd"><a href="javascript:void(0);">Send Mail</a></div>
		<div class="clr"></div>		
	</div>	

	<!-- TO INPUT SECTION START -->
	<div class="composetop">
		<div id="email_to_1" style="float:left; margin-right:5px;">
			<div class="composefl">
				<?php echo $this->Html->image('front_end/compose_fl.jpg');?>
			</div>
			<div class="composemid"><?php echo $usrArr['User']['first_name'].' '.$usrArr['User']['last_name'];?></div>
			<div class="composefr"><?php echo $this->Html->image('front_end/compose_fr.jpg');?></div>
		</div>
	</div>
	<!-- TO INPUT SECTION END -->

	<div class="mailbtmboxbg">
		<div class="mailinbox">
			<div class="mailbtmbox">
				<?php echo $this->Form->textarea('message', array('class'=>'textarebox', 'placeholder'=>'Write a message...', 'style'=>'resize:none;'));?>
			</div>

			<div>
				<div id="result" style="float:left; padding:5px;"></div>
				<div class="mailbtmfrsendtn" style="padding:5px;">
					<?php echo $this->Form->submit('front_end/send_btn.jpg', array('div'=>false, 'onclick'=>'return submit_user_message();'));?>
				</div>
				<div class="clr"></div>								
			</div>
		</div>				
	</div>
</div>

<script type="text/javascript">
function submit_user_message(){
	var receiver_id = "<?php echo $usrArr['User']['id'];?>";
	var msg = $('#message').val();

	if(msg != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'mails/submit_profile_message/';?>",
			data: "receiver_id="+receiver_id+"&msg="+msg,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?>';
				$('#result').html(bSend);
			},
			success: function(response){
				//$('#result').html(response);
				if(response == 'sent'){
					$('#result').html('<font color="green">Mail Sent!</font>');
					$.fancybox.close();
				}else{
					$('#result').html('<font color="red">Please Try Later!</font>');
				}
			}
		});
	}
}
</script>