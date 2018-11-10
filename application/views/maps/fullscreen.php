<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
		
			html {
				height: 100%
			}
			
			body {
				height: 100%;
				margin: 0;
				padding: 0
			}
			
			#map-canvas {
				height: 100%;
				width:100%;
			}
			select
{
 border: 2px solid #DDDDDD;
    font-size: 0.8em;
    padding: 3px;
    width: 140px;
	float:left;
	margin:0 2px 0 0;
}
fieldset
{
  padding:15px 5px;
  border:1px dotted gray;
  border-width:1px 0;
  margin-top:-1px;
  position:relative;
  top:1px;
  background:none !important;
}
label
{
  font:normal normal normal 0.8em tahoma,sans-serif;
  display:block;
  padding-bottom:8px;
}
input[type="text"]
{
  width:13em;
  font-size:0.8em;
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 13px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
	box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

.radius-container {

    text-align: right;
    position: absolute;
    right: 200px;
    top: -2px;
    z-index: 99;
    background-color: #438eb9;
    color: white;
    padding: 5px;
	width:70%;}

    .select {
        width: 60px;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
}

.regions{
	select {
        width: 60px;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
}

    .map-container {
    position: relative;
}

#footer {
    position: absolute;
    bottom: 100px;
    right: 40px;
	z-index: 99;
	background-image: url('<?php echo base_url();?>images/tbg.png');
	background-repeat:repeat;
	color: white;
    padding: 4px;
	border:1px #000 solid;
	font-family:Verdana, Geneva, sans-serif;
}

		</style>
		<title>eDEWS Somalia System Alerts</title>
     <script>
		
   function trim(str){
	return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');}
	function totalEncode(str){
	var s=escape(trim(str));
	s=s.replace(/\+/g,"+");
	s=s.replace(/@/g,"@");
	s=s.replace(/\//g,"/");
	s=s.replace(/\*/g,"*");
	return(s);
	}
	function connect(url,params)
	{
	var connection;  // The variable that makes Ajax possible!
	try{// Opera 8.0+, Firefox, Safari
	connection = new XMLHttpRequest();}
	catch (e){// Internet Explorer Browsers
	try{
	connection = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e){
	try{
	connection = new ActiveXObject("Microsoft.XMLHTTP");}
	catch (e){// Something went wrong
	return false;}}}
	connection.open("POST", url, true);
	connection.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	connection.setRequestHeader("Content-length", params.length);
	connection.setRequestHeader("connection", "close");
	connection.send(params);
	return(connection);
	}
	
	function validateForm(frm){
	var errors='';
		
	if (errors){
	alert('The following error(s) occurred:\n'+errors);
	return false; }
	return true;
	}
	
	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/datalist/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetRegions(frm){
	if(validateForm(frm)){
	document.getElementById('regions').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getregions";
	
	var params = "zone_id=" + totalEncode(document.frm.zone_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/export/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	</script>
    
    
<script type="text/javascript">
<!--
// Form validation code will come here.

function validate()
{
	
   if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the from reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.week_no.value == "" )
   {
     alert( "Please enter the from week number" );
     document.frm.week_no.focus() ;
     return false;
   }
   
   if( document.frm.reporting_year2.value == "" )
   {
     alert( "Please enter the to reporting year" );
     document.frm.reporting_year2.focus() ;
     return false;
   }
   
   if( document.frm.week_no2.value == "" )
   {
     alert( "Please enter the to week number" );
     document.frm.week_no2.focus() ;
     return false;
   }
   
   var e = document.getElementById("reporting_year");
   var repyearone = e.options[e.selectedIndex].value;
   
   var y = document.getElementById("reporting_year2");
   var repyeartwo = y.options[y.selectedIndex].value;
   
   var x = document.getElementById("week_no");
   var fromval = x.options[x.selectedIndex].value;
   
   var z = document.getElementById("week_no2");
   var toval = z.options[z.selectedIndex].value;
   
   if(repyearone>repyeartwo)
   {
	  alert( "The year from cannot be greater than the year to" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if(repyearone==repyeartwo)
   {
	 if(Number(fromval)>Number(toval))
	 {
		 alert( "The week from cannot be greater than the week to on the same year." );
		 document.frm.week_no.focus() ;
		 return false;
	 }
   }
   
   return( true );
}

</script>   
      
	</head>
	<body>
    <div class="radius-container">
    
    <?php
	$user_country_id = $this->erkanaauth->getField('country_id');
$user_country = $this->countriesmodel->get_by_id($user_country_id)->row();

?>
   <?php 
					   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
					  echo form_open('maps/getfullscreen',$attributes); ?>
 <select name="zone_id" id="zone_id" onChange="GetRegions(this)" class="form-control">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                <?php
								foreach($zones as $key=> $zone)
								{
									?>
                                    <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
                                    <?php
								}
								?>
                                </select>
                                   <div id="regions">
                                   <?php
								   if($zone_id ==0)
								   {
								   ?>
                                   <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option>
                                 
                                    </select>
                                    <?php
								   }
								   else
								   {
									   ?>
                                        <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option>
                                  <?php
									foreach($regions as $key=>$region)
									{
									?>
                                   <option value="<?php echo $region['id'];?>" <?php if(set_value('region_id')==$region['id']){echo 'selected="selected"';}?>><?php echo $region['region'];?></option>
                                    <?php
									}
									?>
                                    </select>
                                       <?php
								   }
								   ?>
                                   
                                   </div>
                                   <select name="reporting_year" id="reporting_year">
                                   
                                   
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y');
        foreach (range(2012, $currentYear) as $value) {
          ?>
           <option value="<?php echo $value;?>" <?php 
		   if($value==set_value('reporting_year'))
		   {
			   echo 'selected="selected"';
		   }
		   ?>><?php echo $value;?></option>
          <?php

        }
?>
                               </select> <select name="week_no" id="week_no" >
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('week_no')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select>
                               
                               <select name="reporting_year2" id="reporting_year2">
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y');
        foreach (range(2012, $currentYear) as $value) {
          ?>
           <option value="<?php echo $value;?>" <?php 
		   if($value==set_value('reporting_year'))
		   {
			   echo 'selected="selected"';
		   }
		   ?>><?php echo $value;?></option>
          <?php

        }
?>
                               </select> <select name="week_no2" id="week_no2" >
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('week_no2')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select>
                               
                               <?php echo form_submit('submit', 'Get Map', 'class="button"'); ?>
                               
                               <?php echo form_close(); ?>  
    
</div>

 <div id="json_data" style="display:none;">
    <?php echo json_encode($points); ?>
  </div>
  <div id="map-canvas"></div>
  
  
   <script src="<?php echo base_url(); ?>js/mapwithmarker.js"></script>
                   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/markerclusterer.js"></script>
                  
 <!--<script src="<?php echo base_url(); ?>js/largemap.js"></script>-->
 
 
 <script>
 
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
      'address': '<?php echo $map_center;?>'
    },function(results, status) {
        map.setCenter(results[0].geometry.location);
    });

  }
  
  
  // set the zoom level of the map
  map.setZoom(7);



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

 </script>
 
	</body>
</html>
