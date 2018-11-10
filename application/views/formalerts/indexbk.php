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
								<li class="active">formalerts</li>
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
										PROJECT NAME
										<small>
											<i class="icon-double-angle-right"></i>
											formalerts
										</small>
									</h1>
								</div>
								<p>
									<a href="<?php echo base_url() ?>formalerts/add" class="btn btn-app btn-primary no-radius">
									<i class="icon-edit bigger-230"></i>
									Add
									</a>
								</p>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Reportingform id</th>
<th>Reportingperiod id</th>
<th>Disease id</th>
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
<th>Outcome</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->reportingform_id; ?></td>
<td><?php echo $row->reportingperiod_id; ?></td>
<td><?php echo $row->disease_id; ?></td>
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
<td><?php echo $row->outcome; ?></td>
<td><a href="<?php echo base_url() ?>formalerts/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
 <span class="green">
 <i class="icon-edit bigger-120"></i>

																	</span></a>&nbsp;&nbsp;<a href="<?php echo base_url() ?>formalerts/delete/<?php echo $row->id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
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
