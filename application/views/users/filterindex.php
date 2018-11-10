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
	
function GetHelathfacility(frm){
	if(validateForm(frm)){
	document.getElementById('healthfacility').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/gethealthfacility";
	
	var params = "hfcode=" + totalEncode(document.frm.hfcode.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('healthfacility').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('healthfacility').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
	}
	
	function GetDistricts(frm){
	if(validateForm(frm)){
	document.getElementById('districts').innerHTML='';
	var url = "<?php echo base_url(); ?>index.php/users/getdistricts";
	
	var params = "region_id=" + totalEncode(document.frm.region_id.value );
	var connection=connect(url,params);
	
	connection.onreadystatechange = function(){
	if(connection.readyState == 4){
		document.getElementById('districts').innerHTML=connection.responseText;
		
		
	}
	if((connection.readyState == 2)||(connection.readyState == 3)){document.getElementById('districts').innerHTML = '<span style="color:green;">Sending request....</span>';}}}
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

						<li class="active">Focal Points</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Registration
							<small>
								<i class="icon-double-angle-right"></i>
								Focal Points
							</small>
						</h1>
					</div><!--/.page-header-->
                    <p>
                     <?php 
					   $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','onsubmit'=>'return(validate())');
					  echo form_open('users/filter',$attributes); ?>
                      
                     <table id="customers">
<tr><td>   <a href="<?php echo base_url() ?>index.php/users/add" class="btn btn-app btn-primary no-radius">
										<i class="icon-edit bigger-230"></i>
										Add New
										
									</a></td>
                                    
                                    <td valign="top">
                                    <table>
                                    <tr><td>Zone</td><td><select name="zone_id" id="zone_id" onChange="GetRegions(this)">
                                <option value="0">-Select Zone-</option>
                                <option value="0">-All Zones-</option>
                                <?php
								foreach($zones as $key=> $zone)
								{
									?>
                                    <option value="<?php echo $zone['id'];?>" <?php if(set_value('zone_id')==$zone['id']){echo 'selected="selected"';}?>><?php echo $zone['zone'];?></option>
                                    <?php
								}
								?>
                                </select>
                                    </td>
                                    <td>Region</td><td> <div id="regions">
                                <select name="region_id" id="region_id" onChange="GetDistricts(this)">
                                <option value="0">-Select Region-</option>
                                <option value="0">-All Regions-</option>
                                <?php
								foreach($regions as $key=> $region)
								{
									?>
                                    <option value="<?php echo $region['id'];?>"  <?php if(set_value('region_id')==$region['id']){echo 'selected="selected"';}?>><?php echo $region['region'];?></option>
                                    <?php
								}
								?>
                                </select>
                                </div>
                                    </td>
                                    <td>District</td><td><div id="districts"><select name="district_id" id="district_id">
                                <option value="0">-Select District-</option>
                                <option value="0">-All Districts-</option>
                                 <?php
								foreach($districts as $key=> $district)
								{
									?>
                                    <option value="<?php echo $district['id'];?>" <?php if(set_value('district_id')==$district['id']){echo 'selected="selected"';}?>><?php echo $district['district'];?></option>
                                    <?php
								}
								?>
                                </select></div>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>Registration Type</td><td><select name="level" id="level">
<!--<option value="1">Zone</option>-->
<option value="0">-Select Type-</option>
<option value="4">National</option>
<option value="1">Zonal</option>
<option value="2">FP</option>
<option value="3">HF</option>
<option value="5">Stake holder </option>
</select></td>
                                    <td colspan="2"><input type="submit" name="submit_button" value="Filter" class="btn btn-info" /></td>
                                    </tr>
                                    </table>
                                    
                                    </td>
                       </tr>
                    </table>
                 <?php echo form_close(); ?>
                    </p>
                   
                         <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Fname</th>
<th>Lname</th>
<th>Username</th>
<th>Registration Type</th>
<th>Active</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php //foreach ($rows->result() as $row): 
foreach ($rows as $key => $row) {
?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->fname; ?></td>
<td><?php echo $row->lname; ?></td>
<td><?php echo $row->username; ?></td>
<td><?php 
if($row->level==2)
{
	echo 'FP';
}
else if($row->level==3)
{
	echo 'HF';
}
else if($row->level==1)
{
	echo 'Zone';
}
else if($row->level==4)
{
	echo 'National';
}
else
{
	echo 'Stake holder';
}
?></td>
<td><?php 
if($row->active==1)
{
	echo '<a href="'.base_url().'index.php/users/deactivate/'.$row->id.'" class="icon-check" data-rel="tooltip" title="Active">Yes</a>';
}
else
{
	echo '<a  href="'.base_url().'index.php/users/activate/'.$row->id.'" class=" icon-check-empty " data-rel="tooltip" title="Inactive">No</a>';
}
 ?></td>
<td><a href="<?php echo base_url() ?>index.php/users/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                           
																<a href="<?php echo base_url() ?>index.php/users/delete/<?php echo $row->id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
																	<span class="red">
																		<i class="icon-trash bigger-120"></i>
																	</span>
																</a></td>
</tr>
<?php //endforeach; 
}
?>
</tbody>
</table>
                           
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
