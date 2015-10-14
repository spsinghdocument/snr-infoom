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
<div id="pulic_7" class="deshlistbox" style="display:none;">
	<div id="map_canvas" style="width:450px; height:400px;"></div>
	<div class="clr"></div>
	<input type="hidden" value="0" id="setMap">
</div>


<!-- --------------------------------------------------------------------------------------------------- -->
<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY;?>&amp;sensor=false">
</script>

<script type="text/javascript">
var geocoder;
var map;
var infowindow = new google.maps.InfoWindow();
var marker;

function initialize(){
	geocoder = new google.maps.Geocoder();
	var myOptions = {
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	codeAddress('<?php echo $address;?>', '<?php echo $businessArr["Business"]["title"];?>');
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

function load_map(){
	if(($('#setMap').val()) == 0){
		$('#setMap').val(1);
		initialize();
	}
}
</script>
<!-- --------------------------------------------------------------------------------------------------- -->