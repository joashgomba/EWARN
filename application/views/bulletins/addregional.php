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
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getperiod";
	
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
	
	
	function CheckAvailability(frm){
	if(validateForm(frm)){
	document.getElementById('availability').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/bulletins/checkregionavailability";
	
	var params = "week_year=" + totalEncode(document.frm.week_year.value ) + "&week_no="+totalEncode(document.frm.week_no.value )+ "&region_id="+totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('availability').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('availability').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	
function validate()
{
  if( document.frm.period_check.value == 1)
   {
     alert( "The bulleting for the selected year and week has already been added." );
     document.frm.week_no.focus() ;
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

						<li class="active">Regional Weekly Reports</li>
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
								Regional Weekly Reports
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
echo form_open('bulletins/add_region_validate',$attributes); ?>
<table id="customers">
<tr><td>Region</td><td>
<?php
if($level==2)
{
	echo '<strong>'.$region->region.'</strong>';
	?>
    <input type="hidden" name="region_id" id="region_id" value="<?php $region->id;?>">
    <?php
}
else
{
	?>
    <select name="region_id" id="region_id" onChange="CheckAvailability(this)">
                                <?php
								foreach($regions as $key=> $region)
								{
									?>
                                    <option value="<?php echo $region['id'];?>"  <?php if(set_value('region_id')==$region['id']){echo 'selected="selected"';}?>><?php echo $region['region'];?></option>
                                    <?php
								}
								?>
                                </select>
    <?php
}
?>
</td></tr>
<tr><td>Year</td><td><select name="week_year" id="week_year" onChange="CheckAvailability(this)">
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y');
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
                               </select></td></tr>
                               
                               <tr><td>Week</td><td><select name="week_no" id="week_no" onChange="CheckAvailability(this)">
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('week_no')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select></td></tr>
<tr><td>Issue No.</td><td><input type="text" name="issue_no" id="issue_no" value="" onKeyPress="return isNumberKey(event)"></td></tr>
<tr><td colspan="2"><div id="availability">
                               <input type="hidden" name="period_check" id="period_check" value="0">&nbsp;
                               </div></td></tr>
</table>
</div>
</div><div class="form-actions">
<input type="submit" name="submit" value="Add" class="btn btn-info" onClick="return(validate())" />
<?php //echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
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
