<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
#themodal {
    display: none;
    position: absolute;
    top: 45%;
    left: 45%;
    width: 64px;
    height: 64px;
    padding:30px 15px 0px;
    border: 3px solid #ababab;
    box-shadow:1px 1px 10px #ababab;
    border-radius:20px;
    background-color: white;
    z-index: 1002;
    text-align:center;
    overflow: auto;
}

#fade {
    display: none;
    position:absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: #ababab;
    z-index: 1001;
    -moz-opacity: 0.8;
    opacity: .70;
    filter: alpha(opacity=80);
}


</style>
<script>

function change(that, fgcolor, bgcolor,txtcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
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

</script>
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
	
	function openModal() {
        document.getElementById('themodal').style.display = 'block';
        document.getElementById('fade').style.display = 'block';
	}
	
	function closeModal() {
		document.getElementById('themodal').style.display = 'none';
		document.getElementById('fade').style.display = 'none';
	}
	
function GetPeriod(frm){
	if(validateForm(frm)){
	document.getElementById('reporingperiods').innerHTML='';
	var url = "<?php echo base_url(); ?>/index.php/forms/getperiod";
	
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
	var district_element = '<select id="district_id" name="district_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	var health_element = '<select id="healthfacility_id" name="healthfacility_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('regions').innerHTML=connection.responseText;
		document.getElementById('districts').innerHTML= district_element;
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('regions').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/reportingforms/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	var health_element = '<select id="healthfacility_id" name="healthfacility_id" required="required">' + '<option value="">Select One</option>' + '</select>';
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		document.getElementById('healthfacilities').innerHTML= health_element;
		
		
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
	openModal();
	var url = "<?php echo base_url(); ?>/index.php/forms/getreportdetails";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&week_no=" + totalEncode(document.frm.week_no.value )+ "&district_id=" + totalEncode(document.frm.district_id.value )+ "&healthfacility_id=" + totalEncode(document.frm.healthfacility_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		closeModal();
		document.getElementById('reportdetails').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reportdetails').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
</script>

<script>

function CalcConsultations()
{
	<?php foreach ($diseases->result() as $disease): ?>
var <?php echo $disease->disease_code;?>_ufive_male;
	var <?php echo $disease->disease_code;?>_ufive_female;
	var <?php echo $disease->disease_code;?>_ofive_male;
	var <?php echo $disease->disease_code;?>_ofive_female;
	<?php endforeach; ?>	
	var initialval;
	var ocmale;
    var ocfemale;
	
	<?php foreach ($diseases->result() as $disease): ?>
	 if( document.frm.<?php echo $disease->disease_code;?>_ufive_male.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ufive_male =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ufive_male = parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_male.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ufive_female.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ufive_female =0;
		}

		else
		{
		  <?php echo $disease->disease_code;?>_ufive_female = parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_female.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ofive_male.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ofive_male =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ofive_male = parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_male.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ofive_female.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ofive_female =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ofive_female = parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_female.value);
		}
	<?php endforeach; ?>
	
	if( document.frm.undismale.value == "" )
	{
	  undismale =0;
	}
	else
	{
	  undismale = parseInt(document.frm.undismale.value);
	}
	
	if( document.frm.undisfemale.value == "" )
	{
	  undisfemale =0;
	}
	else
	{
	  undisfemale = parseInt(document.frm.undisfemale.value);
	}
	
	if( document.frm.undismaletwo.value == "" )
	{
	  undismaletwo =0;
	}
	else
	{
	  undismaletwo = parseInt(document.frm.undismaletwo.value);
	}
	
	if( document.frm.undisfemaletwo.value == "" )
	{
	  undisfemaletwo =0;
	}
	else
	{
	  undisfemaletwo = parseInt(document.frm.undisfemaletwo.value);
	}
	
	if( document.frm.ocmale.value == "" )
	{
	  ocmale =0;
	}
	else
	{
	  ocmale = parseInt(document.frm.ocmale.value);
	}
	
	if( document.frm.ocfemale.value == "" )
	{
	  ocfemale =0;
	}
	else
	{
	  ocfemale = parseInt(document.frm.ocfemale.value);
	}

	
	initialval = 0;
	
	totalconsultations = <?php echo $total_formula; ?> + undismale + undisfemale + undismaletwo + undisfemaletwo + ocmale + ocfemale;
	
	document.frm.total_consultations.value=totalconsultations;
	
}

function validate()
{
	<?php foreach ($diseases->result() as $disease): ?>
var <?php echo $disease->disease_code;?>_ufive_male;
	var <?php echo $disease->disease_code;?>_ufive_female;
	var <?php echo $disease->disease_code;?>_ofive_male;
	var <?php echo $disease->disease_code;?>_ofive_female;
	<?php endforeach; ?>
	var initialval;
	var ocmale;
    var ocfemale;
	
	<?php foreach ($diseases->result() as $disease): ?>
	 if( document.frm.<?php echo $disease->disease_code;?>_ufive_male.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ufive_male =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ufive_male = parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_male.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ufive_female.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ufive_female =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ufive_female = parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_female.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ofive_male.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ofive_male =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ofive_male = parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_male.value);
		}
		
		if( document.frm.<?php echo $disease->disease_code;?>_ofive_female.value == "" )
		{
		  <?php echo $disease->disease_code;?>_ofive_female =0;
		}
		else
		{
		  <?php echo $disease->disease_code;?>_ofive_female = parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_female.value);
		}
	<?php endforeach; ?>
	
	if( document.frm.undismale.value == "" )
	{
	  undismale =0;
	}
	else
	{
	  undismale = parseInt(document.frm.undismale.value);
	}
	
	if( document.frm.undisfemale.value == "" )
	{
	  undisfemale =0;
	}
	else
	{
	  undisfemale = parseInt(document.frm.undisfemale.value);
	}
	
	if( document.frm.undismaletwo.value == "" )
	{
	  undismaletwo =0;
	}
	else
	{
	  undismaletwo = parseInt(document.frm.undismaletwo.value);
	}
	
	if( document.frm.undisfemaletwo.value == "" )
	{
	  undisfemaletwo =0;
	}
	else
	{
	  undisfemaletwo = parseInt(document.frm.undisfemaletwo.value);
	}
	
	if( document.frm.ocmale.value == "" )
	{
	  ocmale =0;
	}
	else
	{
	  ocmale = parseInt(document.frm.ocmale.value);
	}
	
	if( document.frm.ocfemale.value == "" )
	{
	  ocfemale =0;
	}
	else
	{
	  ocfemale = parseInt(document.frm.ocfemale.value);
	}
	
	
	initialval = 0;
	
	totalconsultations = <?php echo $total_formula; ?> + undismale + undisfemale + undismaletwo + undisfemaletwo + ocmale + ocfemale;
	
	
	if( document.frm.total_consultations.value == "" )
   {
     alert( "Please calculate total consultations" );
     document.frm.total_consultations.focus() ;
     return false;
   }
   
   
   if( document.frm.total_consultations.value != totalconsultations )
   {
     alert( "Please re-calculate the total consultations." );
     document.frm.total_consultations.focus() ;
     return false;
   }


	/**
	
	if( document.frm.period_check.value == 1)
   {
     alert( "The reporting period for the health facility has been entered." );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   **/
   
  
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
   
   
   <?php foreach ($diseases->result() as $disease): ?>

	
	if( document.frm.<?php echo $disease->disease_code;?>_ufive_male.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> <5yr Male" );
     document.frm.<?php echo $disease->disease_code;?>_ufive_male.focus() ;
     return false;
   }
   
   if( document.frm.<?php echo $disease->disease_code;?>_ufive_female.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> <5yr Female" );
     document.frm.<?php echo $disease->disease_code;?>_ufive_female.focus() ;
     return false;
   }
   
   if( document.frm.<?php echo $disease->disease_code;?>_ofive_male.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> >5yr Male" );
     document.frm.<?php echo $disease->disease_code;?>_ofive_male.focus() ;
     return false;
   }
   
   if( document.frm.<?php echo $disease->disease_code;?>_ofive_female.value == "" )
   {
     alert( "Please enter <?php echo $disease->disease_code;?> >5yr Female" );
     document.frm.<?php echo $disease->disease_code;?>_ofive_female.focus() ;
     return false;
   }
	<?php endforeach; ?>
	
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
     alert( "Please enter SRE" );
     document.frm.sre.focus() ;
     return false;
   }
   
   if( document.frm.pf.value == "" )
   {
     alert( "Please enter Pf" );
     document.frm.pf.focus() ;
     return false;
   }
   
   if( document.frm.pv.value == "" )
   {
     alert( "Please enter Pv" );
     document.frm.pv.focus() ;
     return false;
   }
   
   if( document.frm.pmix.value == "" )
   {
     alert( "Please enter Pmix" );
     document.frm.pmix.focus() ;
     return false;
   }
   
   
   
     
   <?php foreach ($diseases->result() as $disease): ?>
	var <?php echo strtolower($disease->disease_code);?> = (parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_male.value) + parseInt(document.frm.<?php echo $disease->disease_code;?>_ufive_female.value)+ parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_male.value) + parseInt(document.frm.<?php echo $disease->disease_code;?>_ofive_female.value));
	
	<?php endforeach; ?>
	
	var undis = (parseInt(document.frm.undismale.value) + parseInt(document.frm.undisfemale.value) + parseInt(document.frm.undismaletwo.value) + parseInt(document.frm.undisfemaletwo.value));
		
	var oc = parseInt(document.frm.ocmale.value) + parseInt(document.frm.ocfemale.value);
	
	
	
	
	<?php 
	foreach ($diseases->result() as $disease): 
			// prompt the user for confirmation if it meets threshold
			if($disease->alert_type==1)
			{
				if($disease->alert_threshold==0)
				{
					$threshold = $disease->alert_threshold;
				}
				else
				{
					$threshold = ($disease->alert_threshold-1);
				}
				?>
				
				if(<?php echo strtolower($disease->disease_code);?> > <?php echo $threshold;?>)
				{
					if(<?php echo $disease->disease_code;?>_ufive_male>0)
					{
						var <?php echo $disease->disease_code;?>_ufive_maleval = confirm('Submit alert <?php echo strtolower($disease->disease_code);?> < 5 Male = '+<?php echo $disease->disease_code;?>_ufive_male+'?');
						
						if(!<?php echo $disease->disease_code;?>_ufive_maleval)
						{
							document.frm.<?php echo $disease->disease_code;?>_ufive_male.focus() ;
							return false;
						}
					}
					
					if(<?php echo $disease->disease_code;?>_ufive_female>0)
					{
						var <?php echo $disease->disease_code;?>_ufive_femaleval = confirm('Submit alert <?php echo strtolower($disease->disease_code);?> < 5 Female = '+<?php echo $disease->disease_code;?>_ufive_female+'?');
						
						if(!<?php echo $disease->disease_code;?>_ufive_femaleval)
						{
							document.frm.<?php echo $disease->disease_code;?>_ufive_female.focus() ;
							return false;
						}
					}
					
					if(<?php echo $disease->disease_code;?>_ofive_male>0)
					{
						var <?php echo $disease->disease_code;?>_ofive_maleval = confirm('Submit alert <?php echo strtolower($disease->disease_code);?> > 5 Male = '+<?php echo $disease->disease_code;?>_ofive_male+'?');
						
						if(!<?php echo $disease->disease_code;?>_ofive_maleval)
						{
							document.frm.<?php echo $disease->disease_code;?>_ofive_male.focus() ;
							return false;
						}
					}
					
					if(<?php echo $disease->disease_code;?>_ofive_female>0)
					{
						var <?php echo $disease->disease_code;?>_ofive_femaleval = confirm('Submit alert <?php echo strtolower($disease->disease_code);?> > 5 Female = '+<?php echo $disease->disease_code;?>_ofive_female+'?');
						
						if(!<?php echo $disease->disease_code;?>_ofive_femaleval)
						{
							document.frm.<?php echo $disease->disease_code;?>_ofive_female.focus() ;
							return false;
						}
					}
					
					
					
				}
				
				<?php
			}
			else
			{
				?>
				var healthfacility_id = document.frm.healthfacility_id.value;
				<?php
				
				//$the_average = $this->formsdatamodel->health_facility_average($disease->id,$healthfacility_id,$disease->weeks);	
				//$disease_threshold_condition = ($the_average * $disease->no_of_times);
			}
	 endforeach; 
	 ?>
	 
	 
	 
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

</script>

		<body>
			<?php include(APPPATH . 'views/common/navbar.php'); ?>
				<div class="main-container container-fluid">
					<a class="menu-toggler" id="menu-toggler" href="#">
						<span class="menu-text"></span>
					</a>
					<?php include(APPPATH . 'views/common/sidebar.php'); ?>
					<div class="main-content">
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
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
						<div class="nav-search" id="nav-search">
							<form class="form-search" method="post" action="" />
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
							</form>
						</div>
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
								</div>
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
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'class'=>'form-horizontal');?>
<?php echo form_open('forms/update_form',$attributes); ?>



<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>At Health Facility level</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
	<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<select name="zone_id" id="zone_id">

<option value="<?php echo $zone->id;?>"><?php echo $zone->zone;?></option>
</select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
<select name="region_id" id="region_id">

<option value="<?php echo $region->id;?>"><?php echo $region->region;?></option>
</select>
</div>
</div>


</div>
</div>

<?php
							  if($level != 3)
							  {
								  ?>
                                  <div class="row-fluid">
                            
                               
                               <div class="span6">

                                <div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
                                <?php
								$level = $this->erkanaauth->getField('level');
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
								 if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
	 							{
									?>
                                    <div id="districts">
                                                                  
                                    <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
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
                                       <select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
                                </div>
                                  <?php
								}
							  }
							  ?>
                                </div>
                                </div>
                                
                                </div>
                                
                                
                                <div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility: </label><div class="controls">
<div id="healthfacilities">
                               <?php
							   if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
	 							{
									?>
                                   
                                  
                                      <select name="healthfacility_id" id="healthfacility_id">
                              <option value="<?php echo $healthfacility->id;?>"><?php echo $healthfacility->health_facility;?></option>
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
									if($level==6)
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
                                   <select name="healthfacility_id" id="healthfacility_id">
                              <option value="<?php echo $healthfacility->id;?>"><?php echo $healthfacility->health_facility;?></option>
                              </select>
                                  <?php
									}
								}
								?>
                                  </div>
                                  <?php echo form_error('healthfacility_id', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
                                  
                                  
                                  </div>
                                  <?php
							  }
							  ?>
                              
                               <?php
							
							  if($level == 3)
							  {
								  ?>
                                                               
                              <div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<select name="district_id" id="district_id">
                              <option value="<?php echo $district->id;?>"><?php echo $district->district;?></option>
                              </select>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp;</label><div class="controls">
&nbsp;
</div>
</div>

</div>
</div>
                                 <?php
							  }
							  ?>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Year: </label><div class="controls">
<select name="reporting_year" id="reporting_year" >
                               
                              
           <option value="<?php echo $row->reporting_year;?>"><?php echo $row->reporting_year;?></option>
         
                               </select>
                               <?php echo form_error('reporting_year', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Week No: </label><div class="controls">
<select name="week_no" id="week_no">
                           <option value="<?php echo $row->week_no;?>">Week <?php echo $row->week_no;?></option>
                               </select>
                               <?php echo form_error('week_no', '<div class="alert alert-danger">', '</div>'); ?>
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Period: </label><div class="controls">
<div id="reporingperiods">
<strong><?php echo date("d F Y", strtotime($reportingperiod->from));?> to <?php echo date("d F Y", strtotime($reportingperiod->to));?></strong>
                               <input type="hidden" name="period_check" id="period_check" value="0">&nbsp;
                               </div>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">&nbsp; </label><div class="controls">
&nbsp;
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting Date: </label><div class="controls">
<?php echo form_error('reporting_date', '<div class="alert alert-danger">', '</div>'); ?>

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

</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reported By:</label><div class="controls">
<strong><?php //echo $this->erkanaauth->getField('fname');?> <?php //echo $this->erkanaauth->getField('lname');?>
                              
                              <?php
							  $username = getField('username');
							  
							  echo $username;
							  ?>
                              </strong>
</div>
</div>

</div>
</div>

<?php
							  if($level == 3)
							  {
								  ?>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility Name: </label><div class="controls">
<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility->id;?>">
                              <input readonly="" type="text" id="form-input-readonly" value="<?php echo $healthfacility->health_facility;?>" />
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Contact Number: </label><div class="controls">
<?php echo form_error('contact_number', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '','name' => 'contact_number', 'value' => $healthfacility->contact_number); echo form_input($data, set_value('contact_number')); ?>
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health Facility Code: </label><div class="controls">
<input readonly="" type="text" name="health_facility_code" id="form-input-readonly" value="<?php echo $healthfacility->hf_code;?>" />
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Supporting NGO: </label><div class="controls">
<?php echo form_error('supporting_ngo', '<div class="alert alert-danger">', '</div>'); ?><?php $data = array('id' => 'form-input-readonly', 'readonly'=> '', 'name' => 'supporting_ngo', 'value' => $healthfacility->organization); echo form_input($data, set_value('supporting_ngo')); ?>
</div>
</div>

</div>
</div>

<?php
							  }
							  else
							  {
								 //show nothing
							  }
							  ?>
												
												
											</div>
										</div>
									</div>



<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Health Events Under Surveillance</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
										
                                        
					<div class="row-fluid">
						<div class="span12">
                        <?php
						 if ($row->approved_dist == 1) {
                        echo ' <div class="alert alert-info">This entry has been validated at the district level. You can only view but not edit.</div>';
                    }
						?>
                        <div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-remove"></i>
											Note!
										</strong>

										This is a zero reporting form and all fields are required. In instances where there are no cases please enter zero (0).
										<br />
									</div>
                       <div><input type="hidden" name="hf_id" id="hf_id" value="<?php echo $row->healthfacility_id;?>">
						<input type="hidden" name="id" id="id" value="<?php echo $row->id; ?>"></div>
                        
                      <?php
						echo $edittable;
						
						?>
                                
                                
                                
                        
                        </div>
                        
                  </div>
												
												
											</div>
										</div>
									</div>


<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Other Unusual Diseases or Deaths</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
										
                                        
					<div class="row-fluid">
						<div class="span12">
                        
                        
                        <div class="row-fluid">
									<div class="span4"><?php $data = array('id' => 'undisonedesc', 'name' => 'undisonedesc', 'value'=>$row->undisonedesc, "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Description"); echo form_input($data, set_value('undisonedesc')); ?>
                                 <?php echo form_error('undisonedesc', '<div class="alert alert-danger">', '</div>'); ?></div>
									<div class="span4"><?php $data = array('id' => 'undismale', 'name' => 'undismale',  'value'=>$row->undismale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Male"); echo form_input($data, set_value('undismale')); ?>
                              <?php echo form_error('undismale', '<div class="alert alert-danger">', '</div>'); ?></div>
                                    <div class="span4"><?php $data = array('id' => 'undisfemale', 'name' => 'undisfemale', 'value'=>$row->undisfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Female"); echo form_input($data, set_value('undisfemale')); ?>
                              <?php echo form_error('undisfemale', '<div class="alert alert-danger">', '</div>'); ?></div>
						</div>
                        <hr>
                         <div class="row-fluid">
									<div class="span4"><?php $data = array('id' => 'undissecdesc', 'name' => 'undissecdesc',  'value'=>$row->undissecdesc, "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Description"); echo form_input($data, set_value('undissecdesc')); ?>
                                 <?php echo form_error('undissecdesc', '<div class="alert alert-danger">', '</div>'); ?></div>
									<div class="span4"><?php $data = array('id' => 'undismaletwo', 'name' => 'undismaletwo', 'value'=>$row->undismaletwo, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Male"); echo form_input($data, set_value('undismaletwo')); ?>
                              <?php echo form_error('undismaletwo', '<div class="alert alert-danger">', '</div>'); ?></div>
                                    <div class="span4"><?php $data = array('id' => 'undisfemaletwo', 'name' => 'undisfemaletwo', 'value'=>$row->undisfemaletwo, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Female"); echo form_input($data, set_value('undisfemaletwo')); ?>
                              <?php echo form_error('undisfemaletwo', '<div class="alert alert-danger">', '</div>'); ?></div>
						</div>
                        
                        <hr>
                        
                        <div class="row-fluid">
									<div class="span4">Other Consultations</div>
									<div class="span4"><?php $data = array('id' => 'ocmale', 'name' => 'ocmale', 'value'=>$row->ocmale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Male"); echo form_input($data, set_value('ocmale')); ?>
                              <?php echo form_error('ocmale', '<div class="alert alert-danger">', '</div>'); ?></div>
                                    <div class="span4"><?php $data = array('id' => 'ocfemale', 'name' => 'ocfemale', 'value'=>$row->ocfemale, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')", "placeholder"=>"Female"); echo form_input($data, set_value('ocfemale')); ?>
                              <?php echo form_error('ocfemale', '<div class="alert alert-danger">', '</div>'); ?></div>
						</div>
                        
                        <hr>
                        
                        <div class="row-fluid">
									<div class="span4">Total Consultations</div>
									<div class="span4"><?php $data = array('id' => 'total_consultations', 'name' => 'total_consultations','value'=>$row->total_consultations, 'readonly'=>'readonly','required'=>'required'); echo form_input($data, set_value('total_consultations')); ?></div>
                                    <div class="span4">
                                    <?php
if ($row->approved_dist == 1) {
    echo '&nbsp;';
}
else
{
?>
                                    
                                    <input type="button" value="CALCULATE" onClick="CalcConsultations()" >
                                    <?php
}
?>
                                    </div>
						</div>
                                
                                
                                
                        
                        </div>
                        
                  </div>
												
												
											</div>
										</div>
									</div>



<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Malaria Tests</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
<div class="control-group"><label class="control-label" for="form-field-1">Slides/RDT examined: </label><div class="controls"><?php $data = array('id' => 'sre', 'name' => 'sre', 'value'=>$row->sre,'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')","required"=>"required"); echo form_input($data, set_value('sre')); ?>
                              <?php echo form_error('sre', '<div class="alert alert-danger">', '</div>'); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Falciparum positive: </label><div class="controls"><?php $data = array('id' => 'pf', 'name' => 'pf', 'value'=>$row->pf, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')","required"=>"required"); echo form_input($data, set_value('pf')); ?>
                              <?php echo form_error('pf', '<div class="alert alert-danger">', '</div>'); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Vivax positive: </label><div class="controls"><?php $data = array('id' => 'pv', 'name' => 'pv', 'value'=>$row->pv, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')","required"=>"required"); echo form_input($data, set_value('pv')); ?>
                              <?php echo form_error('pv', '<div class="alert alert-danger">', '</div>'); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Mixed Positive: </label><div class="controls"><?php $data = array('id' => 'pmix', 'name' => 'pmix', 'value'=>$row->pmix, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'5', "onfocus"=>"change(this,'#FF0000','#FFCCFF','#000000')", "onblur"=>"change(this,'','','')","required"=>"required"); echo form_input($data, set_value('pmix')); ?>
                              <?php echo form_error('pmix', '<div class="alert alert-danger">', '</div>'); ?></div>
</div>
												
												
											</div>
										</div>
									</div>

<?php
if ($row->approved_dist == 1) {
    
}
else
{
?>
                                
<div class="form-actions"><input type="submit" name="draft_button" value="save to draft only" class="btn" onClick="return(draftvalidate())" />
&nbsp; &nbsp; &nbsp;
<input type="submit" name="submit_button" value="Submit report" class="btn btn-info" onClick="return(validate())" /></div>
<?php
 }
 ?>

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
