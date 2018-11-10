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
.display td:nth-of-type(2):before { content: "Week No"; }
.display td:nth-of-type(3):before { content: "Week Year"; }
.display td:nth-of-type(4):before { content: "Zone"; }
.display td:nth-of-type(5):before { content: "Period From"; }
.display td:nth-of-type(6):before { content: "Period To"; }
.display td:nth-of-type(7):before { content: "Issue No"; }
.display td:nth-of-type(8):before { content: "Creation Date Time"; }
.display td:nth-of-type(9):before { content: "Actions"; }
 
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

						<li class="active">Zonal Weekly Reports</li>
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
								Zonal Weekly Reports
							</small>
						</h1>
					</div><!--/.page-header-->
                    <p>
                    <a href="<?php echo base_url() ?>index.php/bulletins/addzonal" class="btn btn-app btn-primary no-radius">
										<i class="icon-edit bigger-230"></i>
										Add Bulletin
										
									</a>
                    </p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Week No</th>
<th>Week Year</th>
<th>Zone</th>
<th>Period From</th>
<th>Period To</th>
<th>Issue No</th>
<th>Creation Date Time</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->bulletin_id; ?></td>
<td><?php echo $row->week_no; ?></td>
<td><?php echo $row->week_year; ?></td>
<td><?php echo $row->zone; ?></td>
<td><?php echo $row->period_from; ?></td>
<td><?php echo $row->period_to; ?></td>
<td><?php echo $row->issue_no; ?></td>
<td><?php echo $row->creation_date_time; ?></td>
<td>
<a href="<?php echo base_url() ?>index.php/bulletins/zonal_edit/<?php echo $row->bulletin_id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                                <a href="<?php echo base_url() ?>index.php/bulletins/zonalbulletin/<?php echo $row->bulletin_id; ?>" class="tooltip-success" data-rel="tooltip" title="Bulletin" target="_blank">
																	<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>