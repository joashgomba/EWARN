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
								<li class="active">Epi bulletins</li>
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
										Reports
										<small>
											<i class="icon-double-angle-right"></i>
											Epi bulletins
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('epibulletins/edit_validate/'.$row->id,$attributes); ?>
<div class="control-group"><label class="control-label" for="form-field-1"><strong>Bulletin Epi Week <?php echo $row->week_no;?>, <?php echo date("d F Y", strtotime($row->from_date));?> - <?php echo date("d F Y", strtotime($row->to_date));?></strong>
: </label><div class="controls"><a href="<?php echo base_url() ?>index.php/epibulletins/downloadpdf/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Download" target="_blank">
 <span class="green">
 <i class="icon-external-link bigger-230"></i> PREVIEW BULLETIN

																	</span></a>
</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Highlight: </label><div class="controls"><?php $data = array('id' => 'highlight', 'name' => 'highlight', 'value' => $row->highlight); echo form_textarea($data, set_value('highlight')); ?>
<script>
var glob2 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('highlight');
 glob2 = editorpunt;
 
});

	
</script> 
</div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Cummulative figures: </label><div class="controls"><?php $data = array('id' => 'cummulative_figures', 'name' => 'cummulative_figures', 'value' => $row->cummulative_figures); echo form_textarea($data, set_value('cummulative_figures')); ?>

<script>
var glob3 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('cummulative_figures');
 glob3 = editorpunt;
 
});

	
</script> 
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Epidemic situation: </label><div class="controls"><?php $data = array('id' => 'epidemic_situation', 'name' => 'epidemic_situation', 'value' => $row->epidemic_situation); echo form_textarea($data, set_value('epidemic_situation')); ?>
<script>
var glob4 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('epidemic_situation');
 glob4 = editorpunt;
 
});

	
</script> 
</div>
</div>


<div class="control-group">
  <label class="control-label" for="form-field-1">Leading disease table: </label><div class="controls"><?php $data = array('id' => 'leadingdiseasetable', 'name' => 'leadingdiseasetable', 'value' => $row->leadingdiseasetable); echo form_textarea($data, set_value('leadingdiseasetable')); ?>
<script>
var glob5 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('leadingdiseasetable');
 glob5 = editorpunt;
 
});

	
</script> 

</div>
</div>

<div class="control-group">
  <label class="control-label" for="form-field-1">Malaria table: </label><div class="controls"><?php $data = array('id' => 'malariatable', 'name' => 'malariatable', 'value' => $row->malariatable); echo form_textarea($data, set_value('malariatable')); ?>
<script>
var glob6 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('malariatable');
 glob6 = editorpunt;
 
});

	
</script> 
</div>
</div><div class="control-group"><label class="control-label" for="form-field-1">First disease of interest table: </label><div class="controls"><?php $data = array('id' => 'interesttable', 'name' => 'interesttable', 'value' => $row->interesttable); echo form_textarea($data, set_value('interesttable')); ?>
<script>
var glob7 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('interesttable');
 glob7 = editorpunt;
 
});

	
</script> 
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Information on the first disease of interest (e.g. vaccination campaigns, outbreak response etc): </label><div class="controls"><?php $data = array('id' => 'doi_one_text', 'name' => 'doi_one_text', 'value' => $row->doi_one_text); echo form_textarea($data, set_value('doi_one_text')); ?>
<script>
var glob8 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('doi_one_text');
 glob8 = editorpunt;
 
});

	
</script> 
</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Second disease of interest table: </label><div class="controls"><?php $data = array('id' => 'lastinteresttable', 'name' => 'lastinteresttable', 'value' => $row->lastinteresttable); echo form_textarea($data, set_value('lastinteresttable')); ?>
<script>
var glob9 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('lastinteresttable');
 glob9 = editorpunt;
 
});

	
</script> 

</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Information on the second disease of interest (e.g. vaccination campaigns, outbreak response etc): </label><div class="controls"><?php $data = array('id' => 'doi_two_text', 'name' => 'doi_two_text', 'value' => $row->doi_two_text); echo form_textarea($data, set_value('doi_two_text')); ?>
<script>
var glob10 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('doi_two_text');
 glob10 = editorpunt;
 
});

	
</script> 
</div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Summarytable: </label><div class="controls"><?php $data = array('id' => 'summarytable', 'name' => 'summarytable', 'value' => $row->summarytable); echo form_textarea($data, set_value('summarytable')); ?>
<script>
var glob11 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('summarytable');
 glob11 = editorpunt;
 
});

	
</script>
</div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Footer one: </label><div class="controls"><?php $data = array('id' => 'footer_one', 'name' => 'footer_one', 'value' => $row->footer_one); echo form_textarea($data, set_value('footer_one')); ?>
<script>
var glob12 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('footer_one');
 glob12 = editorpunt;
 
});

	
</script>
</div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Footer two: </label><div class="controls"><?php $data = array('id' => 'footer_two', 'name' => 'footer_two', 'value' => $row->footer_two); echo form_textarea($data, set_value('footer_two')); ?>
<script>
var glob13 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('footer_two');
 glob13 = editorpunt;
 
});

	
</script>

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
