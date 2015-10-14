<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyAwRX-ElDvyL7oiWafWaomBiGg5jlSPbCA" type="text/javascript"></script>

<script type="text/javascript">
    var geocoder = null;
    var map = null;
    var baseIcon = null;
    var setPoint = true;
    var displayAdd = null;

    function initialize() {
        if (GBrowserIsCompatible()){
            map = new GMap2(document.getElementById("map_canvas"));
            geocoder = new GClientGeocoder();
            map.setCenter(new GLatLng(27.18852,-83.937881), 2);
            map.setUIToDefault();
            // Create a base icon for all of our markers that specifies the
            // shadow, icon dimensions, etc.           
                baseIcon = new GIcon(G_DEFAULT_ICON);
                baseIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_purple.png";
                baseIcon.iconSize = new GSize(20, 34);
                baseIcon.shadowSize = new GSize(37, 34);
                baseIcon.iconAnchor = new GPoint(9, 34);
                baseIcon.infoWindowAnchor = new GPoint(9, 2);
                // Creates a marker whose info window displays the letter corresponding
                // to the given index.      
		
		<?php
			foreach($viewListing_1 as $listing){
				$addInfo = '<div style="float:left; font-weight:bold;"><a href="'.SITE_PATH.'groups/details/'.$this->Fused->encrypt($listing['id']).'/'.$listing['alias_name'].'/">'.$listing['title'].'</a></div>';
		?>
			showAddress('<?php echo $listing["city"];?>, <?php echo $listing["state"];?>, <?php echo $listing["country"];?>', '<?php echo $addInfo;?>');
		<?php } ?>
        }
    }

    function createMarker(point, address){
        // Create a lettered icon for this point using our icon class
        var letter = String.fromCharCode("G".charCodeAt(0));
        var letteredIcon = new GIcon(baseIcon);
        //if(isF == 1){
            //letteredIcon.image = "http://www.google.com/mapfiles/marker_purple" + letter + ".png";
//            letteredIcon.image = "http://labs.google.com/ridefinder/images/mm_20_purple.png";
            //letteredIcon.shadow = "http://chart.apis.google.com/chart?chst=d_map_pin_shadow";
      //  }
       // else{
            letteredIcon.image = "http://www.google.com/mapfiles/marker_green" + letter + ".png";
//            letteredIcon.image = "http://labs.google.com/ridefinder/images/mm_20_green.png";
            letteredIcon.shadow = "http://chart.apis.google.com/chart?chst=d_map_pin_shadow";
       // }

        // Set up our GMarkerOptions object
        markerOptions = { icon:letteredIcon };
        var marker = new GMarker(point, markerOptions);

        GEvent.addListener(marker, "click", function() {
            marker.openInfoWindowHtml( address );
        });
        return marker;
    }

    function showAddress(address, addInfo) {
        var findAddress = address;
        var displayAdd = addInfo;
        if (geocoder) {
            geocoder.getLatLng(
            findAddress,
            function(point) {
                if (!point) {
                    //alert("hi")
                } else {
                    if(setPoint){
                        
                           map.setCenter(point, 2);
                        
                        setPoint = false;
                    }
                    map.addOverlay(createMarker(point, displayAdd));
                }
            }
        );
        }
    }

    window.onload = function(){
        initialize();
    }
</script>





<div class="groupsmapbox" id="map_canvas" style="width:692px; height:268px;">
	<!-- <img src="../../img/front_end/groups_map.jpg" alt="" /> -->
</div>