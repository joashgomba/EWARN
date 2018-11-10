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
	
	
	function getCalendar(frm){
	if(validateForm(frm)){
	document.getElementById('calendarlist').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/epdcalendar/findcalendars";
	
	var params = "reporting_year=" + totalEncode(document.frm.reporting_year.value ) + "&country_id="+totalEncode(document.frm.country_id.value ) ;
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('calendarlist').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('calendarlist').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	</script>
    
    <style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:50%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#0066FF;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
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

						<li class="active">Epidemiological Weeks Calendar</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Epidemiological Weeks Calendar
							<small>
								<i class="icon-double-angle-right"></i>
								View
							</small>
						</h1>
					</div><!--/.page-header-->
                   
                  
                <?php 
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','class' => 'block-content form');
				echo form_open('',$attributes); ?>
                
                <table id="listtable">
                               <thead>
                               		<tr><th colspan="5">Epidemiological Weeks Calendar</th></tr>
                               </thead>
                               <tbody>
                            <tr><td>Year:</td><td><select name="reporting_year" id="reporting_year" >
                               <option value="">Select Year</option>
                               <?php
     $currentYear = date('Y');
	 $nextYear = $currentYear + 1;
        foreach (range(2012, $nextYear) as $value) {
          ?>
           <option value="<?php echo $value;?>"><?php echo $value;?></option>
          <?php

        }
?>
                               </select></td></tr>
                               <tr><td>Country:</td><td><select name="country_id" id="country_id" required="required">
<?php
foreach($countries as $key => $country)
{
	?>
    <option value="<?php echo $country['id'];?>" <?php if($country['id']==set_value('country_id')){ echo 'selected="selected"';}?> ><?php echo $country['country_name'];?></option>
    <?php
}
?>
</select></td></tr>
                               <tr><td colspan="2"><input type="button" name="submit_button" value="List" class="btn btn-info" onClick="getCalendar()" /></td></tr>
                               </tbody>
                               
              </table>
               <div id="calendarlist">
                   &nbsp;
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
