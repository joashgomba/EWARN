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
                    <p>
                    <a href="<?php echo base_url() ?>index.php/bulletins/addregional" class="btn btn-app btn-primary no-radius">
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
<th>Period From</th>
<th>Period To</th>
<th>Issue No</th>
<th>Region</th>
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
<td><?php echo $row->period_from; ?></td>
<td><?php echo $row->period_to; ?></td>
<td><?php echo $row->issue_no; ?></td>
<td><?php echo $row->region; ?></td>
<td><?php echo $row->creation_date_time; ?></td>
<td>
<a href="<?php echo base_url() ?>index.php/bulletins/editregional/<?php echo $row->bulletin_id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                                <a href="<?php echo base_url() ?>index.php/bulletins/regionsbulletin/<?php echo $row->bulletin_id; ?>" class="tooltip-success" data-rel="tooltip" title="Bulletin" target="_blank">
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