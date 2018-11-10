<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
    #map-canvas{
      width: 100%;
      height: 500px;
	    padding: 6px;
        border-width: 1px;
        border-style: solid;
        border-color: #ccc #ccc #999 #ccc;
        -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
    }
	
	img { max-width:none; }
</style>
<style>
#themodal {
    display: none;
    position: absolute;
    top: 45%;
    left: 45%;
    width: 64px;
    height: 64px;
    padding:30px 15px 0px;
    border: 3px solid #ababab;
    box-shadow:1px 1px 10px #ababab;
    border-radius:20px;
    background-color: white;
    z-index: 1002;
    text-align:center;
    overflow: auto;
}

#fade {
    display: none;
    position:absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #ababab;
    z-index: 1001;
    -moz-opacity: 0.8;
    opacity: .70;
    filter: alpha(opacity=80);
}


</style>
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
	
	function openModal() {
        document.getElementById('themodal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
	}
	
	function closeModal() {
		document.getElementById('themodal').style.display = 'none';
		document.getElementById('fade').style.display = 'none';
	}
	
	function GetZones(frm){
	if(validateForm(frm)){
	document.getElementById('zones').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/users/getzones";
	
	var params = "country_id=" + totalEncode(document.frm.country_id.value ) ;
	var connection=connect(url,params);
	var region_element = '<select id="region_id" name="region_id">' + '<option value="">Select One</option>' + '</select>';
	var district_element = '<select id="district_id" name="district_id">' + '<option value="">Select One</option>' + '</select>';
	var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML= region_element;
		document.getElementById('districts').innerHTML= district_element;
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	var district_element = '<select id="district_id" name="district_id">' + '<option value="">Select One</option>' + '</select>';
	var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		document.getElementById('districts').innerHTML= district_element;
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/export/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function findReport(frm){
	if(validateForm(frm)){
	document.getElementById('reportdetails').innerHTML='';
	openModal();
	var url = "<?php echo base_url(); ?>index.php/validate/getlist";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&reporting_year2=" + totalEncode(document.frm.reporting_year2.value ) + "&from=" + totalEncode(document.frm.from.value ) + "&to=" + totalEncode(document.frm.to.value ) + "&district_id=" + totalEncode(document.frm.district_id.value )+ "&healthfacility_id=" + totalEncode(document.frm.healthfacility_id.value )+ "&gender=" + totalEncode(document.frm.gender.value )+ "&region_id=" + totalEncode(document.frm.region_id.value )+ "&zone_id=" + totalEncode(document.frm.zone_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		closeModal();
		document.getElementById('reportdetails').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reportdetails').innerHTML = '<span style="color:green;"><h1>Retrieving records....</h1> <i class="icon-spinner icon-spin orange bigger-125"></i></span>';}}}
	}
	
	
</script>

<script>

function validate()
{
	
   if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the from reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.from.value == "" )
   {
     alert( "Please enter the from week number" );
     document.frm.from.focus() ;
     return false;
   }
   
   if( document.frm.reporting_year2.value == "" )
   {
     alert( "Please enter the to reporting year" );
     document.frm.reporting_year2.focus() ;
     return false;
   }
   
   if( document.frm.to.value == "" )
   {
     alert( "Please enter the to week number" );
     document.frm.to.focus() ;
     return false;
   }
   
   var e = document.getElementById("reporting_year");
   var repyearone = e.options[e.selectedIndex].value;
   
   var y = document.getElementById("reporting_year2");
   var repyeartwo = y.options[y.selectedIndex].value;
   
   var x = document.getElementById("from");
   var fromval = x.options[x.selectedIndex].value;
   
   var z = document.getElementById("to");
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

<style>
	div.scroll
	{
	background-color:#fff;
	width:1100px;
	height:500px;
	
	}
	
	div.hidden 
	{
	background-color:#fff;
	width:100px;
	height:100px;
	overflow:hidden;
	}
</style>

		<body>
			<?php include(APPPATH . 'views/common/navbar.php'); ?>
				<div class="main-container container-fluid">
					<a class="menu-toggler" id="menu-toggler" href="#">
						<span class="menu-text"></span>
					</a>
					<?php include(APPPATH . 'views/common/sidebar.php'); ?>
					<div class="main-content">
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="icon-home home-icon"></i>
										<a href="<?php echo site_url('home')?>">Home</a>
										<span class="divider">
											<i class="icon-angle-right arrow-icon"></i>
										</span>
								</li>
								<li class="active">Weekly Alerts Map</li>
							</ul><!--.breadcrumb-->
						<div class="nav-search" id="nav-search">
							<form class="form-search" method="post" action="" />
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
					</div>
					<div class="page-content">
						<div class="row-fluid">
							<div class="span12">
								<!--PAGE CONTENT BEGINS-->
								<div class="page-header position-relative">
									<h1>
										EWARN
										<small>
											<i class="icon-double-angle-right"></i>
								    Weekly Alerts Map</small></h1>
								</div>
                                 
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal','onsubmit'=>'return(validate())');?>
<?php echo form_open('maps/getmap',$attributes); ?>

<div id="accordion2" class="accordion">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
													Dynamic Map Search
												</a>
											</div>

											<div class="accordion-body collapse" id="collapseOne">
												<div class="accordion-inner">
													
                                                    <div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Filter Parameters</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            
  <?php
if (getRole() == 'SuperAdmin' || getRole() == 'Admin')
{
	?>                                        
                                            
                                            <div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php
if (getRole() == 'Admin')
{
	$country = $this->countriesmodel->get_by_id($country_id)->row();
	echo '<strong>'.$country->country_name.'</strong>';
	?>
    <input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>">
    <?php
}
else
{
	?>
    <select name="country_id" id="country_id" onChange="GetZones(this)">
    <option value=""> - Select Country - </option>
    <?php
	foreach($countries as $key=>$country)
	{
		?>
        <option value="<?php echo $country['id'];?>" <?php if(set_value('country_id')==$country['id']){echo 'selected="selected"';}?>> <?php echo $country['country_name'];?> </option>
        <?php
	}
	?>
    </select>
    
    <?php
	
}
?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp; </label><div class="controls">
&nbsp;
</div>
</div>


</div>
</div>

<?php
}
?>
												
	<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<div id="zones">
 <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
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
                                
                                </div>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">

<div id="regions">
 <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option>
                                    <?php
									foreach($regions as $key=>$region)
									{
									?>
                                   <!-- <option value="<?php echo $region['id'];?>"><?php echo $region['region'];?></option>-->
                                    <?php
									}
									?>
                                    </select>
                                    
                                    </div>
</div>
</div>


</div>
</div>

              
                                                               
                              <div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">

 <div id="districts">
                             <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                <option value="">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                  <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                </select>
                             </div>

</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health facility</label><div class="controls">

 <div id="healthfacilities">
                                  <select name="healthfacility_id" id="healthfacility_id">
                                        <option value="">Select Health Facility</option>
                                        </select>
                                  </div>

</div>
</div>

</div>
</div>
                               

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">From: </label><div class="controls">
<select name="reporting_year" id="reporting_year">
                                 <option value="">Select Year</option>
                                 <?php
     $currentYear = date('Y')+10;
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
                               </select>
                               
                             <select name="from" id="from">
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('from')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">To: </label><div class="controls">
<select name="reporting_year2" id="reporting_year2">
                                 <option value="">Select Year</option>
                                 <?php
     $currentYear = date('Y')+10;
        foreach (range(2012, $currentYear) as $value) {
          ?>
                                 <option value="<?php echo $value;?>" <?php 
		   if($value==set_value('reporting_year2'))
		   {
			   echo 'selected="selected"';
		   }
		   ?>><?php echo $value;?></option>
                                 <?php

        }
?>
                               </select>
                               <select name="to" id="to">
                                 <option value="">Select Week</option>
                                 <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                 <option value="<?php echo $i;?>" <?php if(set_value('to')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                 <?php
							   }
							   ?>
                               </select>
</div>
</div>

</div>
</div>

<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Disease: </label><div class="controls">
<select name="disease_id" id="disease_id">
<option value="0">Select Disease</option>
<?php
foreach($diseases->result() as $disease)
{
	?>
    <option value="<?php echo $disease->id;?>" <?php if($disease->id==set_value('disease_id')){ echo 'selected="selected"';}?> ><?php echo $disease->disease_name;?></option>
    <?php
}
?>

</select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Verification Status: </label><div class="controls">

<select name="verification_status" id="verification_status">

<option value="2">Select status</option>
<option value="0">Not Verified</option>
<option value="1">Verified</option>

</select>
</div>
</div>


</div>
</div>

<div class="row-fluid">
<div class="span12">
<?php echo form_submit('submit', 'GET MAP', 'class="btn btn-info "'); ?>

</div>

</div>



						
												
											</div>
										</div>
									</div>
                                                    
                                                    
												</div>
											</div>
										</div>

										

										
									</div>




    
<div class="row-fluid">
						<div class="span12">
                        
                        <h4 class="header smaller lighter blue">Weekly Alerts Map</h4>
							                       
                                                 
                            <div id="json_data" style="display:none;">
                            
									 <?php
                                    
                      					echo json_encode($points,JSON_HEX_QUOT | JSON_HEX_TAG);
                                     
                                     ?>
                                     </div>
                                     
                                   
                                   <div id="map-canvas"></div>
                                 
                                   
                                   <script src="<?php echo base_url(); ?>js/mapwithmarker.js"></script>
                   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/clusterer.js"></script>
                  
 <!-- <script src="<?php echo base_url(); ?>js/largemap.js"></script>-->
 
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
  map.setZoom(6);



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
                            
							
						</div>
                        
                                                
                        
                        <!--/.span-->
					</div>



<?php echo form_close(); ?>

								<!--PAGE CONTENT ENDS-->
								</div><!--/.span-->
							</div><!--/.row-fluid-->
						</div><!--/.page-content-->
					<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
				</div><!--/.main-content-->
			</div><!--/.main-container-->
		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
