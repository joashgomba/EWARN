<?php include(APPPATH . 'views/common/header.php'); ?>
<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      //-->
</SCRIPT>
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

						<li class="active">Mobile Numbers</li>
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
								Mobile Numbers
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
                <?php echo form_open('mobilenumbers/edit_validate/'.$row->id); ?>
<div class="control-group"><label>Name: </label><div class="controls"><?php $data = array('id' => 'name', 'name' => 'name', 'value' => $row->name); echo form_input($data, set_value('name')); ?></div>
<div class="control-group"><label>Designation: </label><div class="controls"><?php $data = array('id' => 'designation', 'name' => 'designation', 'value' => $row->designation); echo form_input($data, set_value('designation')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Organization: </label><div class="controls"><?php $data = array('id' => 'organization', 'name' => 'organization', 'value' => $row->organization); echo form_input($data, set_value('organization')); ?></div>
</div>
<div class="control-group"><label>Sector: </label><div class="controls">
<select name="diseasecategory_id" id="diseasecategory_id" required="required">
<?php
foreach($diseasecategories as $key => $diseasecategory)
{
	?>
    <option value="<?php echo $diseasecategory['id'];?>" <?php if($diseasecategory['id']==$row->diseasecategory_id){ echo 'selected="selected"';}?> ><?php echo $diseasecategory['category_name'];?></option>
    <?php
}
?>
<option value="0" <?php if($row->diseasecategory_id==0){ echo 'selected="selected"';}?>>All diseases</option>
</select>

</div>
</div>
<div class="control-group"><label>Phone number: </label><div class="controls"><?php $data = array('id' => 'phone_number', 'name' => 'phone_number', 'value' => $row->phone_number, 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'12'); echo form_input($data, set_value('phone_number')); ?>
<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Enter numbers in this format (no + sign) 25290001122" title="Mobile phone format">?</span>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Email: </label><div class="controls"><?php $data = array('id' => 'email', 'name' => 'email', 'required'=>'required', 'value'=>$row->email); echo form_input($data, set_value('email')); ?></div>
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
