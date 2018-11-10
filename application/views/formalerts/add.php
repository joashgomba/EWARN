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
								<li class="active">formalerts</li>
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
											formalerts
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('formalerts/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Reportingform id: </label><div class="controls"><?php $data = array('id' => 'reportingform_id', 'name' => 'reportingform_id'); echo form_input($data, set_value('reportingform_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Reportingperiod id: </label><div class="controls"><?php $data = array('id' => 'reportingperiod_id', 'name' => 'reportingperiod_id'); echo form_input($data, set_value('reportingperiod_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Disease id: </label><div class="controls"><?php $data = array('id' => 'disease_id', 'name' => 'disease_id'); echo form_input($data, set_value('disease_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Disease name: </label><div class="controls"><?php $data = array('id' => 'disease_name', 'name' => 'disease_name'); echo form_input($data, set_value('disease_name')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Healthfacility id: </label><div class="controls"><?php $data = array('id' => 'healthfacility_id', 'name' => 'healthfacility_id'); echo form_input($data, set_value('healthfacility_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">District id: </label><div class="controls"><?php $data = array('id' => 'district_id', 'name' => 'district_id'); echo form_input($data, set_value('district_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Region id: </label><div class="controls"><?php $data = array('id' => 'region_id', 'name' => 'region_id'); echo form_input($data, set_value('region_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Zone id: </label><div class="controls"><?php $data = array('id' => 'zone_id', 'name' => 'zone_id'); echo form_input($data, set_value('zone_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Cases: </label><div class="controls"><?php $data = array('id' => 'cases', 'name' => 'cases'); echo form_input($data, set_value('cases')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Deaths: </label><div class="controls"><?php $data = array('id' => 'deaths', 'name' => 'deaths'); echo form_input($data, set_value('deaths')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Notes: </label><div class="controls"><?php $data = array('id' => 'notes', 'name' => 'notes'); echo form_textarea($data, set_value('notes')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Verification status: </label><div class="controls"><?php $data = array('id' => 'verification_status', 'name' => 'verification_status'); echo form_input($data, set_value('verification_status')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Include bulletin: </label><div class="controls"><?php $data = array('id' => 'include_bulletin', 'name' => 'include_bulletin'); echo form_input($data, set_value('include_bulletin')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Outcome: </label><div class="controls"><?php $data = array('id' => 'outcome', 'name' => 'outcome'); echo form_input($data, set_value('outcome')); ?></div>
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
