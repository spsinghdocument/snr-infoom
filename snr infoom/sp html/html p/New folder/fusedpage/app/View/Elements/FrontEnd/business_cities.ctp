<?php 
	$businessPlan = '2';
if($businessPlan > 0){?>
<style type="text/css">
.cityBorder{float:left; border:2px solid #DCDCDC; width:150px; max-height:300px; overflow:auto; margin:10px;}
.cityMiddleBorder{float:left; width:50px; height:300px; margin:10px;}
.innerCity{margin:0 0 0 10px; cursor:pointer;}
.selectedCityBorder{float:left; border:2px solid #DCDCDC; width:150px; height:300px; overflow:auto; margin:10px;}
.sele{font-weight:bold;}
.selectedSele{font-weight:bold;}
.moveForward{cursor:pointer; text-align:center; margin-top:80px;}
.moveBackword{cursor:pointer; text-align:center; margin-top:80px;}
.selectedCities{margin:0 0 0 10px; cursor:pointer;}
</style>

<div style="border:1px solid #DCDCDC; width:485px; margin:20px 0 0 0;">

	<?php 
		$displayCitySect = 'block';
		$nationalChecked = '';
		if($businessArr['Business']['national_level'] == '1'){
			$displayCitySect = 'none';
			$nationalChecked = 'checked="checked"';
		}
	?>

	<!-- NATIONAL LEVEL MARKETING START -->
	<div style="margin:10px;">
		<input type="checkbox" value="national" id="national_level" <?php echo $nationalChecked;?>/> National Level Advertising
		<div id="national_save" style="float:right; display:none;">
			<div class="btnimage" style="margin:10px; height:30px; float:left;">
				<a href="javascript:void(0);" onclick="return validateNationalLevel();" ><span>Save</span></a>
			</div>
			<div id="result_national_level"></div>
		</div>
	</div>
	<div class="clr"></div>
	<!-- NATIONAL LEVEL MARKETING END -->

	

	<div id="cities_selection" style="display:<?php echo $displayCitySect;?>;">
	<div class="priceinhd" style="font-size:20px; margin:10px;">Select cities for Business</div>

	<!-- SOURCE SECTION START -->
	<div class="cityBorder">
		<?php 
			//fetch the plan details
			$allowedCities = $this->Fused->fetchPlanCities($businessPlan);
			$userSelectedCities = $this->Fused->fetchUserSelectedCities($businessArr['Business']['id']); 
			if($allowedCities == 'Custom')
				$allowedCities = '';
			else
				$allowedCities = (int)$allowedCities;
		
			$citiesArr = $this->Fused->fetchUserStateCities();
			if(!empty($citiesArr)){
				foreach($citiesArr as $city){
					$display = 'block;';
					if(!empty($userSelectedCities)){
						if(in_array($city, $userSelectedCities))
							$display = 'none;';
					}
		?>
				<div class="innerCity" style="display:<?php echo $display;?>">
					<?php echo $city;?>
				</div>
		<?php		
				}
			}
		?>
	</div>
	<!-- SOURCE SECTION START -->

	<!-- MIDDLE NAVIGATION SECTION START -->
	<div class="cityMiddleBorder">
		<div class="moveForward">
			<?php echo $this->Html->image('front_end/next_icon.gif', array('alt'=>'Select', 'title'=>'Select'));?>
		</div>

		<div class="moveBackword">
			<?php echo $this->Html->image('front_end/prev_icon.gif', array('alt'=>'Deselect', 'title'=>'Deselect'));?>
		</div>
	</div>
	<!-- MIDDLE NAVIGATION SECTION END -->

	<!-- SELECTED CITY SECTION START -->
	<div class="selectedCityBorder">
		<?php
			if(!empty($userSelectedCities)){
				foreach($userSelectedCities as $city){
		?>
				<div class="selectedCities"> <?php echo $city;?> </div>
		<?php
				}
			}
		?>
	</div>
	<!-- SELECTED CITY SECTION END -->

	<div class="clr"></div>

	<!-- SAVE BUTTON SECTION START -->
	<div class="btnimage" style="margin:10px; height:30px; float:left;">
		<a href="javascript:void(0);" onclick="return validateCitiesSave();"><span>Save</span></a>
	</div>
	<div id="cities_result" style="float:left; margin-left:10px;"></div>
	<div class="clr"></div>
	<!-- SAVE BUTTON SECTION END -->
	</div>
</div>
<div class="clr"></div>

<!-- HIDDEN FIELDS START -->
<?php echo $this->Form->hidden('totalSelectedCities', array('value'=>count($userSelectedCities)));?>
<!-- HIDDEN FIELDS END -->
<?php } ?>
<script type="text/javascript">
function selectedCounter(){
	var prevSelectedCount = $('#totalSelectedCities').val(); //count the total selected
	if(prevSelectedCount == '')
		prevSelectedCount = 0
	else
		prevSelectedCount = parseInt(prevSelectedCount);
	return prevSelectedCount;
}

$(document).ready(function(){
	//FOR CLICK ON SOURCE ELEMENT
	$('.innerCity').click(function(){
		//alert($(this).text());
		$('.innerCity').removeClass('sele');
		$(this).addClass('sele');
		$(this).addClass('added');
	}),

	//FOR CLICK ON FORWARD ARROW
	$('.moveForward').click(function(){	
		var prevSelectedCount = selectedCounter();
		var maxAllowed = "<?php echo $allowedCities;?>";
		var businesPlan = "<?php echo $businessPlan;?>";
		if(businesPlan < 4){
			if(prevSelectedCount < maxAllowed){
				var selCity = $('.sele').html();
				if(selCity != null){
					var divs = '<div class="selectedCities">'+selCity+'</div>';
					$('.selectedCityBorder').append(divs);
					$('.innerCity').removeClass('sele');
					$('.added').hide();

					//increase the count
					$('#totalSelectedCities').val((prevSelectedCount + 1));
				}
			}
		}else{
			var selCity = $('.sele').html();
			if(selCity != null){
				var divs = '<div class="selectedCities">'+selCity+'</div>';
				$('.selectedCityBorder').append(divs);
				$('.innerCity').removeClass('sele');
				$('.added').hide();

				//increase the count
				$('#totalSelectedCities').val((prevSelectedCount + 1));
			}
		}
	}),

	//FOR CLICK ON SELCTED CITIES ELEMENT
	$('.selectedCities').live('click', function(){
		$('.selectedCities').removeClass('selectedSele');
		$(this).addClass('selectedSele');
	}),

	//FOR CLICK ON BACKWARD ARROW
	$('.moveBackword').click(function(){
		var prevSelectedCount = selectedCounter();
		var selectedValue = $('.selectedSele').html();
		if(selectedValue != null){
			$('.added').each(function(){
				var hddenVal = $(this).html();
				if(selectedValue == hddenVal){
					$(this).removeClass('added');
					$(this).show();
					$('.selectedSele').remove();

					//decrease the counter
					$('#totalSelectedCities').val((prevSelectedCount - 1));
				}
			});
		}
	}),
	
	$('#national_level').change(function(){
		if($(this).is(':checked')){
			$('#cities_selection').hide();
			$('#national_save').show();
		}else{
			$('#cities_selection').show();
			$('#national_save').hide();
		}
	});
});

function validateCitiesSave(){
	var cities = '';
	count = 1;
	$('.selectedCities').each(function(){
	if(count == 1)
		cities = $(this).html();
	else
		cities += ','+$(this).html();
	count++;
	});

	if(cities != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/push_marketing_business/';?>",
			data: "business_id=<?php echo $businessArr['Business']['id'];?>&cities="+cities+"&plan_id=<?php echo $businessPlan;?>",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#cities_result').html(bSend);
			},
			success: function(response){
				if(response == 'saved')
					$('#cities_result').html('<font color="green">Successfully Saved!</font>');
				else
					$('#cities_result').html('<font color="red">Successfully Saved!</font>');
			}
		});
	}
}

function validateNationalLevel(){
	$.ajax({
		type: "POST",
		url: "<?php echo SITE_PATH.'businesses/mark_national_level_marketing/';?>",
		data: "business_id=<?php echo $businessArr['Business']['id'];?>",
		beforeSend:function(){
			var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
			$('#result_national_level').html(bSend);
		},
		success: function(response){
			if(response == 'success')
				$('#result_national_level').html('<font color="green">Set to Nationa Level!</font>');
			else
				$('#result_national_level').html('<font color="red">Error!</font>');
		}
	});
}
</script>