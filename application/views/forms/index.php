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
	var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML= region_element;
		document.getElementById('districts').innerHTML= district_element
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/forms/getperiodbyhf";
	
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
	var district_element = '<select id="district_id" name="district_id">' + '<option value="0">Select One</option>' + '</select>';
	var health_element = '<select id="healthfacility_id" name="healthfacility_id">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		document.getElementById('districts').innerHTML= district_element
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/reportingforms/getdistricts";
	
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
								<li class="active">forms</li>
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
										Data entry
										<small>
											<i class="icon-double-angle-right"></i>
											forms
										</small>
									</h1>
								</div>
                                 <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');?>
<?php echo form_open('forms/search',$attributes); ?>
                                <div id="accordion2" class="accordion">
										<div class="accordion-group">
											<div class="accordion-heading">
												<a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">
													Search for records
												</a>
											</div>

											<div class="accordion-body collapse" id="collapseOne">
												<div class="accordion-inner">
													
                                                    <div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Select search parameters</h4>
										</div>
                                        
                                       

										<div class="widget-body">
											<div class="widget-main">
                                            
    <?php
if (getRole() == 'SuperAdmin')
{
	?>                                        
                                            
                                            <div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php
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
<?php
							   if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
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
							   if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
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
<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<?php
							
							  if($level == 3 || $level==6)
							  {
								  ?>
                                   <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
                                  <?php
							  }
							  elseif($level==2)
							  {
								  ?>
                                  <div id="districts">
                                  <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                   <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>
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
							  else
							  {
								  
								?>
                                 <div id="districts">
                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                   <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>
								
                                </select>
                                
                                </div>
                                
                                <?php  
							  }
							  
							  ?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility: </label><div class="controls">
<?php
							
							  if($level==3)
							  {
								  ?>
                                   <select name="healthfacility_id" id="healthfacility_id">
                              <option value="<?php echo $healthfacility->id;?>"><?php echo $healthfacility->health_facility;?></option>
                              </select>
                                  <?php
							  }
							  elseif($level==6)
							  {
								  ?>
                                   <select name="healthfacility_id" id="healthfacility_id">
                                          <option value="">Select Health Facility</option>
                                          <?php
                                              foreach($healthfacilities->result() as $healthfacility):
                                              
                                                 ?>
                                                 <option value="<?php echo $healthfacility->id;?>" <?php if($healthfacility->id==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility->health_facility;?></option> 
                                                 <?php 
                                             endforeach;
                                          ?>
                                          
                                          </select>
                                  <?php
							  }
							  else
							  {
								  
								?>
                                 <div id="healthfacilities">
                                    <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                 
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

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Year: </label><div class="controls">
<select name="reporting_year" id="reporting_year">
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
<select name="week_no" id="week_no">
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

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo form_submit('submit', 'SEARCH RECORDS', 'class="btn btn-info "'); ?> </label><div class="controls">
&nbsp; 
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


		
											</div>
										</div>
									</div>
                                                    
                                                    
												</div>
											</div>
										</div>

										

										
									</div>
							
                                
                                    <?php echo form_close(); ?>
                                     <?php
    	if(!empty($sucsess_message))
		{
		?>
        <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>
		<p>
											<strong>
												<i class="icon-ok"></i>
												&nbsp;
											</strong>
											<?php echo $sucsess_message;?>
		</p>
        </div>
	   <?php
	   }
	   ?>
                                    <div class="pagination">
										
                                        <?php echo $links; ?>
                                        
                                      </div>
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Health Facility</th>
												<th>Week No.</th>
												<th class="hidden-480">Reporting year</th>

												<th class="hidden-phone">
													<i class="icon-time bigger-110 hidden-phone"></i>Reporting date</th>
                                                <th>Timeliness</th>
                                                <th>Status</th>
												<th></th>
											</tr>
										</thead>

										<tbody>
                                        <?php foreach ($rows as $row): ?>
											<tr>
												<td>
                                                <?php 
												$healthfacility = $this->healthfacilitiesmodel->get_by_id($row['healthfacility_id'])->row();
												echo $healthfacility->health_facility; ?>
												</td>
												<td><?php echo $row['week_no']; ?></td>
												<td class="hidden-480"><?php echo $row['reporting_year']; ?></td>
												<td class="hidden-phone"><?php echo $row['reporting_date']; ?></td>

                                                <td>
                                                    <?php
                                                    if ($row['timely'] == 0) {
                                                    ?>
                                                        <strong><font color="#FF0000">Not Timely</font> </strong>
                                                    <?php
                                                    }
                                                    else{
                                                        ?>
                                                    <strong><font color="#008000">Timely</font> </strong>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                <?php
												if ($row['approved_dist'] == 0) {
													?>
                                                    <span class="label label-important arrowed-in">Submited HF (Not validated <?php echo $user_country->third_admin_level_label;?>)</span>
                                                    
                                                   
                                                    <?php
												}
												else if ($row['approved_dist'] == 1)
												{
													if($row['approved_region']==0)
													{
														//approved district
														?>
                                                         <span class="label label-info">Validated <?php echo $user_country->third_admin_level_label;?></span>
                                                        <?php
													}
													else if($row['approved_region']==1)
													{
														if($row['approved_zone']==0)
														{
															// approved region
															?>
                                                            <span class="label label-warning">Validated <?php echo $user_country->second_admin_level_label;?></span> 
                                                            <?php
														}
														else
														{
															//approved zone
															?>
                                                            <span class="label label-success">Validated <?php echo $user_country->first_admin_level_label;?></span>
                                                            <?php
														}
													}
												
												}
												?>
                                                </td>
												<td>
                                                <?php
												if ($row['approved_dist'] == 0) {
													?>
													<a href="<?php echo base_url() ?>index.php/forms/edit/<?php echo $row['id']; ?>" class="btn btn-mini btn-success" data-rel="tooltip" title="Edit">
                                                    <i class="icon-edit bigger-120"></i>
                                                    </a>
                                                    <?php
												}
												?>
                                                    <a href="<?php echo base_url() ?>index.php/forms/view/<?php echo $row['id']; ?>" class="btn btn-mini btn-info" data-rel="tooltip" title="View">
                                                    <i class="icon-zoom-in bigger-120"></i>
                                                    </a>

													
												</td>
											</tr>
                                            <?php endforeach; ?>
                                         
										</tbody>
									</table>
                                     
                                    
                                    



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
