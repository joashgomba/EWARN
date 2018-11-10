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
   if( document.frm.diphmale.value == "" )
   {
     alert( "Please enter Diph <5 Male" );
     document.frm.diphmale.focus() ;
     return false;
   }
   
    if(!document.frm.diphmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Diph <5 Male")
	  document.frm.diphmale.focus() ;
     return false;
    }
   
   if( document.frm.diphfemale.value == "" )
   {
     alert( "Please enter Diph <5 Female" );
     document.frm.diphfemale.focus() ;
     return false;
   }
   
   if(!document.frm.diphfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Diph <5 Female")
	  document.frm.diphfemale.focus() ;
     return false;
    }
	
	if( document.frm.diphofivemale.value == "" )
   {
     alert( "Please enter Diph >5 Male" );
     document.frm.diphofivemale.focus() ;
     return false;
   }
   
    if(!document.frm.diphofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Diph >5 Male")
	  document.frm.diphofivemale.focus() ;
     return false;
    }
   
   if( document.frm.diphofivefemale.value == "" )
   {
     alert( "Please enter Diph >5 Female" );
     document.frm.diphofivefemale.focus() ;
     return false;
   }
   
   if(!document.frm.diphofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Diph >5 Female")
	  document.frm.diphofivefemale.focus() ;
     return false;
    }
   
   
   if( document.frm.wcmale.value == "" )
   {
     alert( "Please enter WC <5 Male" );
     document.frm.wcmale.focus() ;
     return false;
   }
   
   if(!document.frm.wcmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for WC <5 Male")
	  document.frm.wcmale.focus() ;
     return false;
    }
   
   if( document.frm.wcfemale.value == "" )
   {
     alert( "Please enter WC <5 Female" );
     document.frm.wcfemale.focus() ;
     return false;
   }
   
    if(!document.frm.wcfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for WC <5 Female")
	  document.frm.wcfemale.focus() ;
     return false;
    }
	
	
	if( document.frm.wcofivemale.value == "" )
   {
     alert( "Please enter WC >5 Male" );
     document.frm.wcofivemale.focus() ;
     return false;
   }
   
   if(!document.frm.wcofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for WC >5 Male")
	  document.frm.wcofivemale.focus() ;
     return false;
    }
   
   if( document.frm.wcofivefemale.value == "" )
   {
     alert( "Please enter WC >5 Female" );
     document.frm.wcofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.wcofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for WC >5 Female")
	  document.frm.wcofivefemale.focus() ;
     return false;
    }
   
   if( document.frm.measmale.value == "" )
   {
     alert( "Please enter Meas <5 Male" );
     document.frm.measmale.focus() ;
     return false;
   }
   
   if(!document.frm.measmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Meas <5 Male")
	  document.frm.measmale.focus() ;
     return false;
    }
   
   if( document.frm.measfemale.value == "" )
   {
     alert( "Please enter Meas <5 Female" );
     document.frm.measfemale.focus() ;
     return false;
   }
   
   if(!document.frm.measfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Mea <5 Female")
	  document.frm.measfemale.focus() ;
     return false;
    }
	
	 if( document.frm.measofivemale.value == "" )
   {
     alert( "Please enter Meas >5 Male" );
     document.frm.measofivemale.focus() ;
     return false;
   }
   
   if(!document.frm.measofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Meas >5 Male")
	  document.frm.measofivemale.focus() ;
     return false;
    }
   
   if( document.frm.measofivefemale.value == "" )
   {
     alert( "Please enter Meas >5 Female" );
     document.frm.measofivefemale.focus() ;
     return false;
   }
   
   if(!document.frm.measofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for Meas >5 Female")
	  document.frm.measofivefemale.focus() ;
     return false;
    }
   
   if( document.frm.nntmale.value == "" )
   {
     alert( "Please enter  NNT Male" );
     document.frm.nntmale.focus() ;
     return false;
   }
   
    if(!document.frm.nntmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for NNT Male")
	  document.frm.nntmale.focus() ;
     return false;
    }
   
   if( document.frm.nntfemale.value == "" )
   {
     alert( "Please enter NNT Female" );
     document.frm.nntfemale.focus() ;
     return false;
   }
   
    if(!document.frm.nntfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for NNT Female")
	  document.frm.nntfemale.focus() ;
     return false;
    }
   
   if( document.frm.afpmale.value == "" )
   {
     alert( "Please enter AFP <5  Male" );
     document.frm.afpmale.focus() ;
     return false;
   }
   
    if(!document.frm.afpmale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AFP <5 Male")
	  document.frm.afpmale.focus() ;
     return false;
    }
   
   if( document.frm.afpfemale.value == "" )
   {
     alert( "Please enter AFP <5 Female" );
     document.frm.afpfemale.focus() ;
     return false;
   }
   
    if(!document.frm.afpfemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AFP <5 Female")
	  document.frm.afpfemale.focus() ;
     return false;
    }
	
	if( document.frm.afpofivemale.value == "" )
   {
     alert( "Please enter AFP >5 Male" );
     document.frm.afpofivemale.focus() ;
     return false;
   }
   
    if(!document.frm.afpofivemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AFP >5 Male")
	  document.frm.afpofivemale.focus() ;
     return false;
    }
   
   if( document.frm.afpofivefemale.value == "" )
   {
     alert( "Please enter AFP >5 Female" );
     document.frm.afpofivefemale.focus() ;
     return false;
   }
   
    if(!document.frm.afpofivefemale.value.match(/^[0-9]+$/))
    {
      alert("Please only enter numeric characters for AFP >5 Female")
	  document.frm.afpofivefemale.focus() ;
     return false;
    }
   
   
   var diphmale;
		var diphfemale;
		var diphofivemale;
		var diphofivefemale;
		var wcmale;
		var wcfemale;
		var wcofivemale;
		var wcofivefemale;
		var measmale;
		var measfemale;
		var measofivemale;
		var measofivefemale;
		var nntmale;
		var nntfemale;
		var afpmale;
		var afpfemale;
		var afpofivemale;
		var afpofivefemale;
		
   if( document.frm.diphmale.value == "" )
   {
     diphmale = 0;
   }
   else
   {
	   diphmale = parseInt(document.frm.diphmale.value);
   }
   
   if( document.frm.diphfemale.value == "" )
   {
     diphfemale = 0;
   }
   else
   {
	   diphfemale = parseInt(document.frm.diphfemale.value);
   }
   
    if( document.frm.wcmale.value == "" )
   {
     wcmale=0;
   }
   else
	{
		wcmale = parseInt(document.frm.wcmale.value);
	}
   
   if( document.frm.wcfemale.value == "" )
   {
     wcfemale=0;
   }
   else
   {
	   wcfemale = parseInt(document.frm.wcfemale.value);
   }
   
   if( document.frm.measmale.value == "" )
   {
     measmale = 0;
   }
   else
   {
	   measmale = parseInt(document.frm.measmale.value);
   }
   
   if( document.frm.measfemale.value == "" )
   {
     measfemale = 0;
   }
   else
   {
	   measfemale = parseInt(document.frm.measfemale.value);
   }
   
   if( document.frm.nntmale.value == "" )
   {
     nntmale = 0;
   }
   else
   {
	   nntmale = parseInt(document.frm.nntmale.value);
   }
   
   if( document.frm.nntfemale.value == "" )
   {
     nntfemale = 0;
   }
   else
   {
	   nntfemale = parseInt(document.frm.nntfemale.value);
   }
   
    if( document.frm.afpmale.value == "" )
   {
     afpmale = 0;
   }
   else
   {
	   afpmale = parseInt(document.frm.afpmale.value);
   }
   
   if( document.frm.afpfemale.value == "" )
   {
     afpfemale = 0;
   }
   else
   {
	   afpfemale = parseInt(document.frm.afpfemale.value);
   }
   
   var diph = parseInt(document.frm.diphmale.value) + parseInt(document.frm.diphfemale.value) +  parseInt(document.frm.diphofivemale.value) + parseInt(document.frm.diphofivefemale.value);
		
	var wc = parseInt(document.frm.wcmale.value) + parseInt(document.frm.wcfemale.value) + parseInt(document.frm.wcofivemale.value) + parseInt(document.frm.wcofivefemale.value);
		
	var meas = parseInt(document.frm.measmale.value) + parseInt(document.frm.measfemale.value) + parseInt(document.frm.measofivemale.value) + parseInt(document.frm.measofivefemale.value);
	
	var nnt = parseInt(document.frm.nntmale.value) + parseInt(document.frm.nntfemale.value);
		
    var afp = parseInt(document.frm.afpmale.value) + parseInt(document.frm.afpfemale.value) + parseInt(document.frm.afpofivemale.value) + parseInt(document.frm.afpofivefemale.value);
	
   
   if(diph>0)
	{
		
		if(diphmale>0)
		{
			var diphval = confirm('Submit alert Diph <5 Male = '+diphmale+'?');
			
			if(!diphval)
			{
				document.frm.diphmale .focus() ;
				return false;		
			}
		}
		
		if(diphfemale>0)
		{
			var diphval2 = confirm('Submit alert Diph <5 Female = '+diphfemale+'?');
		
			if(!diphval2)
			{
				document.frm.diphfemale .focus() ;
				return false;		
			}
		}
		
		if(diphofivemale>0)
		{
			var diphofiveval = confirm('Submit alert Diph >5 Male = '+diphofivemale+'?');
			
			if(!diphofiveval)
			{
				document.frm.diphofivemale .focus() ;
				return false;		
			}
		}
		
		if(diphofivefemale>0)
		{
			var diphofiveval2 = confirm('Submit alert Diph >5 Female = '+diphofivefemale+'?');
		
			if(!diphofiveval2)
			{
				document.frm.diphofivefemale .focus() ;
				return false;		
			}
		}
	}
	
	if(wc>4)
	{
		
		if(wcmale>0)
		{
			var wcval = confirm('Submit alert WC <5 Male = '+wcmale+'?');
			
			if(!wcval)
			{
				document.frm.wcmale .focus() ;
				return false;		
			}
		}
		
		if(wcfemale>0)
		{
			var wcval2 = confirm('Submit alert WC <5 Female = '+wcfemale+'?');
			
			if(!wcval2)
			{
				document.frm.wcfemale .focus() ;
				return false;		
			}
		}
		
		if(wcofivemale>0)
		{
			var wcofiveval = confirm('Submit alert WC >5 Male = '+wcofivemale+'?');
			
			if(!wcofiveval)
			{
				document.frm.wcofivemale .focus() ;
				return false;		
			}
		}
		
		if(wcofivefemale>0)
		{
			var wcofiveval2 = confirm('Submit alert WC >5 Female = '+wcofivefemale+'?');
			
			if(!wcofiveval2)
			{
				document.frm.wcofivefemale .focus() ;
				return false;		
			}
		}
		
	}
	
	if(meas>0)
	{
		
		if(measmale>0)
		{
			var measval = confirm('Submit alert Meas <5 Male = '+measmale+'?');
		
			if(!measval)
			{
				document.frm.measmale .focus() ;
				return false;		
			}
		}
		
		if(measfemale>0)
		{
			var measval2 = confirm('Submit alert Meas <5 Female = '+measfemale+'?');
		
			if(!measval2)
			{
				document.frm.measfemale .focus() ;
				return false;		
			}
		}
		
		if(measofivemale>0)
		{
			var measofiveval = confirm('Submit alert Meas >5 Male = '+measofivemale+'?');
		
			if(!measofiveval)
			{
				document.frm.measofivemale .focus() ;
				return false;		
			}
		}
		
		if(measofivefemale>0)
		{
			var measofiveval2 = confirm('Submit alert Meas >5 Female = '+measofivefemale+'?');
		
			if(!measofiveval2)
			{
				document.frm.measofivefemale .focus() ;
				return false;		
			}
		}
	}
	
	if(nnt>0)
	{
		if(nntmale>0)
		{
			var nntval = confirm('Submit alert NNT Male = '+nntmale+'?');
		
			if(!nntval)
			{
				document.frm.nntmale .focus() ;
				return false;		
			}
		}
		
		if(nntfemale>0)
		{
			var nntval2 = confirm('Submit alert NNT Female = '+nntfemale+'?');
			
			if(!nntval2)
			{
				document.frm.nntfemale .focus() ;
				return false;		
			}
		}
	}
	
	if(afp>0)
	{
		
		if(afpmale>0)
		{
			var afpval = confirm('Submit alert AFP <5 Male = '+afpmale+'?');
			
			if(!afpval)
			{
				document.frm.afpmale .focus() ;
				return false;		
			}
		}
		
		if(afpfemale>0)
		{
			var afpval2 = confirm('Submit alert AFP <5 Female = '+afpfemale+'?');
		
			if(!afpval2)
			{
				document.frm.afpfemale .focus() ;
				return false;		
			}
		
		}
		
		if(afpofivemale>0)
		{
			var afpofiveval = confirm('Submit alert AFP >5 Male = '+afpofivemale+'?');
			
			if(!afpofiveval)
			{
				document.frm.afpofivemale .focus() ;
				return false;		
			}
		}
		
		if(afpofivefemale>0)
		{
			var afpofiveval2 = confirm('Submit alert AFP >5 Female = '+afpofivefemale+'?');
		
			if(!afpofiveval2)
			{
				document.frm.afpofivefemale .focus() ;
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
 <div class="intro">Vaccine Preventable Diseases</div>
 <div class="form">
  <?php 
$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
echo form_open('mobile/addthird',$attributes); 
						  ?>
     <ul>
 <h3>Diph < 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="hidden" name="reportingform_id" id="reportingform_id"  value="<?php echo $row->id;?>"/>
 <input type="text" name="diphmale" value="<?php echo $row->diphmale;?>" id="diphmale" onkeypress="return isNumberKey(event)" maxlength="5"  />    
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="diphfemale" value="<?php echo $row->diphfemale;?>" id="diphfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />      
         </li>
         
   <h3>Diph > 5yr</h3>
         <li>
 <label>MALE</label>
 <input type="text" name="diphofivemale" value="<?php echo $row->diphofivemale;?>" id="diphofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />    
          </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="diphofivefemale" value="<?php echo $row->diphofivefemale;?>" id="diphofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />      
         </li>

 <!---->
 <h3>WC <5yr </h3>
         <li>
 <label>MALE</label>
 <input type="text" name="wcmale" value="<?php echo $row->wcmale;?>" id="wcmale" onkeypress="return isNumberKey(event)" maxlength="5"  />       
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="wcfemale" value="<?php echo $row->wcfemale;?>" id="wcfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
  <h3>WC >5yr </h3>
         <li>
 <label>MALE</label>
 <input type="text" name="wcofivemale" value="<?php echo $row->wcofivemale;?>" id="wcofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />       
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="wcofivefemale" value="<?php echo $row->wcofivefemale;?>" id="wcfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>

 <!---->
 <h3>Meas <5yr </h3>
         <li>
 <label>MALE</label>
 <input type="text" name="measmale" value="<?php echo $row->measmale;?>" id="measmale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="measfemale" value="<?php echo $row->measfemale;?>" id="measfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />               
         </li>
         
          <h3>Meas >5yr </h3>
         <li>
 <label>MALE</label>
 <input type="text" name="measofivemale" value="<?php echo $row->measofivemale;?>" id="measofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
         </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="measofivefemale" value="<?php echo $row->measofivefemale;?>" id="measofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />               
         </li>
 <!---->
 <h3>NNT</h3>
        <li>
 <label>MALE</label>
<input type="text" name="nntmale" value="<?php echo $row->nntmale;?>" id="nntmale" onkeypress="return isNumberKey(event)" maxlength="5"  />
        </li>
         <li>
  <label>FEMALE</label>
<input type="text" name="nntfemale" value="<?php echo $row->nntfemale;?>" id="nntfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />             
         </li>

  <!---->
 <h3>AFP <5yr </h3>
        <li>
 <label>MALE</label>
 <input type="text" name="afpmale" value="<?php echo $row->afpmale;?>" id="afpmale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="afpfemale" value="<?php echo $row->afpfemale;?>" id="afpfemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
 
 <h3>AFP >5yr </h3>
        <li>
 <label>MALE</label>
 <input type="text" name="afpofivemale" value="<?php echo $row->afpofivemale;?>" id="afpofivemale" onkeypress="return isNumberKey(event)" maxlength="5"  />     
        </li>
         <li>
  <label>FEMALE</label>
 <input type="text" name="afpofivefemale" value="<?php echo $row->afpofivefemale;?>" id="afpofivefemale" onkeypress="return isNumberKey(event)" maxlength="5"  />
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
