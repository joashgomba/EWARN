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

						<li class="active">Regional Weekly Reports</li>
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
								Regional Weekly Reports
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
<?php echo form_open('bulletins/edit_region_validate/'.$row->id); ?>
<div class="control-group"><label>Week No/Week Year: </label><div class="controls"><strong><?php echo $row->week_no; ?> / <?php echo $row->week_year; ?></strong></div>
</div>
<div class="control-group"><label>Reporting Health Facilities Count: </label><div class="controls"><strong><?php echo $row->reporting_hf_count; ?> </strong></div>
</div>
<div class="control-group"><label>Total Consultations Sum: </label><div class="controls"><strong><?php echo $row->total_consultation; ?> </strong></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Highlight text: </label><div class="controls">
<?php $data = array('id' => 'highlight', 'name' => 'highlight', 'value' => $row->highlight); echo form_textarea($data, set_value('highlight')); ?>
<script>
var glob2 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('highlight');
 glob2 = editorpunt;
 
});

	
</script> 
</div>
</div><div class="control-group"><label>Narrative Title: </label><div class="controls"><?php $data = array('id' => 'title', 'name' => 'title', 'value' => $row->title); echo form_input($data, set_value('title')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Narrative Text: </label><div class="controls"><?php $data = array('id' => 'narrative', 'name' => 'narrative', 'value' => $row->narrative); echo form_textarea($data, set_value('narrative')); ?>
<script>
var glob3 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('narrative');
 glob3 = editorpunt;
 
});

	
</script> 
</div>
<div class="control-group"><label>Footer Text: </label><div class="controls">

<textarea name="footercaption" id="footercaption"><?php echo $row->footercaption;?></textarea>
</div>
</div>
<div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
