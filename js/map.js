
var map,
    markerCluster,
    geocoder,
    markers = [],
    image_dir_url = document.body.getAttribute('data-template-url') + '/images/';


// load the maps script
// specify a callback initialize() in the url
function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyABDtmTfMBisFzZ2ajsUlRgDHi95680Xjw&sensor=false&callback=initialize';
  document.body.appendChild(script);
}
window.onload = loadScript;


//will be called after the maps script loads
function initialize(){
  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map(document.getElementById("map-canvas"));
  map.mapTypeId = google.maps.MapTypeId.HYBRID;
  //set options
  //map styles borrowed from: http://snazzymaps.com/style/15/subtle-grayscale
  /**
  
  var kmlUrl = 'http://www.asalforum.or.ke/mappingtool/kml/KenyaCounties.kml';
var kmlOptions = {
  suppressInfoWindows: true,
  preserveViewport: true,
  map: map
};
var kmlLayer = new google.maps.KmlLayer(kmlUrl, kmlOptions);

**/
//var kmzLayer = new google.maps.KmlLayer('http://www.cisp-som.org/drcdbase/drcdbase/kml/SOM_adm2.kmz');
//var kmzLayer = new google.maps.KmlLayer('http://www.asalforum.or.ke/mappingtool/kml/CountiesLayer.kmz');
//var kmzLayer = new google.maps.KmlLayer('http://www.asalforum.or.ke/mappingtool/kml/CountiesKML3.kmz');
//var kmzLayer = new google.maps.KmlLayer('http://www.asalforum.or.ke/mappingtool/kml/kenyacounties.kmz');
//kmzLayer.setMap(map);

  map.setOptions({
    styles : [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
  });

  // use geolocation web api to get users
  // current location
  if (navigator.geolocation) {
    geolocate();
  }

  // if no latlong defined yet, that means either we
  // were denied access to fetch location or we are on an
  // older browser that doesn't support geoloc api
  if( typeof(latlong) === 'undefined') {
    //fetch the address for Nairobi and center map
    geocoder.geocode({
      'address': 'Bulo-Burte, Somalia'
    },function(results, status) {
        map.setCenter(results[0].geometry.location);
    });

  }
  
  
  // set the zoom level of the map
  map.setZoom(5);



  //add branch markers to the map
  addMarkers(
    JSON.parse(document.getElementById("json_data").innerHTML)
  );

  var markerCluster = new MarkerClusterer(map, markers);
}


function addMarkers(locations){
  var infowindow = new google.maps.InfoWindow();
  var i;

  for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i].position.lat, locations[i].position.lng),
      icon: locations[i].icon,
      map: map
    });
	
	
	
	

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i].info);
        infowindow.open(map, marker);
      }
    })(marker, i));

    markers.push(marker); //add all markers to this array


  }
}


// geolocate current user
// and add a marker to the map
function geolocate(){
  navigator.geolocation.getCurrentPosition(function(position){

    latlong = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };

    map.setCenter(latlong);

    //add a marker to this point
    marker = new google.maps.Marker({
      map: map,
      position: latlong
    });

  });

}
