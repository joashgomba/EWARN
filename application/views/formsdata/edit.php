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
								<li class="active">formsdata</li>
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
											formsdata
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('formsdata/edit_validate/'.$row->id,$attributes); ?>
<div class="control-group"><label>Form id: </label><div class="controls"><?php $data = array('id' => 'form_id', 'name' => 'form_id', 'value' => $row->form_id); echo form_input($data, set_value('form_id')); ?></div>
</div><div class="control-group"><label>Disease id: </label><div class="controls"><?php $data = array('id' => 'disease_id', 'name' => 'disease_id', 'value' => $row->disease_id); echo form_input($data, set_value('disease_id')); ?></div>
</div><div class="control-group"><label>Male under five: </label><div class="controls"><?php $data = array('id' => 'male_under_five', 'name' => 'male_under_five', 'value' => $row->male_under_five); echo form_input($data, set_value('male_under_five')); ?></div>
</div><div class="control-group"><label>Female under five: </label><div class="controls"><?php $data = array('id' => 'female_under_five', 'name' => 'female_under_five', 'value' => $row->female_under_five); echo form_input($data, set_value('female_under_five')); ?></div>
</div><div class="control-group"><label>Male over five: </label><div class="controls"><?php $data = array('id' => 'male_over_five', 'name' => 'male_over_five', 'value' => $row->male_over_five); echo form_input($data, set_value('male_over_five')); ?></div>
</div><div class="control-group"><label>Female over five: </label><div class="controls"><?php $data = array('id' => 'female_over_five', 'name' => 'female_over_five', 'value' => $row->female_over_five); echo form_input($data, set_value('female_over_five')); ?></div>
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
