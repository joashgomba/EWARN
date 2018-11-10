<?php include(APPPATH . 'views/common/header.php'); ?>
 <script type="text/javascript">
<!--
// Form validation code will come here.
function validate()
{
	     
    if( document.frm.email.value == "" )
   {
     alert( "Please enter the email" );
     document.frm.email.focus() ;
     return false;
   }
   
  
   if( document.frm.fname.value == "" )
   {
     alert( "Please enter the First Name" );
     document.frm.fname.focus() ;
     return false;
   }
   
   if( document.frm.lname.value == "" )
   {
     alert( "Please enter the Last Name" );
     document.frm.lname.focus() ;
     return false;
   }
   
   if( document.frm.contact_number.value == "" )
   {
     alert( "Please enter the contact number" );
     document.frm.contact_number.focus() ;
     return false;
   }
     
   if( document.frm.username.value == "" )
   {
     alert( "Please enter the username" );
     document.frm.username.focus() ;
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
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active">Users</li>
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
								Users</small>
						</h1>
					</div><!--/.page-header-->
                    
                         	<?php
				if(validation_errors())
				{
					?>
					<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
					<?php
				}
				?>
                <?php echo form_open('users/edit_validate/'.$row->id); ?>
<div class="control-group"><label>First Name: </label><div class="controls"><?php $data = array('id' => 'fname', 'name' => 'fname', 'value' => $row->fname); echo form_input($data, set_value('fname')); ?></div>
</div><div class="control-group"><label>Last Name: </label><div class="controls"><?php $data = array('id' => 'lname', 'name' => 'lname', 'value' => $row->lname); echo form_input($data, set_value('lname')); ?></div>
</div>
<div class="control-group"><label>Contact Number: </label><div class="controls"><?php $data = array('id' => 'contact_number', 'name' => 'contact_number', 'value' => $row->contact_number); echo form_input($data, set_value('contact_number')); ?></div>
</div></div>
<div class="control-group"><label>Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email', 'value' => $row->email); echo form_input($data, set_value('email')); ?></div>
</div></div>

<!--<div class="control-group"><label>Health Facility: </label><div class="controls">
<select name="healthfacility_id" id="healthfacility_id">
<option value="0">All health facilities</option>
<?php
foreach($healthfacilities as $key => $healthfacility)
{
	?>
    <option value="<?php echo $healthfacility['id'];?>" <?php if($healthfacility['id']==$row->healthfacility_id){ echo 'selected="selected"';}?> ><?php echo $healthfacility['health_facility'];?></option>
    <?php
}
?>
</select>
</div>
</div>-->

<div class="control-group"><label>Username: </label><div class="controls"><?php $data = array('id' => 'username', 'name' => 'username', 'value' => $row->username); echo form_input($data, set_value('username')); ?></div>
</div><div class="control-group"><label>Password (If changing password): </label><div class="controls">
<?php $data = array('id' => 'password', 'name' => 'password', 'type' => 'password'); echo form_input($data, set_value('password')); ?>

<input type="hidden" name="oldpassword" id="oldpassword" value="<?php echo $row->password;?>" />
</div>
</div><!--<div class="control-group"><label>Role: </label><div class="controls">
<select name="role_id" id="role_id">
<?php
foreach($roles as $key => $role)
{
	?>
    <option value="<?php echo $role['id'];?>" <?php if($role['id']==$row->role_id){ echo 'selected="selected"';}?> ><?php echo $role['name'];?></option>
    <?php
}
?>
</select>
</div>
</div>-->
<!--<div class="control-group"><label>Level: </label><div class="controls">
<select name="level" id="level">
<option value="1" <?php if($row->level==1){ echo 'selected="selected"';}?>>Zone</option>
<option value="2" <?php if($row->level==2){ echo 'selected="selected"';}?>>Region</option>
<option value="3" <?php if($row->level==3){ echo 'selected="selected"';}?>>Facility</option>
<option value="4" <?php if($row->level==4){ echo 'selected="selected"';}?>>National</option>
<option value="5" <?php if($row->level==5){ echo 'selected="selected"';}?>>Stake holder</option>
</select>
</div>
</div>-->
<div class="control-group"><label>Active: </label><div class="controls">
<select name="active" id="active">
<option value="1" <?php if($row->active==1){ echo 'selected="selected"';}?>>Yes</option>
<option value="0" <?php if($row->active==0){ echo 'selected="selected"';}?>>No</option>
</select>
</div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
