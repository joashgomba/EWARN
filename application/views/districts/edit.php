<?php include(APPPATH . 'views/common/header.php'); ?>
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
<?php
if(empty($row->lat) || empty($row->long))
{
?>
  var latLng = new google.maps.LatLng(-1.292066, 36.821946);
<?php
}
else
{
	?>
	var latLng = new google.maps.LatLng(<?php echo $row->lat;?>, <?php echo $row->long;?>);
	<?php
}
?>
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 8,
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
 <style>
  #mapCanvas {
    width: 500px;
    height: 400px;
  }
  #infoPanel {
    
    margin-left: 10px;
  }
  #infoPanel div {
    margin-bottom: 5px;
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
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active">Districts</li>
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
								Districts
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
					   echo form_open('districts/edit_validate/'.$row->id,$attributes); ?>
<div class="control-group"><label><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls"><?php $data = array('id' => 'district', 'name' => 'district', 'value' => $row->district); echo form_input($data, set_value('district')); ?></div>
</div><div class="control-group"><label><?php echo $user_country->third_admin_level_label;?> code: </label><div class="controls"><?php $data = array('id' => 'district_code', 'name' => 'district_code', 'value' => $row->district_code); echo form_input($data, set_value('district_code')); ?></div>
</div><div class="control-group"><label><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
<select name="region_id" id="region_id">
<?php
foreach($regions as $key => $region)
{
	?>
    <option value="<?php echo $region['region_id'];?>" <?php if($region['region_id']==$row->region_id){ echo 'selected="selected"';}?> ><?php echo $region['region'];?></option>
    <?php
}
?>
</select>
</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Latitude: </label><div class="controls"><?php $data = array('id' => 'lat', 'name' => 'lat', 'value'=>$row->lat); echo form_input($data, set_value('lat')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Longitude: </label><div class="controls"><?php $data = array('id' => 'long', 'name' => 'long', 'value'=>$row->long); echo form_input($data, set_value('long')); ?></div>
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


<div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
