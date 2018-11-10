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
								<li class="active">Countries</li>
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
										Registration
										<small>
											<i class="icon-double-angle-right"></i>
											Countries
										</small>
									</h1>
								</div>
								<p>
									<a href="<?php echo base_url() ?>index.php/countries/add"  class="btn btn-primary">
										<i class="icon-edit bigger-110"></i>
									Add
									</a>
								</p>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Country name</th>
<th>Country code</th>
<th>First admin level label</th>
<th>Second admin level label</th>
<th>Third admin level label</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->country_name; ?></td>
<td><?php echo $row->country_code; ?></td>
<td><?php echo $row->first_admin_level_label; ?></td>
<td><?php echo $row->second_admin_level_label; ?></td>
<td><?php echo $row->third_admin_level_label; ?></td>
<td><a href="<?php echo base_url() ?>index.php/countries/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
 <span class="green">
 <i class="icon-edit bigger-120"></i>

																	</span></a><!--&nbsp;&nbsp;<a href="<?php echo base_url() ?>countries/delete/<?php echo $row->id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
 <span class="red">

																		<i class="icon-trash bigger-120"></i>

																	</span></a>--></td>
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
