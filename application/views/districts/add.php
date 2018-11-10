<?php include(APPPATH . 'views/common/header.php'); ?>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABDtmTfMBisFzZ2ajsUlRgDHi95680Xjw&sensor=false&callback=initialize"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}

function initialize() {
  var latLng = new google.maps.LatLng(0, 0);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 2,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function (event) {


            document.getElementById("lat").value = event.latLng.lat();
            document.getElementById("long").value = event.latLng.lng();
        });
		
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>
 <style>
  #mapCanvas {
    width: 100%;
    height: 400px;
  }
  #infoPanel {
    
    margin-left: 10px;
  }
  #infoPanel div {
    margin-bottom: 5px;
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
	
	function GetZones(frm){
	if(validateForm(frm)){
	document.getElementById('zones').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/users/getzones";
	
	var params = "country_id=" + totalEncode(document.frm.country_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getperiodbyhf";
	
	var params = "week_no=" + totalEncode(document.frm.week_no.value ) + "&reporting_year="+totalEncode(document.frm.reporting_year.value ) + "&healthfacility_id="+totalEncode(document.frm.healthfacility_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reporingperiods').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reporingperiods').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetRegions(frm){
	if(validateForm(frm)){
	document.getElementById('regions').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getallregions";
	
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
	var url = "<?php echo base_url(); ?>index.php/reportingforms/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	</script>
    
    
 <script type="text/javascript">  
 
 
function checkcoordinates()
{

	var lat = document.frm.lat.value;
	var longitude = document.frm.long.value;
	
	var val = parseFloat(lat);
	if (!isNaN(val) && val <= 90 && val >= -90)
	{
		//return true;
	}else{
		alert( "The latitude coordinates must be of correct format. Use the map to drag the marker to the correct point." );
        document.frm.lat.focus() ;
		return false;
	}
	
	var theval = parseFloat(longitude);
	if (!isNaN(theval) && theval <= 90 && theval >= -90)
	{
		//return true;
	}else{
		alert( "The longitude coordinates must be of correct format. Use the map to drag the marker to the correct point." );
        document.frm.long.focus() ;
		return false;
	}
	
	
}

</script>
	<body>
		<?php include(APPPATH . 'views/common/navbar.php'); ?>

		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>
			<?php include(APPPATH . 'views/common/sidebar.php'); ?>
			
			<div class="main-content">
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active"><?php echo $user_country->third_admin_level_label;?></li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Registration
							<small>
								<i class="icon-double-angle-right"></i>
								<?php echo $user_country->third_admin_level_label;?>
							</small>
						</h1>
					</div><!--/.page-header-->
                  
                         	<?php
				if(validation_errors())
				{
					?>
					<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
					<?php
				}
				?>
                         <?php 
						$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(checkcoordinates())'); 
						 echo form_open('districts/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls"><?php $data = array('id' => 'district', 'name' => 'district', 'required'=>'required'); echo form_input($data, set_value('district')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?> code: </label><div class="controls"><?php $data = array('id' => 'district_code', 'name' => 'district_code', 'required'=>'required'); echo form_input($data, set_value('district_code')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php
if (getRole() == 'Admin')
{
	
	?>
     <select name="country_id" id="country_id" onChange="GetZones(this)" required="required">
    <option value=""> - Select Country - </option>
     <option value="<?php echo $country->id;?>"> <?php echo $country->country_name;?> </option>
    
     </select>
    <?php
}
else
{
	?>
   
<select name="country_id" id="country_id" onChange="GetZones(this)" required="required">
    <option value=""> - Select Country - </option>
    <?php
	foreach($countries as $key=>$country)
	{
		?>
        <option value="<?php echo $country['id'];?>"> <?php echo $country['country_name'];?> </option>
        <?php
	}
	?>
    </select>
    <?php
}
?>

</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<div id="zones">
    <select name="zone_id" id="zone_id" required="required">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                               
                                </select>
                                
                                </div>
</div>
</div>


<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">


<div id="regions">
     <select name="region_id" id="region_id" onChange="GetDistricts(this)" required="required">
      <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
     </select>
     </div>

</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Latitude: </label><div class="controls"><?php $data = array('id' => 'lat', 'name' => 'lat', 'required'=>'required'); echo form_input($data, set_value('lat')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Longitude: </label><div class="controls"><?php $data = array('id' => 'long', 'name' => 'long', 'required'=>'required'); echo form_input($data, set_value('long')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Map: </label><div class="controls">

<div id="mapCanvas"></div>

<div id="infoPanel">
    <b>Marker status:</b>
    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Current position:</b>
    <div id="info"></div>
    <b>Closest matching address:</b>
    <div id="address"></div>
  </div>

</div>
</div>


<div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
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
