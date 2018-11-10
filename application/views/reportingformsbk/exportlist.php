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

	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/datalist/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function findReport(frm){
	if(validateForm(frm)){
	document.getElementById('reportdetails').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/datalist/getlist";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&reporting_year2=" + totalEncode(document.frm.reporting_year2.value ) + "&from=" + totalEncode(document.frm.from.value ) + "&to=" + totalEncode(document.frm.to.value ) + "&district_id=" + totalEncode(document.frm.district_id.value )+ "&healthfacility_id=" + totalEncode(document.frm.healthfacility_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reportdetails').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reportdetails').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/export/getdistricts";
	
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

<script>
function validateEntry(str)
{
	var x=document.getElementById("frm");
	var reporting_year;
	var reporting_year2;
	var from;
	var to;
	var district_id;
	var healthfacility_id;
	
	reporting_year = x.reporting_year.value;	
	reporting_year2 = x.reporting_year2.value;
	from = x.from.value;
	to = x.to.value;
	district_id = x.district_id.value;
	healthfacility_id = x.healthfacility_id.value;
	
	
if (str=="")
  {
  document.getElementById("reportdetails").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("reportdetails").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url(); ?>/index.php/datalist/validate/"+str+"/"+reporting_year+"/"+reporting_year2+"/"+from+"/"+to+"/"+district_id+"/"+healthfacility_id,true);
xmlhttp.send();
}


function invalidateEntry(str)
{
	var x=document.getElementById("frm");
	var reporting_year;
	var reporting_year2;
	var from;
	var to;
	var district_id;
	var healthfacility_id;
	
	reporting_year = x.reporting_year.value;	
	reporting_year2 = x.reporting_year2.value;
	from = x.from.value;
	to = x.to.value;
	district_id = x.district_id.value;
	healthfacility_id = x.healthfacility_id.value;
	
	
if (str=="")
  {
  document.getElementById("reportdetails").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("reportdetails").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url(); ?>/index.php/datalist/invalidate/"+str+"/"+reporting_year+"/"+reporting_year2+"/"+from+"/"+to+"/"+district_id+"/"+healthfacility_id,true);
xmlhttp.send();
}
</script>

<script type="text/javascript">
<!--
// Form validation code will come here.

function validate()
{
	
   if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the first reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.from.value == "" )
   {
     alert( "Please enter the first week number" );
     document.frm.from.focus() ;
     return false;
   }
   
   if( document.frm.reporting_year2.value == "" )
   {
     alert( "Please enter the second reporting year" );
     document.frm.reporting_year2.focus() ;
     return false;
   }
   
   if( document.frm.to.value == "" )
   {
     alert( "Please enter the second week number" );
     document.frm.to.focus() ;
     return false;
   }
   
   var e = document.getElementById("reporting_year");
   var repyearone = e.options[e.selectedIndex].value;
   
   var y = document.getElementById("reporting_year2");
   var repyeartwo = y.options[y.selectedIndex].value;
   
   var x = document.getElementById("from");
   var fromval = x.options[x.selectedIndex].value;
   
   var z = document.getElementById("to");
   var toval = z.options[z.selectedIndex].value;
   
   if(repyearone>repyeartwo)
   {
	  alert( "The year from cannot be greater than the year to" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if(repyearone==repyeartwo)
   {
	 if(fromval>toval)
	 {
		 alert( "The week from cannot be greater than the week to on the same year." );
		 document.frm.to.focus() ;
		 return false;
	 }
   }
   
   return( true );
}

</script>
<style>
	div.scroll
	{
	background-color:#fff;
	width:1100px;
	height:500px;
	overflow:scroll;
	}
	
	div.hidden 
	{
	background-color:#fff;
	width:100px;
	height:100px;
	overflow:hidden;
	}
</style>

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

						<li class="active">Export</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Data<small> Export
							</small>
						</h1>
					</div><!--/.page-header-->
                    
                    
                 
                           <?php 
						   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
						   echo form_open('export/exportlist',$attributes); ?>
                           <table id="customers">
                               <thead>
                               		<tr><th colspan="4">Filter fields</th></tr>
                               </thead>
                               <tbody>
                               <tr><td>Zone</td><td><?php 
							   if(getRole() == 'SuperAdmin')
	  							{
									?>
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
                                    <?php
								}
								else
								{

								   if($level==2)//FP
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
                                       <?php
								   }
								}
								   ?></td>
                               
                               <td>Region</td>
                               <td><?php 
							   if($level==2)
							   {
								  echo '<strong>'.$region->region.'</strong>';
								  ?>
                                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">
                                  
                                  <?php
							   }
							   else
							   {
								   ?>
                                   <div id="regions">
                                   <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                   <option value="">Select Region</option>
                                     <option value="">All Regions</option
                                   ></select>
                                  <!-- <select name="region_id" id="region_id" onChange="GetDistricts(this)">
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
                                    </select>-->
                                    </div>
                                   <?php
							   }?></td>
                               </tr>
                              <tr><td width="93">District</td><td width="181">
                            <div id="districts">
                            <?php
							if($level==1)
							{
								?>
                                <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                <option value="">-All Districts-</option>
                                  <option value="">Select District</option>
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
								if($level==2)
								{
									?>
                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                   <option value="">Select District</option>
                                   <option value="">All Districts</option>
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
								else
								{
									?>
                                       <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                <option value="">-All Districts-</option>
                                  <option value="">Select District</option>
                                </select>
                                    <?php
								}
							?>
                                    
                                  
                              <?php
							}
							?>
                             </div>
                              </td>
                              <td width="121">Health Facility</td><td width="109">
                           
                                  <div id="healthfacilities">
                                  <?php
								  if($level==2)//FP
	   								{
								  ?>
                                  <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">-All health facilities-</option>
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
									else
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
									?>
                                  </div>
                             
                              </td>
                              </tr>
                             <tr>
                             <td valign="top">From</td><td valign="top">
                               <select name="reporting_year" id="reporting_year">
                                 <option value="">Select Year</option>
                                 <?php
     $currentYear = date('Y')+10;
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
                               </select><select name="from" id="from">
                            <option value="">Select Week</option>
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if(set_value('week_no')==$i){echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select></td>
                               <td valign="top">To</td><td valign="top"><select name="reporting_year2" id="reporting_year2">
                                 <option value="">Select Year</option>
                                 <?php
     $currentYear = date('Y')+10;
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
                               <select name="to" id="to">
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
                               </td>
                             </tr>
                             <tr><td colspan="4"><input type="submit" name="find_button" value="Get Data" class="btn"  /></td></tr>
                               </tbody>
                               </table>
                               
                            
                            <table id="customers">
                             <tbody>
                             <tr><td><div id="reportdetails">&nbsp;</div></td></tr>
                              </tbody>
                          </table>
                          
							

</div>
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
