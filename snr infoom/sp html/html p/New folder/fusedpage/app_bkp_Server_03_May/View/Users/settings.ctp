<?php echo $this->Html->script('FrontEnd/ddaccordion');?>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "expandable", //Shared CSS class name of headers group that are expandable
	contentclass: "categoryitems", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [25], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: true, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: true, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<div class="insiderightbox" style="min-height:460px;">
	<div class="insidehdmain">
		<div class="insideflhd">Account Settings</div>					
		<div class="clr"></div>	
	</div>

	<div>
		<div class="accinbox expandable">
			<div class="acclable">Name</div>
			<div class="accfield"><?php echo $this->data['User']['first_name'].' '.$this->data['User']['last_name'];?></div>
			<div class="accedit"><a href="javascript:void(0);">Edit</a></div>
			<div class="clr"></div>	
		</div>
		<div class="categoryitems passbox">
			<div class="passtext">
				<div style="margin-left:90px;">
					<div class="passlable">First Name:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->text('User.first_name', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'required'=>false));?><span id="span_first_name" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable">Last Name:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->text('User.last_name', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'required'=>false));?><span id="span_last_name" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable">&nbsp;</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Html->image('front_end/save_btn.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'return validate_name();'));?>
						<span id="span_name_save" style="margin-left:10px;"></span>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>


		<div class="accinbox expandable">
			<div class="acclable">Username</div>
			<div class="accfield"><?php echo SITE_PATH.'user/'.'<span id="username_span">'.$this->data['User']['username'].'</span>/';?></div>
			<div class="accedit"><a href="javascript:void(0);">Edit</a></div>
			<div class="clr"></div>	
		</div>

		<div class="categoryitems passbox" id="username_main_div">
			<div class="passtext">
				<div style="margin-left:76px;">
					<div class="passlable" style="width:210px;"><?php echo SITE_PATH.'user/';?></div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->text('User.username', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'required'=>false));?><span id="span_first_name" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable" style="width:210px;">&nbsp;</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Html->image('front_end/save_btn.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'return validate_username();'));?>
					</div>
					<div id="span_username_save" style="margin-left:10px;"></div>
					<div class="clr"></div>
				</div>
			</div>
		</div>

		<div class="accinbox expandable">
			<div class="acclable">Email</div>
			<div class="accfield"><span id="email_span"><?php echo $this->data['User']['email'];?></span></div>
			<div class="accedit"><a href="javscript:void(0);">Edit</a></div>
			<div class="clr"></div>	
		</div>

		<div class="categoryitems passbox">
			<div class="passtext">
				<div style="margin-left:76px;">
					<div class="passlable" style="width:0px;">&nbsp;</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->text('User.email', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'required'=>false));?><span id="span_email_error" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable" style="width:0px;">&nbsp;</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Html->image('front_end/save_btn.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'return validate_email();'));?>
						<span id="span_email_save" style="margin-left:10px;"></span>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>

		<div class="accinbox expandable">
			<div class="acclable">Password</div>
			<div class="accfield">Change Password</div>
			<div class="accedit"><a href="javascript://" onclick="show_box('popup1')">Edit</a></div>
			<div class="clr"></div>
		</div>

		<div class="categoryitems passbox">	
			<div class="passtext">
				<div style="margin-left:90px;">
					<div class="passlable">Current:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->password('User.current', array('div'=>false, 'label'=>false, 'class'=>'passinput'));?>
						<span id="span_current" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable">New:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->password('User.new', array('div'=>false, 'label'=>false, 'class'=>'passinput'));?>
						<span id="span_new" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable">Confirm:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->password('User.confirm', array('div'=>false, 'label'=>false, 'class'=>'passinput'));?>
						<span id="span_confirm" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<div class="passlable">&nbsp;</div>
					<div class="stepfieldfr" style="float:left; width:390px;">
						<?php echo $this->Html->image('front_end/save_btn.png', array('alt'=>'', 'style'=>'cursor:pointer;', 'onclick'=>'return validate_password();'));?>
						<span id="span_password_save" style="margin-left:10px;"></span>
					</div>
					<div class="clr"></div>
				</div>
			</div>
		</div>

		<!-- Change Image Start -->
		<div class="accinbox expandable">
			<div class="acclable">Profile Image</div>
			<div class="accfield">Change Image</div>
			<div class="accedit"><a href="javascript://" onclick="show_box('popup1')">Edit</a></div>
			<div class="clr"></div>
		</div>

		<div class="categoryitems passbox">	
			<div class="passtext">
				<div style="margin-left:90px;">
				<?php echo $this->Form->create('User', array('action'=>'settings', 'type'=>'file', 'onsubmit'=>'return validateForm();'));?>
					<div class="passlable">Upload:</div>
					<div class="stepfieldfr" style="float:left;">
						<?php echo $this->Form->input('User.image', array('div'=>false, 'label'=>false, 'class'=>'passinput', 'type'=>'file'));?>
						<span id="span_current" style="color:#FF0000;"></span>
					</div>
					<div class="clr"></div>

					<?php echo $this->Form->hidden('User.old_image', array('value'=>$this->data['User']['image']));?>

					<div class="passlable">&nbsp;</div>
					<div class="stepfieldfr" style="float:left; width:390px;">
						<?php echo $this->Form->submit('front_end/save_btn.png', array('div'=>false));?>
						<span id="span_image_save" style="margin-left:10px;"></span>
					</div>
					<div class="clr"></div>
				<?php echo $this->Form->end();?>
				</div>
			</div>
		</div>
		<!-- Change Image End -->
		

	</div>

	<div class="insidehdmain" style="margin-top:50px;">
		<div class="insideflhd">Social Media Authentication</div>					
		<div class="clr"></div>	
	</div>

	<div>
		<?php $socialsValidate = $this->Fused->authticateSocialAccounts();
			/*----------- TWITTER START  ------------------------*/
			if($socialsValidate['twitter'] == 'authenticated'){
				$twitterBorder = '2px solid green;';
				$twitterMessage = 'Authenticated';

			}else{
				$twitterBorder = '2px solid red;';
				$twitterMessage = 'Authenticate Twitter Account';
			}
			//for twitter Auth Start
			echo $this->Html->link($this->Html->image('front_end/twitter_logo.jpg', array('alt'=>'', 'style'=>"border:$twitterBorder")), '/users/login_twitter/', array('escape'=>false, 'title'=>$twitterMessage));
			/*----------- TWITTER END  ---------------------------*/

			/*----------- FACEBOOK START  ------------------------*/
			if($socialsValidate['facebook'] == 'authenticated'){
				$facebookBorder = '2px solid green;';
				$facebookMessage = 'Authenticated';

			}else{
				$facebookBorder = '2px solid red;';
				$facebookMessage = 'Authenticate Facebook Account';
			}

			//for facebook Auth Start
			echo $this->Html->link($this->Html->image('front_end/face_book_logo_inside.jpg', array('alt'=>'', 'style'=>"border:$facebookBorder;")), '/users/login_facebook/', array('escape'=>false, 'title'=>$facebookMessage, 'style'=>'margin-left:10px;'));
			/*----------- FACEBOOK END  ----------------------------*/
		?>
	</div>
</div>

<script type="text/javascript">
function validate_name(){
	var first_name = $('#UserFirstName').val();
	var last_name = $('#UserLastName').val();

	if(first_name == ''){
		$('#span_first_name').html('First Name Required');
		$('#UserFirstName').focus();
		return false;
	}

	if(last_name == ''){
		$('#span_last_name').html('Last Name Required');
		$('#UserLastName').focus();
		return false;
	}

	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'users/save_name_details/';?>",
		data: "first_name="+first_name+"&last_name="+last_name,
		beforeSend:function(){
			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>';
			$('#span_name_save').html(bSend);
		},
		success: function(response){
			if(response == 'saved')
				$('#span_name_save').html('<font color="green">Name Saved Succesfully!!');
			else
				$('#span_name_save').html('<font color="red">Please Try Later!!');
		}
	});	
}

function validate_username(){
	var username = $('#UserUsername').val();
	if(username == ''){
		$('#span_username_save').html(' Required');
		$('#UserUsername').focus();
		return false;
	}else{
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'users/save_username';?>",
			data: "username="+username,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>';
				$('#span_username_save').html(bSend);
			},
			success: function(response){
				$('#span_username_save').html(response);
				if(response == '<font color="green">Username Changed Successfully!</font>'){
					$('#username_span').html(username);
				}
			}
		});
	}
}

function validate_email(){
	var email = $('#UserEmail').val();
	if(email == ''){
		$('#span_email_error').html(' Required');
		$('#UserEmail').focus();
		return false;
	}else{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(email) == false){
			$('#span_email_error').html('Invalid Email!!');
			return false;
		}else{
			//send the ajax call
			$.ajax({
				type: "POST",
				url: "<?php echo SITE_PATH.'users/save_new_email';?>",
				data: "email="+email,
				beforeSend:function(){
					var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>';
					$('#span_email_error').html(bSend);
				},
				success: function(response){
					$('#span_email_error').html(response);
				}
			});
		}
	}
}

function  validate_password(){
	var current = $('#UserCurrent').val();
	var newPass = $('#UserNew').val();
	var confirm = $('#UserConfirm').val();

	if(current == ''){
		$('#span_current').html(' Required');
		$('#UserCurrent').focus();
		return false;
	}

	if(newPass == ''){
		$('#span_new').html(' Required');
		$('#UserNew').focus();
		return false;
	}

	if(confirm == ''){
		$('#span_confirm').html(' Required');
		$('#UserConfirm').focus();
		return false;
	}

	if(newPass != confirm){
		$('#span_confirm').html(' Both Passwords Should Be Same');
		$('#UserConfirm').focus();
		return false;
	}else{
		//hide all errors
		$('#span_current').html('');
		$('#span_new').html('');
		$('#span_confirm').html('');

		//send ajax
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'users/save_new_password';?>",
			data: "current="+current+"&newPass="+newPass+"&confirm="+confirm,
			beforeSend:function(){
				var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0"));?>';
				$('#span_password_save').html(bSend);
			},
			success: function(response){
				$('#span_password_save').html(response);
			}
		});
	}

}

function validateForm(){
	var imagename = $('#UserImage').val();
	var imageArr = imagename.split(".");
	var ext = imageArr[imageArr.length-1];
	if((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')){
		return true;
	}else{
		$('#span_image_save').html('<font color="red">Please upload *.jpg, *.gif, *.png image only</font>');
		return false;
	}
}
</script>