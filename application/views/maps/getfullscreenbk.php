<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>eDEWS Somalia System Alerts</title>
    <style type="text/css">
        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        }
        #customers td, #customers th 
        {
        font-size:1.0em;
        border:1px  #999999;
        padding:3px 7px 2px 7px;
        }
        #customers th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#fff;
        }
        #customers tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
		
		</style>
    <style type="text/css">

    html, body {
      height: 100%;
      overflow: hidden;
    }

    body {
      background-color: white;
      font-family: Arial, sans-serif;
      margin: 0;
    }

    a:link {
      color: #0000cc;
    }

    a:active {
      color: red;
    }

    a:visited {
      color: #551a8b;
    }
/**
   #map-canvas{
      width: 100%;
      height: 100%;
    }
	**/
	 #map-canvas {
position: relative;
padding-bottom: 75%; // This is the aspect ratio
height: 100%;
overflow: hidden;
}

img { max-width:none; }

    .loading {
      color: gray;
      font-size: medium;
      padding: 1em;
    }

    </style>
    
    
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
	var url = "<?php echo base_url(); ?>index.php/datalist/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	var url = "<?php echo base_url(); ?>index.php/export/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	</script>
    
    
<script type="text/javascript">
<!--
// Form validation code will come here.

function validate()
{
	
   if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the from reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.week_no.value == "" )
   {
     alert( "Please enter the from week number" );
     document.frm.week_no.focus() ;
     return false;
   }
   
   if( document.frm.reporting_year2.value == "" )
   {
     alert( "Please enter the to reporting year" );
     document.frm.reporting_year2.focus() ;
     return false;
   }
   
   if( document.frm.week_no2.value == "" )
   {
     alert( "Please enter the to week number" );
     document.frm.week_no2.focus() ;
     return false;
   }
   
   var e = document.getElementById("reporting_year");
   var repyearone = e.options[e.selectedIndex].value;
   
   var y = document.getElementById("reporting_year2");
   var repyeartwo = y.options[y.selectedIndex].value;
   
   var x = document.getElementById("week_no");
   var fromval = x.options[x.selectedIndex].value;
   
   var z = document.getElementById("week_no2");
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
		 document.frm.week_no.focus() ;
		 return false;
	 }
   }
   
   return( true );
}

</script>
  </head>
  
   <?php 
					   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
					  echo form_open('maps/getfullscreen',$attributes); ?>
 <table id="customers">
                   <tr><td>Zone </td><td><?php 
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
								   ?></td></tr>
								<tr><td>Region </td><td>
                                <?php 
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
                                     <option value="">All Regions</option>
                                 
                                    </select>
                                   <!--<select name="region_id" id="region_id" onChange="GetDistricts(this)">
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
                                    </select>--
                                    </div>
                                   <?php
							   }?>
                                </td></tr>
                                <tr><td>District </td><td><div id="districts">
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
							?>
                            
                             <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                   <option value="">Select District</option>
                                   <option value="">All Districts</option>
							</select>
                                  <!-- <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
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
                                </select>-->
                              <?php
							}
							?>
                             </div></td></tr>
                             
                             <tr><td>From</td><td><select name="reporting_year" id="reporting_year">
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
                               </select> <select name="week_no" id="week_no" >
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
                                 <tr><td>To</td><td><select name="reporting_year2" id="reporting_year2">
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
                               </select> <select name="week_no2" id="week_no2" >
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
                               <tr><td colspan="2"><?php echo form_submit('submit', 'Get Map', 'class="btn btn-info "'); ?></td></tr>
                   </table>
 <?php echo form_close(); ?>  	
 <div id="json_data" style="display:none;">
    <?php echo json_encode($points); ?>
  </div>
  <div id="map-canvas"></div>
   <script src="<?php echo base_url(); ?>js/mapwithmarker.js"></script>
                   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/markerclusterer.js"></script>
                  
  <script src="<?php echo base_url(); ?>js/map.js"></script>
</html>
