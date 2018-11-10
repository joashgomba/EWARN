<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xmlns:br="http://www.w3.org/1999/xhtml" class="">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>EDEWS WHO Somalia</title>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
<style>


 input:focus, 
 input.focus { background: pink; }
 
 
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
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getperiod";
	
	var params = "week_no=" + totalEncode(document.frm.week_no.value ) + "&reporting_year="+totalEncode(document.frm.reporting_year.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reporingperiods').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reporingperiods').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	  
function validate()
{
	if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.week_no.value == "" )
   {
     alert( "Please enter the week number" );
     document.frm.week_no.focus() ;
     return false;
   }
   
   if( document.frm.sariufivemale.value == "" )
   {
     alert( "Please enter SARI <5yr Male" );
     document.frm.sariufivemale.focus() ;
     return false;
   }
   if( document.frm.sariufivefemale.value == "" )
   {
     alert( "Please enter SARI <5yr Female" );
     document.frm.sariufivefemale.focus() ;
     return false;
   }
   
   if( document.frm.sariofivemale.value == "" )
   {
     alert( "Please enter SARI >5yr Male" );
     document.frm.sariofivemale.focus() ;
     return false;
   }
   
   if( document.frm.sariofivefemale.value == "" )
   {
     alert( "Please enter SARI >5yr Female" );
     document.frm.sariofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.iliufivemale.value == "" )
   {
     alert( "Please enter ILI <5 Male" );
     document.frm.iliufivemale.focus() ;
     return false;
   }
   
   if( document.frm.iliufivefemale.value == "" )
   {
     alert( "Please enter ILI <5 Female" );
     document.frm.iliufivefemale.focus() ;
     return false;
   }
   
   if( document.frm.iliofivemale.value == "" )
   {
     alert( "Please enter ILI >5 Male" );
     document.frm.iliofivemale.focus() ;
     return false;
   }
   
   if( document.frm.iliofivefemale.value == "" )
   {
     alert( "Please enter ILI >5 Female" );
     document.frm.iliofivefemale.focus() ;
     return false;
   }
   
   return( true );
		
}
   </SCRIPT>
</head>
<body>
<div id="wrapper ">
 <div class="bg"><a href=""></a>
  <div class="intro">ELECTRONIC DISEASE EARLY WARNING & RESPONSE SYSTEM</div>
  <div class="intro"><div align="right"><a href="<?php echo site_url('mobile/home')?>">Add</a> | <a href="<?php echo site_url('mobile/edit')?>">Edit</a> | <a href="<?php echo site_url('mobile/logout')?>">Logout</a></div></div>
  </div>
 <div class="intro">Respiratory Diseases	</div>
 <div class="form">
    <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/add_validate',$attributes); 
						  ?>
     <ul>
      <li>

 <label>Reporting Year</label>
 <select name="reporting_year" id="reporting_year" onChange="GetPeriod(this)">
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
                               </select>
          </li>
         <li>
  <label>Week No.</label>
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
         </li>
         <li><div id="reporingperiods">
            &nbsp;
         </div></li>
         <h3>SARI < 5yr</h3>
         <li>

 <label>MALE</label>
<input type="text" name="sariufivemale" value="" id="sariufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
          </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="sariufivefemale" value="" id="sariufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <h3>SARI > 5yr</h3>
         <li>
 <!---->

 <label>MALE</label>
<input type="text" name="sariofivemale" value="" id="sariofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="sariofivefemale" value="" id="sariofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                                                                </td></tr>
         </li>
         <h3>ILI < 5yr</h3>
         <li>
 <!---->

 <label>MALE</label>
 <input type="text" name="iliufivemale" value="" id="iliufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="iliufivefemale" value="" id="iliufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                                                                </td></tr>
         </li>
         <h3>ILI > 5yr</h3>
         <li>
 <!---->

 <label>MALE</label>
 <input type="text" name="iliofivemale" value="" id="iliofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                         
         </li>
         <li>
  <label>FEMALE</label>
   <input type="text" name="iliofivefemale" value="" id="iliofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                   
         </li>
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
         </ul>
 </form>
 </div>
</div>
</body>
</html>
