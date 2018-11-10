<?php include(APPPATH . 'views/common/header.php'); ?>
<script language="Javascript" type="text/javascript">

        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
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
						<!--.breadcrumb--><div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb">
								<li>
									<i class="icon-home home-icon"></i>
										<a href="<?php echo site_url('home')?>">Home</a>
										<span class="divider">
											<i class="icon-angle-right arrow-icon"></i>
										</span>
								</li>
								<li class="active">diseases</li>
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
										Configuration
										<small>
											<i class="icon-double-angle-right"></i>
											diseases
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('diseases/edit_validate/'.$row->id,$attributes); ?>
<!--<div class="control-group"><label>Country id: </label><div class="controls"><?php $data = array('id' => 'country_id', 'name' => 'country_id', 'value' => $row->country_id); echo form_input($data, set_value('country_id')); ?></div>
</div>-->
<div class="control-group">
  <label class="control-label" for="form-field-1">Disease category: </label><div class="controls">
  <select name="diseasecategory_id" id="diseasecategory_id">
<?php
foreach($diseasecategories as $key => $diseasecategory)
{
	?>
    <option value="<?php echo $diseasecategory['id'];?>" <?php if($diseasecategory['id']==$row->diseasecategory_id){ echo 'selected="selected"';}?> ><?php echo $diseasecategory['category_name'];?></option>
    <?php
}
?>
</select>
  </div>
</div>
<div class="control-group"><label>Disease code: </label><div class="controls"><?php $data = array('id' => 'disease_code', 'name' => 'disease_code', 'value' => $row->disease_code,'onkeypress'=>'return onlyAlphabets(event,this);'); echo form_input($data, set_value('disease_code')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Colour code: </label><div class="controls"><input id="colorpicker1" name="color_code" value="<?php echo $row->color_code;?>" type="text" class="input-mini" /><span class="help-inline">For disease colours on graphs</span></div>
</div>
<div class="control-group"><label>Disease name: </label><div class="controls"><?php $data = array('id' => 'disease_name', 'name' => 'disease_name', 'value' => $row->disease_name); echo form_input($data, set_value('disease_name')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Case definition: </label><div class="controls"><?php $data = array('id' => 'case_definition', 'name' => 'case_definition', 'value' => $row->case_definition); echo form_textarea($data, set_value('case_definition')); ?>
<input type="hidden" name="alert_type" id="alert_type" value="<?php echo $row->alert_type;?>">
</div>
</div>
<?php
if($row->alert_type==1)
{
	?>
    <div class="control-group"><label class="control-label" for="form-field-1">Alert threshold: </label><div class="controls"><?php $data = array('id' => 'alert_threshold', 'name' => 'alert_threshold', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2', 'value' => $row->alert_threshold); echo form_input($data, set_value('alert_threshold')); ?> suspected/comformed cases (or more cases)</div>
</div>
    <?php
}
else
{
	?>
    <div class="control-group"><label class="control-label" for="form-field-1">Alert calculation: </label><div class="controls"><?php $data = array('id' => 'no_of_times', 'name' => 'no_of_times', 'class'=>'input-small', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2', 'value' => $row->no_of_times); echo form_input($data, set_value('no_of_times')); ?> times the mean number of cases of the previous <?php $data = array('id' => 'weeks', 'name' => 'weeks', 'class'=>'input-small', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2', 'value' => $row->weeks); echo form_input($data, set_value('weeks')); ?> weeks</div>
</div>
    <?php
}
?>
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
