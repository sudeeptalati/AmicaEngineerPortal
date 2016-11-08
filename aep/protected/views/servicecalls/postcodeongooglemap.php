
<body onload="initialize()">
<input id="address" type="hidden" value="<?php echo $address;?>">
<!--
<div>
    <input id="address" type="textbox" value="<?php echo $address;?>">
    <input type="button" value="Mark on Map" onclick="codeAddress()">
</div>
-->
<div id="map-canvas" style="width:200px;height:200px;top:5px; border-radius: 25px;"></div>
</body>
<script>
    var geocoder;
    var map;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
            zoom: 8,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        codeAddress();
    }

    function codeAddress() {
        var address = document.getElementById('address').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>


