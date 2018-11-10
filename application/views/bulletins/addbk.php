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

						<li class="active">National Weekly Reports</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Reports
							<small>
								<i class="icon-double-angle-right"></i>
								National Weekly Reports
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
<?php echo form_open('bulletins/add_validate'); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Reportingperiod id: </label><div class="controls"><?php $data = array('id' => 'reportingperiod_id', 'name' => 'reportingperiod_id'); echo form_input($data, set_value('reportingperiod_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Week no: </label><div class="controls"><?php $data = array('id' => 'week_no', 'name' => 'week_no'); echo form_input($data, set_value('week_no')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Week year: </label><div class="controls"><?php $data = array('id' => 'week_year', 'name' => 'week_year'); echo form_input($data, set_value('week_year')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Period from: </label><div class="controls"><?php $data = array('id' => 'period_from', 'name' => 'period_from'); echo form_input($data, set_value('period_from')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Period to: </label><div class="controls"><?php $data = array('id' => 'period_to', 'name' => 'period_to'); echo form_input($data, set_value('period_to')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Issue no: </label><div class="controls"><?php $data = array('id' => 'issue_no', 'name' => 'issue_no'); echo form_input($data, set_value('issue_no')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Zone id: </label><div class="controls"><?php $data = array('id' => 'zone_id', 'name' => 'zone_id'); echo form_input($data, set_value('zone_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Region id: </label><div class="controls"><?php $data = array('id' => 'region_id', 'name' => 'region_id'); echo form_input($data, set_value('region_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">District id: </label><div class="controls"><?php $data = array('id' => 'district_id', 'name' => 'district_id'); echo form_input($data, set_value('district_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Highlight: </label><div class="controls"><?php $data = array('id' => 'highlight', 'name' => 'highlight'); echo form_textarea($data, set_value('highlight')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Title: </label><div class="controls"><?php $data = array('id' => 'title', 'name' => 'title'); echo form_input($data, set_value('title')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Narrative: </label><div class="controls"><?php $data = array('id' => 'narrative', 'name' => 'narrative'); echo form_textarea($data, set_value('narrative')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Creation date: </label><div class="controls"><?php $data = array('id' => 'creation_date', 'name' => 'creation_date'); echo form_input($data, set_value('creation_date')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
