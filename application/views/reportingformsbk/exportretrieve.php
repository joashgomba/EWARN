<?php include(APPPATH . 'views/common/header.php'); ?>

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
	var url = "<?php echo base_url(); ?>datalist/gethealthfacilities";
	
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
	var url = "<?php echo base_url(); ?>datalist/getlist";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&reporting_year2=" + totalEncode(document.frm.reporting_year2.value ) + "&from=" + totalEncode(document.frm.from.value ) + "&to=" + totalEncode(document.frm.to.value ) + "&district_id=" + totalEncode(document.frm.district_id.value )+ "&healthfacility_id=" + totalEncode(document.frm.healthfacility_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('reportdetails').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('reportdetails').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	
</script>

<script>
function validateEntry(str)
{
	var x=document.getElementById("frm");
	var reporting_year;
	var reporting_year2;
	var from;
	var to;
	var district_id;
	var healthfacility_id;
	
	reporting_year = x.reporting_year.value;	
	reporting_year2 = x.reporting_year2.value;
	from = x.from.value;
	to = x.to.value;
	district_id = x.district_id.value;
	healthfacility_id = x.healthfacility_id.value;
	
	
if (str=="")
  {
  document.getElementById("reportdetails").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("reportdetails").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url(); ?>/index.php/datalist/validate/"+str+"/"+reporting_year+"/"+reporting_year2+"/"+from+"/"+to+"/"+district_id+"/"+healthfacility_id,true);
xmlhttp.send();
}


function invalidateEntry(str)
{
	var x=document.getElementById("frm");
	var reporting_year;
	var reporting_year2;
	var from;
	var to;
	var district_id;
	var healthfacility_id;
	
	reporting_year = x.reporting_year.value;	
	reporting_year2 = x.reporting_year2.value;
	from = x.from.value;
	to = x.to.value;
	district_id = x.district_id.value;
	healthfacility_id = x.healthfacility_id.value;
	
	
if (str=="")
  {
  document.getElementById("reportdetails").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("reportdetails").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url(); ?>/index.php/datalist/invalidate/"+str+"/"+reporting_year+"/"+reporting_year2+"/"+from+"/"+to+"/"+district_id+"/"+healthfacility_id,true);
xmlhttp.send();
}
</script>

<style>
	div.scroll
	{
	background-color:#fff;
	width:1100px;
	height:500px;
	overflow:scroll;
	}
	
	div.hidden 
	{
	background-color:#fff;
	width:100px;
	height:100px;
	overflow:hidden;
	}
</style>

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

						<li class="active">Export</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Verification<small> Export
							</small>
						</h1>
					</div><!--/.page-header-->
                    
                    
                 
                           <?php 
						   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data', 'target'=>'blank');
						   echo form_open('',$attributes); ?>
                           <table id="customers">
                             <tbody>
                             <tr><td><i class="icon-ok green">The CSV file has been created. Please click the button below to download.</i></td></tr>
                             <tr><td><a href="<?php echo base_url() ?>csvfiles/csv_file.csv" class="btn btn-success" target="_blank">Download</a></td></tr>
                              </tbody>
                          </table>
                          </div>
							

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
