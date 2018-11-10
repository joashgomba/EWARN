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
    if( document.frm.sre.value == "" )
   {
     alert( "Please enter SRE Female" );
     document.frm.sre.focus() ;
     return false;
   }
   
    if(!document.frm.sre.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for SRE")
	  document.frm.sre.focus() ;
     return false;
    }
   
   if( document.frm.pf.value == "" )
   {
     alert( "Please enter Pf Female" );
     document.frm.pf.focus() ;
     return false;
   }
   
   if(!document.frm.pf.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Pf")
	  document.frm.pf.focus() ;
     return false;
    }
   
   if( document.frm.pv.value == "" )
   {
     alert( "Please enter Pv Female" );
     document.frm.pv.focus() ;
     return false;
   }
   
   if(!document.frm.pv.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Pvf")
	  document.frm.pv.focus() ;
     return false;
    }
   
   if( document.frm.pmix.value == "" )
   {
     alert( "Please enter Pmix Female" );
     document.frm.pmix.focus() ;
     return false;
   }
   
   if(!document.frm.pmix.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Pmix")
	  document.frm.pmix.focus() ;
     return false;
    }
   
   
   var sre = parseInt(document.frm.sre.value);
   var total_positive = parseInt(document.frm.pf.value) + parseInt(document.frm.pv.value) + parseInt(document.frm.pmix.value);
   
   if( total_positive > sre )
   {
	 alert( "Positive cases must be less than Slides/RDT examined." );
     document.frm.sre.focus() ;
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
 <div class="intro">Malaria Tests</div>
 <div class="form">
  <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/addsixth',$attributes); 
						  ?>
     <ul>
 <h3>SRE</h3>

         <li>
 <label>&nbsp;</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
<input type="text" name="sre" value="<?php echo $row->sre;?>" id="sre" onkeypress="return isNumberKey(event)" maxlength="5"  /> 
          </li>
         <li>
 &nbsp;                                
         </li>

 <!---->
 <h3>Pf</h3>

         <li>
 <label>&nbsp;</label>
<input type="text" name="pf" value="<?php echo $row->pf;?>" id="pf" onkeypress="return isNumberKey(event)" maxlength="5"  />    
         </li>
         <li>
 &nbsp;
         </li>

 <!---->
 <h3>Pv</h3>
         <li>
 <label>&nbsp;</label>
<input type="text" name="pv" value="<?php echo $row->pv;?>" id="pv" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  &nbsp;                         
         </li>
         
          <!---->
 <h3>Pmix</h3>
         <li>
 <label>&nbsp;</label>
<input type="text" name="pmix" value="<?php echo $row->pmix;?>" id="pmix" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
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
  document.write("<input type='hidden' readonly=''  name='reporting_date' id='form-input-readonly' value='" +today+ "'>")
							</script>      
  &nbsp;                         
         </li>

  <!---->
 
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
     </ul>
 </form>
 </div>
</div>
</body>
</html>
