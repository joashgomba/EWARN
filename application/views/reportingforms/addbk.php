<?php include(APPPATH . 'views/common/header.php'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<style>
#container { border:   #ccc; padding: 2px; }
.clear {overflow: hidden;width: 100%;
}
</style>


<script>

function change(that, fgcolor, bgcolor,txtcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
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

<script type="text/JavaScript">
function doStuff()
{
	for (var i=1; i<4; i++)
	{
		if (document.getElementById('field_'+i) || document.getElementById('male'+i))
		{
			if (document.getElementById('field_'+i).value=="")
			{
				alert("Please fill in the other consultaion #"+i+" field...");
				return false;
			}
			if (document.getElementById('male'+i).value=="")
			{
				alert("Please fill in the male #"+i+" field...");
				return false;
			}
		}
	}
	alert("Ok to submit...");
	//document.form1.submit();
}
</script>

<script type="text/javascript">
<!--
// Form validation code will come here.
function checkvalid()
{
	if( document.frm.period_check.value == 1)
   {
     alert( "The reporting period for the health facility has been entered." );
     document.frm.reporting_year.focus() ;
     return false;
   }
}

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
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getperiodbyhf";
	
	var params = "week_no=" + totalEncode(document.frm.week_no.value ) + "&reporting_year="+totalEncode(document.frm.reporting_year.value ) + "&healthfacility_id="+totalEncode(document.frm.healthfacility_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reporingperiods').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reporingperiods').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	
	function totalConsultations(frm){
	if(validateForm(frm)){
	document.getElementById('totconsultations').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/reportingforms/getconsultations";
	
	/**
	ajsmale
		ajsfemale
		vhfmale
		vhffemale
		malufivemale
		malufivefemale
		malofivemale
		malofivefemale
		suspectedmenegitismale
		suspectedmenegitisfemale
		undismale
		undisfemale
		undismaletwo
		undisfemaletwo
		ocmale
		ocfemale
	**/
	
	var params = "sariufivemale=" + totalEncode(document.frm.sariufivemale.value )+ "&sariufivefemale="+totalEncode(document.frm.sariufivefemale.value )+ "&sariofivemale="+totalEncode(document.frm.sariofivemale.value )+ "&sariofivefemale="+totalEncode(document.frm.sariofivefemale.value )+ "&iliufivemale="+totalEncode(document.frm.iliufivemale.value )+ "&iliufivefemale="+totalEncode(document.frm.iliufivefemale.value )+ "&iliofivemale="+totalEncode(document.frm.iliofivemale.value )+ "&iliofivefemale="+totalEncode(document.frm.iliofivefemale.value )+ "&awdufivemale="+totalEncode(document.frm.awdufivemale.value )+ "&awdufivefemale="+totalEncode(document.frm.awdufivefemale.value )+ "&awdofivemale="+totalEncode(document.frm.awdofivemale.value )+ "&awdofivefemale="+totalEncode(document.frm.awdofivefemale.value )+ "&bdufivemale="+totalEncode(document.frm.bdufivemale.value )+ "&bdufivefemale="+totalEncode(document.frm.bdufivefemale.value )+ "&bdofivemale="+totalEncode(document.frm.bdofivemale.value )+ "&bdofivefemale="+totalEncode(document.frm.bdofivefemale.value ) + "&oadufivemale="+totalEncode(document.frm.oadufivemale.value )+ "&oadufivefemale="+totalEncode(document.frm.oadufivefemale.value )+ "&oadofivemale="+totalEncode(document.frm.oadofivemale.value )+ "&oadofivefemale="+totalEncode(document.frm.oadofivefemale.value )+ "&diphmale="+totalEncode(document.frm.diphmale.value )+ "&diphfemale="+totalEncode(document.frm.diphfemale.value )+ "&wcmale="+totalEncode(document.frm.wcmale.value )+ "&wcfemale="+totalEncode(document.frm.wcfemale.value ) + "&measmale="+totalEncode(document.frm.measmale.value ) + "&measfemale="+totalEncode(document.frm.measfemale.value ) + "&nntmale="+totalEncode(document.frm.nntmale.value ) + "&nntfemale="+totalEncode(document.frm.nntfemale.value ) + "&afpmale="+totalEncode(document.frm.afpmale.value ) + "&afpfemale="+totalEncode(document.frm.afpfemale.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('totconsultations').innerHTML=connection.responseText ;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('totconsultations').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
						 //$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
						  // echo form_open('reportingforms/add_validate',$attributes); 
						 
						   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');
						   echo form_open('reportingforms/add_validate',$attributes); 
						  ?>
                           <table id="customers">
                               <thead>
                               		<tr><th colspan="4">At Health Facility level</th></tr>
                               </thead>
                               <tbody>
                               <tr>
                               <td>Zone</td><td><?php
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
							   ?>
                               <strong><?php echo $zone->zone;?></strong>
                               <?php
								}
								?></td>
                               <td>Region</td><td>
                               <?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                    <div id="regions">
                                    <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="0">-All Regions-</option>
                               
                                    </select>
                                    <!--<select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="0">-All Regions-</option>
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
								?>
                               </td></tr>
                                 <?php
							  if($level != 3)
							  {
								  ?>
                               <tr>
                               <td>District</td><td>
                                <?php
								$level = $this->erkanaauth->getField('level');
							  if($level == 3)
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
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								
                                </select>
                                    <!--<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								<?php
                                foreach($admindistricts as $key => $district)
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
                                   <div id="districts">
                                   <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" >
                                   <option value="">Select District</option>
                                   <option value="0">-All districts-</option>
								<?php
                                foreach($districts as $key => $district)
                                {
                                    ?>
                                    <option value="<?php echo $district['id'];?>" <?php if($district['id']==set_value('district_id')){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
                                    <?php
                                }
                                ?>
                                </select>
                                </div>
                                  <?php
								}
							  }
							  ?>
                               </td>
                               <td>Health Facility</td><td> <div id="healthfacilities">
                               <?php
							   if(getRole() == 'SuperAdmin')
	 							{
									?>
                                      <select name="healthfacility_id" id="healthfacility_id">
                                  <option value="">Select Health Facility</option>
                                 
                                  </select>
                                   <!-- <select name="healthfacility_id" id="healthfacility_id">
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
								?>
                                  </div>
                                  <?php echo form_error('healthfacility_id', '<div class="alert alert-danger">', '</div>'); ?></td> 
                                  </tr>
                                  <?php
							  }
							  ?>
                                <?php
							
							  if($level == 3)
							  {
								  ?>
                                  <tr><td>District</td><td>
                                   <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
                               
                              </td><td>&nbsp;</td><td>&nbsp;</td>
                              </tr>
                                 <?php
							  }
							  ?>
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
                               <?php echo form_error('reporting_year', '<div class="alert alert-danger">', '</div>'); ?>
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
                               <?php echo form_error('week_no', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                               <tr><td valign="top">Reporting Period:</td><td>
                              <div id="reporingperiods">
                               <input type="hidden" name="period_check" id="period_check" value="0">&nbsp;
                               </div></td>
                               <td colspan="2">&nbsp;</td>
                               </tr>
                               
                               <tr><td valign="top">Reporting Date</td><td valign="top"><?php echo form_error('reporting_date', '<div class="alert alert-danger">', '</div>'); ?>
							   		<!--<input class="span10 date-picker" id="id-date-picker-1" name="reporting_date" type="text" data-date-format="yyyy-mm-dd" value="<?php echo set_value('reporting_date');?>" />
                                    <span class="add-on">
																<i class="icon-calendar"></i>
															</span>
                                    -->
                                   <!-- <input readonly="" type="text" id="form-input-readonly" name="reporting_date" value="<?php echo date('Y-m-d');?>" />-->
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
															
							  </td><td valign="top">Reported By:</td><td valign="top"><strong><?php //echo $this->erkanaauth->getField('fname');?> <?php //echo $this->erkanaauth->getField('lname');?>
                              
                              <?php
							  $username = getField('username');
							  
							  echo $username;
							  ?>
                              </strong></td></tr>
                               <?php
							  if($level == 3)
							  {
								  ?>
                              <tr><td valign="top">Health Facility Name</td><td valign="top">
                              <input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility->id;?>">
                              <input readonly="" type="text" id="form-input-readonly" value="<?php echo $healthfacility->health_facility;?>" /></td><td valign="top">Contact Number</td><td valign="top"><?php echo form_error('contact_number', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '','name' => 'contact_number', 'value' => $healthfacility->contact_number); echo form_input($data, set_value('contact_number')); ?></td>
                              <tr><td valign="top">Health Facility Code</td><td valign="top"><input readonly="" type="text" name="health_facility_code" id="form-input-readonly" value="<?php echo $healthfacility->hf_code;?>" /></td><td valign="top">Supporting NGO</td><td valign="top"><?php echo form_error('supporting_ngo', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '', 'name' => 'supporting_ngo', 'value' => $healthfacility->organization); echo form_input($data, set_value('supporting_ngo')); ?></td></tr>
                              <?php
							  }
							  else
							  {
								 //show nothing
							  }
							  ?>
                              
                              <tr ><th colspan="2">Health Events Under Surveillance</th><th colspan="2">Total Cases</th></tr>
                              
                               <tr class="alt"><td valign="top" colspan="2">Respiratory Diseases</td><td valign="top">Male</td><td valign="top">Female</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &lt;5yr</td><td valign="top"><?php $data = array('id' => 'sariufivemale', 'name' => 'sariufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000'),checkvalid()", "onblur"=>"change(this,'','','')", 'onClick'=>'checkvalid()'); echo form_input($data, set_value('sariufivemale')); ?><?php echo form_error('sariufivemale', '<div class="alert alert-danger">', '</div>'); ?></td><td valign="top"><?php $data = array('id' => 'sariufivefemale', 'name' => 'sariufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariufivefemale')); ?><?php echo form_error('sariufivefemale', '<div class="alert alert-danger">', '</div>'); ?></td></tr>
                              <tr>
                                <td valign="top" colspan="2">Severe acute respiratory infection &gt;5yr</td><td valign="top"><?php $data = array('id' => 'sariofivemale', 'name' => 'sariofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivemale')); ?>
                                <?php echo form_error('sariofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'sariofivefemale', 'name' => 'sariofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sariofivefemale')); ?>
                                <?php echo form_error('sariofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &lt;5yr</td><td valign="top"><?php $data = array('id' => 'iliufivemale', 'name' => 'iliufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivemale')); ?>
                                <?php echo form_error('iliufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'iliufivefemale', 'name' => 'iliufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Influenza like illnesses &gt;5yr</td><td valign="top">
                                <?php $data = array('id' => 'iliofivemale', 'name' => 'iliofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top">
                                  <?php $data = array('id' => 'iliofivefemale', 'name' => 'iliofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('iliufivefemale')); ?>
                                <?php echo form_error('iliofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Gastro Intestinal Tract Disease</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &lt;5yr</td><td valign="top"><?php $data = array('id' => 'awdufivemale', 'name' => 'awdufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivemale')); ?>
                                <?php echo form_error('awdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdufivefemale', 'name' => 'awdufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdufivefemale')); ?>
                                <?php echo form_error('awdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Acute Watery Diarrhea/Sus.Cholera &gt;5yr</td><td valign="top"><?php $data = array('id' => 'awdofivemale', 'name' => 'awdofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivemale')); ?>
                                <?php echo form_error('awdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'awdofivefemale', 'name' => 'awdofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('awdofivefemale')); ?>
                                <?php echo form_error('awdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'bdufivemale', 'name' => 'bdufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivemale')); ?>
                                <?php echo form_error('bdufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdufivefemale', 'name' => 'bdufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdufivefemale')); ?>
                                <?php echo form_error('bdufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Bloody Diarrhea/Sus.Shigellosis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'bdofivemale', 'name' => 'bdofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivemale')); ?>
                                <?php echo form_error('bdofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'bdofivefemale', 'name' => 'bdofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('bdofivefemale')); ?>
                                <?php echo form_error('bdofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Other Acute Diarrhea &lt;5yr</td><td valign="top"><?php $data = array('id' => 'oadufivemale', 'name' => 'oadufivemale'); echo form_input($data, set_value('oadufivemale')); ?>
                                 <?php echo form_error('oadufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'oadufivefemale', 'name' => 'oadufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadufivefemale')); ?>
                                 <?php echo form_error('oadufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                              <tr>
                                <td valign="top" colspan="2">Other Acute Diarrhea &gt;5yr</td><td valign="top"><?php $data = array('id' => 'oadofivemale', 'name' => 'oadofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivemale')); ?>
                                <?php echo form_error('oadofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'oadofivefemale', 'name' => 'oadofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('oadofivefemale')); ?>
                                <?php echo form_error('oadofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                              <tr class="alt"><td valign="top" colspan="4">Vaccine Preventable Diseases</td></tr>
                              <tr>
                                <td valign="top" colspan="2">Suspected Diphtheria &lt;5yr</td><td valign="top"><?php $data = array('id' => 'diphmale', 'name' => 'diphmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphmale')); ?>
                                
                                <?php echo form_error('diphmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'diphfemale', 'name' => 'diphfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphfemale')); ?>
                                <?php echo form_error('diphfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                                
                                  <tr>
                                <td valign="top" colspan="2">Suspected Diphtheria &gt;5yr</td><td valign="top"><?php $data = array('id' => 'diphofivemale', 'name' => 'diphofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphofivemale')); ?>
                                
                                <?php echo form_error('diphofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'diphofivefemale', 'name' => 'diphofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('diphofivefemale')); ?>
                                <?php echo form_error('diphofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                              <tr>
                                <td valign="top" colspan="2">Suspected Whooping Cough &lt;5yr</td><td valign="top"><?php $data = array('id' => 'wcmale', 'name' => 'wcmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcmale')); ?>
                                <?php echo form_error('wcmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'wcfemale', 'name' => 'wcfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcfemale')); ?>
                                <?php echo form_error('wcfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                                    <tr>
                                <td valign="top" colspan="2">Suspected Whooping Cough &gt;5yr</td><td valign="top"><?php $data = array('id' => 'wcofivemale', 'name' => 'wcofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcofivemale')); ?>
                                <?php echo form_error('wcofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'wcofivefemale', 'name' => 'wcofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('wcofivefemale')); ?>
                                <?php echo form_error('wcofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                                
                               <tr>
                                 <td valign="top" colspan="2">Suspected Measles &lt;5yr</td><td valign="top"><?php $data = array('id' => 'measmale', 'name' => 'measmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measmale')); ?>
                                  <?php echo form_error('measmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'measfemale', 'name' => 'measfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measfemale')); ?>
                                  <?php echo form_error('measfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                                 
                                 <tr>
                                 <td valign="top" colspan="2">Suspected Measles &gt;5yr</td><td valign="top"><?php $data = array('id' => 'measofivemale', 'name' => 'measofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measofivemale')); ?>
                                  <?php echo form_error('measofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'measofivefemale', 'name' => 'measofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('measofivefemale')); ?>
                                  <?php echo form_error('measofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                              <tr>
                                <td valign="top" colspan="2">Neonatal Tetanus</td><td valign="top"><?php $data = array('id' => 'nntmale', 'name' => 'nntmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntmale')); ?>
                                <?php echo form_error('nntmale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'nntfemale', 'name' => 'nntfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('nntfemale')); ?>
                                <?php echo form_error('nntfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                </td></tr>
                               <tr>
                                 <td valign="top" colspan="2">Acute Flaccid Paralysis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'afpmale', 'name' => 'afpmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpmale')); ?>
                                 <?php echo form_error('afpmale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'afpfemale', 'name' => 'afpfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpfemale')); ?>
                                 <?php echo form_error('afpfemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>
                                 
                                 
                                 <tr>
                                 <td valign="top" colspan="2">Acute Flaccid Paralysis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'afpofivemale', 'name' => 'afpofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpofivemale')); ?>
                                 <?php echo form_error('afpofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td><td valign="top"><?php $data = array('id' => 'afpofivefemale', 'name' => 'afpofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('afpofivefemale')); ?>
                                 <?php echo form_error('afpofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                                 </td></tr>

                               <tr class="alt"><td valign="top" colspan="4">Other Communicable Diseases</td></tr>
                             <tr>
                               <td valign="top" colspan="2">Suspected Acute Jaundice Syndrome</td><td valign="top"><?php $data = array('id' => 'ajsmale', 'name' => 'ajsmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsmale')); ?>
                               <?php echo form_error('ajsmale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'ajsfemale', 'name' => 'ajsfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ajsfemale')); ?>
                               <?php echo form_error('ajsfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Suspected Viral Hemorrhagic Fever/Ebola</td><td valign="top"><?php $data = array('id' => 'vhfmale', 'name' => 'vhfmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhfmale')); ?>
                              <?php echo form_error('vhfmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'vhffemale', 'name' => 'vhffemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('vhffemale')); ?>
                              <?php echo form_error('vhffemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               <tr><td valign="top" colspan="2">Confirmed Malaria &lt;5yr</td><td valign="top"><?php $data = array('id' => 'malufivemale', 'name' => 'malufivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivemale')); ?>
                               <?php echo form_error('malufivemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'malufivefemale', 'name' => 'malufivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malufivefemale')); ?>
                               <?php echo form_error('malufivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                              <tr><td valign="top" colspan="2">Confirmed Malaria &gt;5yr</td><td valign="top"><?php $data = array('id' => 'malofivemale', 'name' => 'malofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivemale')); ?>
                              <?php echo form_error('malofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'malofivefemale', 'name' => 'malofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('malofivefemale')); ?>
                              <?php echo form_error('malofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                               
                               <tr><td valign="top" colspan="2">Suspected Meningitis &lt;5yr</td><td valign="top"><?php $data = array('id' => 'suspectedmenegitismale', 'name' => 'suspectedmenegitismale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitismale')); ?>                             
                               <?php echo form_error('suspectedmenegitismale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisfemale', 'name' => 'suspectedmenegitisfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisfemale')); ?>
                               <?php echo form_error('suspectedmenegitisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                               
                               
                               <tr><td valign="top" colspan="2">Suspected Meningitis &gt;5yr</td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisofivemale', 'name' => 'suspectedmenegitisofivemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisofivemale')); ?>                             
                               <?php echo form_error('suspectedmenegitisofivemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td><td valign="top"><?php $data = array('id' => 'suspectedmenegitisofivefemale', 'name' => 'suspectedmenegitisofivefemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('suspectedmenegitisofivefemale')); ?>
                               <?php echo form_error('suspectedmenegitisofivefemale', '<div class="alert alert-danger">', '</div>'); ?>
                               </td></tr>
                            
                              <tr class="alt"><td valign="top" colspan="4">Other Unusual Diseases or Deaths</td></tr>
                              <tr>
                                <td valign="top" colspan="2"><?php $data = array('id' => 'undisonedesc', 'name' => 'undisonedesc', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisonedesc')); ?>
                                 <?php echo form_error('undisonedesc', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'undismale', 'name' => 'undismale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismale')); ?>
                              <?php echo form_error('undismale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemale', 'name' => 'undisfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemale')); ?>
                              <?php echo form_error('undisfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              
                              
                              <tr>
                                <td valign="top" colspan="2"><?php $data = array('id' => 'undissecdesc', 'name' => 'undissecdesc', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undissecdesc')); ?>
                                 <?php echo form_error('undissecdesc', '<div class="alert alert-danger">', '</div>'); ?>
                                </td><td valign="top"><?php $data = array('id' => 'undismaletwo', 'name' => 'undismaletwo', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undismaletwo')); ?>
                              <?php echo form_error('undismaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'undisfemaletwo', 'name' => 'undisfemaletwo', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('undisfemaletwo')); ?>
                              <?php echo form_error('undisfemaletwo', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                                     <tr><td colspan="4"> <div id="container">
            <p id="add_field"><a href="javascript:void(0)" class="btn btn-success"><span>Add Fields</span></a></p>
        </div></td></tr>
                              
                              <tr><td valign="top" colspan="2">Other Consultations</td><td valign="top"><?php $data = array('id' => 'ocmale', 'name' => 'ocmale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocmale')); ?>
                              <?php echo form_error('ocmale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td><td valign="top"><?php $data = array('id' => 'ocfemale', 'name' => 'ocfemale', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('ocfemale')); ?>
                              <?php echo form_error('ocfemale', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                       
                              <tr><td valign="top" colspan="2">Total Consultations</td><td valign="top" colspan="2"><?php $data = array('id' => 'total_consultations', 'name' => 'total_consultations', 'readonly'=>'readonly'); echo form_input($data, set_value('total_consultations')); ?> <input type="button" value="CALCULATE" onClick="CalcConsultations()" ></td></tr>
                              
                              <tr class="alt"><td valign="top" colspan="4">Malaria Tests</td></tr>
                              <tr><td valign="top" colspan="2">Slides/RDT examined</td><td valign="top" colspan="2"><?php $data = array('id' => 'sre', 'name' => 'sre', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('sre')); ?>
                              <?php echo form_error('sre', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Falciparum positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pf', 'name' => 'pf', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pf')); ?>
                              <?php echo form_error('pf', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Vivax positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pv', 'name' => 'pv', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pv')); ?>
                              <?php echo form_error('pv', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <tr><td valign="top" colspan="2">Mixed positive</td><td valign="top" colspan="2"><?php $data = array('id' => 'pmix', 'name' => 'pmix', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')"); echo form_input($data, set_value('pmix')); ?>
                              <?php echo form_error('pmix', '<div class="alert alert-danger">', '</div>'); ?>
                              </td></tr>
                              <!--<tr><td valign="top" colspan="2">Total Negative</td><td valign="top" colspan="2"><?php $data = array('id' => 'totalnegative', 'name' => 'totalnegative', 'onkeyup' => 'doMath()'); echo form_input($data, set_value('totalnegative')); ?>
							  <?php echo form_error('totalnegative', '<div class="alert alert-danger">', '</div>'); ?></td></tr>-->
                              
                              <!--<tr class="alt"><td valign="top" colspan="4">Approvals</td></tr>
                              <tr><td valign="top" colspan="2">Submit for Regional Approval</td><td valign="top" colspan="2">
                              <select name="approved_hf" id="approved_hf">
                              	<option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                              </select>
                              </td></tr>-->
                               </tbody>
                               </table>
<div class="form-actions"><?php //echo form_submit('submit', 'Save Data', 'class="btn btn-info "'); ?>

<input type="submit" name="draft_button" value="save to draft only" class="btn" onClick="return(draftvalidate())" />
&nbsp; &nbsp; &nbsp;
<input type="submit" name="submit_button" value="Submit report" class="btn btn-info" onClick="return(validate())" />


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
