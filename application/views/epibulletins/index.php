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
								<li class="active">Epi bulletins</li>
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
										Reports
										<small>
											<i class="icon-double-angle-right"></i>
											Epi bulletins
										</small>
									</h1>
								</div>
                                 <?php if (getRole() == 'SuperAdmin' || getRole() == 'Admin'){
						?>
								<p>
									   <a href="<?php echo base_url() ?>index.php/epibulletins/add" class="btn btn-primary">
										<i class="icon-edit bigger-110"></i>
										Add
										
									</a>
								</p>
                                <?php
								 }
								 ?>
                                 
                                 <?php
    	if(!empty($error_message))
		{
		?>
        <div class="alert alert-block alert-error">
        <button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>
		<p>
											<strong>
												<i class="icon-remove"></i>
												&nbsp;
											</strong>
											<?php echo $error_message;?>
		</p>
        </div>
	   <?php
	   }
	   ?>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Week no</th>
<th>Week year</th>
<th>Period From</th>
<th>Period To</th>
<th>Country</th>
<th>Creation Date</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->week_no; ?></td>
<td><?php echo $row->week_year; ?></td>
<td><?php echo $row->from_date; ?></td>
<td><?php echo $row->to_date; ?></td>
<td><?php 
$country = $this->countriesmodel->get_by_id($row->country_id)->row(); 
echo $country->country_name;?></td>
<td><?php echo $row->creation_date_time; ?></td>
<td>
<?php if (getRole() == 'SuperAdmin' || getRole() == 'Admin'){
?>
<a href="<?php echo base_url() ?>index.php/epibulletins/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
 <span class="green">
 <i class="icon-edit bigger-120"></i>

																	</span></a>
<?php
	 }
?>
  <a href="<?php echo base_url() ?>index.php/epibulletins/downloadpdf/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Download" target="_blank">
 <span class="green">
 <i class="icon-download bigger-120"></i>

																	</span></a>                                                                  
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
