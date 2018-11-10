<?php include(APPPATH . 'views/common/header.php'); ?>
<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      //-->
</SCRIPT>

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
	
	function checkusername(frm){
	if(validateForm(frm)){
	document.getElementById('check').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/checkusername";
	
	var params = "username=" + totalEncode(document.frm.username.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('check').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('check').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
function GetHelathfacility(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacility').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/gethealthfacility";
	
	var params = "hfcode=" + totalEncode(document.frm.hfcode.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacility').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacility').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	
	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/users/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetRoles(frm){
	if(validateForm(frm)){
	document.getElementById('roles').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getroles";
	
	var params = "level=" + totalEncode(document.frm.level.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('roles').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('roles').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	</script>
    
    <script type="text/javascript">
<!--
// Form validation code will come here.
function validate()
{
	var e = document.getElementById("level");
	var level = e.options[e.selectedIndex].value;
	
	//var leveltxt = e.options[e.selectedIndex].text;//to get the text value
	
	
		
	if( document.frm.level.value == "" )
   {
     alert( "Please enter the registration type" );
     document.frm.level.focus() ;
     return false;
   }
   
   if(level==3)
   {
	   if( document.frm.healthfacility_id.value == "" )
	   {
		 alert( "Please enter the healthfacility" );
		 document.frm.level.focus() ;
		 return false;
	   }
   }
   
    if(level!=4 && level !=5)
   {
	   if( document.frm.zone_id.value == "" )
	   {
		 alert( "Please enter the zone" );
		 document.frm.zone_id.focus() ;
		 return false;
	   }
   }
   
   if(level==2)
   {
	 
		if( document.frm.region_id.value == "" )
	   {
		 alert( "Please enter the region. A Regional Focal person MUST have a region and cannot manage all regions." );
		 document.frm.region_id.focus() ;
		 return false;
	   }
	}
      
   if(level==3)
   {
	 
		if( document.frm.region_id.value == "" )
	   {
		 alert( "Please enter the region" );
		 document.frm.region_id.focus() ;
		 return false;
	   }
	   
	   if( document.frm.district_id.value == "" )
	   {
		 alert( "Please enter the district" );
		 document.frm.district_id.focus() ;
		 return false;
	   }
   }
   
  
   
   if( document.frm.organization.value == "" )
   {
     alert( "Please enter the organization" );
     document.frm.organization.focus() ;
     return false;
   }
   
    if( document.frm.email.value == "" )
   {
     alert( "Please enter the email" );
     document.frm.email.focus() ;
     return false;
   }
   
    if( document.frm.contact_number.value == "" )
   {
     alert( "Please enter the contact number" );
     document.frm.contact_number.focus() ;
     return false;
   }
   
     
   if( document.frm.fname.value == "" )
   {
     alert( "Please enter the First Name" );
     document.frm.fname.focus() ;
     return false;
   }
   
   if( document.frm.lname.value == "" )
   {
     alert( "Please enter the Last Name" );
     document.frm.lname.focus() ;
     return false;
   }
   
   if( document.frm.username.value == "" )
   {
     alert( "Please enter the username" );
     document.frm.username.focus() ;
     return false;
   }
   
   if( document.frm.password.value == "" )
   {
     alert( "Please enter the pasword" );
     document.frm.password.focus() ;
     return false;
   }
   
   if( document.frm.retypepassword.value == "" )
   {
     alert( "Please enter the retype pasword" );
     document.frm.retypepassword.focus() ;
     return false;
   }
   
   var str = document.getElementById("username").value;
	if (str.match(' ')) {
		alert( "Please make sure the username field has no space" );
		 document.frm.username.focus() ;
		 return false;
	}
	
	var pass = document.getElementById("password").value;
	if (pass.match(' ')) {
		alert( "Please make sure the password field has no space" );
		 document.frm.password.focus() ;
		 return false;
	}
   
   var password = document.frm.password.value;
	var retypepassword = document.frm.retypepassword.value;
	
	if(password != retypepassword)
	{
		alert( "Retype password value must be the same us the password" );
		 document.frm.retypepassword.focus() ;
		 return false;
	}

   
   return( true );
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
								Users</small>
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
					   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
					  echo form_open('users/add_validate',$attributes); ?>
                      
                       <table id="customers">
                               <thead>
                               		<tr><th colspan="2">User Registration</th></tr>
                               </thead>
                               <tbody>
                               <tr>
								  <td>Country <span class="red">*</span></td><td>
                                  <select name="country_id" id="country_id" required="required" onChange="GetZones(this)">
                                  <option value="">-Select Country-</option>
<?php
foreach($countries as $key => $country)
{
	if(getRole() == 'Admin')
	{
		if($country_id != $country['id'])
		{
		}
		else
		{
		?>
        <option value="<?php echo $country['id'];?>" <?php if($country['id']==set_value('country_id')){ echo 'selected="selected"';}?> ><?php echo $country['country_name'];?></option>
        <?php
		}
	}
	else
	{
	?>
    <option value="<?php echo $country['id'];?>" <?php if($country['id']==set_value('country_id')){ echo 'selected="selected"';}?> ><?php echo $country['country_name'];?></option>
    <?php
	}
}
?>
</select>
                                  
                                  </td></tr>
								<tr>
								  <td><?php echo $user_country->first_admin_level_label;?> <span class="red">*</span></td><td><div id="zones">
    <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                               
                                </select>
                                
                                </div></td></tr>
								<tr><td><?php echo $user_country->second_admin_level_label;?> <span class="red">*</span></td><td>
                                <div id="regions">
                                <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                 <option value="">-Select <?php echo $user_country->second_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->second_admin_level_label;?>s-</option>
                                </select>
                                <!--<select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                <option value="">-Select Region-</option>
                                <option value="">-All Regions-</option>
                                <?php
								foreach($regions as $key=> $region)
								{
									?>
                                    <option value="<?php echo $region['id'];?>"  <?php if(set_value('region_id')==$region['id']){echo 'selected="selected"';}?>><?php echo $region['region'];?></option>
                                    <?php
								}
								?>
                                </select>-->
                                </div>
                                </td></tr>
                                <tr><td><?php echo $user_country->third_admin_level_label;?> <span class="red">*</span></td><td><div id="districts">
                                <select name="district_id" id="district_id">
                                    <option value="">-Select <?php echo $user_country->third_admin_level_label;?>-</option>
                                    <option value="">-All <?php echo $user_country->third_admin_level_label;?>s-</option>
                                </select>
                                <!--<select name="district_id" id="district_id">
                                <option value="">-Select District-</option>
                                <option value="">-All Districts-</option>
                                 <?php
								foreach($districts as $key=> $district)
								{
									?>
                                    <option value="<?php echo $district['id'];?>" <?php if(set_value('district_id')==$district['id']){echo 'selected="selected"';}?>><?php echo $district['district'];?></option>
                                    <?php
								}
								?>
                                </select>
                                -->
                                </div></td></tr>
                               <tr><td>Registration Type</td><td><select name="level" id="level" onChange="showDiv(this.value);GetRoles(this);">
<!--<option value="1">Zone</option>-->
<option value="">-Select Type-</option>
<option value="4">National</option>
<option value="1"><?php echo $user_country->first_admin_level_label;?></option>
<option value="2"><?php echo $user_country->second_admin_level_label;?> FP</option>
<option value="6"><?php echo $user_country->third_admin_level_label;?> FP</option>
<option value="3">Health Facility</option>
<option value="5">Stake holder </option>
</select>
<?php echo form_error('level', '<div class="alert alert-danger">', '</div>'); ?>
</td></tr>
 <script type="text/javascript"><!--
var lastDiv = "";
function showDiv(divName) {
	// hide last div
	if (lastDiv) {
		document.getElementById(lastDiv).className = "hiddenDiv";
	}
	//if value of the box is not nothing and an object with that name exists, then change the class
	if (divName && document.getElementById(divName)) {
		document.getElementById(divName).className = "visibleDiv";
		lastDiv = divName;
	}
}
//-->
</script>
		<style type="text/css" media="screen"><!--
.hiddenDiv {
	display: none;
	}
.visibleDiv {
	display: block;
	border: 1px grey solid;
	}

--></style>
<tr><td colspan="2">
<div id="3" class="hiddenDiv">
<!--<p>Health Facility code: <input type="text" name="hfcode" id="hfcode"></p>-->
<div class="control-group"><label class="control-label" for="form-field-1">Health Facility:  </label><div class="controls"><!--<input type="text" name="hfcode" id="hfcode"><input type="button" value="FIND" onClick="GetHelathfacility(this)">-->
<input type="button" value="FIND" onClick="GetHealthFacilities(this)" class="btn btn-success">

</div>
</div>
</div>

</td></tr>
<tr><td colspan="2">
<div id="healthfacilities">

<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="0"></div></td></tr>

                                <tr><td>Organization <span class="red">*</span></td><td><input type="text" name="organization" id="organization"></td></tr>
                                <tr>
                                  <td>Email <span class="red">*</span></td><td><input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>"></td></tr>
                                <tr><td>Contact Number <span class="red">*</span></td><td><input type="text" name="contact_number" id="contact_number" value="<?php echo set_value('contact_number'); ?>" onKeyPress="return isNumberKey(event)"  maxlength="12" > <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Enter numbers in this format (no + sign) 25290001122" title="Mobile phone format">?</span></td></tr>
                                <tr><td>First Name <span class="red">*</span></td><td><input type="text" name="fname" id="fname" value="<?php echo set_value('fname'); ?>"><?php echo form_error('fname', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td>Last Name <span class="red">*</span></td><td><input type="text" name="lname" id="lname" value="<?php echo set_value('lname'); ?>"><?php echo form_error('lname', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td>User Name <span class="red">*</span></td><td><input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" onKeyPress="checkusername()" onFocus="checkusername()" onKeyUp="checkusername()"><div id="check"></div><?php echo form_error('username', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td>Password <span class="red">*</span></td><td><input type="password" name="password" id="password"><?php echo form_error('password', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td>Retype Password <span class="red">*</span></td><td><input type="password" name="retypepassword" id="retypepassword"><?php echo form_error('retypepassword', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td>Access Rights</td><td>
                                <div id="roles">
                                <select name="role_id" id="role_id">
                                <option value="3">User</option>
                                
                                </select>
                                </div>
                                <!--<select name="role_id" id="role_id">
<?php
foreach($roles as $key => $role)
{
	?>
    <option value="<?php echo $role['id'];?>" <?php if($role['id']==3){ echo 'selected="selected"';}?> ><?php echo $role['name'];?></option>
    <?php
}
?>
</select>--></td></tr>
<tr><td>Activate</td><td><select name="active" id="active">
<option value="1" selected="selected">Yes</option>
<option value="0" >No</option>
</select></td></tr>
                               </tbody>
                               
                               </table>
                               
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
