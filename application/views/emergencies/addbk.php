<?php include(APPPATH . 'views/common/header.php'); ?>
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
										PROJECT NAME
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
<div class="control-group"><label class="control-label" for="form-field-1">Healthfacility id: </label><div class="controls"><?php $data = array('id' => 'healthfacility_id', 'name' => 'healthfacility_id'); echo form_input($data, set_value('healthfacility_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">District id: </label><div class="controls"><?php $data = array('id' => 'district_id', 'name' => 'district_id'); echo form_input($data, set_value('district_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Region id: </label><div class="controls"><?php $data = array('id' => 'region_id', 'name' => 'region_id'); echo form_input($data, set_value('region_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Zone id: </label><div class="controls"><?php $data = array('id' => 'zone_id', 'name' => 'zone_id'); echo form_input($data, set_value('zone_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Country id: </label><div class="controls"><?php $data = array('id' => 'country_id', 'name' => 'country_id'); echo form_input($data, set_value('country_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Week no: </label><div class="controls"><?php $data = array('id' => 'week_no', 'name' => 'week_no'); echo form_input($data, set_value('week_no')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Reporting year: </label><div class="controls"><?php $data = array('id' => 'reporting_year', 'name' => 'reporting_year'); echo form_input($data, set_value('reporting_year')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Epicalendar id: </label><div class="controls"><?php $data = array('id' => 'epicalendar_id', 'name' => 'epicalendar_id'); echo form_input($data, set_value('epicalendar_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Reporting date: </label><div class="controls"><?php $data = array('id' => 'reporting_date', 'name' => 'reporting_date'); echo form_input($data, set_value('reporting_date')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">User id: </label><div class="controls"><?php $data = array('id' => 'user_id', 'name' => 'user_id'); echo form_input($data, set_value('user_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Disease id: </label><div class="controls"><?php $data = array('id' => 'disease_id', 'name' => 'disease_id'); echo form_input($data, set_value('disease_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Male under five: </label><div class="controls"><?php $data = array('id' => 'male_under_five', 'name' => 'male_under_five'); echo form_input($data, set_value('male_under_five')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Female under five: </label><div class="controls"><?php $data = array('id' => 'female_under_five', 'name' => 'female_under_five'); echo form_input($data, set_value('female_under_five')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Male over five: </label><div class="controls"><?php $data = array('id' => 'male_over_five', 'name' => 'male_over_five'); echo form_input($data, set_value('male_over_five')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Female over five: </label><div class="controls"><?php $data = array('id' => 'female_over_five', 'name' => 'female_over_five'); echo form_input($data, set_value('female_over_five')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Other: </label><div class="controls"><?php $data = array('id' => 'other', 'name' => 'other'); echo form_input($data, set_value('other')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Death: </label><div class="controls"><?php $data = array('id' => 'death', 'name' => 'death'); echo form_input($data, set_value('death')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Action taken: </label><div class="controls"><?php $data = array('id' => 'action_taken', 'name' => 'action_taken'); echo form_textarea($data, set_value('action_taken')); ?></div>
</div>									<!--PAGE CONTENT ENDS-->
								</div><!--/.span-->
							</div><!--/.row-fluid-->
						</div><!--/.page-content-->
					<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
				</div><!--/.main-content-->
			</div><!--/.main-container-->
		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
