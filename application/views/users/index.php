<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
/* Make Table Responsive --- */
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
.display table, .display thead, .display th, .display tr, .display td {
display: block;
}
/* Hide table headers (but not display:none, for accessibility) */
.display thead tr {
position: absolute;
top: -9999px;
left: -9999px;
}
.display tr {
border: 1px solid #ccc;
}
.display td {
/* Behave like a row */
border: none;
padding-left: 50%;
border-bottom: 1px solid #eee;
position: relative;
}
.display td:before {
/* Now, like a table header */
/**position: absolute;**/
/* Top / left values mimic padding */
top: 6px; left: 6px;
width: 45%;
padding-right: 10px;
font-weight:bold;
white-space: nowrap;
}
/* -- LABEL THE DATA -- */
.display td:nth-of-type(1):before { content: ""; }
.display td:nth-of-type(2):before { content: "Id"; }
.display td:nth-of-type(3):before { content: "First Name"; }
.display td:nth-of-type(4):before { content: "Last Name"; }
.display td:nth-of-type(5):before { content: "Username"; }
.display td:nth-of-type(6):before { content: "Registration Type"; }
.display td:nth-of-type(7):before { content: "Active"; }
.display td:nth-of-type(8):before { content: "Action"; }
 
}/* End responsive query */

</style>
<script>
function validateSubmit()
{
	
	var chks = document.getElementsByName('user_id[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
	if (chks[i].checked)
	{
	hasChecked = true;
	break;
	}
	}
	if (!hasChecked)
	{
	alert("Please select at least one user");
	chks[0].focus();
	return false;
	}
	
	
			
	return true;
	
}
</script>


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
	
	var region_element = '<select id="region_id" name="region_id">' + '<option value="0">Select One</option>' + '</select>';
	var district_element = '<select id="district_id" name="district_id">' + '<option value="0">Select One</option>' + '</select>';
	
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML= region_element;
		document.getElementById('districts').innerHTML= district_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetRegions(frm){
	if(validateForm(frm)){
	document.getElementById('regions').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getregions";
	
	var params = "zone_id=" + totalEncode(document.frm.zone_id.value );
	var connection=connect(url,params);
	
	var district_element = '<select id="district_id" name="district_id">' + '<option value="0">Select One</option>' + '</select>';
	
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

						<li class="active">Users</li>
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
								Users
							</small>
						</h1>
					</div><!--/.page-header-->
                    <p>
                       <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');
					  echo form_open('users/filter',$attributes); ?>
                      
                     <div id="accordion2" class="accordion">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
													Filter records
												</a>
											</div>

											<div class="accordion-body collapse" id="collapseOne">
												<div class="accordion-inner">
													
                                                    <div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Select filter parameters</h4>
										</div>
                                        
                                       

										<div class="widget-body">
											<div class="widget-main">
												
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
    <option value="0"> - Select Country - </option>
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

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
 <?php
if (getRole() == 'Admin')
{
	?>
    <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="0">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="0">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                <?php
								foreach($zones as $key=> $zone)
								{
									?>
                                    <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
                                    <?php
								}
								?>
                                </select>
    <?php
}
else
{
	?>
    <div id="zones">
    <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="0">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="0">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                               
                                </select>
                                
                                </div>
    
    <?php
}
?>
</div>
</div>


</div>
</div>

<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
<div id="regions">
                                    <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="0">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="0">-All <?php echo $user_country->second_admin_level_label;?>s-</option>
                               
                                    </select>
                                    </div>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
 
  <div id="districts">
                                    <select name="district_id" id="district_id" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								
                                </select>
                                
                                </div>
 
</div>
</div>


</div>
</div>


<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Registration Type: </label><div class="controls">
<select name="level" id="level">
<option value="0">-Select Type-</option>
<option value="4">National</option>
<option value="1"><?php echo $user_country->first_admin_level_label;?></option>
<option value="2"><?php echo $user_country->second_admin_level_label;?> FP</option>
<option value="6"><?php echo $user_country->third_admin_level_label;?> FP</option>
<option value="3">Health Facility</option>
<option value="5">Stake holder </option>
</select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp; </label><div class="controls">
<?php echo form_submit('submit', 'FILTER RECORDS', 'class="btn btn-info "'); ?>
</div>
</div>

</div>
</div>


		
											</div>
										</div>
									</div>
                                                    
                                                    
												</div>
											</div>
										</div>

										

										
									</div>
                 <?php echo form_close(); ?>
                
                  
                   <?php 
					   $attributes = array('name' => 'frm1', 'id' => 'frm1', 'enctype' => 'multipart/form-data', 'onsubmit' =>'return validateSubmit()');
					  echo form_open('users/activation',$attributes); ?>
                      
                      <div class="row-fluid">

<div class="span12">

<div class="control-group"><label class="control-label" for="form-field-1">With selected: </label><div class="controls">
<select name="activation" id="activation">
 <option value="1">Activate</option>
 <option value="0">Deactivate</option>
 </select>
 <?php echo form_submit('submit', 'Go', 'class="btn btn-info "'); ?>
</div>
</div>

</div>

</div>

<div class="row-fluid">

<div class="span12">

<div class="control-group"><label class="control-label" for="form-field-1"><a href="<?php echo base_url() ?>index.php/users/export" class="btn btn-success" target="_blank">Export to excel</a> <a href="<?php echo base_url() ?>index.php/users/add" class="btn btn-primary">
										<i class="icon-edit bigger-110"></i>
										Add New
										
									</a></label><div class="controls">&nbsp;

</div>
</div>

</div>



</div>
                                  
                    </p>
                   
                   
										
                                        
                                        
                                     
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th colspan="8">
<div class="pagination">
<?php echo $links; ?>
 </div>
</th>
</tr>
<tr>
<th colspan="8"><a href="<?php echo base_url() ?>index.php/users/find/A">A</a> | <a href="<?php echo base_url() ?>index.php/users/find/B">B</a> | <a href="<?php echo base_url() ?>index.php/users/find/C">C</a> | <a href="<?php echo base_url() ?>index.php/users/find/D">D</a> | <a href="<?php echo base_url() ?>index.php/users/find/E">E</a> | <a href="<?php echo base_url() ?>index.php/users/find/F">F</a> | <a href="<?php echo base_url() ?>index.php/users/find/G">G</a> | <a href="<?php echo base_url() ?>index.php/users/find/H">H</a> | <a href="<?php echo base_url() ?>index.php/users/find/I">I</a> | <a href="<?php echo base_url() ?>index.php/users/find/J">J</a> | <a href="<?php echo base_url() ?>index.php/users/find/K">K</a>| <a href="<?php echo base_url() ?>index.php/users/find/L">L</a> | <a href="<?php echo base_url() ?>index.php/users/find/M">M</a> | <a href="<?php echo base_url() ?>index.php/users/find/N">N</a> | <a href="<?php echo base_url() ?>index.php/users/find/O">O</a> | <a href="<?php echo base_url() ?>index.php/users/find/P">P</a>| <a href="<?php echo base_url() ?>index.php/users/find/Q">Q</a> | <a href="<?php echo base_url() ?>index.php/users/find/R">R</a> | <a href="<?php echo base_url() ?>index.php/users/find/S">S</a> | <a href="<?php echo base_url() ?>index.php/users/find/T">T</a> | <a href="<?php echo base_url() ?>index.php/users/find/U">U</a> | <a href="<?php echo base_url() ?>index.php/users/find/V">V</a> | <a href="<?php echo base_url() ?>index.php/users/find/W">W</a> | <a href="<?php echo base_url() ?>index.php/users/find/X">X</a> | <a href="<?php echo base_url() ?>index.php/users/find/Y">Y</a> | <a href="<?php echo base_url() ?>index.php/users/find/Z">Z</a></th>
</tr>
<tr>
<th>&nbsp;</th>

<th>Fname</th>
<th>Lname</th>
<th>Username</th>
<th>Country</th>
<th>Registration Type</th>
<th>Active</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row): ?>
<?php

if(getRole() == 'Admin' && $row['role_id']==1) 
{
}
else
{

?>

<tr>
<td><div class="control-group">
<div class="controls">
												<label>
													<input name="user_id[]" id="user_id" type="checkbox" value="<?php echo $row['id']; ?>"/>
													<span class="lbl"> &nbsp;</span>
												</label>
                                                
                                                </div>
                                                </div></td>

<td><?php echo $row['fname']; ?></td>
<td><?php echo $row['lname']; ?></td>
<td><?php echo $row['username']; ?></td>
<td>
<?php
$country = $this->countriesmodel->get_by_id($row['country_id'])->row();
echo $country->country_name;
?>
</td>
<td><?php 
$nationality = $this->countriesmodel->get_by_id($row['country_id'])->row();
if($row['level']==2)
{
	echo $nationality->second_admin_level_label.' FP';
}
else if($row['level']==3)
{
	echo 'Health Facility';
}
else if($row['level']==1)
{
	echo $nationality->first_admin_level_label;
}
else if($row['level']==4)
{
	echo 'National';
}
else if($row['level']==6)
{
	echo $nationality->third_admin_level_label.' FP';
}
else
{
	echo 'Stake holder';
}
?></td>

<td><?php 
if($row['active']==1)
{
	echo '<a href="'.base_url().'index.php/users/deactivate/'.$row['id'].'" class="icon-check" data-rel="tooltip" title="Active">Yes</a>';
}
else
{
	echo '<a  href="'.base_url().'index.php/users/activate/'.$row['id'].'" class=" icon-check-empty " data-rel="tooltip" title="Inactive">No</a>';
}
 ?></td>
<td><a href="<?php echo base_url() ?>index.php/users/edit/<?php echo $row['id']; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a></td>
</tr>
<?php

}
?>
<?php endforeach; ?>

</tbody>
</table>
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
