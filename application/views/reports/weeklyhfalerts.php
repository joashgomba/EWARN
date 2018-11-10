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

						<li class="active">Weekly HF Cases</li>
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
								Weekly HF Alerts &amp; Cases
							</small>
						</h1>
					</div><!--/.page-header-->
                
                      
                       <table id="customers">
                               <thead>
                               		<tr><th colspan="2">Weekly HF Alerts &amp; Cases from <?php echo $reporting_year;?>/<?php echo $from;?> - <?php echo $reporting_year2;?>/<?php echo $to;?></th></tr>
                               </thead>
                               <tbody>
                               <tr class="alt"><td colspan="2"><strong>Zone:</strong> <?php echo $zone;?>  <strong>Region:</strong> <?php echo $region;?> <strong>District:</strong> <?php echo $district;?>  <strong>Health Facility:</strong> <?php echo $healthfacility;?></td></tr>
                               <tr><td><?php echo $alertstable;?></td></tr>
                               <tr><td><?php echo $alertsbtable;?></td></tr>
                               <tr><td><?php echo $tbl;?></td></tr>
                              <tr><td><?php echo $typebtable;?></td></tr>
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
