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

						<li class="active">Alerts</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							eDEWS
							<small>
								<i class="icon-double-angle-right"></i>
								Alerts
							</small>
						</h1>
					</div><!--/.page-header-->
                 
                  <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
                <thead>
                <tr>
                <th>Id</th>
                <th>Reportingform id</th>
                <th>Disease name</th>
                <th>Healthfacility id</th>
                <th>District id</th>
                <th>Region id</th>
                <th>Zone id</th>
                <th>Cases</th>
                <th>Deaths</th>
                <th>Notes</th>
                <th>Verification status</th>
                <th>Include bulletin</th>
                <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows->result() as $row): ?>
                <tr>
                <td><?php echo $row->id; ?></td>
                <td><?php echo $row->reportingform_id; ?></td>
                <td><?php echo $row->disease_name; ?></td>
                <td><?php echo $row->healthfacility_id; ?></td>
                <td><?php echo $row->district_id; ?></td>
                <td><?php echo $row->region_id; ?></td>
                <td><?php echo $row->zone_id; ?></td>
                <td><?php echo $row->cases; ?></td>
                <td><?php echo $row->deaths; ?></td>
                <td><?php echo $row->notes; ?></td>
                <td><?php echo $row->verification_status; ?></td>
                <td><?php echo $row->include_bulletin; ?></td>
                <td><a href="<?php echo base_url() ?>alerts/edit/<?php echo $row->id; ?>">Edit</a> <a href="<?php echo base_url() ?>alerts/delete/<?php echo $row->id; ?>">Delete</a></td>
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
