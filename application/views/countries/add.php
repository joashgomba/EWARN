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
								<li class="active">Countries</li>
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
										Registration
										<small>
											<i class="icon-double-angle-right"></i>
											Countries
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('countries/add_validate',$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Country name: </label><div class="controls"><?php $data = array('id' => 'country_name', 'name' => 'country_name'); echo form_input($data, set_value('country_name')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Country code: </label><div class="controls"><?php $data = array('id' => 'country_code', 'name' => 'country_code'); echo form_input($data, set_value('country_code')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">First admin level label: </label><div class="controls"><?php $data = array('id' => 'first_admin_level_label', 'name' => 'first_admin_level_label'); echo form_input($data, set_value('first_admin_level_label')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Second admin level label: </label><div class="controls"><?php $data = array('id' => 'second_admin_level_label', 'name' => 'second_admin_level_label'); echo form_input($data, set_value('second_admin_level_label')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Third admin level label: </label><div class="controls"><?php $data = array('id' => 'third_admin_level_label', 'name' => 'third_admin_level_label'); echo form_input($data, set_value('third_admin_level_label')); ?></div>
</div>	

<div class="control-group"><label class="control-label" for="form-field-1">Country Map Center: </label><div class="controls"><?php $data = array('id' => 'map_center', 'name' => 'map_center', 'required'=>'required'); echo form_input($data, set_value('map_center')); ?><span class="help-inline">Example: Cairo, Egypt</span></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Contact Person: </label><div class="controls"><?php $data = array('id' => 'contact_person', 'name' => 'contact_person', 'required'=>'required'); echo form_input($data, set_value('contact_person')); ?></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Contact Email: </label><div class="controls"><?php $data = array('id' => 'contact_email', 'name' => 'contact_email', 'required'=>'required'); echo form_input($data, set_value('contact_email')); ?></div>
</div>
<div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>								<!--PAGE CONTENT ENDS-->
								</div><!--/.span-->
							</div><!--/.row-fluid-->
						</div><!--/.page-content-->
					<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
				</div><!--/.main-content-->
			</div><!--/.main-container-->
		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
