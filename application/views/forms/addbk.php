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
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="icon-home home-icon"></i>
										<a href="<?php echo site_url('home')?>">Home</a>
										<span class="divider">
											<i class="icon-angle-right arrow-icon"></i>
										</span>
								</li>
								<li class="active">Reporting Form</li>
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
										Data Entry
										<small>
											<i class="icon-double-angle-right"></i>
											Reporting Form
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('',$attributes); ?>

<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>At Health Facility level</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												

												
												
											</div>
										</div>
									</div>

<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>At Health Facility level</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												

												
												
											</div>
										</div>
									</div>



<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
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
                                    <?php
								}
								else
								{
							   ?>
                               <strong><?php echo $zone->zone;?></strong>
                               <?php
								}
								?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
 <?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <div id="regions">
                                    <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="0">-All <?php echo $user_country->second_admin_level_label;?>s-</option>
                               
                                    </select>
                                    <!--<select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="0">-All Regions-</option>
                                    <?php
									foreach($regions as $key=>$region)
									{
									?>
                                    <option value="<?php echo $region['id'];?>"><?php echo $region['region'];?></option>
                                    <?php
									}
									?>
                                    </select>-->
                                    </div>
                                    <?php
								}
								else
								{
							   ?>
                               <strong><?php echo $region->region;?></strong>
                               <?php
								}
								?>
</div>
</div>


</div>
</div>



<?php
							  if($level != 3)
							  {
								  ?>
                                  <div class="row-fluid">
                            
                               
                               <div class="span6">

                                <div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
                                <?php
								$level = $this->erkanaauth->getField('level');
							  if($level == 3)
							  {
								  ?>
                                   <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
                                  <?php
							  }
							  else
							  {
								 if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <div id="districts">
                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								
                                </select>
                                    <!--<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								<?php
                                foreach($admindistricts as $key => $district)
                                {
                                    ?>
                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
                                    <?php
                                }
                                ?>
                                </select>-->
                                </div>
                                    <?php
								}
								else
								{
								  ?>
                                   <div id="districts">
                                   <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								<?php
                                foreach($districts as $key => $district)
                                {
                                    ?>
                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
                                    <?php
                                }
                                ?>
                                </select>
                                </div>
                                  <?php
								}
							  }
							  ?>
                                </div>
                                </div>
                                
                                </div>
                                
                                
                                <div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility: </label><div class="controls">
<?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                      <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                 
                                  </select>
                                   <!-- <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                  <?php
                                foreach($healthfacilities as $key => $healthfacility)
                                {
                                    ?>
                                  <option value="<?php echo $healthfacility['id'];?>" <?php if($healthfacility['id']==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility['health_facility'];?></option>
                                  <?php
								}
							  ?>
                                  </select>-->
                                    
                                    <?php
								}
								else
								{
								?>
                                  <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                  <?php
                                foreach($healthfacilities->result() as $healthfacility)
                                {
                                    ?>
                                  <option value="<?php echo $healthfacility->healthfacility_id;?>" <?php if($healthfacility->healthfacility_id==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility->health_facility;?></option>
                                  <?php
								}
							  ?>
                                  </select>
                                  <?php
								}
								?>
                                  </div>
                                  <?php echo form_error('healthfacility_id', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
                                  
                                  
                                  </div>
                                  <?php
							  }
							  ?>


 <?php
							
							  if($level == 3)
							  {
								  ?>
                                                               
                              <div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp;</label><div class="controls">
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

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Year: </label><div class="controls">
<select name="reporting_year" id="reporting_year" onChange="GetPeriod(this)">
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y')+1;
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
                               <?php echo form_error('reporting_year', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Week No: </label><div class="controls">
<select name="week_no" id="week_no" onChange="GetPeriod(this)">
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
                               <?php echo form_error('week_no', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Period: </label><div class="controls">
<div id="reporingperiods">
                               <input type="hidden" name="period_check" id="period_check" value="0">&nbsp;
                               </div>
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


<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Date: </label><div class="controls">
<?php echo form_error('reporting_date', '<div class="alert alert-danger">', '</div>'); ?>

<script>
						Date.prototype.yyyymmdd = function() {         
                                
        var yyyy = this.getFullYear().toString();                                    
        var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
        var dd  = this.getDate().toString();             
                            
        return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
   }; 

d = new Date();
today = d.yyyymmdd();


function formatDate(d){
   function pad(n){return n<10 ? '0'+n : n}
   return [d.getUTCFullYear(),'-',
          pad(d.getUTCMonth()+1),'-',
          pad(d.getUTCDate()),' ',
          pad(d.getUTCHours()),':',
          pad(d.getUTCMinutes()),':',
          pad(d.getUTCSeconds())].join("");
  }

  var dt = new Date();
  var formattedDate = formatDate(dt); 
						 
  document.write("<input type='hidden' name='datetime' value='" + formattedDate + "'><br>")
  document.write("<input type='text' readonly=''  name='reporting_date' id='form-input-readonly' value='" +today+ "'>")
							</script>

</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reported By:: </label><div class="controls">
<strong><?php //echo $this->erkanaauth->getField('fname');?> <?php //echo $this->erkanaauth->getField('lname');?>
                              
                              <?php
							  $username = getField('username');
							  
							  echo $username;
							  ?>
                              </strong>
</div>
</div>

</div>
</div>

 <?php
							  if($level == 3)
							  {
								  ?>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility Name: </label><div class="controls">
<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility->id;?>">
                              <input readonly="" type="text" id="form-input-readonly" value="<?php echo $healthfacility->health_facility;?>" />
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Contact Number: </label><div class="controls">
<?php echo form_error('contact_number', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '','name' => 'contact_number', 'value' => $healthfacility->contact_number); echo form_input($data, set_value('contact_number')); ?>
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility Code: </label><div class="controls">
<input readonly="" type="text" name="health_facility_code" id="form-input-readonly" value="<?php echo $healthfacility->hf_code;?>" />
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Supporting NGO: </label><div class="controls">
<?php echo form_error('supporting_ngo', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '', 'name' => 'supporting_ngo', 'value' => $healthfacility->organization); echo form_input($data, set_value('supporting_ngo')); ?>
</div>
</div>

</div>
</div>

<?php
							  }
							  else
							  {
								 //show nothing
							  }
							  ?>

                              
                              

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Label: </label><div class="controls">
Element
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Label: </label><div class="controls">
Element
</div>
</div>

</div>
</div>

<table id="customers">
                               <thead>
                               		<tr><th colspan="4">At Health Facility level</th></tr>
                               </thead>
                               <tbody>
                               
                                 
                               
                               
                               
                               
                               
                              
                              
                              <tr ><th colspan="2">Health Events Under Surveillance</th><th colspan="2">Total Cases</th></tr>
                              
                               <tr class="alt"><td valign="top" colspan="2">Respiratory Diseases</td><td valign="top">Male</td><td valign="top">Female</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &lt;5yr</td><td valign="top"><?php $data = array('id' => 'sariufivemale', 'name' => 'sariufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000'),checkvalid()", "onblur"=>"change(this,'','','')", 'onClick'=>'checkvalid()'); echo form_input($data, set_value('sariufivemale')); ?><?php echo form_error('sariufivemale', '<div class="alert alert-danger">', '</div>'); ?></td><td valign="top"><?php $data = array('id' => 'sariufivefemale', 'name' => 'sariufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariufivefemale')); ?><?php echo form_error('sariufivefemale', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &gt;5yr</td><td valign="top"><?php $data = array('id' => 'sariofivemale', 'name' => 'sariofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivemale')); ?>
                                <?php echo form_error('sariofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'sariofivefemale', 'name' => 'sariofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivefemale')); ?>
                                <?php echo form_error('sariofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &lt;5yr</td><td valign="top"><?php $data = array('id' => 'iliufivemale', 'name' => 'iliufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivemale')); ?>
                                <?php echo form_error('iliufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'iliufivefemale', 'name' => 'iliufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &gt;5yr</td><td valign="top">
                                <?php $data = array('id' => 'iliofivemale', 'name' => 'iliofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top">
                                  <?php $data = array('id' => 'iliofivefemale', 'name' => 'iliofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Gastro Intestinal Tract Disease</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &lt;5yr</td><td valign="top"><?php $data = array('id' => 'awdufivemale', 'name' => 'awdufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivemale')); ?>
                                <?php echo form_error('awdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdufivefemale', 'name' => 'awdufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivefemale')); ?>
                                <?php echo form_error('awdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &gt;5yr</td><td valign="top"><?php $data = array('id' => 'awdofivemale', 'name' => 'awdofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivemale')); ?>
                                <?php echo form_error('awdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdofivefemale', 'name' => 'awdofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivefemale')); ?>
                                <?php echo form_error('awdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'bdufivemale', 'name' => 'bdufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivemale')); ?>
                                <?php echo form_error('bdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdufivefemale', 'name' => 'bdufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivefemale')); ?>
                                <?php echo form_error('bdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'bdofivemale', 'name' => 'bdofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivemale')); ?>
                                <?php echo form_error('bdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdofivefemale', 'name' => 'bdofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivefemale')); ?>
                                <?php echo form_error('bdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Other Acute Diarrhea &lt;5yr</td><td valign="top"><?php $data = array('id' => 'oadufivemale', 'name' => 'oadufivemale'); echo form_input($data, set_value('oadufivemale')); ?>
                                 <?php echo form_error('oadufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'oadufivefemale', 'name' => 'oadufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadufivefemale')); ?>
                                 <?php echo form_error('oadufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Other Acute Diarrhea &gt;5yr</td><td valign="top"><?php $data = array('id' => 'oadofivemale', 'name' => 'oadofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivemale')); ?>
                                <?php echo form_error('oadofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'oadofivefemale', 'name' => 'oadofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivefemale')); ?>
                                <?php echo form_error('oadofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Vaccine Preventable Diseases</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Suspected Diphtheria &lt;5yr</td><td valign="top"><?php $data = array('id' => 'diphmale', 'name' => 'diphmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphmale')); ?>
                                
                                <?php echo form_error('diphmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'diphfemale', 'name' => 'diphfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphfemale')); ?>
                                <?php echo form_error('diphfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                                
                                  <tr>
                                <td valign="top" colspan="2">Suspected Diphtheria &gt;5yr</td><td valign="top"><?php $data = array('id' => 'diphofivemale', 'name' => 'diphofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphofivemale')); ?>
                                
                                <?php echo form_error('diphofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'diphofivefemale', 'name' => 'diphofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphofivefemale')); ?>
                                <?php echo form_error('diphofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                              <tr>
                                <td valign="top" colspan="2">Suspected Whooping Cough &lt;5yr</td><td valign="top"><?php $data = array('id' => 'wcmale', 'name' => 'wcmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcmale')); ?>
                                <?php echo form_error('wcmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'wcfemale', 'name' => 'wcfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcfemale')); ?>
                                <?php echo form_error('wcfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                                    <tr>
                                <td valign="top" colspan="2">Suspected Whooping Cough &gt;5yr</td><td valign="top"><?php $data = array('id' => 'wcofivemale', 'name' => 'wcofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcofivemale')); ?>
                                <?php echo form_error('wcofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'wcofivefemale', 'name' => 'wcofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcofivefemale')); ?>
                                <?php echo form_error('wcofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                               <tr>
                                 <td valign="top" colspan="2">Suspected Measles &lt;5yr</td><td valign="top"><?php $data = array('id' => 'measmale', 'name' => 'measmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measmale')); ?>
                                  <?php echo form_error('measmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'measfemale', 'name' => 'measfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measfemale')); ?>
                                  <?php echo form_error('measfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                                 
                                 <tr>
                                 <td valign="top" colspan="2">Suspected Measles &gt;5yr</td><td valign="top"><?php $data = array('id' => 'measofivemale', 'name' => 'measofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measofivemale')); ?>
                                  <?php echo form_error('measofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'measofivefemale', 'name' => 'measofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measofivefemale')); ?>
                                  <?php echo form_error('measofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                              <tr>
                                <td valign="top" colspan="2">Neonatal Tetanus</td><td valign="top"><?php $data = array('id' => 'nntmale', 'name' => 'nntmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntmale')); ?>
                                <?php echo form_error('nntmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'nntfemale', 'name' => 'nntfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntfemale')); ?>
                                <?php echo form_error('nntfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Acute Flaccid Paralysis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'afpmale', 'name' => 'afpmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpmale')); ?>
                                 <?php echo form_error('afpmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'afpfemale', 'name' => 'afpfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpfemale')); ?>
                                 <?php echo form_error('afpfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                                 
                                 <tr>
                                 <td valign="top" colspan="2">Acute Flaccid Paralysis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'afpofivemale', 'name' => 'afpofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpofivemale')); ?>
                                 <?php echo form_error('afpofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'afpofivefemale', 'name' => 'afpofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpofivefemale')); ?>
                                 <?php echo form_error('afpofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>

                               <tr class="alt"><td valign="top" colspan="4">Other Communicable Diseases</td></tr>
                             <tr>
                               <td valign="top" colspan="2">Suspected Acute Jaundice Syndrome</td><td valign="top"><?php $data = array('id' => 'ajsmale', 'name' => 'ajsmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsmale')); ?>
                               <?php echo form_error('ajsmale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'ajsfemale', 'name' => 'ajsfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsfemale')); ?>
                               <?php echo form_error('ajsfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Suspected Viral Hemorrhagic Fever/Ebola</td><td valign="top"><?php $data = array('id' => 'vhfmale', 'name' => 'vhfmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhfmale')); ?>
                              <?php echo form_error('vhfmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'vhffemale', 'name' => 'vhffemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhffemale')); ?>
                              <?php echo form_error('vhffemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               <tr><td valign="top" colspan="2">Confirmed Malaria &lt;5yr</td><td valign="top"><?php $data = array('id' => 'malufivemale', 'name' => 'malufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivemale')); ?>
                               <?php echo form_error('malufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'malufivefemale', 'name' => 'malufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivefemale')); ?>
                               <?php echo form_error('malufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Confirmed Malaria &gt;5yr</td><td valign="top"><?php $data = array('id' => 'malofivemale', 'name' => 'malofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivemale')); ?>
                              <?php echo form_error('malofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'malofivefemale', 'name' => 'malofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivefemale')); ?>
                              <?php echo form_error('malofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               
                               <tr><td valign="top" colspan="2">Suspected Meningitis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'suspectedmenegitismale', 'name' => 'suspectedmenegitismale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitismale')); ?>                             
                               <?php echo form_error('suspectedmenegitismale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisfemale', 'name' => 'suspectedmenegitisfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisfemale')); ?>
                               <?php echo form_error('suspectedmenegitisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                               
                               
                               <tr><td valign="top" colspan="2">Suspected Meningitis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisofivemale', 'name' => 'suspectedmenegitisofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisofivemale')); ?>                             
                               <?php echo form_error('suspectedmenegitisofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisofivefemale', 'name' => 'suspectedmenegitisofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisofivefemale')); ?>
                               <?php echo form_error('suspectedmenegitisofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                            
                              <tr class="alt"><td valign="top" colspan="4">Other Unusual Diseases or Deaths</td></tr>
                              <tr>
                                <td valign="top" colspan="2"><?php $data = array('id' => 'undisonedesc', 'name' => 'undisonedesc', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisonedesc')); ?>
                                 <?php echo form_error('undisonedesc', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'undismale', 'name' => 'undismale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismale')); ?>
                              <?php echo form_error('undismale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemale', 'name' => 'undisfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemale')); ?>
                              <?php echo form_error('undisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              
                              
                              <tr>
                                <td valign="top" colspan="2"><?php $data = array('id' => 'undissecdesc', 'name' => 'undissecdesc', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undissecdesc')); ?>
                                 <?php echo form_error('undissecdesc', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'undismaletwo', 'name' => 'undismaletwo', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismaletwo')); ?>
                              <?php echo form_error('undismaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemaletwo', 'name' => 'undisfemaletwo', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemaletwo')); ?>
                              <?php echo form_error('undisfemaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                                     <tr><td colspan="4"> <div id="container">
            <p id="add_field"><a href="javascript:void(0)" class="btn btn-success"><span>Add Fields</span></a></p>
        </div></td></tr>
                              
                              <tr><td valign="top" colspan="2">Other Consultations</td><td valign="top"><?php $data = array('id' => 'ocmale', 'name' => 'ocmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocmale')); ?>
                              <?php echo form_error('ocmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'ocfemale', 'name' => 'ocfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocfemale')); ?>
                              <?php echo form_error('ocfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                       
                              <tr><td valign="top" colspan="2">Total Consultations</td><td valign="top" colspan="2"><?php $data = array('id' => 'total_consultations', 'name' => 'total_consultations', 'readonly'=>'readonly'); echo form_input($data, set_value('total_consultations')); ?> <input type="button" value="CALCULATE" onClick="CalcConsultations()" ></td></tr>
                              
                              <tr class="alt"><td valign="top" colspan="4">Malaria Tests</td></tr>
                              <tr><td valign="top" colspan="2">Slides/RDT examined</td><td valign="top" colspan="2"><?php $data = array('id' => 'sre', 'name' => 'sre', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sre')); ?>
                              <?php echo form_error('sre', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Falciparum positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pf', 'name' => 'pf', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pf')); ?>
                              <?php echo form_error('pf', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Vivax positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pv', 'name' => 'pv', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pv')); ?>
                              <?php echo form_error('pv', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Mixed positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pmix', 'name' => 'pmix', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pmix')); ?>
                              <?php echo form_error('pmix', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <!--<tr><td valign="top" colspan="2">Total Negative</td><td valign="top" colspan="2"><?php $data = array('id' => 'totalnegative', 'name' => 'totalnegative', 'onkeyup' => 'doMath()'); echo form_input($data, set_value('totalnegative')); ?>
							  <?php echo form_error('totalnegative', '<div class="alert alert-danger">', '</div>'); ?></td></tr>-->
                              
                              <!--<tr class="alt"><td valign="top" colspan="4">Approvals</td></tr>
                              <tr><td valign="top" colspan="2">Submit for Regional Approval</td><td valign="top" colspan="2">
                              <select name="approved_hf" id="approved_hf">
                              	<option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                              </select>
                              </td></tr>-->
                               </tbody>
                               </table>
                                
<div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>

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
