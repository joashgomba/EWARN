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
   if( document.frm.undisonedesc.value == "" )
   {
     alert( "Please enter UnDis" );
     document.frm.undisonedesc.focus() ;
     return false;
   }
   
   if (!frm.undisonedesc.value.match(/^[a-zA-Z]+$/))
    {
		alert("Please Enter only letters in text");
		document.frm.undisonedesc.focus() ;
		 return false;
    }
   
   
   
    if( document.frm.undismale.value == "" )
   {
     alert( "Please enter UnDis Male" );
     document.frm.undismale.focus() ;
     return false;
   }
   
    if(!document.frm.undismale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for UnDis Male")
	  document.frm.undismale.focus() ;
     return false;
    }
   
   if( document.frm.undisfemale.value == "" )
   {
     alert( "Please enter UnDis Female" );
     document.frm.undisfemale.focus() ;
     return false;
   }
   
   if(!document.frm.undisfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for UnDis Female")
	  document.frm.undisfemale.focus() ;
     return false;
    }
   
   
    if( document.frm.undissecdesc.value == "" )
   {
     alert( "Please enter UnDis" );
     document.frm.undissecdesc.focus() ;
     return false;
   }
   
   if (!frm.undissecdesc.value.match(/^[a-zA-Z]+$/))
    {
		alert("Please Enter only letters in text");
		document.frm.undissecdesc.focus() ;
		 return false;
    }
   
    if( document.frm.undismaletwo.value == "" )
   {
     alert( "Please enter UnDis Male" );
     document.frm.undismaletwo.focus() ;
     return false;
   }
   
   if(!document.frm.undismaletwo.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for UnDis Male")
	  document.frm.undismaletwo.focus() ;
     return false;
    }
   
   if( document.frm.undisfemaletwo.value == "" )
   {
     alert( "Please enter UnDis Female" );
     document.frm.undisfemaletwo.focus() ;
     return false;
   }
   
   if(!document.frm.undisfemaletwo.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for UnDis Female")
	  document.frm.undisfemaletwo.focus() ;
     return false;
    }
   
    if( document.frm.ocmale.value == "" )
   {
     alert( "Please enter OC Male" );
     document.frm.ocmale.focus() ;
     return false;
   }
   
    if(!document.frm.ocmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OC Male")
	  document.frm.ocmale.focus() ;
     return false;
    }
   
   if( document.frm.ocfemale.value == "" )
   {
     alert( "Please enter OC Female" );
     document.frm.ocfemale.focus() ;
     return false;
   }
   
    if(!document.frm.ocfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for OC Female")
	  document.frm.ocfemale.focus() ;
     return false;
    }
   
   var undismale;
		var undisfemale;
		var undismaletwo;
		var undisfemaletwo;
		var ocmale;
		var ocfemale;
		
   if( document.frm.undismale.value == "" )
   {
     undismale = 0
   }
   else
   {
	   undismale = parseInt(document.frm.undismale.value);
   }
   
   
   if( document.frm.undisfemale.value == "" )
   {
     undisfemale = 0;
   }
   else
   {
	   undisfemale = parseInt(document.frm.undisfemale.value);
   }
   
   if( document.frm.undismaletwo.value == "" )
   {
    undismaletwo = 0;
   }
   else
   {
	   undismaletwo = parseInt(document.frm.undismaletwo.value);
   }
   
   if( document.frm.undisfemaletwo.value == "" )
   {
     undisfemaletwo = 0;
   }
   else
   {
	   undisfemaletwo = parseInt(document.frm.undisfemaletwo.value);
   }
   
   if( document.frm.ocmale.value == "" )
   {
     ocmale = 0;
   }
   else
   {
	   ocmale = parseInt(document.frm.ocmale.value);
   }
   
   if( document.frm.ocfemale.value == "" )
   {
     ocfemale = 0;
   }
   else
   {
	   ocfemale = parseInt(document.frm.ocfemale.value);
   }
   
   var undis = (parseInt(document.frm.undismale.value) + parseInt(document.frm.undisfemale.value) + parseInt(document.frm.undismaletwo.value) + parseInt(document.frm.undisfemaletwo.value));
		
	var oc = parseInt(document.frm.ocmale.value) + parseInt(document.frm.ocfemale.value);
		
    if(undis>1)
	{
		
		if(undismale>0)
		{
			var undisval = confirm('Submit alert UnDis Male= '+undismale+'?');
			
			if(!undisval)
			{
				document.frm.undismale .focus() ;
				return false;		
			}
		}
		
		if(undisfemale>0)
		{
			var undisval2 = confirm('Submit alert UnDis Female= '+undisfemale+'?');
			
			if(!undisval2)
			{
				document.frm.undisfemale.focus() ;
				return false;		
			}
		}
		
		if(undismaletwo>0)
		{
			var undisval3 = confirm('Submit alert UnDis Male (2)= '+undismaletwo+'?');
			
			if(!undisval3)
			{
				document.frm.undismaletwo.focus() ;
				return false;		
			}
		}
		
		if(undisfemaletwo>0)
		{
			var undisval4 = confirm('Submit alert UnDis Female (2)= '+undisfemaletwo+'?');
			
			if(!undisval4)
			{
				document.frm.undisfemaletwo.focus() ;
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
 <div class="intro">Other Unusual Diseases or Deaths (specify below)</div>
 <div class="form">
  <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/addfifth',$attributes); 
						  ?>
     <ul>
 <h3>UnDis</h3>
   <li>
 <label>Describe</label>
 <input type="text" name="undisonedesc" value="" id="undisonedesc"  />   
          </li>
          <li>&nbsp;</li>
         <li>
 <label>MALE</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
<input type="text" name="undismale" value="<?php echo $row->undismale;?>" id="undismale" onkeypress="return isNumberKey(event)" maxlength="5"  />  
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="undisfemale" value="<?php echo $row->undisfemale;?>" id="undisfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />                                  
         </li>

 <!---->
 <h3>Undis</h3>
  <li>
 <label>Describe</label>
 <input type="text" name="undissecdesc" value="<?php echo $row->undissecdesc;?>" id="undissecdesc"  />   
          </li>
          <li>&nbsp;</li>
         <li>
 <label>MALE</label>
<input type="text" name="undismaletwo" value="<?php echo $row->undismaletwo;?>" id="undismaletwo" onkeypress="return isNumberKey(event)" maxlength="5"  />     
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="undisfemaletwo" value="<?php echo $row->undisfemaletwo;?>" id="undisfemaletwo" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>

 <!---->
 <h3>OC</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="ocmale" value="<?php echo $row->ocmale;?>" id="ocmale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="ocfemale" value="<?php echo $row->ocfemale;?>" id="ocfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />             <script>
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

  <!---->
 
<br clear="both" />
 <input type="submit"  value="SAVE & CONTINUE"/>
     </ul>
 </form>
 </div>
</div>
</body>
</html>
