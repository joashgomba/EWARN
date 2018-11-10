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
   if( document.frm.ajsmale.value == "" )
   {
     alert( "Please enter AJS Male" );
     document.frm.ajsmale.focus() ;
     return false;
   }
   
    if(!document.frm.ajsmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AJS Male")
	  document.frm.ajsmale.focus() ;
     return false;
    }
   
   if( document.frm.ajsfemale.value == "" )
   {
     alert( "Please enter AJS Female" );
     document.frm.ajsfemale.focus() ;
     return false;
   }
   
    if(!document.frm.ajsfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AJS Female")
	  document.frm.ajsfemale.focus() ;
     return false;
    }
   
   if( document.frm.vhfmale.value == "" )
   {
     alert( "Please enter VHF Male" );
     document.frm.vhfmale.focus() ;
     return false;
   }
   
   if(!document.frm.vhfmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for VHF Male")
	  document.frm.vhfmale.focus() ;
     return false;
    }
   
   if( document.frm.vhffemale.value == "" )
   {
     alert( "Please enter VHF Female" );
     document.frm.vhffemale.focus() ;
     return false;
   }
   
    if(!document.frm.vhffemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for VHF Female")
	  document.frm.vhffemale.focus() ;
     return false;
    }
   
   if( document.frm.malufivemale.value == "" )
   {
     alert( "Please enter Mal <5 Male" );
     document.frm.malufivemale.focus() ;
     return false;
   }
   
    if(!document.frm.malufivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Mal < 5 Male")
	  document.frm.malufivemale.focus() ;
     return false;
    }
   
   if( document.frm.malufivefemale.value == "" )
   {
     alert( "Please enter Mal <5 Female" );
     document.frm.malufivefemale.focus() ;
     return false;
   }
   
   if(!document.frm.malufivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Mal < 5 Female")
	  document.frm.malufivefemale.focus() ;
     return false;
    }
   
   if( document.frm.malofivemale.value == "" )
   {
     alert( "Please enter  Mal >5 Male" );
     document.frm.malofivemale.focus() ;
     return false;
   }
   
    if(!document.frm.malofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Mal > 5 Male")
	  document.frm.malofivemale.focus() ;
     return false;
    }
   
   if( document.frm.malofivefemale.value == "" )
   {
     alert( "Please enter  Mal >5 Female" );
     document.frm.malofivefemale.focus() ;
     return false;
   }
   
   if(!document.frm.malofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Mal > 5 Female")
	  document.frm.malofivefemale.focus() ;
     return false;
    }
   
   if( document.frm.suspectedmenegitismale.value == "" )
   {
     alert( "Please enter  Men <5 Male" );
     document.frm.suspectedmenegitismale.focus() ;
     return false;
   }
   
    if(!document.frm.suspectedmenegitismale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Men <5 Male")
	  document.frm.suspectedmenegitismale.focus() ;
     return false;
    }
   
   if( document.frm.suspectedmenegitisfemale.value == "" )
   {
     alert( "Please enter Men <5 Female" );
     document.frm.suspectedmenegitisfemale.focus() ;
     return false;
   }
   
    if(!document.frm.suspectedmenegitisfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Men <5 Female")
	  document.frm.suspectedmenegitisfemale.focus() ;
     return false;
    }
	
	if( document.frm.suspectedmenegitisofivemale.value == "" )
   {
     alert( "Please enter  Men >5 Male" );
     document.frm.suspectedmenegitisofivemale.focus() ;
     return false;
   }
   
    if(!document.frm.suspectedmenegitisofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Men >5 Male")
	  document.frm.suspectedmenegitisofivemale.focus() ;
     return false;
    }
   
   if( document.frm.suspectedmenegitisofivefemale.value == "" )
   {
     alert( "Please enter Men >5 Female" );
     document.frm.suspectedmenegitisofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.suspectedmenegitisofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Men >5 Female")
	  document.frm.suspectedmenegitisofivefemale.focus() ;
     return false;
    }
   
   var ajsmale;
		var ajsfemale;
		var vhfmale;
		var vhffemale;
		var malufivemale;
		var malufivefemale;
		var malofivemale;
		var malofivefemale;
		var suspectedmenegitismale;
		var suspectedmenegitisfemale;
		var suspectedmenegitisofivemale;
		var suspectedmenegitisofivefemale;
		
		
 if( document.frm.ajsmale.value == "" )
   {
     ajsmale = 0;
   }
   else
   {
	   ajsmale = parseInt(document.frm.ajsmale.value);
   }
   
   if( document.frm.ajsfemale.value == "" )
   {
     ajsfemale = 0;
   }
   else
   {
	   ajsfemale = parseInt(document.frm.ajsfemale.value);
   }
   
   if( document.frm.vhfmale.value == "" )
   {
     vhfmale = 0;
   }
   else
   {
	   vhfmale = parseInt(document.frm.vhfmale.value);
   }
   
   if( document.frm.vhffemale.value == "" )
   {
     vhffemale =0;
   }
   else
   {
	   vhffemale = parseInt(document.frm.vhffemale.value);
   }
   
   if( document.frm.malufivemale.value == "" )
   {
     malufivemale = 0;
   }
    else
   {
	   malufivemale = parseInt(document.frm.malufivemale.value);
   }
   
   if( document.frm.malufivefemale.value == "" )
   {
     malufivefemale = 0;
   }
    else
   {
	   malufivefemale = parseInt(document.frm.malufivefemale.value);
   }
   
   if( document.frm.malofivemale.value == "" )
   {
     malofivemale = 0;
   }
    else
   {
	   malofivemale = parseInt(document.frm.malofivemale.value);
   }
   
   
   if( document.frm.malofivefemale.value == "" )
   {
     malofivefemale = 0;
   }
   else
   {
	   malofivefemale = parseInt(document.frm.malofivefemale.value);
   }
   
    if( document.frm.suspectedmenegitismale.value == "" )
   {
     suspectedmenegitismale = 0;
   }
    else
   {
	   suspectedmenegitismale = parseInt(document.frm.suspectedmenegitismale.value);
   }
   
   if( document.frm.suspectedmenegitisfemale.value == "" )
   {
     suspectedmenegitisfemale = 0;
   }
   else
   {
	   suspectedmenegitisfemale = parseInt(document.frm.suspectedmenegitisfemale.value);
   }
   
   if( document.frm.suspectedmenegitisofivemale.value == "" )
   {
     suspectedmenegitisofivemale = 0;
   }
    else
   {
	   suspectedmenegitisofivemale = parseInt(document.frm.suspectedmenegitisofivemale.value);
   }
   
   if( document.frm.suspectedmenegitisofivefemale.value == "" )
   {
     suspectedmenegitisofivefemale = 0;
   }
   else
   {
	   suspectedmenegitisofivefemale = parseInt(document.frm.suspectedmenegitisofivefemale.value);
   }
   
   var ajs = parseInt(document.frm.ajsmale.value) + parseInt(document.frm.ajsfemale.value);
		
	var vhf = parseInt(document.frm.vhfmale.value) + parseInt(document.frm.vhffemale.value);
		
	var mal = (parseInt(document.frm.malufivemale.value) + parseInt(document.frm.malufivefemale.value) + parseInt(document.frm.malofivemale.value) + parseInt(document.frm.malofivefemale.value));
	
	var men = parseInt(document.frm.suspectedmenegitismale.value) + parseInt(document.frm.suspectedmenegitisfemale.value) + parseInt(document.frm.suspectedmenegitisofivemale.value) + parseInt(document.frm.suspectedmenegitisofivefemale.value);
   
   if(ajs>4)
	{
		
		if(ajsmale>0)
		{
			var ajsval = confirm('Submit alert AJS Male = '+ajsmale+'?');
			
			if(!ajsval)
			{
				document.frm.ajsmale .focus() ;
				return false;		
			}
		}
		
		if(ajsfemale>0)
		{
			var ajsval2 = confirm('Submit alert AJS Female = '+ajsfemale+'?');
		
			if(!ajsval2)
			{
				document.frm.ajsfemale .focus() ;
				return false;		
			}
		}
	}
	
	if(vhf>0)
	{
		
		if(vhfmale>0)
		{
			var vhfval = confirm('Submit alert VHF Male = '+vhfmale+'?');
			
			if(!vhfval)
			{
				document.frm.vhfmale .focus() ;
				return false;		
			}
		}
		
		if(vhffemale>0)
		{
			var vhfval2 = confirm('Submit alert VHF Female = '+vhffemale+'?');
			
			if(!vhfval2)
			{
				document.frm.vhffemale .focus() ;
				return false;		
			}
		}
		
	}
	
	if(men>1)
	{
		
		if(suspectedmenegitismale>0)
		{
			var menval = confirm('Submit alert Men <5 Male= '+suspectedmenegitismale+'?');
			
			if(!menval)
			{
				document.frm.suspectedmenegitismale .focus() ;
				return false;		
			}
		}
		
		if(suspectedmenegitisfemale>0)
		{
			var menval2 = confirm('Submit alert Men <5 Female= '+suspectedmenegitisfemale+'?');
			
			if(!menval2)
			{
				document.frm.suspectedmenegitisfemale .focus() ;
				return false;		
			}
		}
		
		if(suspectedmenegitisofivemale>0)
		{
			var menofiveval = confirm('Submit alert Men >5 Male= '+suspectedmenegitisofivemale+'?');
			
			if(!menofiveval)
			{
				document.frm.suspectedmenegitisofivemale .focus() ;
				return false;		
			}
		}
		
		if(suspectedmenegitisofivefemale>0)
		{
			var menofiveval2 = confirm('Submit alert Men >5 Female= '+suspectedmenegitisofivefemale+'?');
			
			if(!menofiveval2)
			{
				document.frm.suspectedmenegitisofivefemale .focus() ;
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
 <div class="intro">Other Communicable Diseases</div>
 <div class="form">
  <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/addfourth',$attributes); 
						  ?>
     <ul>
 <h3>AJS</h3>
         <li>
 <label>MALE</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
 <input type="text" name="ajsmale" value="<?php echo $row->ajsmale;?>" id="ajsmale" onkeypress="return isNumberKey(event)" maxlength="5"  />    
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="ajsfemale" value="<?php echo $row->ajsfemale;?>" id="ajsfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                                  
         </li>

 <!---->
 <h3>VHF</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="vhfmale" value="<?php echo $row->vhfmale;?>" id="vhfmale" onkeypress="return isNumberKey(event)" maxlength="5"  />      
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="vhffemale" value="<?php echo $row->vhffemale;?>" id="vhffemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>

 <!---->
 <h3>Mal <5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="malufivemale" value="<?php echo $row->malufivemale;?>" id="malufivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="malufivefemale" value="<?php echo $row->malufivefemale;?>" id="malufivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                           
         </li>
 <!---->
 <h3>Mal >5yr</h3>
        <li>
 <label>MALE</label>
<input type="text" name="malofivemale" value="<?php echo $row->malofivemale;?>" id="malofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
        </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="malofivefemale" value="<?php echo $row->malofivefemale;?>" id="malofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                    
         </li>

  <!---->
 <h3>Men <5yr </h3>
        <li>
 <label>MALE</label>
 <input type="text" name="suspectedmenegitismale" value="<?php echo $row->suspectedmenegitismale;?>" id="suspectedmenegitismale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="suspectedmenegitisfemale" value="<?php echo $row->suspectedmenegitisfemale;?>" id="suspectedmenegitisfemale" onkeypress="return isNumberKey(event)" maxlength="5"  /> 
 
  <h3>Men >5yr </h3>
        <li>
 <label>MALE</label>
 <input type="text" name="suspectedmenegitisofivemale" value="<?php echo $row->suspectedmenegitisofivemale;?>" id="suspectedmenegitisofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="suspectedmenegitisofivefemale" value="<?php echo $row->suspectedmenegitisofivefemale;?>" id="suspectedmenegitisofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  /> 
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

  <!---->
 
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
     </ul>
 </form>
 </div>
</div>
</body>
</html>
