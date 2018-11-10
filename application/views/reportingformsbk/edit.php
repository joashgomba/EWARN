<?php include(APPPATH . 'views/common/header.php'); ?>

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
		var wcmale;
		var wcfemale;
		var measmale;
		var measfemale;
		var nntmale;
		var nntfemale;
		var afpmale;
		var afpfemale;
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
  
     
   if( document.frm.healthfacility_id.value == "" )
   {
     alert( "Please enter the health facility" );
     document.frm.healthfacility_id.focus() ;
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
     alert( "Please enter Diph Male" );
     document.frm.diphmale.focus() ;
     return false;
   }
   
   if( document.frm.diphfemale.value == "" )
   {
     alert( "Please enter Diph Female" );
     document.frm.diphfemale.focus() ;
     return false;
   }
   
   if( document.frm.wcmale.value == "" )
   {
     alert( "Please enter WC Male" );
     document.frm.wcmale.focus() ;
     return false;
   }
   
   if( document.frm.wcfemale.value == "" )
   {
     alert( "Please enter WC Female" );
     document.frm.wcfemale.focus() ;
     return false;
   }
   
   if( document.frm.measmale.value == "" )
   {
     alert( "Please enter Meas Male" );
     document.frm.measmale.focus() ;
     return false;
   }
   
   if( document.frm.measfemale.value == "" )
   {
     alert( "Please enter Meas Female" );
     document.frm.measfemale.focus() ;
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
     alert( "Please enter AFP Male" );
     document.frm.afpmale.focus() ;
     return false;
   }
   
   if( document.frm.afpfemale.value == "" )
   {
     alert( "Please enter AFP Female" );
     document.frm.afpfemale.focus() ;
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
     alert( "Please enter  Men Male" );
     document.frm.suspectedmenegitismale.focus() ;
     return false;
   }
   
   if( document.frm.suspectedmenegitisfemale.value == "" )
   {
     alert( "Please enter Men Female" );
     document.frm.suspectedmenegitisfemale.focus() ;
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
   /**
   if (!frm.undissecdesc.value.match(/^[a-zA-Z]+$/))
    {
		alert("Please Enter only letters in text");
		document.frm.undissecdesc.focus() ;
		 return false;
    }
   **/
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
		
	var diph = parseInt(document.frm.diphmale.value) + parseInt(document.frm.diphfemale.value);
		
	var wc = parseInt(document.frm.wcmale.value) + parseInt(document.frm.wcfemale.value);
		
	var meas = parseInt(document.frm.measmale.value) + parseInt(document.frm.measfemale.value);
		
	var nnt = parseInt(document.frm.nntmale.value) + parseInt(document.frm.nntfemale.value);
		
    var afp = parseInt(document.frm.afpmale.value) + parseInt(document.frm.afpfemale.value);
		
	var ajs = parseInt(document.frm.ajsmale.value) + parseInt(document.frm.ajsfemale.value);
		
	var vhf = parseInt(document.frm.vhfmale.value) + parseInt(document.frm.vhffemale.value);
		
	var mal = (parseInt(document.frm.malufivemale.value) + parseInt(document.frm.malufivefemale.value) + parseInt(document.frm.malofivemale.value) + parseInt(document.frm.malofivefemale.value));
		
	var men = parseInt(document.frm.suspectedmenegitismale.value) + parseInt(document.frm.suspectedmenegitisfemale.value);
		
	var undis = (parseInt(document.frm.undismale.value) + parseInt(document.frm.undisfemale.value) + parseInt(document.frm.undismaletwo.value) + parseInt(document.frm.undisfemaletwo.value));
		
	var oc = parseInt(document.frm.ocmale.value) + parseInt(document.frm.ocfemale.value);
	
	  var totalconsultations;
    var totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale + awdufivemale + awdufivefemale + awdofivemale +awdofivefemale +bdufivemale +bdufivefemale +bdofivemale +bdofivefemale +oadufivemale +oadufivefemale +oadofivemale + oadofivefemale +diphmale +diphfemale +wcmale +wcfemale +measmale +measfemale +nntmale +nntfemale +afpmale +afpfemale +ajsmale +ajsfemale +vhfmale + vhffemale +malufivemale + malufivefemale +malofivemale +malofivefemale +suspectedmenegitismale +suspectedmenegitisfemale +undismale +undisfemale +undismaletwo +undisfemaletwo +ocmale +ocfemale;
	
	
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
			var diphval = confirm('Submit alert Diph Male = '+diphmale+'?');
			
			if(!diphval)
			{
				document.frm.diphmale .focus() ;
				return false;		
			}
		}
		
		if(diphfemale>0)
		{
			var diphval2 = confirm('Submit alert Diph Female = '+diphfemale+'?');
		
			if(!diphval2)
			{
				document.frm.diphfemale .focus() ;
				return false;		
			}
		}
	}
	
	if(wc>4)
	{
		
		if(wcmale>0)
		{
			var wcval = confirm('Submit alert WC Male = '+wcmale+'?');
			
			if(!wcval)
			{
				document.frm.wcmale .focus() ;
				return false;		
			}
		}
		
		if(wcfemale>0)
		{
			var wcval2 = confirm('Submit alert WC Female = '+wcfemale+'?');
			
			if(!wcval2)
			{
				document.frm.wcfemale .focus() ;
				return false;		
			}
		}
		
	}
	
	if(meas>0)
	{
		
		if(measmale>0)
		{
			var measval = confirm('Submit alert Meas Male = '+measmale+'?');
		
			if(!measval)
			{
				document.frm.measmale .focus() ;
				return false;		
			}
		}
		
		if(measfemale>0)
		{
			var measval2 = confirm('Submit alert Meas Female = '+measfemale+'?');
		
			if(!measval2)
			{
				document.frm.measfemale .focus() ;
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
			var afpval = confirm('Submit alert AFP Male = '+afpmale+'?');
			
			if(!afpval)
			{
				document.frm.afpmale .focus() ;
				return false;		
			}
		}
		
		if(afpfemale>0)
		{
			var afpval2 = confirm('Submit alert AFP Female = '+afpfemale+'?');
		
			if(!afpval2)
			{
				document.frm.afpfemale .focus() ;
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
			var menval = confirm('Submit alert Men Male= '+suspectedmenegitismale+'?');
			
			if(!menval)
			{
				document.frm.suspectedmenegitismale .focus() ;
				return false;		
			}
		}
		
		if(suspectedmenegitisfemale>0)
		{
			var menval2 = confirm('Submit alert Men Female= '+suspectedmenegitisfemale+'?');
			
			if(!menval2)
			{
				document.frm.suspectedmenegitisfemale .focus() ;
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
		var wcmale;
		var wcfemale;
		var measmale;
		var measfemale;
		var nntmale;
		var nntfemale;
		var afpmale;
		var afpfemale;
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
   
    totalconsultations = sariufivemale + sariufivefemale + sariofivemale + sariofivefemale + iliufivemale + iliufivefemale + iliofivemale + iliofivefemale + awdufivemale + awdufivefemale + awdofivemale +awdofivefemale +bdufivemale +bdufivefemale +bdofivemale +bdofivefemale +oadufivemale +oadufivefemale +oadofivemale + oadofivefemale +diphmale +diphfemale +wcmale +wcfemale +measmale +measfemale +nntmale +nntfemale +afpmale +afpfemale +ajsmale +ajsfemale +vhfmale + vhffemale +malufivemale + malufivefemale +malofivemale +malofivefemale +suspectedmenegitismale +suspectedmenegitisfemale +undismale +undisfemale +undismaletwo +undisfemaletwo +ocmale +ocfemale;
		
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
							Data Entry
							<small>
								<i class="icon-double-angle-right"></i>
								Reporting Form
							</small>
						</h1>
					</div><!--/.page-header-->
                 
                          <?php 
						  $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
						  echo form_open('reportingforms/edit_validate/'.$row->id.'',$attributes); ?>
                           <table id="customers">
                               <thead>
                               		<tr><th colspan="4">At Health Facility level</th></tr>
                               </thead>
                               <tbody>
                               <tr><td valign="top">Week No</td><td valign="top"><?php echo form_error('week_no', '<div class="alert alert-danger">', '</div>'); ?><select class="chzn-select" name="week_no" id="form-field-select-3" data-placeholder="Select a Week..." disabled>
                               
                               <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                   <option value="<?php echo $i;?>" <?php if($row->week_no==$i){ echo 'selected="selected"';}?>>Week <?php echo $i;?></option>
                                   <?php
							   }
							   ?>
                               </select></td><td valign="top">Reporting Year</td><td valign="top"><select name="reporting_year" disabled>
                               <?php
     $currentYear = date('Y');
        foreach (range(2012, $currentYear) as $value) {
          ?>
           <option value="<?php echo $value;?>" <?php if($value==$row->reporting_year){echo 'selected="selected"';}?>><?php echo $value;?></option>
          <?php

        }
?>
                               </select>
                               </td></tr>
                               
                               <tr><td valign="top">Reporting Date</td><td valign="top"><?php echo form_error('reporting_date', '<div class="alert alert-danger">', '</div>'); ?>
							   		<input readonly="" id="form-input-readonly" name="reporting_date" type="text" value="<?php echo $row->reporting_date;?>" />
                                    
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
															<span class="add-on">
																<i class="icon-calendar"></i>
															</span>
							  </td><td valign="top">Reported By:</td><td valign="top"><input readonly="" type="text" id="form-input-readonly" value="<?php echo $user->fname;?> <?php echo$user->lname;?>" /></td></tr>
                              
                              <tr><td valign="top">Health Facility Name</td><td valign="top">
                              <?php
							  if($level==3)
							  {
								  ?>
                                   <input readonly="" type="text" id="form-input-readonly" value="<?php echo $healthfacility->health_facility;?>" />
                                   <input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility->id;?>">
                                    <input type="hidden" name="oldhf_id" id="oldhf_id" value="<?php echo $healthfacility->id;?>">
                                  <?php
							  }
							  else
							  {
								  ?>
                                   <input type="hidden" name="oldhf_id" id="oldhf_id" value="<?php echo $healthfacility->id;?>">
                                   <select name="healthfacility_id" id="healthfacility_id">
                                  <?php
                                foreach($healthfacilities as $key => $facility)
                                {
                                    ?>
                                  <option value="<?php echo $facility['id'];?>" <?php if($facility['id']==$healthfacility->id){ echo 'selected="selected"';}?> ><?php echo $facility['health_facility'];?></option>
                                  <?php
								}
							  ?>
                                  </select>
                                  <?php
							  }
							  ?>
                             </td><td valign="top">Contact Number</td><td valign="top"><?php echo form_error('contact_number', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '', 'name' => 'contact_number', 'value'=> $row->contact_number); echo form_input($data, set_value('contact_number')); ?></td>
                              <tr><td valign="top">Health Facility Code</td><td valign="top"><input readonly="" type="text" name="health_facility_code" id="form-input-readonly" value="<?php echo $healthfacility->hf_code;?>" /></td><td valign="top">Supporting NGO</td><td valign="top"><?php echo form_error('supporting_ngo', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '', 'name' => 'supporting_ngo', 'value'=> $row->supporting_ngo); echo form_input($data, set_value('supporting_ngo')); ?></td></tr>
                              <tr><td valign="top">Region</td><td valign="top"><input readonly="" type="text" id="form-input-readonly" value="<?php echo $region->region;?>" /></td>
                                <td valign="top">District</td>
                                <td valign="top"><input readonly="" type="text" id="form-input-readonly" value="<?php echo $district->district;?>" /></td>
                              </tr>
                              <?php
							   if ($row->approved_regional == 1) {
								   ?>
                              <tr ><td colspan="4"><p class="alert alert-info">
													This form has been submitted and has been validated, therefore you can only view but you cannot edit it.
												</p></td></tr>
                              <?php
							   }
							   ?>
                              <tr ><th colspan="2">Health Events Under Surveillance</th><th colspan="2">Total Cases</th></tr>
                              
                               <tr class="alt"><td valign="top" colspan="2">Respiratory Diseases</td><td valign="top">Male</td><td valign="top">Female</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &lt;5yr</td><td valign="top"><?php $data = array('id' => 'sariufivemale', 'name' => 'sariufivemale', 'value'=> $row->sariufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariufivemale')); ?><?php echo form_error('sariufivemale', '<div class="alert alert-danger">', '</div>'); ?></td><td valign="top"><?php $data = array('id' => 'sariufivefemale', 'name' => 'sariufivefemale', 'value'=> $row->sariufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariufivefemale')); ?><?php echo form_error('sariufivefemale', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &gt;5yr</td><td valign="top"><?php $data = array('id' => 'sariofivemale', 'name' => 'sariofivemale', 'value'=> $row->sariofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivemale')); ?>
                                <?php echo form_error('sariofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'sariofivefemale', 'name' => 'sariofivefemale', 'value'=> $row->sariofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivefemale')); ?>
                                <?php echo form_error('sariofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &lt;5yr</td><td valign="top"><?php $data = array('id' => 'iliufivemale', 'name' => 'iliufivemale', 'value'=> $row->iliufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivemale')); ?>
                                <?php echo form_error('iliufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'iliufivefemale', 'name' => 'iliufivefemale', 'value'=> $row->iliufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &gt;5yr</td><td valign="top">
                                <?php $data = array('id' => 'iliofivemale', 'name' => 'iliofivemale', 'value'=> $row->iliofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top">
                                  <?php $data = array('id' => 'iliofivefemale', 'name' => 'iliofivefemale', 'value'=> $row->iliofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Gastro Intestinal Tract Disease</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &lt;5yr</td><td valign="top"><?php $data = array('id' => 'awdufivemale', 'name' => 'awdufivemale', 'value'=> $row->awdufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivemale')); ?>
                                <?php echo form_error('awdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdufivefemale', 'name' => 'awdufivefemale', 'value'=> $row->awdufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivefemale')); ?>
                                <?php echo form_error('awdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &gt;5yr</td><td valign="top"><?php $data = array('id' => 'awdofivemale', 'name' => 'awdofivemale', 'value'=> $row->awdofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivemale')); ?>
                                <?php echo form_error('awdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdofivefemale', 'name' => 'awdofivefemale', 'value'=> $row->awdofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivefemale')); ?>
                                <?php echo form_error('awdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'bdufivemale', 'name' => 'bdufivemale', 'value'=> $row->bdufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivemale')); ?>
                                <?php echo form_error('bdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdufivefemale', 'name' => 'bdufivefemale', 'value'=> $row->bdufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivefemale')); ?>
                                <?php echo form_error('bdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'bdofivemale', 'name' => 'bdofivemale', 'value'=> $row->bdofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivemale')); ?>
                                <?php echo form_error('bdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdofivefemale', 'name' => 'bdofivefemale', 'value'=> $row->bdofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivefemale')); ?>
                                <?php echo form_error('bdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Other Acute Diarrhea &lt;5yr</td><td valign="top"><?php $data = array('id' => 'oadufivemale', 'name' => 'oadufivemale', 'value'=> $row->oadufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadufivemale')); ?>
                                 <?php echo form_error('oadufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'oadufivefemale', 'name' => 'oadufivefemale', 'value'=> $row->oadufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadufivefemale')); ?>
                                 <?php echo form_error('oadufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Other Acute Diarrhea &gt;5yr</td><td valign="top"><?php $data = array('id' => 'oadofivemale', 'name' => 'oadofivemale', 'value'=> $row->oadofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivemale')); ?>
                                <?php echo form_error('oadofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'oadofivefemale', 'name' => 'oadofivefemale', 'value'=> $row->oadofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivefemale')); ?>
                                <?php echo form_error('oadofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Vaccine Preventable Diseases</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Suspected Diphtheria</td><td valign="top"><?php $data = array('id' => 'diphmale', 'name' => 'diphmale', 'value'=> $row->diphmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphmale')); ?>
                                
                                <?php echo form_error('diphmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'diphfemale', 'name' => 'diphfemale', 'value'=> $row->diphfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphfemale')); ?>
                                <?php echo form_error('diphfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Suspected Whooping Cough</td><td valign="top"><?php $data = array('id' => 'wcmale', 'name' => 'wcmale', 'value'=> $row->wcmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcmale')); ?>
                                <?php echo form_error('wcmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'wcfemale', 'name' => 'wcfemale', 'value'=> $row->wcfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcfemale')); ?>
                                <?php echo form_error('wcfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Suspected Measles</td><td valign="top"><?php $data = array('id' => 'measmale', 'name' => 'measmale', 'value'=> $row->measmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measmale')); ?>
                                  <?php echo form_error('measmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'measfemale', 'name' => 'measfemale', 'value'=> $row->measfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measfemale')); ?>
                                  <?php echo form_error('measfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Neonatal Tetanus</td><td valign="top"><?php $data = array('id' => 'nntmale', 'name' => 'nntmale', 'value'=> $row->nntmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntmale')); ?>
                                <?php echo form_error('nntmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'nntfemale', 'name' => 'nntfemale', 'value'=> $row->nntfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntfemale')); ?>
                                <?php echo form_error('nntfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Acute Flaccid Paralysis</td><td valign="top"><?php $data = array('id' => 'afpmale', 'name' => 'afpmale', 'value'=> $row->afpmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpmale')); ?>
                                 <?php echo form_error('afpmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'afpfemale', 'name' => 'afpfemale', 'value'=> $row->afpfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpfemale')); ?>
                                 <?php echo form_error('afpfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>

                               <tr class="alt"><td valign="top" colspan="4">Other Communicable Diseases</td></tr>
                             <tr>
                               <td valign="top" colspan="2">Suspected Acute Jaundice Syndrome</td><td valign="top"><?php $data = array('id' => 'ajsmale', 'name' => 'ajsmale', 'value'=> $row->ajsmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsmale')); ?>
                               <?php echo form_error('ajsmale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'ajsfemale', 'name' => 'ajsfemale', 'value'=> $row->ajsfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsfemale')); ?>
                               <?php echo form_error('ajsfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Suspected Viral Hemorrhagic Fever</td><td valign="top"><?php $data = array('id' => 'vhfmale', 'name' => 'vhfmale', 'value'=> $row->vhfmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhfmale')); ?>
                              <?php echo form_error('vhfmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'vhffemale', 'name' => 'vhffemale', 'value'=> $row->vhffemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhffemale')); ?>
                              <?php echo form_error('vhffemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               <tr><td valign="top" colspan="2">Confirmed Malaria &lt;5yr</td><td valign="top"><?php $data = array('id' => 'malufivemale', 'name' => 'malufivemale', 'value'=> $row->malufivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivemale')); ?>
                               <?php echo form_error('malufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'malufivefemale', 'name' => 'malufivefemale', 'value'=> $row->malufivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivefemale')); ?>
                               <?php echo form_error('malufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Confirmed Malaria &gt;5yr</td><td valign="top"><?php $data = array('id' => 'malofivemale', 'name' => 'malofivemale', 'value'=> $row->malofivemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivemale')); ?>
                              <?php echo form_error('malofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'malofivefemale', 'name' => 'malofivefemale', 'value'=> $row->malofivefemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivefemale')); ?>
                              <?php echo form_error('malofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               <tr><td valign="top" colspan="2">Suspected Meningitis</td><td valign="top"><?php $data = array('id' => 'suspectedmenegitismale', 'name' => 'suspectedmenegitismale', 'value'=> $row->suspectedmenegitismale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitismale')); ?>
                               
                               <?php echo form_error('suspectedmenegitismale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisfemale', 'name' => 'suspectedmenegitisfemale', 'value'=> $row->suspectedmenegitisfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisfemale')); ?>
                               <?php echo form_error('suspectedmenegitisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                            <tr class="alt"><td valign="top" colspan="4">Other Unusual Diseases or Deaths</td></tr>
                              <tr><td valign="top" colspan="2"><?php $data = array('id' => 'undisonedesc', 'name' => 'undisonedesc', 'value'=> $row->undisonedesc); echo form_input($data, set_value('undisonedesc')); ?>
                                 <?php echo form_error('undisonedesc', '<div class="alert alert-danger">', '</div>'); ?></td><td valign="top"><?php $data = array('id' => 'undismale', 'name' => 'undismale', 'value'=> $row->undismale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismale')); ?>
                              <?php echo form_error('undismale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemale', 'name' => 'undisfemale', 'value'=> $row->undisfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemale')); ?>
                              <?php echo form_error('undisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              
                              <tr>
                                <td valign="top" colspan="2"><?php $data = array('id' => 'undissecdesc', 'name' => 'undissecdesc', 'value'=> $row->undissecdesc); echo form_input($data, set_value('undissecdesc')); ?>
                                 <?php echo form_error('undissecdesc', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'undismaletwo', 'name' => 'undismaletwo', 'value'=> $row->undismaletwo, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismaletwo')); ?>
                              <?php echo form_error('undismaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemaletwo', 'name' => 'undisfemaletwo', 'value'=> $row->undisfemaletwo, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemaletwo')); ?>
                              <?php echo form_error('undisfemaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td colspan="4"> <div id="container">
            <p id="add_field"><a href="javascript:void(0)" class="btn btn-success"><span>Add Fields</span></a></p>
        </div></td></tr>
                              <tr><td valign="top" colspan="2">Other Consultations</td><td valign="top"><?php $data = array('id' => 'ocmale', 'name' => 'ocmale', 'value'=> $row->ocmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocmale')); ?>
                              <?php echo form_error('ocmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'ocfemale', 'name' => 'ocfemale', 'value'=> $row->ocfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocfemale')); ?>
                              <?php echo form_error('ocfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <?php
							  foreach($otherconsultations as $key=>$otherconsultation)
							  {
								  ?>
                                  <tr><td colspan="2"><input type="text" name="fields[]" value="<?php echo $otherconsultation['disease'];?>" id="male"><td><input type="text" name="male[]" value="<?php echo $otherconsultation['malevalue'];?>" id=""></td><td><input type="text" name="female[]" value="<?php echo $otherconsultation['femalevalue'];?>" id="female"></td></tr>
                                  <?php
							  }
							  ?>
                              
                              <tr><td valign="top" colspan="2">Total Consultations</td><td valign="top" colspan="2"><?php $data = array('id' => 'total_consultations', 'name' => 'total_consultations', 'value'=> $row->total_consultations, 'readonly'=>'readonly'); echo form_input($data, set_value('total_consultations')); ?><input type="button" value="CALCULATE" onClick="CalcConsultations()" ></td></tr>
                              
                              <tr class="alt"><td valign="top" colspan="4">Malaria Tests</td></tr>
                              <tr><td valign="top" colspan="2">Slides/RDT examined</td><td valign="top" colspan="2"><?php $data = array('id' => 'sre', 'name' => 'sre', 'value'=> $row->sre, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sre')); ?>
                              <?php echo form_error('sre', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Falciparum positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pf', 'name' => 'pf', 'value'=> $row->pf, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pf')); ?>
                              <?php echo form_error('pf', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Vivax positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pv', 'name' => 'pv', 'value'=> $row->pv, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pv')); ?>
                              <?php echo form_error('pv', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Mixed positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pmix', 'name' => 'pmix', 'value'=> $row->pmix, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pmix')); ?>
                              <?php echo form_error('pmix', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Total Negative</td><td valign="top" colspan="2"><?php $data = array('id' => 'totalnegative', 'name' => 'totalnegative', 'value'=> $row->totalnegative, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('totalnegative')); ?>
							  <?php echo form_error('totalnegative', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                                <tr><td valign="top" colspan="2">Total Positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'total_positive', 'name' => 'total_positive', 'value'=> $row->total_positive, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('total_positive')); ?>
							  <?php echo form_error('total_positive', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                            
                              <!--<tr><td valign="top" colspan="2">Submit for Regional Approval</td><td valign="top" colspan="2">
                              <select name="approved_hf" id="approved_hf">
                              	<option value="1" <?php if($row->approved_hf==1){ echo 'selected="selected"';}?>>Yes</option>
                                <option value="0" <?php if($row->approved_hf==0){ echo 'selected="selected"';}?>>No</option>
                              </select>
                              </td></tr>-->
                               </tbody>
                               </table>
                               <?php
							   //if($row->approved_hf==1)
							    if($row->approved_regional==1)
								{
									//do not show submit buttons
								}
								else
								{
							   ?>
<div class="form-actions"><?php //echo form_submit('submit', 'Save Data', 'class="btn btn-info "'); ?>
<?php
if($row->approved_hf==0)
{
?>
<input type="submit" name="draft_button" value="save to draft only" class="btn" onClick="return(draftvalidate())" />
&nbsp; &nbsp; &nbsp;
<?php
}
?>
<input type="submit" name="submit_button" value="Submit report" class="btn btn-info" onClick="return(validate())"/>
<?php
								}
								?>
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
