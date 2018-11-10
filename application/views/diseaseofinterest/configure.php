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
								<li class="active">Priority Diseases</li>
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
										Disease Settings
										<small>
											<i class="icon-double-angle-right"></i>
											Priority Diseases
										</small>
									</h1>
								</div>
<?php if(validation_errors()){?>
<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
<?php } ?>
<?php $attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data');?>
<?php echo form_open('diseaseofinterest/edit_validate',$attributes); ?>
<div class="row-fluid">

<div class="span12">
									<div class="widget-box">
										<div class="widget-header">
											<h4 class="smaller">Select Country Priority Diseases</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
											<?php
                                            foreach ($diseases->result() as $disease):
											
											$priority = $this->db->get_where('diseaseofinterest', array('country_id' => $country_id,'disease_id'=>$disease->id),1);
											
											$priority = $this->diseaseofinterestmodel->get_country_disease($country_id,$disease->id);
											
											if(empty($priority))
											{
												$checked = '';
											}
											else
											{
												$checked = 'checked="checked"';
											}
	   
											?>
                                            <div class="control-group">
											                                         

											<div class="controls">
												<label>
													<input name="disease_<?php echo $disease->id;?>" type="checkbox" <?php echo $checked; ?> value="<?php echo $disease->id;?>" />
													<span class="lbl"> <?php echo $disease->disease_name;?> (<?php echo $disease->disease_code;?>)</span>
												</label>
                                             </div>
                                                
                                            </div>
                                            
                                            <?php
											
												   
										    endforeach;
                                            
                                            ?>
												
											</div>
										</div>
									</div>
								</div>




</div>	
<div class="form-actions"><?php echo form_submit('submit', 'SAVE PRIORITY DISEASES', 'class="btn btn-info "'); ?></div>
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
