<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
/* Make Table Responsive --- */
@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px)  {
.display table, .display thead, .display th, .display tr, .display td {
display: block;
}
/* Hide table headers (but not display:none, for accessibility) */
.display thead tr {
position: absolute;
top: -9999px;
left: -9999px;
}
.display tr {
border: 1px solid #ccc;
}
.display td {
/* Behave like a row */
border: none;
padding-left: 50%;
border-bottom: 1px solid #eee;
position: relative;
}
.display td:before {
/* Now, like a table header */
/**position: absolute;**/
/* Top / left values mimic padding */
top: 6px; left: 6px;
width: 45%;
padding-right: 10px;
font-weight:bold;
white-space: nowrap;
}
/* -- LABEL THE DATA -- */
.display td:nth-of-type(1):before { content: "Id"; }
.display td:nth-of-type(2):before { content: "Week no"; }
.display td:nth-of-type(3):before { content: "Reporting year"; }
.display td:nth-of-type(4):before { content: "Reporting date"; }
.display td:nth-of-type(5):before { content: "Health facility"; }
.display td:nth-of-type(6):before { content: "Actions"; }
 
}/* End responsive query */

</style>
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

						<li class="active">Reporting Form</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							Data Entry
							<small>
								<i class="icon-double-angle-right"></i>
								Reporting Form
							</small>
						</h1>
					</div><!--/.page-header-->
                    <p>
                    <a href="<?php echo base_url() ?>index.php/reportingforms/add" class="btn btn-app btn-primary no-radius">
										<i class="icon-edit bigger-230"></i>
										Add New
										
									</a>
                    </p>
                     <?php
    	if(!empty($alert_message))
		{
		?>
		
   <p> <div class="alert alert-danger"> <?php echo $alert_message;?></div></p>
	   <?php
	   }
	   ?>
        <?php
    	if(!empty($sucsess_message))
		{
		?>
        <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>
		<p>
											<strong>
												<i class="icon-ok"></i>
												&nbsp;
											</strong>
											<?php echo $sucsess_message;?>
		</p>
        </div>
	   <?php
	   }
	   ?>
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Week no</th>
<th>Reporting year</th>
<th>Reporting date</th>
<th>Health facility</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->reportingform_id; ?></td>
<td><?php echo $row->week_no; ?></td>
<td><?php echo $row->reporting_year; ?></td>
<td><?php echo $row->reporting_date; ?></td>
<td><?php echo $row->health_facility; ?></td>
<td>
<!--<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																		<span class="blue">
																			<i class="icon-zoom-in bigger-120"></i>
																		</span>
																	</a>&nbsp;&nbsp;-->
                                                                    <?php
																	if($row->approved_regional==1)
																	{
																		?>
                                                                        <a href="<?php echo base_url() ?>index.php/reportingforms/edit/<?php echo $row->reportingform_id; ?>" class="tooltip-info" data-rel="tooltip" title="View">
																		<span class="blue">
																			<i class="icon-zoom-in bigger-120"></i>
																		</span>
																	</a>&nbsp;&nbsp;
                                                                        <?php
																	}
																	else
																	{
																	?>
<a href="<?php echo base_url() ?>index.php/reportingforms/edit/<?php echo $row->reportingform_id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                                <?php
																	}
																	?>
                                                            <?php
$atts = array(
		              'width'      => '600',
		              'height'     => '500',
		              'scrollbars' => 'yes',
		              'status'     => 'no',
		              'resizable'  => 'yes',
		              'screenx'    => '0',
		              'screeny'    => '0',
					  'class'    => 'stooltip-info',
					  'data-rel'    => 'tooltip',
					  'title'    => 'Audit Trail'
					  
		            );
$url = 'audittrail/reportformlist/'.$row->reportingform_id;

$linktext = '<span class="blue">
			<i class="icon-eye-open bigger-120"></i>
			</span>';
$viewlink = anchor_popup($url, $linktext, $atts);

echo $viewlink;
?>
                                                              <?php
																	if($row->approved_regional==1)
																	{
																		
																	}
																	else
																	{
																	?>
                                                                    &nbsp;&nbsp;
																<a href="<?php echo base_url() ?>index.php/reportingforms/delete/<?php echo $row->reportingform_id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
																	<span class="red">
																		<i class="icon-trash bigger-120"></i>
																	</span>
																</a>
                                                               <?php
																	}
															   ?>
                                                                
                                                                </td>
</tr>
<?php endforeach; ?>
</tbody>
</table> 	
                           
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
