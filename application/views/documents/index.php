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

						<li class="active">Information Resources</li>
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
								Information Resources
							</small>
						</h1>
					</div><!--/.page-header-->
                    <?php
					if($level==5)
					{
						//show nothing
					}
					else
					{
					?>
                    <p>
                    <a href="<?php echo base_url() ?>index.php/documents/add" class="btn btn-primary">
										<i class="icon-edit bigger-230"></i>
										Add
										
									</a>
                    </p>
                    <?php
					}
					?>
                         	
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Title</th>
<th>Level</th>
<th>Date added</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->title; ?></td>
<td><?php 
$nationality = $this->countriesmodel->get_by_id($row->country_id)->row();
if($row->level==1) 
{
	echo 'National';
}
elseif($row->level==2) 
{
	echo $nationality->first_admin_level_label;
}
elseif($row->level==3) 
{
	echo $nationality->second_admin_level_label;
}
elseif($row->level==4) 
{
	echo 'Health Facility';
}
elseif($row->level==6) 
{
	echo $nationality->third_admin_level_label;
}
elseif($row->level==5) 
{
	echo 'Stake holder';
}

?></td>
<td><?php echo date("d F Y", strtotime($row->date_added)); ?></td>
<td><a href="<?php echo base_url() ?>documents/<?php echo $row->docname; ?>" class="tooltip-info" data-rel="tooltip" title="View" target="_blank">
																		<span class="blue">
																			<i class="icon-zoom-in bigger-120"></i>
																		</span>
																	</a>
                                                                     <?php
					if($level==5)
					{
						//show nothing
					}
					else
					{
					?>
                                                                    &nbsp;&nbsp;<a href="<?php echo base_url() ?>index.php/documents/edit/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a>&nbsp;&nbsp;
                                                           
																<a href="<?php echo base_url() ?>index.php/documents/delete/<?php echo $row->id; ?>" class="tooltip-error" data-rel="tooltip" title="Delete" onClick="return confirm('Are you sure you want to delete? This action is not reversable')">
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
</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>
