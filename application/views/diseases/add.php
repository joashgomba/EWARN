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
<script type="text/javascript"><!--
var lastDiv = "";
function showDiv(divName) {
	// hide last div
	if (lastDiv) {
		document.getElementById(lastDiv).className = "hiddenDiv";
	}
	//if value of the box is not nothing and an object with that name exists, then change the class
	if (divName && document.getElementById(divName)) {
		document.getElementById(divName).className = "visibleDiv";
		lastDiv = divName;
	}
}
//-->
</script>

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
    
		<style type="text/css" media="screen"><!--
.hiddenDiv {
	display: none;
	}
.visibleDiv {
	display: block;
	
	}

--></style>
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
<?php echo form_open('diseases/add_validate',$attributes); ?>
<div class="control-group">
  <label class="control-label" for="form-field-1">Country: </label><div class="controls">
  <select name="country_id" id="country_id">
<?php
foreach($countries as $key => $country)
{
	if(getRole() == 'Admin')
	{
		if($country_id != $country['id'])
		{
		}
		else
		{
		?>
        <option value="<?php echo $country['id'];?>" <?php if($country['id']==set_value('country_id')){ echo 'selected="selected"';}?> ><?php echo $country['country_name'];?></option>
        <?php
		}
	}
	else
	{
	?>
    <option value="<?php echo $country['id'];?>" <?php if($country['id']==set_value('country_id')){ echo 'selected="selected"';}?> ><?php echo $country['country_name'];?></option>
    <?php
	}
}
?>
</select>
  
</div>
</div><div class="control-group">
  <label class="control-label" for="form-field-1">Disease category: </label><div class="controls">
  <select name="diseasecategory_id" id="diseasecategory_id">
<?php
foreach($diseasecategories as $key => $diseasecategory)
{
	?>
    <option value="<?php echo $diseasecategory['id'];?>" <?php if($diseasecategory['id']==set_value('diseasecategory_id')){ echo 'selected="selected"';}?> ><?php echo $diseasecategory['category_name'];?></option>
    <?php
}
?>
</select>
  </div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Colour code: </label><div class="controls"><input id="colorpicker1" name="color_code" type="text" class="input-mini" /><span class="help-inline">For disease colours on graphs</span></div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Disease code: </label><div class="controls"><?php $data = array('id' => 'disease_code', 'name' => 'disease_code','onkeypress'=>'return onlyAlphabets(event,this);'); echo form_input($data, set_value('disease_code')); ?><span class="help-inline">Alphabets Only</span></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Disease name: </label><div class="controls"><?php $data = array('id' => 'disease_name', 'name' => 'disease_name'); echo form_input($data, set_value('disease_name')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Case definition: </label><div class="controls"><?php $data = array('id' => 'case_definition', 'name' => 'case_definition'); echo form_textarea($data, set_value('case_definition')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Alert type: </label><div class="controls">
<select name="alert_type" id="alert_type" class="form-control" onChange="showDiv(this.value);" required="required">
                                                                      		<option value="" <?php if(set_value('alert_type')==0){echo 'selected="selected"';}?>>Select</option>
                                                                            <option value="1"  <?php if(set_value('alert_type')==1){echo 'selected="selected"';}?>>Threshold</option>
                                                                            <option value="2"  <?php if(set_value('alert_type')==2){echo 'selected="selected"';}?>>Calculation</option>
                                                                        
                                                                        </select>
</div>
</div>

<div id="1" class="hiddenDiv">

<div class="control-group"><label class="control-label" for="form-field-1">Alert threshold: </label><div class="controls"><?php $data = array('id' => 'alert_threshold', 'name' => 'alert_threshold', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2'); echo form_input($data, set_value('alert_threshold')); ?> suspected/comformed cases (or more cases)</div>
</div>

</div>

<div id="2" class="hiddenDiv">

<div class="control-group"><label class="control-label" for="form-field-1">Alert calculation: </label><div class="controls"><?php $data = array('id' => 'no_of_times', 'name' => 'no_of_times', 'class'=>'input-small', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2'); echo form_input($data, set_value('no_of_times')); ?> times the mean number of cases of the previous <?php $data = array('id' => 'weeks', 'name' => 'weeks', 'class'=>'input-small', 'onkeypress'=>'return isNumberKey(event)', 'maxlength'=>'2'); echo form_input($data, set_value('weeks')); ?> weeks</div>
</div>

</div>

<div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>

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
