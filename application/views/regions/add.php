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
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('zones').innerHTML=connection.responseText;
		
		
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

						<li class="active"><?php echo $user_country->second_admin_level_label;?></li>
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
								<?php echo $user_country->second_admin_level_label;?>
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
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');

				echo form_open('regions/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls"><?php $data = array('id' => 'region', 'name' => 'region'); echo form_input($data, set_value('region')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?> code: </label><div class="controls"><?php $data = array('id' => 'regional_code', 'name' => 'regional_code'); echo form_input($data, set_value('regional_code')); ?></div>
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
<!--<select name="zone_id" id="zone_id">
<?php
foreach($zones as $key => $zone)
{
	?>
    <option value="<?php echo $zone['id'];?>" <?php if($zone['id']==set_value('zone_id')){ echo 'selected="selected"';}?> ><?php echo $zone['zone'];?></option>
    <?php
}
?>
</select>-->
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
