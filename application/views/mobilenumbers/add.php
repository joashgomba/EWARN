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
	
	
	function GetZones(frm){
	if(validateForm(frm)){
	document.getElementById('zones').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/users/getzones";
	
	var params = "country_id=" + totalEncode(document.frm.country_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML='<select id="region_id" name="region_id"></select>';
		document.getElementById('districts').innerHTML='<select id="district_id" name="district_id"></select>';
		document.getElementById('healthfacilities').innerHTML='<select id="healthfacility_id" name="healthfacility_id"></select>';
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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

						<li class="active">Mobile Numbers</li>
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
								Mobile Numbers
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
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
				echo form_open('mobilenumbers/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Name: </label><div class="controls"><?php $data = array('id' => 'name', 'name' => 'name', 'required'=>'required'); echo form_input($data, set_value('name')); ?></div>
<div class="control-group"><label class="control-label" for="form-field-1">Designation: </label><div class="controls"><?php $data = array('id' => 'designation', 'name' => 'designation', 'required'=>'required'); echo form_input($data, set_value('designation')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Organization: </label><div class="controls"><?php $data = array('id' => 'organization', 'name' => 'organization', 'required'=>'required'); echo form_input($data, set_value('organization')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Sector: </label><div class="controls">
<select name="diseasecategory_id" id="diseasecategory_id" required="required">
<option value="">Select Sector</option>
<?php
foreach($diseasecategories as $key => $diseasecategory)
{
	?>
    <option value="<?php echo $diseasecategory['id'];?>" <?php if($diseasecategory['id']==set_value('diseasecategory_id')){ echo 'selected="selected"';}?> ><?php echo $diseasecategory['category_name'];?></option>
    <?php
}
?>
<option value="0">All diseases</option>
</select>
</div>
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
<select name="zone_id" id="zone_id">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                
                                </select>
 </div>
                                
</div>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
<div id="regions">
<select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                 <option value="">-Select <?php echo $user_country->second_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->second_admin_level_label;?>-</option>
                                </select>
</div>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<div id="districts">
    <select name="district_id" id="district_id">
    <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
     <option value="">-All <?php echo $user_country->third_admin_level_label;?>-</option>
    </select>
    </div>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Phone number: </label><div class="controls"><?php $data = array('id' => 'phone_number', 'name' => 'phone_number', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'12', 'required'=>'required'); echo form_input($data, set_value('phone_number')); ?> <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Enter numbers in this format (no + sign) 25290001122" title="Mobile phone format">?</span></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email', 'required'=>'required'); echo form_input($data, set_value('email')); ?></div>
</div>

</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
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
