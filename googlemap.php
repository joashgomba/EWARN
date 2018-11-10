https://stackoverflow.com/questions/37783753/php-how-to-change-the-markers-without-refresh-the-google-map-in-php-ajax-call
<html>
    <head>
        <title>Tracking</title>
        <meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #map {
                height: 100%;
            }
            #map-canvas 
            { 
                height: 100%; 
                width: 100%;
            }
        </style>
    </head>
    <body>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABDtmTfMBisFzZ2ajsUlRgDHi95680Xjw&sensor=false&callback=initialize"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <div id="map-canvas"></div>
        <script>
            var a, b, varInterval, marker = [];

            var markersPlacement = 0;
            var locations = [];
            locations.push(17.429385 + ',' + 78.4451901667);
            locations.push(41.8369 + ',' + 87.6847); //Chicago
            locations.push(36.1215 + ',' + 115.1739); //LA

            var defaultLocation = locations[markersPlacement].split(',');
            var mapIcon = 'http://images.clipartpanda.com/google-location-icon-location-map-512.png';

            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 5,
                center: new google.maps.LatLng(parseFloat(defaultLocation[0]), parseFloat(defaultLocation[1])),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            function deleteMarkers() {
                clearMarkers();
                marker = [];
            }
            function clearMarkers() {
                setMapOnAll(null);
            }

            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < marker.length; i++) {
                    marker[i].setMap(map);
                }
            }

            function addMarker(location) {
                var mark = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: mapIcon,
                });
                marker.push(mark);
            }


            $(document).ready(
                    function () {
                        varInterval = setInterval(function () {
                            console.log(markersPlacement);
                            console.log(locations.length);
                            if (locations.length >= markersPlacement) {
                                deleteMarkers();

                                //REMOVE THE BELOW AND ADD THE AJAX CODE BELOW HERE.
                                defaultLocation = locations[markersPlacement].split(',');
                                addMarker(new google.maps.LatLng(parseFloat(defaultLocation[0]), parseFloat(defaultLocation[1])));
                                markersPlacement++;
                            } else {
                                clearInterval(varInterval);
                            }

                        }, 5000);
                    });


        </script>
    </body>
</html>