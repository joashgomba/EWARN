<?php include(APPPATH . 'views/common/header.php'); ?>

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

						<li class="active">Health Facilities</li>
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
								Health Facilities
							</small>
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
                       <?php echo form_open('healthfacilities/edit_validate/'.$row->id); ?>
 <div class="control-group"><label class="control-label" for="form-field-1">Organization: </label><div class="controls"><?php $data = array('id' => 'organization', 'name' => 'organization', 'value'=>$row->organization); echo form_input($data, set_value('organization')); ?></div>
                </div>
<div class="control-group"><label>Health facility: </label><div class="controls"><?php $data = array('id' => 'health_facility', 'name' => 'health_facility', 'value' => $row->health_facility); echo form_input($data, set_value('health_facility')); ?></div>
</div><div class="control-group"><label>Hf code: </label><div class="controls"><?php $data = array('id' => 'hf_code', 'name' => 'hf_code', 'value' => $row->hf_code); echo form_input($data, set_value('hf_code')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Health facility type: </label><div class="controls">
<select name="health_facility_type" id="health_facility_type">

    
     <option value="MCH" <?php if($row->health_facility_type=='MCH'){ echo 'selected="selected"';}?>>MCH</option>
				<option value="Hospital" <?php if($row->health_facility_type=='Hospital'){ echo 'selected="selected"';}?>>Hospital</option>
				<option value="Other" <?php if($row->health_facility_type=='Other'){ echo 'selected="selected"';}?>>Other</option>

</select>
</div>
</div
>

<div class="control-group"><label class="control-label" for="form-field-1">Enter if other: </label><div class="controls">
<input type="text" name="othervalue" id="othervalue" value="<?php echo $row->otherval;?>">
</div>
</div
>
<div class="control-group"><label><?php echo $user_country->third_admin_level_label;?>: </label><div class="controls">
<select name="district_id" id="district_id">
<?php
foreach($districts as $key => $district)
{
	?>
    <option value="<?php echo $district['id'];?>" <?php if($district['id']==$row->district_id){ echo 'selected="selected"';}?> ><?php echo $district['district'];?></option>
    <?php
}
?>
</select>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Catchment population: </label><div class="controls"><?php $data = array('id' => 'catchment_population', 'name' => 'catchment_population', 'value'=>$row->catchment_population); echo form_input($data, set_value('catchment_population')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Focal person name: </label><div class="controls"><?php $data = array('id' => 'focal_person_name', 'name' => 'focal_person_name', 'value'=>$row->focal_person_name); echo form_input($data, set_value('focal_person_name')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Contact number: </label><div class="controls"><?php $data = array('id' => 'contact_number', 'name' => 'contact_number', 'value'=>$row->contact_number); echo form_input($data, set_value('contact_number')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email', 'value'=>$row->email); echo form_input($data, set_value('email')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Activated: </label><div class="controls">
<select name="activated" id="activated">
<option value="1" <?php if($row->activated==1){echo 'selected="selected"';}?>>Yes</option>
<option value="0" <?php if($row->activated==0){echo 'selected="selected"';}?>>No</option>
</select>

</div>
</div>

<div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
