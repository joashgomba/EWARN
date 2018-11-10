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
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		document.getElementById('regions').innerHTML= region_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('zones').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
                    
                     <?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');
					  echo form_open('districts/filter',$attributes); ?>
                      
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
                    
                    <p>
                    <a href="<?php echo base_url() ?>index.php/districts/add" class="btn btn-primary">
										<i class="icon-edit bigger-110"></i>
										Add
										
									</a>
                    </p>
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th>
 <div align="right">
 <?php 
					   $attributes = array('name' => 'frm1', 'id' => 'frm1', 'class' => "form-search",'enctype' => 'multipart/form-data');
					  echo form_open('districts/search',$attributes); ?>

							<span class="input-icon">
								<input type="text" name="search" id="search" placeholder="Search ...." class="input-small nav-search-input"  autocomplete="off" required="required" />
								<i class="icon-search nav-search-icon"></i>
							</span>
						
                        <?php echo form_close(); ?> 
                        </div>
</th>
</tr>
</thead>
</table>
 <table id="sample-table-1" class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th colspan="6">
<div class="pagination">
<?php echo $links; ?>
 </div>
</th>
</tr>
<tr>
<th>Country</th>
<th><?php echo $user_country->first_admin_level_label;?></th>
<th><?php echo $user_country->second_admin_level_label;?></th>
<th><?php echo $user_country->third_admin_level_label;?></th>
<th><?php echo $user_country->third_admin_level_label;?> code</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $row): ?>
<tr>
<td><?php echo $row['country_name']; ?></td>
<td><?php echo $row['zone']; ?></td>
<td><?php echo $row['region']; ?></td>
<td><?php echo $row['district']; ?></td>
<td><?php echo $row['district_code']; ?></td>
<td>
<a href="<?php echo base_url() ?>index.php/districts/edit/<?php echo $row['district_id']; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                           
																<!--<a href="<?php echo base_url() ?>index.php/districts/delete/<?php echo $row['district_id']; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
																	<span class="red">
																		<i class="icon-trash bigger-120"></i>
																	</span>
																</a>--></td>
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
