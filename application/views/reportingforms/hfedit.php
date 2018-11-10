<?php include(APPPATH . 'views/common/header.php'); ?>

<script type="text/javascript">
var counter = 0;
function addInput(divName){
counter++; 
var Ai8ousa = document.createElement('div'); 
 Ai8ousa.innerHTML = "Other Unusual Disease or death # "+(counter +1) + "<br><input type='text' id='field_" + count + "' name='fields[]'> <input type='text' id='male" + (counter +1) + "' name='male[]' type='text' onkeypress ='return isNumberKey(event)' maxlength='5' placeholder='Male' > <input type='text' id='female" + (counter +1) + "' name='female[]' type='text' onkeypress ='return isNumberKey(event)' maxlength='5' placeholder='Female' >";   
document.getElementById(divName).appendChild(Ai8ousa);

}

function validations(form){
var field;
var i=0;
do{
     field=form[i];
       if (field.value=='')
          {
            alert('The field is null!!!'+i);
            return false;
          }
		  
		  i++;
}while(i<=counter);
}
</script>
<script type="text/javascript">


var count = 0;
$(function(){
	$('p#add_field').click(function(){
		count += 1;
		$('#container').append(
				'<strong>Other Unusual Disease or death #' + count + '</strong><br />' 
				+ '<input id="field_' + count + '" name="fields[]' + '" type="text" "/> <input id="male' + count + '" name="male[]' + '" type="text" onkeypress ="return isNumberKey(event)" maxlength="5" placeholder="Male" /> <input id="female' + count + '" name="female[]' + '" type="text" onkeypress ="return isNumberKey(event)" maxlength="5" placeholder="Female" /><br />' );
	
	});
});
</script>
<script>

function change(that, fgcolor, bgcolor,txtcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}

</script>
<script type="text/javascript">
<!--
// Form validation code will come here.

function draftvalidate()
{
	 if( document.frm.period_check.value == 1)
   {
     alert( "The reporting period for the health facility has been entered." );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
  
  if( document.frm.district_id.value == "" )
   {
     alert( "Please enter the district" );
     document.frm.district_id.focus() ;
     return false;
   }
   
   if( document.frm.healthfacility_id.value == "" )
   {
     alert( "Please enter the health facility" );
     document.frm.healthfacility_id.focus() ;
     return false;
   }
   
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
   
   return( true );
}


function validate()
{

	  
		var sariufivemale;
		var sariufivefemale;
		var sariofivemale;
		var sariofivefemale;
		var iliufivemale;
		var iliufivefemale;
		var iliofivemale;
		var iliofivefemale;
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
		var undismale;
		var undisfemale;
		var undismaletwo;
		var undisfemaletwo;
		var ocmale;
		var ocfemale;
		
		
	
   if( document.frm.sariufivemale.value == "" )
   {
     sariufivemale =0;
   }
   else
   {
	   sariufivemale = parseInt(document.frm.sariufivemale.value);
   }
   if( document.frm.sariufivefemale.value == "" )
   {
     sariufivefemale = 0;
   }
   else
   {
	   sariufivefemale = parseInt(document.frm.sariufivefemale.value);
   }
   
   if( document.frm.sariofivemale.value == "" )
   {
     sariofivemale =0;
   }
   else
   {
	   sariofivemale = parseInt(document.frm.sariofivemale.value);
   }
   
   if( document.frm.sariofivefemale.value == "" )
   {
    sariofivefemale =0;
   }
   else
   {
	   sariofivefemale = parseInt(document.frm.sariofivefemale.value);
   }
   
   if( document.frm.iliufivemale.value == "" )
   {
     iliufivemale = 0;
   }
   else
   {
	   iliufivemale = parseInt(document.frm.iliufivemale.value);
   }
   
   if( document.frm.iliufivefemale.value == "" )
   {
     iliufivefemale =0;
   }
   else
   {
	   iliufivefemale = parseInt(document.frm.iliufivefemale.value);
   }
   
   if( document.frm.iliofivemale.value == "" )
   {
     iliofivemale =0;
   }
   else
   {
	   iliofivemale = parseInt(document.frm.iliofivemale.value);
   }
   
   if( document.frm.iliofivefemale.value == "" )
   {
     iliofivefemale = 0;
   }
   else
   {
	   iliofivefemale = parseInt(document.frm.iliofivemale.value);
   }
   
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
   
    if( document.frm.diphofivemale.value == "" )
   {
     diphofivemale = 0;
   }
   else
   {
	   diphofivemale = parseInt(document.frm.diphofivemale.value);
   }
   
   if( document.frm.diphofivefemale.value == "" )
   {
     diphofivefemale = 0;
   }
   else
   {
	   diphofivefemale = parseInt(document.frm.diphofivefemale.value);
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
   
   
   if( document.frm.wcofivemale.value == "" )
   {
     wcofivemale=0;
   }
   else
	{
		wcofivemale = parseInt(document.frm.wcofivemale.value);
	}
   
   if( document.frm.wcofivefemale.value == "" )
   {
     wcofivefemale=0;
   }
   else
   {
	   wcofivefemale = parseInt(document.frm.wcofivefemale.value);
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
   
   
    if( document.frm.measofivemale.value == "" )
   {
     measofivemale = 0;
   }
   else
   {
	   measofivemale = parseInt(document.frm.measofivemale.value);
   }
   
   if( document.frm.measofivefemale.value == "" )
   {
     measofivefemale = 0;
   }
   else
   {
	   measofivefemale = parseInt(document.frm.measofivefemale.value);
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
   
   
   if( document.frm.afpofivemale.value == "" )
   {
     afpofivemale = 0;
   }
   else
   {
	   afpofivemale = parseInt(document.frm.afpofivemale.value);
   }
   
   if( document.frm.afpofivefemale.value == "" )
   {
     afpofivefemale = 0;
   }
   else
   {
	   afpofivefemale = parseInt(document.frm.afpofivefemale.value);
   }
   
   
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
   
   //totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale ;
 if( document.frm.period_check.value == 1)
   {
     alert( "The reporting period for the health facility has been entered." );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
  
  if( document.frm.district_id.value == "" )
   {
     alert( "Please enter the district" );
     document.frm.district_id.focus() ;
     return false;
   }
   
   if( document.frm.healthfacility_id.value == "" )
   {
     alert( "Please enter the health facility" );
     document.frm.healthfacility_id.focus() ;
     return false;
   }
   
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
   
   if( document.frm.awdufivemale.value == "" )
   {
     alert( "Please enter AWD <5 Male" );
     document.frm.awdufivemale.focus() ;
     return false;
   }
   
   if( document.frm.awdufivefemale.value == "" )
   {
     alert( "Please enter AWD <5 Female" );
     document.frm.awdufivefemale.focus() ;
     return false;
   }
   
   if( document.frm.awdofivemale.value == "" )
   {
     alert( "Please enter AWD >5 Male" );
     document.frm.awdofivemale.focus() ;
     return false;
   }
   
   if( document.frm.awdofivefemale.value == "" )
   {
     alert( "Please enter AWD >5 Female" );
     document.frm.awdofivefemale.focus() ;
     return false;
   }
   
   
   if( document.frm.bdufivemale.value == "" )
   {
     alert( "Please enter BD <5 Male" );
     document.frm.bdufivemale.focus() ;
     return false;
   }
   
   if( document.frm.bdufivefemale.value == "" )
   {
     alert( "Please enter BD <5 Female" );
     document.frm.bdufivefemale.focus() ;
     return false;
   }
   
   if( document.frm.bdofivemale.value == "" )
   {
     alert( "Please enter BD >5 Male" );
     document.frm.bdofivemale.focus() ;
     return false;
   }
   
   if( document.frm.bdofivefemale.value == "" )
   {
     alert( "Please enter BD >5 Female" );
     document.frm.bdofivefemale.focus() ;
     return false;
   }
   
    if( document.frm.oadufivemale.value == "" )
   {
     alert( "Please enter OAD <5 Male" );
     document.frm.oadufivemale.focus() ;
     return false;
   }
   
   if( document.frm.oadufivefemale.value == "" )
   {
     alert( "Please enter OAD <5 Female" );
     document.frm.oadufivefemale.focus() ;
     return false;
   }
   
    if( document.frm.oadofivemale.value == "" )
   {
     alert( "Please enter OAD >5 Male" );
     document.frm.oadofivemale.focus() ;
     return false;
   }
   
   if( document.frm.oadofivefemale.value == "" )
   {
     alert( "Please enter OAD >5 Female" );
     document.frm.oadofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.diphmale.value == "" )
   {
     alert( "Please enter Diph <5 Male" );
     document.frm.diphmale.focus() ;
     return false;
   }
   
   if( document.frm.diphfemale.value == "" )
   {
     alert( "Please enter Diph <5 Female" );
     document.frm.diphfemale.focus() ;
     return false;
   }
   
   if( document.frm.diphofivemale.value == "" )
   {
     alert( "Please enter Diph >5 Male" );
     document.frm.diphofivemale.focus() ;
     return false;
   }
   
   if( document.frm.diphofivefemale.value == "" )
   {
     alert( "Please enter Diph >5 Female" );
     document.frm.diphofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.wcmale.value == "" )
   {
     alert( "Please enter WC <5 Male" );
     document.frm.wcmale.focus() ;
     return false;
   }
   
   if( document.frm.wcfemale.value == "" )
   {
     alert( "Please enter WC <5 Female" );
     document.frm.wcfemale.focus() ;
     return false;
   }
   
   if( document.frm.wcofivemale.value == "" )
   {
     alert( "Please enter WC >5 Male" );
     document.frm.wcofivemale.focus() ;
     return false;
   }
   
   if( document.frm.wcofivefemale.value == "" )
   {
     alert( "Please enter WC >5 Female" );
     document.frm.wcofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.measmale.value == "" )
   {
     alert( "Please enter Meas <5 Male" );
     document.frm.measmale.focus() ;
     return false;
   }
   
   if( document.frm.measfemale.value == "" )
   {
     alert( "Please enter Meas <5 Female" );
     document.frm.measfemale.focus() ;
     return false;
   }
   
   if( document.frm.measofivemale.value == "" )
   {
     alert( "Please enter Meas >5 Male" );
     document.frm.measofivemale.focus() ;
     return false;
   }
   
   if( document.frm.measofivefemale.value == "" )
   {
     alert( "Please enter Meas >5 Female" );
     document.frm.measofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.nntmale.value == "" )
   {
     alert( "Please enter  NNT Male" );
     document.frm.nntmale.focus() ;
     return false;
   }
   
   if( document.frm.nntfemale.value == "" )
   {
     alert( "Please enter NNT Female" );
     document.frm.nntfemale.focus() ;
     return false;
   }
   
   if( document.frm.afpmale.value == "" )
   {
     alert( "Please enter AFP <5 Male" );
     document.frm.afpmale.focus() ;
     return false;
   }
   
   if( document.frm.afpfemale.value == "" )
   {
     alert( "Please enter AFP <5 Female" );
     document.frm.afpfemale.focus() ;
     return false;
   }
   
    if( document.frm.afpofivemale.value == "" )
   {
     alert( "Please enter AFP >5 Male" );
     document.frm.afpofivemale.focus() ;
     return false;
   }
   
   if( document.frm.afpofivefemale.value == "" )
   {
     alert( "Please enter AFP >5 Female" );
     document.frm.afpofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.ajsmale.value == "" )
   {
     alert( "Please enter AJS Male" );
     document.frm.ajsmale.focus() ;
     return false;
   }
   
   if( document.frm.ajsfemale.value == "" )
   {
     alert( "Please enter AJS Female" );
     document.frm.ajsfemale.focus() ;
     return false;
   }
   
   if( document.frm.vhfmale.value == "" )
   {
     alert( "Please enter VHF Male" );
     document.frm.vhfmale.focus() ;
     return false;
   }
   
   if( document.frm.vhffemale.value == "" )
   {
     alert( "Please enter VHF Female" );
     document.frm.vhffemale.focus() ;
     return false;
   }
   
   if( document.frm.malufivemale.value == "" )
   {
     alert( "Please enter Mal <5 Male" );
     document.frm.malufivemale.focus() ;
     return false;
   }
   
   if( document.frm.malufivefemale.value == "" )
   {
     alert( "Please enter Mal <5 Female" );
     document.frm.malufivefemale.focus() ;
     return false;
   }
   
   if( document.frm.malofivemale.value == "" )
   {
     alert( "Please enter  Mal >5 Male" );
     document.frm.malofivemale.focus() ;
     return false;
   }
   
   if( document.frm.malofivefemale.value == "" )
   {
     alert( "Please enter  Mal >5 Female" );
     document.frm.malofivefemale.focus() ;
     return false;
   }
   
   if( document.frm.suspectedmenegitismale.value == "" )
   {
     alert( "Please enter  Men <5 Male" );
     document.frm.suspectedmenegitismale.focus() ;
     return false;
   }
   
   if( document.frm.suspectedmenegitisfemale.value == "" )
   {
     alert( "Please enter Men <5 Female" );
     document.frm.suspectedmenegitisfemale.focus() ;
     return false;
   }
   
   if( document.frm.suspectedmenegitisofivemale.value == "" )
   {
     alert( "Please enter  Men >5 Male" );
     document.frm.suspectedmenegitisofivemale.focus() ;
     return false;
   }
   
   if( document.frm.suspectedmenegitisofivefemale.value == "" )
   {
     alert( "Please enter Men >5 Female" );
     document.frm.suspectedmenegitisofivefemale.focus() ;
     return false;
   }
   
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
   
   if( document.frm.undisfemale.value == "" )
   {
     alert( "Please enter UnDis Female" );
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
   
   if( document.frm.undisfemaletwo.value == "" )
   {
     alert( "Please enter UnDis Female" );
     document.frm.undisfemaletwo.focus() ;
     return false;
   }
   
    if( document.frm.ocmale.value == "" )
   {
     alert( "Please enter OC Male" );
     document.frm.ocmale.focus() ;
     return false;
   }
   
   if( document.frm.ocfemale.value == "" )
   {
     alert( "Please enter OC Female" );
     document.frm.ocfemale.focus() ;
     return false;
   }
   
   if( document.frm.total_consultations.value == "" )
   {
     alert( "Please calculate total consultations" );
     document.frm.total_consultations.focus() ;
     return false;
   }
   
   if( document.frm.sre.value == "" )
   {
     alert( "Please enter SRE Female" );
     document.frm.sre.focus() ;
     return false;
   }
   
   if( document.frm.pf.value == "" )
   {
     alert( "Please enter Pf Female" );
     document.frm.pf.focus() ;
     return false;
   }
   
   if( document.frm.pv.value == "" )
   {
     alert( "Please enter Pv Female" );
     document.frm.pv.focus() ;
     return false;
   }
   
   if( document.frm.pmix.value == "" )
   {
     alert( "Please enter Pmix Female" );
     document.frm.pmix.focus() ;
     return false;
   }
   /**
   if (!frm.undisonedesc.value.match(/^[a-zA-Z]+$/))
    {
		alert("Please Enter only letters in text");
		document.frm.undisonedesc.focus() ;
		 return false;
    }
	**/
   
   
   var sari = (parseInt(document.frm.sariufivemale.value) + parseInt(document.frm.sariufivefemale.value)+ parseInt(document.frm.sariofivemale.value) + parseInt(document.frm.sariofivefemale.value));
		
	var ili = (parseInt(document.frm.iliufivemale.value) + parseInt(document.frm.iliufivemale.value) + parseInt(document.frm.iliofivemale.value) + parseInt(document.frm.iliofivefemale.value));
		
	var awd = (parseInt(document.frm.awdufivemale.value) + parseInt(document.frm.awdufivefemale.value) +parseInt(document.frm.awdofivemale.value) + parseInt(document.frm.awdofivefemale.value));
		
	var bd = (parseInt(document.frm.bdufivemale.value) + parseInt(document.frm.bdufivefemale.value) + parseInt(document.frm.bdofivemale.value) + parseInt(document.frm.bdofivefemale.value));
		
		
  var oad = (parseInt(document.frm.oadufivemale.value) + parseInt(document.frm.oadufivefemale.value) + parseInt(document.frm.oadofivemale.value) + parseInt(document.frm.oadofivefemale.value));
		
	var diph = parseInt(document.frm.diphmale.value) + parseInt(document.frm.diphfemale.value) + parseInt(document.frm.diphofivemale.value) + parseInt(document.frm.diphofivefemale.value);
		
	var wc = parseInt(document.frm.wcmale.value) + parseInt(document.frm.wcfemale.value) + parseInt(document.frm.wcofivemale.value) + parseInt(document.frm.wcofivefemale.value);
		
	var meas = parseInt(document.frm.measmale.value) + parseInt(document.frm.measfemale.value) + parseInt(document.frm.measofivemale.value) + parseInt(document.frm.measofivefemale.value);
		
	var nnt = parseInt(document.frm.nntmale.value) + parseInt(document.frm.nntfemale.value);
		
    var afp = parseInt(document.frm.afpmale.value) + parseInt(document.frm.afpfemale.value) + parseInt(document.frm.afpofivemale.value) + parseInt(document.frm.afpofivefemale.value);
		
	var ajs = parseInt(document.frm.ajsmale.value) + parseInt(document.frm.ajsfemale.value);
		
	var vhf = parseInt(document.frm.vhfmale.value) + parseInt(document.frm.vhffemale.value);
		
	var mal = (parseInt(document.frm.malufivemale.value) + parseInt(document.frm.malufivefemale.value) + parseInt(document.frm.malofivemale.value) + parseInt(document.frm.malofivefemale.value));
		
	var men = parseInt(document.frm.suspectedmenegitismale.value) + parseInt(document.frm.suspectedmenegitisfemale.value) + parseInt(document.frm.suspectedmenegitisofivemale.value) + parseInt(document.frm.suspectedmenegitisofivefemale.value);
		
	var undis = (parseInt(document.frm.undismale.value) + parseInt(document.frm.undisfemale.value) + parseInt(document.frm.undismaletwo.value) + parseInt(document.frm.undisfemaletwo.value));
		
	var oc = parseInt(document.frm.ocmale.value) + parseInt(document.frm.ocfemale.value);
	
	  var totalconsultations;
    var totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale + awdufivemale + awdufivefemale + awdofivemale +awdofivefemale +bdufivemale +bdufivefemale +bdofivemale +bdofivefemale +oadufivemale +oadufivefemale +oadofivemale + oadofivefemale +diphmale +diphfemale +diphofivemale +diphofivefemale +wcmale +wcfemale +wcofivemale +wcofivefemale + measmale +measfemale + measofivemale +measofivefemale +nntmale +nntfemale +afpmale +afpfemale +afpofivemale + afpofivefemale +ajsmale +ajsfemale +vhfmale + vhffemale +malufivemale + malufivefemale +malofivemale +malofivefemale +suspectedmenegitismale +suspectedmenegitisfemale +suspectedmenegitisofivemale +suspectedmenegitisofivefemale +undismale +undisfemale +undismaletwo +undisfemaletwo +ocmale +ocfemale;
	
	
  if( document.frm.total_consultations.value != totalconsultations )
   {
     alert( "Please re-calculate the total consultations." );
     document.frm.total_consultations.focus() ;
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
   
      
	/**
	var proceed = confirm('Submit Data SARI < Male = '+sariufivemale+'?');
		
		if(!proceed)
		{
			document.frm.sariufivemale.focus() ;
			return false;
		}
		
		
		var proceed2 = confirm('Submit Data SARI <5 Female = '+sariufivefemale+'?');
		
		if(!proceed2)
		{
			document.frm.sariufivefemale.focus() ;
			return false;
		}
		
		var proceed3 = confirm('Submit Data SARI >5 Male = '+sariofivemale+'?');
		
		if(!proceed3)
		{
			document.frm.sariofivemale.focus() ;
			return false;		
		}
		
		var proceed4 = confirm('Submit Data SARI >5 Female = '+sariofivefemale+'?');
		
		if(!proceed4)
		{
			document.frm.sariofivefemale.focus() ;
			return false;		
		}
		
		var proceed5 = confirm('Submit Data ILI <5 Male = '+iliufivemale+'?');
		
		if(!proceed5)
		{
			document.frm.iliufivemale.focus() ;
			return false;		
		}
		
		var proceed6 = confirm('Submit Data ILI <5 Female = '+iliufivefemale+'?');
		
		if(!proceed6)
		{
			document.frm.iliufivefemale.focus() ;
			return false;		
		}
		
		var proceed7 = confirm('Submit Data ILI >5 Male = '+iliofivemale+'?');
		
		if(!proceed7)
		{
			document.frm.iliofivemale.focus() ;
			return false;		
		}
		
		
		var proceed8 = confirm('Submit Data ILI >5 Female = '+iliofivefemale +'?');
		
		if(!proceed8)
		{
			document.frm.iliofivefemale.focus() ;
			return false;		
		}
		
		
		var proceed9 = confirm('Submit Data AWD <5 Male = '+awdufivemale+'?');
		
		if(!proceed9)
		{
			document.frm.awdufivemale .focus() ;
			return false;		
		}
		
		
		var proceed10 = confirm('Submit Data AWD <5 Female = '+awdufivefemale+'?');
		
		if(!proceed10)
		{
			document.frm.awdufivefemale .focus() ;
			return false;		
		}
		
		
		var proceed11 = confirm('Submit Data AWD  >5 Male = '+awdofivemale+'?');
		
		if(!proceed11)
		{
			document.frm.awdofivemale .focus() ;
			return false;		
		}
		
		
		var proceed12 = confirm('Submit Data AWD  >5 Female = '+awdofivefemale+'?');
		
		if(!proceed12)
		{
			document.frm.awdofivefemale .focus() ;
			return false;		
		}
		
		var proceed13 = confirm('Submit Data BD  <5 Male = '+bdufivemale+'?');
		
		if(!proceed13)
		{
			document.frm.bdufivemale .focus() ;
			return false;		
		}
		
		var proceed14 = confirm('Submit Data BD  <5 Female = '+bdufivefemale+'?');
		
		if(!proceed14)
		{
			document.frm.bdufivefemale .focus() ;
			return false;		
		}
		
		var proceed15 = confirm('Submit Data BD  >5 Male = '+bdofivemale+'?');
		
		if(!proceed15)
		{
			document.frm.bdofivemale .focus() ;
			return false;		
		}
		
		var proceed16 = confirm('Submit Data BD  >5 Female = '+bdofivefemale+'?');
		
		if(!proceed16)
		{
			document.frm.bdofivefemale .focus() ;
			return false;		
		}
		
		var proceed17 = confirm('Submit Data OAD <5 Male = '+oadufivemale+'?');
		
		if(!proceed17)
		{
			document.frm.oadufivemale .focus() ;
			return false;		
		}
		
		var proceed18 = confirm('Submit Data OAD <5 Female = '+oadufivefemale+'?');
		
		if(!proceed18)
		{
			document.frm.oadufivefemale .focus() ;
			return false;		
		}
		
		var proceed19 = confirm('Submit Data OAD >5 Male = '+oadofivemale+'?');
		
		if(!proceed19)
		{
			document.frm.oadofivemale .focus() ;
			return false;		
		}
		
		var proceed20 = confirm('Submit Data OAD >5 Female = '+oadofivefemale+'?');
		
		if(!proceed20)
		{
			document.frm.oadofivefemale .focus() ;
			return false;		
		}
		
		var proceed21 = confirm('Submit Data Diph Male = '+diphmale+'?');
		
		if(!proceed21)
		{
			document.frm.diphmale .focus() ;
			return false;		
		}
		
		var proceed22 = confirm('Submit Data Diph Female = '+diphfemale+'?');
		
		if(!proceed22)
		{
			document.frm.diphfemale .focus() ;
			return false;		
		}
		
		var proceed23 = confirm('Submit Data WC Male = '+wcmale+'?');
		
		if(!proceed23)
		{
			document.frm.wcmale .focus() ;
			return false;		
		}
		
		var proceed24 = confirm('Submit Data WC Female = '+wcfemale+'?');
		
		if(!proceed24)
		{
			document.frm.wcfemale .focus() ;
			return false;		
		}
		
		var proceed25 = confirm('Submit Data Meas Male = '+measmale+'?');
		
		if(!proceed25)
		{
			document.frm.measmale .focus() ;
			return false;		
		}
		
		var proceed26 = confirm('Submit Data Meas Female = '+measfemale+'?');
		
		if(!proceed26)
		{
			document.frm.measfemale .focus() ;
			return false;		
		}
		
		var proceed27 = confirm('Submit Data NNT Male = '+nntmale+'?');
		
		if(!proceed27)
		{
			document.frm.nntmale .focus() ;
			return false;		
		}
		
		var proceed28 = confirm('Submit Data NNT Female = '+nntfemale+'?');
		
		if(!proceed28)
		{
			document.frm.nntfemale .focus() ;
			return false;		
		}
		
		var proceed29 = confirm('Submit Data AFP Male = '+afpmale+'?');
		
		if(!proceed29)
		{
			document.frm.afpmale .focus() ;
			return false;		
		}
		
		var proceed30 = confirm('Submit Data AFP Female = '+afpfemale+'?');
		
		if(!proceed30)
		{
			document.frm.afpfemale .focus() ;
			return false;		
		}
		
		var proceed31 = confirm('Submit Data AJS Male = '+ajsmale+'?');
		
		if(!proceed31)
		{
			document.frm.ajsmale .focus() ;
			return false;		
		}
		
		var proceed32 = confirm('Submit Data AJS Female = '+ajsfemale+'?');
		
		if(!proceed32)
		{
			document.frm.ajsfemale .focus() ;
			return false;		
		}
		
		var proceed33 = confirm('Submit Data VHF Male = '+vhfmale+'?');
		
		if(!proceed33)
		{
			document.frm.vhfmale .focus() ;
			return false;		
		}
		
		var proceed34 = confirm('Submit Data VHF Female = '+vhffemale+'?');
		
		if(!proceed34)
		{
			document.frm.vhffemale .focus() ;
			return false;		
		}
		
		var proceed35 = confirm('Submit Data Mal <5 Male = '+malufivemale+'?');
		
		if(!proceed35)
		{
			document.frm.malufivemale .focus() ;
			return false;		
		}
		
		var proceed36 = confirm('Submit Data Mal <5 Female = '+malufivefemale+'?');
		
		if(!proceed36)
		{
			document.frm.malufivefemale .focus() ;
			return false;		
		}
		
		var proceed37 = confirm('Submit Data Mal >5 Male= '+malofivemale+'?');
		
		if(!proceed37)
		{
			document.frm.malofivemale .focus() ;
			return false;		
		}
		
		var proceed38 = confirm('Submit Data Mal >5 Female= '+malofivefemale+'?');
		
		if(!proceed38)
		{
			document.frm.malofivefemale .focus() ;
			return false;		
		}
		
		var proceed39 = confirm('Submit Data Men Male= '+suspectedmenegitismale+'?');
		
		if(!proceed39)
		{
			document.frm.suspectedmenegitismale .focus() ;
			return false;		
		}
		
		var proceed40 = confirm('Submit Data Men Female= '+suspectedmenegitisfemale+'?');
		
		if(!proceed40)
		{
			document.frm.suspectedmenegitisfemale .focus() ;
			return false;		
		}
		
		var proceed41 = confirm('Submit Data UnDis Male= '+undismale+'?');
		
		if(!proceed41)
		{
			document.frm.undismale .focus() ;
			return false;		
		}
		
		var proceed42 = confirm('Submit Data UnDis Female= '+undisfemale+'?');
		
		if(!proceed42)
		{
			document.frm.undisfemale.focus() ;
			return false;		
		}
		
		var proceed43 = confirm('Submit Data UnDis Male (2)= '+undismaletwo+'?');
		
		if(!proceed43)
		{
			document.frm.undismaletwo.focus() ;
			return false;		
		}
		
		var proceed44 = confirm('Submit Data UnDis Female (2)= '+undisfemaletwo+'?');
		
		if(!proceed44)
		{
			document.frm.undisfemaletwo.focus() ;
			return false;		
		}
		
		var proceed45 = confirm('Submit Data OC Male = '+ocmale+'?');
		
		if(!proceed45)
		{
			document.frm.ocmale.focus() ;
			return false;		
		}
		
		var proceed46 = confirm('Submit Data OC Female = '+ocfemale+'?');
		
		if(!proceed46)
		{
			document.frm.ocfemale.focus() ;
			return false;		
		}
	
	**/
	if(sari>4)
	{
		if(sariufivemale>0)
		{
			var sarival = confirm('Submit alert SARI < Male = '+sariufivemale+'?');
			
			if(!sarival)
			{
				document.frm.sariufivemale.focus() ;
				return false;
			}
		}
		
		if(sariufivefemale>0)
		{
			var sarival2 = confirm('Submit alert SARI <5 Female = '+sariufivefemale+'?');
			
			if(!sarival2)
			{
				document.frm.sariufivefemale.focus() ;
				return false;
			}
		}
		
		if(sariofivemale>0)
		{
			var sarival3 = confirm('Submit alert SARI >5 Male = '+sariofivemale+'?');
			
			if(!sarival3)
			{
				document.frm.sariofivemale.focus() ;
				return false;		
			}
		}
		
		if(sariofivefemale>0)
		{
			var sarival5 = confirm('Submit alert SARI >5 Female = '+sariofivefemale+'?');
			
			if(!sarival5)
			{
				document.frm.sariofivefemale.focus() ;
				return false;		
			}
		}
		
	}
	
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
			var wcofiveval2 = confirm('Submit alert WC <5 Female = '+wcofivefemale+'?');
			
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
	
  var total_slides = parseInt(document.frm.pf.value) + parseInt(document.frm.pv.value) + parseInt(document.frm.pmix.value);
   
   var fr;
   var spr;
   
   if(total_slides==0)
   {
	   fr=0;
	   spr=0;
   }
   else
   {
	   var pf = parseInt(document.frm.pf.value);
	   spr = (total_slides/sre) * 100;
	   fr = (pf/total_slides) * 100;
   }
   
   
   if(fr>40)
	{
			var frval = confirm('Submit FR >40% ?');
			
			if(!frval)
			{
				document.frm.sre.focus() ;
				return false;
			}
	}
	
	if(spr>50)
	{
			var sprval = confirm('Submit SPR >50% ?');
			
			if(!sprval)
			{
				document.frm.sre.focus() ;
				return false;
			}
	}
	
   return( true );
}
//-->


function CalcConsultations()
	{
		var sariufivemale;
		var sariufivefemale;
		var sariofivemale;
		var sariofivefemale;
		var iliufivemale;
		var iliufivefemale;
		var iliofivemale;
		var iliofivefemale;
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
		var undismale;
		var undisfemale;
		var undismaletwo;
		var undisfemaletwo;
		var ocmale;
		var ocfemale;
		
  
   if( document.frm.sariufivemale.value == "" )
   {
     sariufivemale =0;
   }
   else
   {
	   sariufivemale = parseInt(document.frm.sariufivemale.value);
   }
   if( document.frm.sariufivefemale.value == "" )
   {
     sariufivefemale = 0;
   }
   else
   {
	   sariufivefemale = parseInt(document.frm.sariufivefemale.value);
   }
   
   if( document.frm.sariofivemale.value == "" )
   {
     sariofivemale =0;
   }
   else
   {
	   sariofivemale = parseInt(document.frm.sariofivemale.value);
   }
   
   if( document.frm.sariofivefemale.value == "" )
   {
    sariofivefemale =0;
   }
   else
   {
	   sariofivefemale = parseInt(document.frm.sariofivefemale.value);
   }
   
   if( document.frm.iliufivemale.value == "" )
   {
     iliufivemale = 0;
   }
   else
   {
	   iliufivemale = parseInt(document.frm.iliufivemale.value);
   }
   
   if( document.frm.iliufivefemale.value == "" )
   {
     iliufivefemale =0;
   }
   else
   {
	   iliufivefemale = parseInt(document.frm.iliufivefemale.value);
   }
   
   if( document.frm.iliofivemale.value == "" )
   {
     iliofivemale =0;
   }
   else
   {
	   iliofivemale = parseInt(document.frm.iliofivemale.value);
   }
   
   if( document.frm.iliofivefemale.value == "" )
   {
     iliofivefemale = 0;
   }
   else
   {
	   iliofivefemale = parseInt(document.frm.iliofivemale.value);
   }
   
   if( document.frm.awdufivemale.value == "" )
   {
     awdufivemale = 0;
   }
   else
   {
	   awdufivemale = parseInt(document.frm.iliofivemale.value);
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
   
    if( document.frm.diphofivemale.value == "" )
   {
     diphofivemale = 0;
   }
   else
   {
	   diphofivemale = parseInt(document.frm.diphofivemale.value);
   }
   
   if( document.frm.diphofivefemale.value == "" )
   {
     diphofivefemale = 0;
   }
   else
   {
	   diphofivefemale = parseInt(document.frm.diphofivefemale.value);
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
   
   
   if( document.frm.wcofivemale.value == "" )
   {
     wcofivemale=0;
   }
   else
	{
		wcofivemale = parseInt(document.frm.wcofivemale.value);
	}
   
   if( document.frm.wcofivefemale.value == "" )
   {
     wcofivefemale=0;
   }
   else
   {
	   wcofivefemale = parseInt(document.frm.wcofivefemale.value);
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
   
   if( document.frm.measofivemale.value == "" )
   {
     measofivemale = 0;
   }
   else
   {
	   measofivemale = parseInt(document.frm.measofivemale.value);
   }
   
   if( document.frm.measofivefemale.value == "" )
   {
     measofivefemale = 0;
   }
   else
   {
	   measofivefemale = parseInt(document.frm.measofivefemale.value);
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
   
    if( document.frm.afpofivemale.value == "" )
   {
     afpofivemale = 0;
   }
   else
   {
	   afpofivemale = parseInt(document.frm.afpofivemale.value);
   }
   
   if( document.frm.afpofivefemale.value == "" )
   {
     afpofivefemale = 0;
   }
   else
   {
	   afpofivefemale = parseInt(document.frm.afpofivefemale.value);
   }
   
   
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
   
   //totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale ;
   
    totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale + awdufivemale + awdufivefemale + awdofivemale +awdofivefemale +bdufivemale +bdufivefemale +bdofivemale +bdofivefemale +oadufivemale +oadufivefemale +oadofivemale + oadofivefemale +diphmale +diphfemale +diphofivemale +diphofivefemale +wcmale +wcfemale + wcofivemale +wcofivefemale+measmale +measfemale + measofivemale + measofivefemale +nntmale +nntfemale +afpmale +afpfemale +afpofivemale +afpofivefemale +ajsmale +ajsfemale +vhfmale + vhffemale +malufivemale + malufivefemale +malofivemale +malofivefemale +suspectedmenegitismale +suspectedmenegitisfemale + suspectedmenegitisofivemale + suspectedmenegitisofivefemale + undismale +undisfemale +undismaletwo +undisfemaletwo +ocmale +ocfemale;
		
		document.frm.total_consultations.value=totalconsultations ;
   
     
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
   </SCRIPT>
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
	
	
	function findReport(frm){
	if(validateForm(frm)){
	document.getElementById('reportdetails').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getreportdetails";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&week_no=" + totalEncode(document.frm.week_no.value )+ "&district_id=" + totalEncode(document.frm.district_id.value )+ "&healthfacility_id=" + totalEncode(document.frm.healthfacility_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reportdetails').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reportdetails').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	
	function CalculateConsultations()
	{
		var sariufivemale;
		var sariufivefemale;
		var sariofivemale;
		var sariofivefemale;
		var iliufivemale
		var iliufivefemale
		var iliofivemale
		var iliofivefemale
		var awdufivemale
		var awdufivefemale
		var awdofivemale
		var awdofivefemale
		var bdufivemale
		var bdufivefemale
		var bdofivemale
		var bdofivefemale
		var oadufivemale
		var oadufivefemale
		var oadofivemale
		var oadofivefemale
		var diphmale
		var diphfemale
		var wcmale
		var wcfemale
		var measmale
		var measfemale
		var nntmale
		var nntfemale
		var afpmale
		var afpfemale
		var ajsmale
		var ajsfemale
		var vhfmale
		var vhffemale
		var malufivemale
		var malufivefemale
		var malofivemale
		var malofivefemale
		var suspectedmenegitismale
		var suspectedmenegitisfemale
		var undismale
		var undisfemale
		var undismaletwo
		var undisfemaletwo
		var ocmale
		var ocfemale
		
		sariufivemale = parseInt(document.getElementById("sariufivemale").value);
		sariufivefemale = parseInt(document.getElementById("sariufivefemale").value);
		sariofivemale = parseInt(document.getElementById("sariofivemale").value);
		sariofivefemale = parseInt(document.getElementById("sariofivefemale").value);
		iliufivemale = parseInt(document.getElementById("iliufivemale").value);
		iliufivefemale = parseInt(document.getElementById("iliufivefemale").value);
		iliofivemale = parseInt(document.getElementById("iliofivemale").value); 
		iliofivefemale = parseInt(document.getElementById("iliofivefemale").value);
		awdufivemale = parseInt(document.getElementById("awdufivemale").value);
		awdufivefemale = parseInt(document.getElementById("awdufivefemale").value);
		awdofivemale = parseInt(document.getElementById("awdofivemale").value);
		awdofivefemale = parseInt(document.getElementById("awdofivefemale").value);
		bdufivemale = parseInt(document.getElementById("bdufivemale").value);
		bdufivefemale = parseInt(document.getElementById("bdufivefemale").value);
		bdofivemale = parseInt(document.getElementById("bdofivemale").value);
		bdofivefemale = parseInt(document.getElementById("bdofivefemale").value);
		oadufivemale = parseInt(document.getElementById("oadufivemale").value);
		oadufivefemale = parseInt(document.getElementById("oadufivefemale").value);
		oadofivemale = parseInt(document.getElementById("oadofivemale").value);
		oadofivefemale = parseInt(document.getElementById("oadofivefemale").value);
		diphmale = parseInt(document.getElementById("undismale").value);
		diphfemale = parseInt(document.getElementById("diphfemale").value);
		wcmale = parseInt(document.getElementById("wcmale").value);
		wcfemale = parseInt(document.getElementById("wcfemale").value);
		measmale = parseInt(document.getElementById("measmale").value);
		measfemale = parseInt(document.getElementById("measfemale").value);
		nntmale = parseInt(document.getElementById("nntmale").value);
		nntfemale = parseInt(document.getElementById("nntfemale").value);
		afpmale = parseInt(document.getElementById("afpmale").value);
		afpfemale = parseInt(document.getElementById("afpfemale").value);
		ajsmale = parseInt(document.getElementById("ajsmale").value);
		ajsfemale = parseInt(document.getElementById("ajsfemale").value);
		vhfmale = parseInt(document.getElementById("vhffemale").value);
		vhffemale = parseInt(document.getElementById("malufivemale").value);
		malufivemale = parseInt(document.getElementById("malufivefemale").value);
		malufivefemale = parseInt(document.getElementById("malofivemale").value);
		malofivemale = parseInt(document.getElementById("malofivemale").value);
		malofivefemale = parseInt(document.getElementById("malofivefemale").value);
		suspectedmenegitismale = parseInt(document.getElementById("suspectedmenegitisfemale").value);
		suspectedmenegitisfemale = parseInt(document.getElementById("undismale").value);
		undismale = parseInt(document.getElementById("undismale").value);
		undisfemale = parseInt(document.getElementById("undisfemale").value);
		undismaletwo = parseInt(document.getElementById("undismaletwo").value);
		undisfemaletwo = parseInt(document.getElementById("undisfemaletwo").value);
		ocmale = parseInt(document.getElementById("ocmale").value);
		ocfemale = parseInt(document.getElementById("ocfemale").value);
		
		
		totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale + awdufivemale + awdufivefemale + awdofivemale +awdofivefemale +bdufivemale +bdufivefemale +bdofivemale +bdofivefemale +oadufivemale +oadufivefemale +oadofivemale + oadofivefemale +diphmale +diphfemale +wcmale +wcfemale +measmale +measfemale +nntmale +nntfemale +afpmale +afpfemale +ajsmale +ajsfemale +vhfmale + vhffemale +malufivemale + malufivefemale +malofivemale +malofivefemale +suspectedmenegitismale +suspectedmenegitisfemale +undismale +undisfemale +undismaletwo +undisfemaletwo +ocmale +ocfemale;
		document.getElementById("total_consultations").value=totalconsultations ;
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

						<li class="active">Reporting Form</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Edit Data
							<small>
								<i class="icon-double-angle-right"></i>
								Reporting Form
							</small>
						</h1>
					</div><!--/.page-header-->
                    <?php
    	if(!empty($alert_message))
		{
		?>
		
   <p> <div class="alert alert-danger"> <?php echo $alert_message;?></div></p>
	   <?php
	   }
	   ?>
        <?php
    	if(!empty($sucsess_message))
		{
		?>
        <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>
		<p>
											<strong>
												<i class="icon-ok"></i>
												&nbsp;
											</strong>
											<?php echo $sucsess_message;?>
		</p>
        </div>
	   <?php
	   }
	   ?>
                    
                 
                           <?php 
						   //$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
						   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
						   echo form_open('reportingforms/update_form/',$attributes); ?>
                           <table id="customers">
                               <thead>
                               		<tr><th colspan="4">At Health Facility level</th></tr>
                               </thead>
                               <tbody>
                               
                               <tr>
                               <td><?php echo $user_country->first_admin_level_label;?></td><td><?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>s-</option>
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
							   ?>
                               <strong><?php echo $zone->zone;?></strong>
                               <?php
								}
								?></td>
                               <td><?php echo $user_country->second_admin_level_label;?></td><td> <?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <div id="regions">
                                    <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="0">-All <?php echo $user_country->second_admin_level_label;?>s</option>
                                
                                    </select>
                                   <!-- <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="0">-All Regions</option>
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
								}
								else
								{
							   ?>
                               <strong><?php echo $region->region;?></strong>
                               <?php
								}
								?></td></tr>
                              <tr><td><?php echo $user_country->third_admin_level_label;?></td><td>
                                <?php
							
							  if($level == 3 || $level==6)
							  {
								  ?>
                                   <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
                                  <?php
							  }
							  else
							  {
								 if(getRole() == 'SuperAdmin')
	 							{
									?>
                                   <div id="districts">
                                   <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                   <option value="0">-All <?php echo $user_country->third_admin_level_label;?>-</option>
							
                                </select>
                                   <!-- <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All Districts-</option>
								<?php
                                foreach($districts as $key => $district)
                                {
                                    ?>
                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
                                    <?php
                                }
                                ?>
                                </select>-->
                               </div>
                                    <?php
								}
								else
								{
								  ?>
                                   <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                   <option value="0">-All <?php echo $user_country->third_admin_level_label;?>s-</option>
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
							  }
							  ?>
                             
                              </td>
                              <td>Health Facility</td><td>
                               <?php
							  if($level== 3)
							  {
								  ?>
                              <select name="healthfacility_id" id="healthfacility_id">
                              <option value="<?php echo $healthfacility->id;?>"><?php echo $healthfacility->health_facility;?></option>
                              </select>
                              <?php
							  }
							  else
							  {
								  ?>
                                  <div id="healthfacilities">
                                  <?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                
                                  </select>
                                  <!--  <select name="healthfacility_id" id="healthfacility_id">
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
								else
								{
									
									if($level==6)
									{
										?>
                                        
                                        <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                  <?php
                                foreach($healthfacilities->result() as $healthfacility)
                                {
                                    ?>
                                  <option value="<?php echo $healthfacility->id;?>" <?php if($healthfacility->id==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility->health_facility;?></option>
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
								}
								?>
                                  </div>
                                 
                                  <?php
							  }
							  ?>
                              </td>
                              </tr>
                             <tr>
                             <td valign="top">Reporting Year</td><td valign="top"><select name="reporting_year" id="reporting_year" onChange="GetPeriod(this)">
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y')+1;
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
                               
                               </td>
                             <td valign="top">Week No</td><td valign="top"><select name="week_no" id="week_no" onChange="GetPeriod(this)">
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
                             <tr><td>Reporting Period</td><td><div id="reporingperiods">
                               <!--<input type="text" name="reporting_period" id="reporting_period" readonly="">-->&nbsp;
                               </div></td><td>&nbsp;</td><td>&nbsp;
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
						 
  document.write("<input type='hidden' name='edit_datetime' value='" + formattedDate + "'><br>")
  document.write("<input type='hidden' name='edit_date' id='edit_date' value='" +today+ "'>")
							</script>
                               </td></tr>
                             <tr><td colspan="4"><input type="button" name="find_button" value="Get Data" class="btn" onClick="findReport()" /></td></tr>
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
