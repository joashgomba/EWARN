<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
		
			html {
				height: 100%
			}
			
			body {
				height: 100%;
				margin: 0;
				padding: 0
			}
			
			#map-canvas {
				height: 100%
			}
			select
{
 border: 1px solid #DDDDDD;
    font-size: 0.8em;
    padding: 3px;
    width: auto;
	float:left;
	margin:0 2px 0 0;
}
fieldset
{
  padding:15px 5px;
  border:1px dotted gray;
  border-width:1px 0;
  margin-top:-1px;
  position:relative;
  top:1px;
  background:none !important;
}
label
{
  font:normal normal normal 0.8em tahoma,sans-serif;
  display:block;
  padding-bottom:8px;
}
input[type="text"]
{
  width:13em;
  font-size:0.8em;
}

.radius-container {

    text-align: right;
    position: absolute;
    right: 200px;
    top: -2px;
    z-index: 99;
    background-color: $orange;
    color: white;
    padding: 5px;
	width:56%;}

    .select {
        width: 60px;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
}

.regions{
	select {
        width: 60px;
        font-size: 20px;
        text-align: center;
        margin: 5px 0;
    }
}

    .map-container {
    position: relative;
}

#footer {
    position: absolute;
    bottom: 50px;
    right: 40px;
	z-index: 99;
	background-image: url('<?php echo base_url();?>images/tbg.png');
	background-repeat:repeat;
	color: white;
    padding: 4px;
	border:1px #000 solid;
	font-family:Verdana, Geneva, sans-serif;
	font-size:9px;

}

#footer-left {
    position: absolute;
    bottom: 50px;
    left: 60px;
	z-index: 99;
	background-image: url('<?php echo base_url();?>images/tbg.png');
	background-repeat:repeat;
	color: black;
    padding: 4px;
	border:1px #000 solid;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
	font-size:11px;
	width:400px;
	
}

#footer-left:hover {
	background-color:#FFF;
}

a {text-decoration:none;} 
a:link {color:#000;}      /* unvisited link */
a:visited {color:#000;}  /* visited link */
a:hover {color:#000;}  /* mouse over link */
a:active {color:#000;}  /* selected link */

		</style>
		<title>eDEWS Somalia System Alerts</title>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-3-2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/animatedcollapse.js">

/***********************************************
* Animated Collapsible DIV v2.4- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>


<script type="text/javascript">

animatedcollapse.addDiv('jason', 'fade=1,height=80px')
animatedcollapse.addDiv('kelly', 'fade=1,height=100px')
animatedcollapse.addDiv('michael', 'fade=1,height=120px')

animatedcollapse.addDiv('cat', 'fade=0,speed=400,group=pets')
animatedcollapse.addDiv('dog', 'fade=0,speed=400,group=pets,persist=1,hide=1')
animatedcollapse.addDiv('rabbit', 'fade=0,speed=400,group=pets,hide=1')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
}

animatedcollapse.init()

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
	
	function GetHealthFacilities(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacilities').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/datalist/gethealthfacilities";
	
	var params = "district_id=" + totalEncode(document.frm.district_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacilities').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacilities').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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
	var url = "<?php echo base_url(); ?>index.php/export/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	</script>
    
    
<script type="text/javascript">
<!--
// Form validation code will come here.

function validate()
{
	
   if( document.frm.reporting_year.value == "" )
   {
     alert( "Please enter the from reporting year" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if( document.frm.week_no.value == "" )
   {
     alert( "Please enter the from week number" );
     document.frm.week_no.focus() ;
     return false;
   }
   /**
   if( document.frm.reporting_year2.value == "" )
   {
     alert( "Please enter the to reporting year" );
     document.frm.reporting_year2.focus() ;
     return false;
   }
   
   if( document.frm.week_no2.value == "" )
   {
     alert( "Please enter the to week number" );
     document.frm.week_no2.focus() ;
     return false;
   }
   
   var e = document.getElementById("reporting_year");
   var repyearone = e.options[e.selectedIndex].value;
   
   var y = document.getElementById("reporting_year2");
   var repyeartwo = y.options[y.selectedIndex].value;
   
   var x = document.getElementById("week_no");
   var fromval = x.options[x.selectedIndex].value;
   
   var z = document.getElementById("week_no2");
   var toval = z.options[z.selectedIndex].value;
   
   if(repyearone>repyeartwo)
   {
	  alert( "The year from cannot be greater than the year to" );
     document.frm.reporting_year.focus() ;
     return false;
   }
   
   if(repyearone==repyeartwo)
   {
	 if(fromval>toval)
	 {
		 alert( "The week from cannot be greater than the week to on the same year." );
		 document.frm.week_no.focus() ;
		 return false;
	 }
   }
   
   **/
   
   return( true );
}

</script>   

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
  
  //document.location="<?php echo base_url().'maps/get_date/';?>" + today;

							</script>
                              
	</head>
  
	<body>
    <div class="radius-container">
   <?php 
					   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
					  echo form_open('maps/gsnnetworks',$attributes); ?>

                                    <select name="zone_id" id="zone_id">
                                <option value="">-Select Region-</option>
                               
                                        </select>
                                     
                                   <div id="regions">
                                   <select name="region_id" id="region_id" >
                                     <option value="">-Select District-</option>
                                 
                                    </select>
                                   
                                   </div>
                                   <select name="reporting_year" id="reporting_year">
                                   
                                   
                               <option value="">-Select program-</option>
                              
                               </select> 
                               
                         
                               
                           
                               
                               <?php echo form_submit('submit', 'Get Map', 'class="btn btn-info "'); ?>
                               
                               <?php echo form_close(); ?>  
    
</div>
<div id="footer-left">
<strong>What is GSN</strong>
<p>
<a href="#" rel="toggle[rabbit]" data-openimage="collapse.jpg" data-closedimage="expand.jpg">(click for details)</a> 
</p>
<div id="rabbit" style="width: 400px;">
<p>

Gold Star Network is a social franchise that offers HIV, TB and reproductive health care services and treatment through private service providers.
</p>
GSN provides access to lower-cost and sources of subsidized drugs and commodities for its franchise members. This includes test kits and medicines, as well as negotiated rates for tests at quality reference laboratories. 
</p>
<p>
Through an innovative public-private partnership model, we build the capacity of our growing network of accredited providers to offer safe and affordable health care to the highest standards of care. 
</p>
<p>
Gold Star Network programs are implemented by Gold Star Kenya, a non-governmental organization focused on integrated health management, with support from the United States Agency for International Development (USAID) and in collaboration with the Government of Kenya and diverse partners that include Family Health International (FHI 360), PSI/Kenya and SafeCare.
</p>

</div>
</div>
<div id="footer">
    <div class="content">
    <p>
  <table>
  <tr><td>Benefits</td></tr>
  <tr><td><ul>
  <li>Laboratory support</li>
  <li>Training</li>
  <li>Clinical support</li>
  </ul></td></tr>
  </table>
    </p>
    </div>
</div>
 <div id="json_data" style="display:none;">
    <?php echo json_encode($points); ?>
  </div>
  <div id="map-canvas"></div>
  
  
   <script src="<?php echo base_url(); ?>js/mapwithmarker.js"></script>
                   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                   <script src="<?php echo base_url(); ?>js/markerclusterer.js"></script>
                  
  <script src="<?php echo base_url(); ?>js/map.js"></script>
 
	</body>
</html>
