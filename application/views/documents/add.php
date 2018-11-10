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
	var district_element = '<select id="district_id" name="district_id">' + '<option value="">Select One</option>' + '</select>';
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		document.getElementById('districts').innerHTML= district_element;
		
		
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

						<li class="active">Information Resources</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Reports
							<small>
								<i class="icon-double-angle-right"></i>
								Information Resources
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
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
echo form_open('documents/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php
$thecountry = $this->countriesmodel->get_by_id($country_id)->row();
if(getRole() == 'Admin' || getRole() == 'User')
{
	echo '<strong>'.$thecountry->country_name.'</strong>';
	?>
    <input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>">
    <?php
		
}
else
{
?>
<select name="country_id" id="country_id" required="required" onChange="GetZones(this)">
                                  <option value="">-Select Country-</option>
<?php
foreach($countries as $key => $country)
{
	if(getRole() == 'Admin' || getRole() == 'User')
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
<?php
}
?>
</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<?php 
							   if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
	  							{
									?>
                                    <div id="zones">
                                    <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="">-Select Zone-</option>
                                <option value="">-All Zones-</option>
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
                                    <?php
								}
								else
								{

								   if($level==2 || $level==6)//FP
								   {
									  echo '<strong>'.$zone->zone.'</strong>';
									 ?>
									  <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
									  <?php
								   }
								   else if($level==1)//Zonal
								   {
									   ?>
                                       <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
                                       <?php
									   echo '<strong>'.$zone->zone.'</strong>';
								   }
								   else
								   {
									   ?>
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
                                       <?php
								   }
								}
								   ?>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
<?php 
							   if($level==2 || $level==6)
							   {
								  echo '<strong>'.$region->region.'</strong>';
								  ?>
                                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">
                                  
                                  <?php
							   }
							   else if($level==1)
							   {
								   ?>
                                     <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="">All Regions</option>
                                    <?php
									foreach($regions as $key=>$region)
									{
									?>
                                    <option value="<?php echo $region['id'];?>"><?php echo $region['region'];?></option>
                                    <?php
									}
									?>
                                    </select>
                                   
                                   <?php
							   }
							   else
							   {
								   ?>
                                   <div id="regions">
                                   <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                   <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option
                                   ></select>
                                
                                    </div>
                                   <?php
							   }?>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<div id="districts">
                            <?php
							if($level==6)
							{
								 echo '<strong>'.$district->district.'</strong>';
								?>
                                <input type="hidden" name="district_id" id="district_id" value="<?php echo $district->id?>">
                                <?php
							}
							elseif($level==1)
							{
								?>
                                <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                <option value="">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                  <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                </select>
                                <!--<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                  <option value="">-All Districts-</option>
                                  <option value="">Select District</option>
                                  <?php
                                foreach($districts->result() as $district)
                                {
                                    ?>
                                  <option value="<?php echo $district->district_id;?>" <?php if($district->district_id==set_value('district_id')){ echo 'selected="selected"';}?>><?php echo $district->district;?></option>
                                  <?php
								}
							  ?>
                                  </select>-->
                                <?php
							}
							else
							{
							?>
                                      <!-- <select name="district_id" id="district_id" >
                                <option value="">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                  <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                </select>-->
                                   <select name="district_id" id="district_id">
                                   <option value="">Select District</option>
								<?php
                                foreach($districts as $key => $district)
                                {
                                    ?>
                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
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
<div class="control-group"><label class="control-label" for="form-field-1">Upload Document: </label><div class="controls">
<input type="file" name="userfile" id="userfile" />
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Title: </label><div class="controls"><?php $data = array('id' => 'title', 'name' => 'title'); echo form_input($data, set_value('title')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Description: </label><div class="controls"><?php $data = array('id' => 'description', 'name' => 'description'); echo form_textarea($data, set_value('description')); ?></div>
</div>
<div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>