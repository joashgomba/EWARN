<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>eEWARN System</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--basic styles-->
<style type="text/css" title="currentStyle">
			@import "<?php echo base_url(); ?>media/css/demo_page.css";
			@import "<?php echo base_url(); ?>media/css/jquery.dataTables_themeroller.css";
			@import "<?php echo base_url(); ?>examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css";
		</style>

        
        <script>
		function  doMath() { 
		   var totalnegative; 
		   var sre; 
		   var pf; 
		   var pv; 
		   var pmix; 
		   var totalpositive;
		 
		   sre = parseInt(document.getElementById("sre").value);
		   pf = parseInt(document.getElementById("pf").value);
		   pv = parseInt(document.getElementById("pv").value);
		   pmix = parseInt(document.getElementById("pmix").value);
		   
		   totalpositive = pf+pv+pmix;
		   totalnegative=(sre-totalpositive);
		   document.getElementById("totalnegative").value=totalnegative ;
		}
		
		function  totalConsultations() { 
		   var totalconsultations; 
		   var undismale; 
		   var undisfemale; 
		   var ocmale; 
		   var ocfemale; 
		 
		   undismale = parseInt(document.getElementById("undismale").value);
		   undisfemale = parseInt(document.getElementById("undisfemale").value);
		   ocmale = parseInt(document.getElementById("ocmale").value);
		   ocfemale = parseInt(document.getElementById("ocfemale").value);
		   
		   totalconsultations = undismale+undisfemale+ocmale+ocfemale;
		   document.getElementById("total_consultations").value=totalconsultations ;
		}
		</script>
        
        <script>
		function confirmValues(){
		   var totalnegative; 
		   var sre; 
		   var pf; 
		   var pv; 
		   var pmix; 
		   var totalpositive;
		 
		   sre = parseInt(document.getElementById("sre").value);
		   pf = parseInt(document.getElementById("pf").value);
		   pv = parseInt(document.getElementById("pv").value);
		   pmix = parseInt(document.getElementById("pmix").value);
		   
		   totalpositive = pf+pv+pmix;
		   
		   if(totalpositive>sre)
		   {
			   alert('Positive cases must be less than slides/RDTs examined.');
			   return false;
		   }
		   else
		   {
			   return true;
		   }
		}
		</script>
        
        
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				} );
			} );
		</script>
        
       
        
		<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorpicker.css" />

		<!--fonts-->

		<style>
		@font-face {
		  font-family: 'Open Sans';
		  font-style: normal;
		  font-weight: 300;
		  src: local('Open Sans Light'), local('OpenSans-Light'), 		url(http://themes.googleusercontent.com/static/fonts/opensans/v6/DXI1ORHCpsQm3Vp6mXoaTXhCUOGz7vYGh680lGh-uXM.woff) format('woff');
		}
		@font-face {
		  font-family: 'Open Sans';
		  font-style: normal;
		  font-weight: 400;
		  src: local('Open Sans'), local('OpenSans'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/cJZKeOuBrn4kERxqtaUH3T8E0i7KZn-EPnyo3HZu7kw.woff) format('woff');
		}
		</style>
        
     
        
      
		 <style>
        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        }
        #customers td, #customers th 
        {
        font-size:1.0em;
        border:1px  #999999;
        padding:3px 7px 2px 7px;
        }
        #customers th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#fff;
        }
        #customers tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
		
		#cust
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:60%;
        border-collapse:collapse;
        }
        #cust td, #cust th 
        {
        font-size:1.0em;
        border:1px  #999999;
        padding:3px 7px 2px 7px;
        }
        #cust th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#fff;
        }
        #cust tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
        </style>


		<!--ace styles-->

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!--inline styles related to this page-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ckeditor/ckeditor.js"></script>




    </head>