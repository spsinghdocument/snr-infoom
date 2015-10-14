<?php //pr($businessArr);
	$address = '';
	if($businessArr['Business']['street'] != '')
		$address = $businessArr['Business']['street'].', ';
	if($businessArr['Business']['city'] != '')
		$address .= $businessArr['Business']['city'].', ';
	if($businessArr['Business']['state'] != '')
		$address .= $businessArr['Business']['state'].', ';
	if($businessArr['Business']['country'] != ''){
		if($businessArr['Business']['country'] == 'CAN')
			$address .= 'Canada';
		else
			$address .= $businessArr['Business']['country'];
	}
	
?>
<style type="text/css">
.mapClassInput{border:1px solid #DFDFDF; color:#909090; font-size:12px; width:300px; height:17px;}
</style>
<div id="pulic_7" style="display:none;">
	<div class="deshlistbox">
		<div>
			<div>
				<div class="feddimgname" style="float:left; width:80px;">Source:</div>
				<div style="float:left; margin-left:5px;">
					<?php echo $this->Form->text('start', array('div'=>false, 'label'=>false, 'class'=>'mapClassInput'));?>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>

			<div style="margin-top:10px;">
				<div class="feddimgname" style="float:left; width:80px;">Destination:</div>
				<div style="float:left; margin-left:5px;">
					<?php echo $this->Form->text('end', array('div'=>false, 'label'=>false, 'class'=>'mapClassInput', 'value'=>$address));?>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>

			<div style="margin-top:10px;">
				<div class="feddimgname" style="float:left; width:80px;">&nbsp;</div>
				<div style="float:left; margin-left:5px;">
					<div class="btnimage fr"><a href="javascript:void(0);" onclick="validateRouteForPath()"><span>Get Directions</span></a></div>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>

	<div class="deshlistbox">
		<div id="map_canvas" style="width:450px; height:400px;"></div>
	</div>
	<div class="clr"></div>
	
	<div class="deshlistbox" id="get_directions" style="display:none;">
		<div id="directionsPanel" style="width:450px; height:400px; overflow:scroll;"></div>
	</div>
	<div class="clr"></div>
	<input type="hidden" value="0" id="setMap">
	<input type="hidden" value="basic" id="mapType">
</div>


<!-- --------------------------------------------------------------------------------------------------- -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<script type="text/javascript">
var rendererOptions = {draggable:true};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
var directionsService = new google.maps.DirectionsService();
var map;

var geocoder;
var infowindow = new google.maps.InfoWindow();
var marker;

var australia = new google.maps.LatLng(28.6667, 77.2167);

function initialize(){
	var mapTType = $('#mapType').val();
	if(mapTType == 'basic'){
		geocoder = new google.maps.Geocoder();
		var myOptions = {
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		codeAddress('<?php echo $address;?>', '<?php echo $businessArr["Business"]["title"];?>');
	}else{
		var mapOptions = {
			zoom: 7,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: australia
		};
		map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById('directionsPanel'));

		google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
			computeTotalDistance(directionsDisplay.directions);
		});

		
		var start = $('#start').val();
		var end = $('#end').val();
		var request = {
			origin: start,
			destination: end,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			}
		});
		calcRoute();
	}
}

function codeAddress(addr, otherInfo){
	var address = addr;
	var addifo= otherInfo;
	geocoder.geocode({ 'address': address}, function(results, status){
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
			infowindow.setContent(addifo);
			infowindow.open(map, marker);
		}else
			$('#map_canvas').html('<div align="center" style="color:#FF0000; margin-top:200px;">Invalid Address Provided!!</div>');
	});
}

function calcRoute(){
	var waypts = [];
	var checkboxArray = document.getElementsByName('waypoints');
	//alert(checkboxArray.length);
	for (var i = 0; i < checkboxArray.length; i++) {
	//alert(checkboxArray[i].value);
	waypts.push({
		location:checkboxArray[i].value,
		stopover:true});
	}

	var start = $('#start').val();
	var end = $('#end').val();
	var request = {
		origin: start,
		destination: end,
		waypoints: waypts,
		travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsService.route(request, function(response, status){
		if(status == google.maps.DirectionsStatus.OK){
			directionsDisplay.setDirections(response);
		}
	});
}

function load_map(){
	if(($('#setMap').val()) == 0){
		$('#setMap').val(1);
		initialize();
		//google.maps.event.addDomListener(window, 'load', initialize);
		
	}
}

function validateRouteForPath(){
	if($('#start').val() == ''){
		$('#start').css('border', '1px solid #FF0000');
		$('#start').focus()
		return false;
	}else
		$('#start').css('border', '1px solid #DFDFDF');

	if($('#end').val() == ''){
		$('#end').css('border', '1px solid #FF0000');
		$('#end').focus()
		return false;
	}else
		$('#end').css('border', '1px solid #DFDFDF');
	
	$('#mapType').val('route');
	$('#get_directions').show();
	initialize();
}
</script>


<!-- --------------------------------------------------------------------------------------------------- -->