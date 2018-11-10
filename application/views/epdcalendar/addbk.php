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
				?>
                <?php echo form_open('epdcalendar/add_validate'); ?>
                
                <table id="customers">
                               <thead>
                               		<tr><th colspan="5">Epidemiological Weeks Calendar</th></tr>
                               </thead>
                               <tbody>
                              <tr><td colspan="2">Year</td><td colspan="3"><select name="epdyear" id="epdyear">
                               <?php
									 $currentYear = date('Y');
									 $nextYear = $currentYear + 1;
										foreach (range(2012, $nextYear) as $value) {
										  ?>
										   <option value="<?php echo $value;?>" <?php 
										   if($value==set_value('reporting_year'))
										   {
											   echo 'selected="selected"';
										   }
										   ?>><?php echo $value;?></option>
										  <?php
								
										}
								?>
								</select></td>
								</tr> 
                                <?php
							   for($i=1;$i<=52;$i++)
							   {
								   ?>
                                <tr><td>Week No. <input type="hidden" name="week_no[]" value="" /></td><td>From</td><td><input type="text" name="from[]" value="" /></td><td>To</td><td><input type="text" name="to[]" value="" /></td></tr>
                                <?php
							   }
							   ?>
                               </tbody>
                               
              </table>
<div class="control-group"><label class="control-label" for="form-field-1">Epdyear: </label><div class="controls"><?php $data = array('id' => 'epdyear', 'name' => 'epdyear'); echo form_input($data, set_value('epdyear')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Week no: </label><div class="controls"><?php $data = array('id' => 'week_no', 'name' => 'week_no'); echo form_input($data, set_value('week_no')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">From: </label><div class="controls"><?php $data = array('id' => 'from', 'name' => 'from'); echo form_input($data, set_value('from')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">To: </label><div class="controls"><?php $data = array('id' => 'to', 'name' => 'to'); echo form_input($data, set_value('to')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
                           
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
