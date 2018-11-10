<?php include(APPPATH . 'views/common/header.php'); ?>
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
   
   <script type="text/javascript"><!--
var lastDiv = "";
function showDiv(divName) {
	// hide last div
	if (lastDiv) {
		document.getElementById(lastDiv).className = "hiddenDiv";
	}
	//if value of the box is not nothing and an object with that name exists, then change the class
	if (divName && document.getElementById(divName)) {
		document.getElementById(divName).className = "visibleDiv";
		lastDiv = divName;
	}
}
//-->
</script>
		<style type="text/css" media="screen"><!--
.hiddenDiv {
	display: none;
	}
.visibleDiv {
	display: block;
	
	}

--></style>

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


<style>
	div.scroll
	{
	background-color:#fff;
	width:1100px;
	height:500px;
	
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
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="icon-home home-icon"></i>
										<a href="<?php echo site_url('home')?>">Home</a>
										<span class="divider">
											<i class="icon-angle-right arrow-icon"></i>
										</span>
								</li>
								<li class="active">emergencies</li>
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
										Data entry
										<small>
											<i class="icon-double-angle-right"></i>
											emergencies
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('emergencies/add_validate',$attributes); ?>

<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Add form</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            
 												
	<div class="row-fluid">

<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<?php 
							   if(getRole() == 'SuperAdmin' || getRole() == 'Admin')
	  							{
									?>
                                    <div id="zones">
                                    <select name="zone_id" id="zone_id" onChange="GetRegions(this)" required="required">
                                <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
                                <?php
								foreach($zones as $key=> $zone)
								{
									?>
                                    <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
                                    <?php
								}
								?>
                                </select>
                                </div>
                                    <?php
								}
								else
								{
									 if($level==3)//HF
								   {
									  echo '<strong>'.$zone->zone.'</strong>';
									 ?>
									  <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
									  <?php
								   }

								   else if($level==2)//FP
								   {
									  echo '<strong>'.$zone->zone.'</strong>';
									 ?>
									  <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
									  <?php
								   }
								   else if($level==6)//FP
								   {
									  echo '<strong>'.$zone->zone.'</strong>';
									 ?>
									  <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
									  <?php
								   }
								   else if($level==1)//Zonal
								   {
									   ?>
                                       <input type="hidden" name="zone_id" id="zone_id" value="<?php echo $zone->id?>">
                                       <?php
									   echo '<strong>'.$zone->zone.'</strong>';
								   }
								   else
								   {
									   ?>
                                       <select name="zone_id" id="zone_id" onChange="GetRegions(this)" required="required">
                                        <option value="">-Select <?php echo $user_country->first_admin_level_label;?>-</option>
                                        <option value="">-All <?php echo $user_country->first_admin_level_label;?>-</option>
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
								}
								   ?>
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls">
							 <?php 
                             if($level==3)//HF
							   {
								  echo '<strong>'.$region->region.'</strong>';
								  ?>
                                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">
                                  
                                  <?php
							   }
							   else if($level==2)//region
							   {
								  echo '<strong>'.$region->region.'</strong>';
								  ?>
                                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">
                                  
                                  <?php
							   }
							   else if($level==6)//district
							   {
								  echo '<strong>'.$region->region.'</strong>';
								  ?>
                                  <input type="hidden" name="region_id" id="region_id" value="<?php echo $region->id?>">
                                  
                                  <?php
							   }
							   else if($level==1)//zone
							   {
								   ?>
                                   <select name="region_id" id="region_id" onChange="GetDistricts(this)" required="required">
                                     <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option>
                                    <?php
									foreach($regions as $key=>$region)
									{
									?>
                                    <option value="<?php echo $region['id'];?>"><?php echo $region['region'];?></option>
                                    <?php
									}
									?>
                                    </select>
                                   
                                   <?php
							   }
							   else
							   {
								   ?>
                                   <div id="regions">
                                   <select name="region_id" id="region_id" onChange="GetDistricts(this)" required="required">
                                   <option value="">Select <?php echo $user_country->second_admin_level_label;?></option>
                                     <option value="">All <?php echo $user_country->second_admin_level_label;?></option
                                   ></select>
                                  <!-- <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                     <option value="">Select Region</option>
                                     <option value="">All Regions</option>
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
							   }?>
</div>
</div>


</div>
</div>

              
                                                               
                              <div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1"><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">

 <div id="districts">
                            <?php
							if($level==1)
							{
								?>
                                <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" required="required">
                                <option value="">-All <?php echo $user_country->third_admin_level_label;?>-</option>
                                  <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                </select>
                                <!--<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">
                                  <option value="">-All Districts-</option>
                                  <option value="">Select District</option>
                                  <?php
                                foreach($districts->result() as $district)
                                {
                                    ?>
                                  <option value="<?php echo $district->district_id;?>" <?php if($district->district_id==set_value('district_id')){ echo 'selected="selected"';}?>><?php echo $district->district;?></option>
                                  <?php
								}
							  ?>
                                  </select>-->
                                <?php
							}
							else
							{
								if($level==2)
								{
									?>
                                    <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" required="required">
                                   <option value="">Select <?php echo $user_country->third_admin_level_label;?></option>
                                   <option value="">All <?php echo $user_country->third_admin_level_label;?></option>
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
								else if($level==3)
								{
									 echo '<strong>'.$district->district.'</strong>';
								  ?>
                                  <input type="hidden" name="district_id" id="district_id" value="<?php echo $district->id?>">
                                  
                                  <?php
								}
								else if($level==6)
								{
									 echo '<strong>'.$district->district.'</strong>';
								  ?>
                                  <input type="hidden" name="district_id" id="district_id" value="<?php echo $district->id?>">
                                  
                                  <?php
								}
								else
								{
									?>
                                       <select name="district_id" id="district_id" onChange="GetHealthFacilities(this)" required="required">
                                <option value="">-All Districts-</option>
                                  <option value="">Select District</option>
                                </select>
                                    <?php
								}
							?>
                                    
                                  
                              <?php
							}
							?>
                             </div>

</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Health facility</label><div class="controls">

 <div id="healthfacilities">
                                  <?php
								  if($level==2)//FP
	   								{
								  ?>
                                  <select name="healthfacility_id" id="healthfacility_id" required="required">
                                  <option value="">-All health facilities-</option>
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
									else if($level==3)//HF
									{
										echo $healthfacility->health_facility;
										?>
                                        <input type="hidden" name="healthfacility_id" id="healthfacility_id" value="<?php echo $healthfacility->id; ?>">
                                        <?php
									}
									else if($level==6)//district
									{
										?>
                                        <select name="healthfacility_id" id="healthfacility_id" required="required">
                                          <option value="">Select Health Facility</option>
                                          <?php
                                              foreach($healthfacilities->result() as $healthfacility):
                                              
                                                 ?>
                                                 <option value="<?php echo $healthfacility->id;?>" <?php if($healthfacility->id==set_value('healthfacility_id')){ echo 'selected="selected"';}?>><?php echo $healthfacility->health_facility;?></option> 
                                                 <?php 
                                             endforeach;
                                          ?>
                                          
                                          </select>
                                        <?php
									}
									else
									{
										?>
                                        <select name="healthfacility_id" id="healthfacility_id" required="required">
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
									?>
                                  </div>

</div>
</div>

</div>
</div>
                               

<div class="row-fluid">
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Reporting period: </label><div class="controls">
<select name="reporting_year" id="reporting_year" required="required">
                                 <option value="">Select Year</option>
                                 <?php
     $currentYear = date('Y')+10;
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
                               
                             <select name="week_no" id="week_no" required="required">
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
</div>
</div>

</div>
<div class="span6">

<div class="control-group"><label class="control-label" for="form-field-1">Disease: </label><div class="controls">
<select name="disease_id" id="disease_id" required="required" onChange="showDiv(this.value);">
                                 <option value="">Select Disease</option>
                                 <?php
    
        foreach ($diseases->result() as $disease) {
          ?>
        <option value="<?php echo $disease->id;?>" <?php 
		   if($disease->id==set_value('disease_id'))
		   {
			   echo 'selected="selected"';
		   }
		   ?>>(<?php echo $disease->disease_code;?>) <?php echo $disease->disease_name;?></option>
                                 <?php

        }
?>
<option value="0">(UnDis) Other Unusual Disease</option>
                               </select>
                               
</div>
</div>

</div>
</div>

<div class="row-fluid">
<div class="span12">

<div id="0" class="hiddenDiv">
<div class="control-group">
									<label class="control-label" for="form-field-5">Description</label>

									<div class="controls">
                                    <input class="span5" type="text" name="other" id="other"  onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')"  />
                                    </div>
                                    
                                    </div>
</div>

</div>

</div>

<div class="row-fluid">
<div class="span12">

<div class="control-group">
									<label class="control-label" for="form-field-5">Total &lt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="male_under_five" id="male_under_five"   onkeypress="return isNumberKey(event)" maxlength="2" onFocus="change(this,'#FF0000','#FFCCFF','#000000'),checkvalid()" onBlur="change(this,'','','')" placeholder="Male" required="required"/>
										<input class="span5" type="text" name="female_under_five" id="female_under_five"  onkeypress="return isNumberKey(event)" maxlength="2" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')" placeholder="Female" required="required"/>
                                        
                               
									</div>
								</div>

</div>

</div>

<div class="row-fluid">
<div class="span12">

<div class="control-group">
									<label class="control-label" for="form-field-5">Total &gt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="male_over_five" id="male_over_five"   onkeypress="return isNumberKey(event)" maxlength="2" onFocus="change(this,'#FF0000','#FFCCFF','#000000'),checkvalid()" onBlur="change(this,'','','')" placeholder="Male" required="required"/>
										<input class="span5" type="text" name="female_over_five" id="female_over_five"  onkeypress="return isNumberKey(event)" maxlength="2" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')" placeholder="Female" required="required" />
                                        
                               
									</div>
								</div>

</div>

</div>

<div class="row-fluid">
<div class="span6">

<div class="control-group">
									<label class="control-label" for="form-field-5">Deaths</label>

									<div class="controls">
										<input class="span5" type="text" name="death" id="death"   onkeypress="return isNumberKey(event)" maxlength="2" onFocus="change(this,'#FF0000','#FFCCFF','#000000'),checkvalid()" onBlur="change(this,'','','')" placeholder="No. of Deaths" required="required" />
										        
                               
									</div>
								</div>

</div>

<div class="span6">

<div class="control-group">
									<label class="control-label" for="form-field-5">Reporting Date</label>

									<div class="controls">
										<input class=" date-picker" id="form-field-date" name="reporting_date" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')" required="required" value="<?php echo set_value('reporting_date');?>" />
										        
                               
									</div>
								</div>

</div>

</div>

<!--<div class="row-fluid">
<div class="span12">

<div class="control-group">
									<label class="control-label" for="form-field-5">Action taken</label>

									<div class="controls">
										<textarea name="action_taken" id="action_taken" required="required"></textarea>
                                        
                               
									</div>
								</div>

</div>

</div>-->

<div class="row-fluid">
<div class="span12">

<div class="form-actions"><?php echo form_submit('submit', 'SUBMIT REPORT', 'class="btn btn-info "'); ?></div>

</div>
</div>

</div>

</div>						
												
											</div>
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
