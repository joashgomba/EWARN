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
				
				
				?>
                <?php 
				$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data','class' => 'block-content form','onsubmit'=>'return(validate())');
				echo form_open('epdcalendar/add_validate',$attributes); ?>
                
                <table id="customers">
                               <thead>
                               		<tr><th colspan="5">Epidemiological Weeks Calendar</th></tr>
                               </thead>
                               <tbody>
                              <tr><td colspan="2">Year</td><td colspan="3"><select name="epdyear" id="epdyear">
                               <?php
									 $currentYear = date('Y');
									 $nextYear = $currentYear + 25;
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
                                <tr><td>Week No.<?php echo $i;?> <input type="hidden" name="week_no[]" value="<?php echo $i;?>" /></td><td>From</td><td>
                                <div class="input-append"><input class="input-small date-picker" id="form-field-date" name="from[]" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')" /><span class="add-on">
																		<i class="icon-calendar"></i>
																	</span>
																</div></td><td>To</td><td><div class="input-append"><input class="input-small date-picker" id="form-field-date" name="to[]" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" onFocus="change(this,'#FF0000','#FFCCFF','#000000')" onBlur="change(this,'','','')"/><span class="add-on">
																		<i class="icon-calendar"></i>
																	</span>
																</div></td></tr>
                                <?php
							   }
							   ?>
                               </tbody>
                               
              </table>
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
