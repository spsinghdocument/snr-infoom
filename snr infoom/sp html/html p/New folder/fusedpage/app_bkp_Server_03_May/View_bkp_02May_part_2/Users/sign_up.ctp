<?php
	function createArrayDropDown($start, $end){
		$ret = '';
		for($i=$end; $i>=$start; $i--)
			$ret[$i] = $i;
		return $ret;
	}

	function listMonths(){
		return array('01'=>'Jan', '02'=>'Feb', '03'=>'March', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>'Jul', '08'=>'Aug', '09'=>'Sept', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');
	}
?>

<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#UserSignUpForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->

<h3>Sign Up</h3>
<div class="pleasetext">Please fill the below fields, and create your accounts! </div>

<!--Start step fl box -->
<div class="stepboxfl">
	<ul class="steptab">
		<li class="sel">Step 1</li>
		<li>Step 2</li>
	</ul>
	<div class="clr"></div>

	<div class="stepinsidebox">
		<div class="stepboinside">
		<?php 
			echo $this->Form->create('User', array('action'=>'sign_up'));
			echo $this->Form->hidden('User.id');
			echo $this->Form->hidden('User.country');
			echo $this->Form->hidden('User.state');
			echo $this->Form->hidden('User.state_code');
			echo $this->Form->hidden('User.latitude');
			echo $this->Form->hidden('User.longitude');
		?>
			<div class="gap">&nbsp;</div>

			<div class="steplablefl">Postal Code:</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->input('User.postcode', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'stepinput validate[required]', 'maxlength'=>'7', 'error'=>false, 'required'=>false, 'onkeyup'=>'fetchPostalCode(this.value);', 'onblur'=>'fetchPostalCode(this.value);'));
				echo $this->Form->error('User.postcode');
				?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl">City:</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->input('User.city', array('div'=>false, 'label'=>false, 'type'=>'text', 'class'=>'stepinput', 'maxlength'=>'100', 'error'=>false, 'required'=>false, 'readonly'=>'readonly'));
				echo $this->Form->error('User.city');
				?>
				<div id="suggestions" style="border:1px solid #B8B8B8; width:250px; display:none; position:absolute; background-color:#FFFFFF; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
			</div>
			<div class="clr"></div>

			<div class="steplablefl" style="padding-top:0;">Gender:</div>
			<div class="stepfieldfr">
				<input name="data[User][gender]" type="radio" value="1"  class="readiocir" checked />Male
				<input name="data[User][gender]" type="radio" value="2"  class="readiocir" style="margin-left:10px;" />Female
			</div>
			<div class="clr"></div>

			<div class="steplablefl">Birthday:</div>
			<div class="stepfieldfr">
				<div class="selectmain">
					<?php echo $this->Form->select('User.year', createArrayDropDown(1910, date('Y')), array('class'=>'selsmlinput validate[required]', 'empty'=>'Select'));?>
				</div>
				<div class="selectmain">
					<?php echo $this->Form->select('User.month', listMonths(), array('class'=>'selsmlinput validate[required]', 'empty'=>'Select'));?>
				</div>
				<?php echo $this->Form->input('User.date', array('div'=>false, 'label'=>false, 'type'=>'text', 'required'=>false, 'class'=>'smlinput validate[required,custom[onlyNumberSp,min[1],max[31]]]'));?>
			</div>
			<div class="clr"></div>

			<div class="steplablefl">&nbsp;</div>
			<div class="stepfieldfr">
				<?php echo $this->Form->submit('front_end/last_step_btn.jpg', array('div'=>false));?>
			</div>
			<div class="clr"></div>
		<?php echo $this->Form->end();?>
		</div>
	</div>
</div>
<!--End step fl box -->

<!--Start step fr text -->
<div class="stepboxfr">
Your location and other information allows us to cater more meaningful content that will matter to you.
</div>
<div class="clr"></div>
<!--End step fr text -->

<script type="text/javascript">
var cityArr = new Array();
function fetchPostalCode(postCode){
	if(postCode.length >= 5){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'users/fetch_post_codes_details/';?>",
			data: "postcode="+postCode,
			dataType:"json",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#suggestions').show();
				$('#suggestions').html(bSend);
			},
			success: function(response){
				if(response.data != ''){
					cityArr = response;
					$('#suggestions').html('');
					for(temp in response.data){
						$('#suggestions').append('<div style="cursor:pointer; margin:2px;" onclick="return validateState('+temp+')">'+response.data[temp]['Postcode']['CityName']+'</div>');
						
					}
				}else{
					$('#suggestions').html('<div style="color:#FF0000; margin:2px; text-align:center;">No City Found!!</div>');
				}
			}
		});
	}else{
		$('#UserCity').val('');
		$('#suggestions').html('');
		$('#suggestions').hide();
	}
}

function validateState(temp){
	$('#UserCountry').val(cityArr.data[temp]['Postcode']['CountryName']);
	$('#UserState').val(cityArr.data[temp]['Postcode']['ProvinceName']);
	$('#UserStateCode').val(cityArr.data[temp]['Postcode']['ProvinceAbbr']);
	$('#UserCity').val(cityArr.data[temp]['Postcode']['CityName']);

	$('#UserLatitude').val(cityArr.data[temp]['Postcode']['Latitude']);
	$('#UserLongitude').val(cityArr.data[temp]['Postcode']['Longitude']);

	$('#suggestions').html('');
	$('#suggestions').hide();
}
</script>