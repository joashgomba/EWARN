<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" class="">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>Gastro Intestinal Diseases | WHO</title>
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
  if( document.frm.awdufivemale.value == "" )
   {
     alert( "Please enter AWD <5 Male" );
     document.frm.awdufivemale.focus() ;
     return false;
   }
   
    if(!document.frm.awdufivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AWD < 5 Male")
	  document.frm.awdufivemale.focus() ;
     return false;
    }
   
   if( document.frm.awdufivefemale.value == "" )
   {
     alert( "Please enter AWD <5 Female" );
     document.frm.awdufivefemale.focus() ;
     return false;
   }
   
   if(!document.frm.awdufivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AWD < 5 Female")
	  document.frm.awdufivefemale.focus() ;
     return false;
    }
   
   if( document.frm.awdofivemale.value == "" )
   {
     alert( "Please enter AWD >5 Male" );
     document.frm.awdofivemale.focus() ;
     return false;
   }
   
    if(!document.frm.awdofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AWD > 5 Male")
	  document.frm.awdofivemale.focus() ;
     return false;
    }
   
   if( document.frm.awdofivefemale.value == "" )
   {
     alert( "Please enter AWD >5 Female" );
     document.frm.awdofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.awdofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AWD > 5 Female")
	  document.frm.awdofivefemale.focus() ;
     return false;
    }
   
   
   if( document.frm.bdufivemale.value == "" )
   {
     alert( "Please enter BD <5 Male" );
     document.frm.bdufivemale.focus() ;
     return false;
   }
   
    if(!document.frm.bdufivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for BD < 5 Male")
	  document.frm.bdufivemale.focus() ;
     return false;
    }
   
   if( document.frm.bdufivefemale.value == "" )
   {
     alert( "Please enter BD <5 Female" );
     document.frm.bdufivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.bdufivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for BD < 5 Female")
	  document.frm.bdufivefemale.focus() ;
     return false;
    }
   
   if( document.frm.bdofivemale.value == "" )
   {
     alert( "Please enter BD >5 Male" );
     document.frm.bdofivemale.focus() ;
     return false;
   }
   
   if(!document.frm.bdofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for BD > 5 Male")
	  document.frm.bdofivemale.focus() ;
     return false;
    }
   
   if( document.frm.bdofivefemale.value == "" )
   {
     alert( "Please enter BD >5 Female" );
     document.frm.bdofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.bdofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for BD > 5 Female")
	  document.frm.bdofivefemale.focus() ;
     return false;
    }
   
   if( document.frm.oadufivemale.value == "" )
   {
     alert( "Please enter OAD <5 Male" );
     document.frm.oadufivemale.focus() ;
     return false;
   }
   
    if(!document.frm.oadufivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OAD < 5 Male")
	  document.frm.oadufivemale.focus() ;
     return false;
    }
   
   if( document.frm.oadufivefemale.value == "" )
   {
     alert( "Please enter OAD <5 Female" );
     document.frm.oadufivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.oadufivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OAD < 5 Female")
	  document.frm.oadufivefemale.focus() ;
     return false;
    }
   
   if( document.frm.oadofivemale.value == "" )
   {
     alert( "Please enter OAD >5 Male" );
     document.frm.oadofivemale.focus() ;
     return false;
   }
   
   if(!document.frm.oadofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OAD > 5 Male")
	  document.frm.oadofivemale.focus() ;
     return false;
    }
   
   if( document.frm.oadofivefemale.value == "" )
   {
     alert( "Please enter OAD >5 Female" );
     document.frm.oadofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.oadofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OAD > 5 Female")
	  document.frm.oadofivefemale.focus() ;
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
 <div class="intro">Gastro Intestinal Diseases</div>
 <div class="form">
  <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/editsecond',$attributes); 
						  ?>
     <ul>
 <h3>AWD < 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
 <input type="text" name="awdufivemale" value="<?php echo $row->awdufivemale;?>" id="awdufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="awdufivefemale" value="<?php echo $row->awdufivefemale;?>" id="awdufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />      
         </li>

 <!---->
 <h3>AWD > 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="awdofivemale" value="<?php echo $row->awdofivemale;?>" id="awdofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="awdofivefemale" value="<?php echo $row->awdofivefemale;?>" id="awdofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />             
         </li>

 <!---->
 <h3>BD < 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="bdufivemale" value="<?php echo $row->bdufivemale;?>" id="bdufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="bdufivefemale" value="<?php echo $row->bdufivefemale;?>" id="bdufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                
         </li>
 <!---->
 <h3>BD > 5yr</h3>
        <li>
 <label>MALE</label>
<input type="text" name="bdofivemale" value="<?php echo $row->bdofivemale;?>" id="bdofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
        </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="bdofivefemale" value="<?php echo $row->bdofivefemale;?>" id="bdofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />               
         </li>

  <!---->
 <h3>AOD > 5yr</h3>
        <li>
 <label>MALE</label>
 <input type="text" name="oadufivemale" value="<?php echo $row->oadufivemale;?>" id="oadufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="oadufivefemale" value="<?php echo $row->oadufivefemale;?>" id="oadufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>

  <!---->
 <h3>AOD > 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="oadofivemale" value="<?php echo $row->oadofivemale;?>" id="oadofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
  <input type="text" name="oadofivefemale" value="<?php echo $row->oadofivefemale;?>" id="oadofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />   
  
  <script>
						Date.prototype.yyyymmdd = function() {         
                                
        var yyyy = this.getFullYear().toString();                                    
        var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
        var dd  = this.getDate().toString();             
                            
        return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
   }; 

d = new Date();
today = d.yyyymmdd();


function formatDate(d){
   function pad(n){return n<10 ? '0'+n : n}
   return [d.getUTCFullYear(),'-',
          pad(d.getUTCMonth()+1),'-',
          pad(d.getUTCDate()),' ',
          pad(d.getUTCHours()),':',
          pad(d.getUTCMinutes()),':',
          pad(d.getUTCSeconds())].join("");
  }

  var dt = new Date();
  var formattedDate = formatDate(dt); 
						 
  document.write("<input type='hidden' name='datetime' value='" + formattedDate + "'><br>")
  document.write("<input type='text' readonly=''  name='reporting_date' id='form-input-readonly' value='" +today+ "'>")
							</script>                
          </li>
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
     </ul>
 </form>
 </div>
</div>
</body>
</html>
