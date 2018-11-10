<?php include(APPPATH . 'views/common/header.php'); ?>
<script>

function change(that, fgcolor, bgcolor,txtcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}

</script>

<script type="text/javascript">

	function validate(){

		var eduInput = document.getElementsByName('from[]');
		for (i=0; i<eduInput.length; i++)
			{
			 if (eduInput[i].value == "")
				{
			 	 alert('Complete all the From Date fields'); 
				 eduInput[i].focus() ;
			 	 return false;
				}
			}
			
		var toInput = document.getElementsByName('to[]');
		for (i=0; i<toInput.length; i++)
			{
			 if (toInput[i].value == "")
				{
			 	 alert('Complete all the To Date fields'); 
				 toInput[i].focus() ;
			 	 return false;
				}
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
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="<?php echo site_url('home')?>">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li class="active">Epidemiological Weeks Calendar</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Epidemiological Weeks Calendar
							<small>
								<i class="icon-double-angle-right"></i>
								Create
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
				if(!empty($error))
				{
				?>
					<p><div class="alert alert-danger"> <?php echo $error; ?></div></p>
					<?php	
				}
				
				?>
                <?php 
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','class' => 'block-content form');
				echo form_open('epdcalendar/add_validate',$attributes); ?>
                
                <div class="control-group"><label class="control-label" for="form-field-1">Year: </label><div class="controls">
<select name="epdyear" id="epdyear">
                               <?php
									 $currentYear = date('Y');
									 $nextYear = $currentYear + 25;
										foreach (range(2012, $nextYear) as $value) {
										  ?>
										   <option value="<?php echo $value;?>" <?php 
										   if($value==set_value('epdyear'))
										   {
											   echo 'selected="selected"';
										   }
										   ?>><?php echo $value;?></option>
										  <?php
								
										}
								?>
								</select>
</div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<select name="country_id" id="country_id" required="required">
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
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Baseline Date: </label><div class="controls">
<input class=" date-picker" id="form-field-date" name="baseline_date" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')" required="required" value="<?php echo set_value('baseline_date');?>" /><span class="add-on">
																		<i class="icon-calendar"></i>
																	</span>
</div>
</div>
                
                
<div class="form-actions"><?php echo form_submit('submit', 'Create Calendar', 'class="btn btn-info "'); ?></div>
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
