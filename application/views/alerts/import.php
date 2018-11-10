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
								<li class="active">calls</li>
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
										System
										<small>
											<i class="icon-double-angle-right"></i>
											Imports
										</small>
									</h1>
								</div>
                              
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php

if(!empty($error))
{
	?>
    <p><div class="alert alert-danger"> <?php echo $error; ?></div></p>
    <?php
}
?>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('dataimport/import',$attributes); ?>


<div class="control-group"><label class="control-label" for="form-field-1">Upload File: </label><div class="controls">

												<div class="widget-main">
													<input type="file" name="userfile" id="id-input-file-2" />
																										
												</div>
                                               

</div>
</div>
<div class="form-actions"><?php echo form_submit('submit', 'Upload', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>  

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
