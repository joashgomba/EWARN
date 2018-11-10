<?php include(APPPATH . 'views/common/header.php'); ?>
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
	var region_element = '<select id="region_id" name="region_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	var district_element = '<select id="district_id" name="district_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML= region_element;
		document.getElementById('districts').innerHTML= district_element;
		
		
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
	var district_element = '<select id="district_id" name="district_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		document.getElementById('districts').innerHTML= district_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/reportingforms/getalldistricts";
	
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

						<li class="active">Health Facilities</li>
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
								Health Facilities</small>
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
				  $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
				echo form_open('healthfacilities/add_validate',$attributes); ?>
                <div class="control-group"><label class="control-label" for="form-field-1">Organization: </label><div class="controls"><?php $data = array('id' => 'organization', 'name' => 'organization'); echo form_input($data, set_value('organization')); ?></div>
                </div>
<div class="control-group"><label class="control-label" for="form-field-1">Health facility name: </label><div class="controls"><?php $data = array('id' => 'health_facility', 'name' => 'health_facility'); echo form_input($data, set_value('health_facility')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Health facility type: </label><div class="controls">
<select name="health_facility_type" id="health_facility_type">

    
     <option value="MCH" <?php if(set_value('health_facility_type')=='MCH'){ echo 'selected="selected"';}?>>MCH</option>
				<option value="Hospital" <?php if(set_value('health_facility_type')=='Hospital'){ echo 'selected="selected"';}?>>Hospital</option>
				<option value="Other" <?php if(set_value('health_facility_type')=='Other'){ echo 'selected="selected"';}?>>Other</option>

</select>
</div>
</div
>
<div class="control-group"><label class="control-label" for="form-field-1">Enter if other: </label><div class="controls">
<input type="text" name="othervalue" id="othervalue" value="">
</div>
</div
>

<div class="control-group"><label class="control-label" for="form-field-1">Hf code: </label><div class="controls"><?php $data = array('id' => 'hf_code', 'name' => 'hf_code'); echo form_input($data, set_value('hf_code')); ?></div>
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
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
     <div id="districts">
    <select name="district_id" id="district_id" required="required">
    <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
    </select>
    </div>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Catchment population: </label><div class="controls"><?php $data = array('id' => 'catchment_population', 'name' => 'catchment_population'); echo form_input($data, set_value('catchment_population')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Focal person name: </label><div class="controls"><?php $data = array('id' => 'focal_person_name', 'name' => 'focal_person_name'); echo form_input($data, set_value('focal_person_name')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Contact number: </label><div class="controls"><?php $data = array('id' => 'contact_number', 'name' => 'contact_number'); echo form_input($data, set_value('contact_number')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email'); echo form_input($data, set_value('email')); ?></div>
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
