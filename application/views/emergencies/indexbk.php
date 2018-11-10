<?php include(APPPATH . 'views/common/header.php'); ?>
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
								<li class="active">emergencies</li>
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
										Data entry
										<small>
											<i class="icon-double-angle-right"></i>
											Emergencies
										</small>
									</h1>
								</div>
								<p>
									<a href="<?php echo base_url() ?>emergencies/add" class="btn btn-primary">
									<i class="icon-edit bigger-230"></i>
									Add
									</a>
								</p>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Healthfacility id</th>
<th>District id</th>
<th>Region id</th>
<th>Zone id</th>
<th>Country id</th>
<th>Week no</th>
<th>Reporting year</th>
<th>Epicalendar id</th>
<th>Reporting date</th>
<th>User id</th>
<th>Disease id</th>
<th>Male under five</th>
<th>Female under five</th>
<th>Male over five</th>
<th>Female over five</th>
<th>Other</th>
<th>Death</th>
<th>Action taken</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->healthfacility_id; ?></td>
<td><?php echo $row->district_id; ?></td>
<td><?php echo $row->region_id; ?></td>
<td><?php echo $row->zone_id; ?></td>
<td><?php echo $row->country_id; ?></td>
<td><?php echo $row->week_no; ?></td>
<td><?php echo $row->reporting_year; ?></td>
<td><?php echo $row->epicalendar_id; ?></td>
<td><?php echo $row->reporting_date; ?></td>
<td><?php echo $row->user_id; ?></td>
<td><?php echo $row->disease_id; ?></td>
<td><?php echo $row->male_under_five; ?></td>
<td><?php echo $row->female_under_five; ?></td>
<td><?php echo $row->male_over_five; ?></td>
<td><?php echo $row->female_over_five; ?></td>
<td><?php echo $row->other; ?></td>
<td><?php echo $row->death; ?></td>
<td><?php echo $row->action_taken; ?></td>
<td><a href="<?php echo base_url() ?>emergencies/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
 <span class="green">
 <i class="icon-edit bigger-120"></i>

																	</span></a>&nbsp;&nbsp;<a href="<?php echo base_url() ?>emergencies/delete/<?php echo $row->id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
 <span class="red">

																		<i class="icon-trash bigger-120"></i>

																	</span></a></td>
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
