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
   
   var awdufivemale;
	var awdufivefemale;
		var awdofivemale;
		var awdofivefemale;
		var bdufivemale;
		var bdufivefemale;
		var bdofivemale;
		var bdofivefemale;
		var oadufivemale;
		var oadufivefemale;
		var oadofivemale;
		var oadofivefemale;
		
		
   if( document.frm.awdufivemale.value == "" )
   {
     awdufivemale = 0;
   }
   else
   {
	   awdufivemale = parseInt(document.frm.awdufivemale.value);
   }
   
   if( document.frm.awdufivefemale.value == "" )
   {
     awdufivefemale = 0;
   }
   else
   {
	   awdufivefemale = parseInt(document.frm.awdufivefemale.value);
   }
   
   if( document.frm.awdofivemale.value == "" )
   {
     awdofivemale = 0;
   }
   else
   {
	   awdofivemale = parseInt(document.frm.awdofivemale.value);
   }
   
   if( document.frm.awdofivefemale.value == "" )
   {
     awdofivefemale = 0;
   }
   else
   {
	    awdofivefemale = parseInt(document.frm.awdofivefemale.value);
   }
   if( document.frm.bdufivemale.value == "" )
   {
     bdufivemale = 0;
   }
   else
   {
	   bdufivemale = parseInt(document.frm.bdufivemale.value);
   }
   
   if( document.frm.bdufivefemale.value == "" )
   {
     bdufivefemale = 0;
   }
   else
   {
	   bdufivefemale = parseInt(document.frm.bdufivefemale.value);
   }
   
   if( document.frm.bdofivemale.value == "" )
   {
     bdofivemale = 0;
   }
   else
   {
	   bdofivemale = parseInt(document.frm.bdofivemale.value);
   }
   
   
   if( document.frm.bdofivefemale.value == "" )
   {
     bdofivefemale = 0;
   }
   else
   {
	   bdofivefemale = parseInt(document.frm.bdofivefemale.value);
   }
   
   if( document.frm.oadufivemale.value == "" )
   {
     oadufivemale =0;
   }
   else
   {
	   oadufivemale = parseInt(document.frm.oadufivemale.value);
   }
   
   if( document.frm.oadufivefemale.value == "" )
   {
     oadufivefemale = 0;
   }
   else
   {
	   oadufivefemale = parseInt(document.frm.oadufivefemale.value);
   }
   
    if( document.frm.oadofivemale.value == "" )
   {
     oadofivemale = 0;
   }
   else
   {
	   oadofivemale = parseInt(document.frm.oadofivemale.value);
   }
   
   if( document.frm.oadofivefemale.value == "" )
   {
     oadofivefemale = 0;
   }
   else
   {
	   oadofivefemale = parseInt(document.frm.oadofivefemale.value);
   }
   
   var awd = (parseInt(document.frm.awdufivemale.value) + parseInt(document.frm.awdufivefemale.value) +parseInt(document.frm.awdofivemale.value) + parseInt(document.frm.awdofivefemale.value));
		
	var bd = (parseInt(document.frm.bdufivemale.value) + parseInt(document.frm.bdufivefemale.value) + parseInt(document.frm.bdofivemale.value) + parseInt(document.frm.bdofivefemale.value));
	
	var oad = (parseInt(document.frm.oadufivemale.value) + parseInt(document.frm.oadufivefemale.value) + parseInt(document.frm.oadofivemale.value) + parseInt(document.frm.oadofivefemale.value));
   
   if(awd>0)
	{
		
		if(awdufivemale>0)
		{
			var awdval = confirm('Submit alert AWD <5 Male = '+awdufivemale+'?');
			
			if(!awdval)
			{
				document.frm.awdufivemale .focus() ;
				return false;		
			}
		}
		
		if(awdufivefemale>0)
		{
			var awdval2 = confirm('Submit alert AWD <5 Female = '+awdufivefemale+'?');
		
			if(!awdval2)
			{
				document.frm.awdufivefemale .focus() ;
				return false;		
			}
		}
		
		if(awdofivemale>0)
		{
			var awdval3 = confirm('Submit alert AWD  >5 Male = '+awdofivemale+'?');
		
			if(!awdval3)
			{
				document.frm.awdofivemale .focus() ;
				return false;		
			}
		}
		
		if(awdofivefemale>0)
		{
			var awdval4 = confirm('Submit alert AWD  >5 Female = '+awdofivefemale+'?');
		
			if(!awdval4)
			{
				document.frm.awdofivefemale .focus() ;
				return false;		
			}
		
		}
	}
	
	if(bd>4)
	{
		
		if(bdufivemale>0)
		{
			var bdval = confirm('Submit alert BD  <5 Male = '+bdufivemale+'?');
			
			if(!bdval)
			{
				document.frm.bdufivemale .focus() ;
				return false;		
			}
		}
		
		if(bdufivefemale>0)
		{
			var bdval2 = confirm('Submit alert BD  <5 Female = '+bdufivefemale+'?');
		
			if(!bdval2)
			{
				document.frm.bdufivefemale .focus() ;
				return false;		
			}
		}
		
		if(bdofivemale>0)
		{
			var bdval3 = confirm('Submit alert BD  >5 Male = '+bdofivemale+'?');
			
			if(!bdval3)
			{
				document.frm.bdofivemale .focus() ;
				return false;		
			}
		}
		
		if(bdofivefemale>0)
		{
			var bdval4 = confirm('Submit alert BD  >5 Female = '+bdofivefemale+'?');
		
			if(!bdval4)
			{
				document.frm.bdofivefemale .focus() ;
				return false;		
			}
		}
		
		
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
echo form_open('mobile/addsecond',$attributes); 
						  ?>
     <ul>
 <h3>AWD < 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
 <input type="text" name="awdufivemale" value="" id="awdufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="awdufivefemale" value="" id="awdufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />      
         </li>

 <!---->
 <h3>AWD > 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="awdofivemale" value="" id="awdofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="awdofivefemale" value="" id="awdofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />             
         </li>

 <!---->
 <h3>BD < 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="bdufivemale" value="" id="bdufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="bdufivefemale" value="" id="bdufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                
         </li>
 <!---->
 <h3>BD > 5yr</h3>
        <li>
 <label>MALE</label>
<input type="text" name="bdofivemale" value="" id="bdofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
        </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="bdofivefemale" value="" id="bdofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />               
         </li>

  <!---->
 <h3>OAD > 5yr</h3>
        <li>
 <label>MALE</label>
 <input type="text" name="oadufivemale" value="" id="oadufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="oadufivefemale" value="" id="oadufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>

  <!---->
 <h3>OAD > 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="oadofivemale" value="" id="oadofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
  <input type="text" name="oadofivefemale" value="" id="oadofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />  
  
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
          </li>
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
     </ul>
 </form>
 </div>
</div>
</body>
</html>
