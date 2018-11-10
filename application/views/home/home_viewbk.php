<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:70%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #000000;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
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

						<li class="active">Dashboard</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <center>
                             <?php
							if($level==3 || $level==2 || $level==1)
							{
								?>
                                <p>
                                <table id="listtable">
                            <tr><th colspan="3"><strong>Latest 5 National Weekly Reports</strong></th></tr>
                            <tr><th>Week No.</th><th>Week Year</th><th>Download</th></tr>
                            <?php 
							$class = 'class="alt"';
							foreach ($primaryrows->result() as $primaryrow): 
							if($class == 'class="alt"')
							{
								$class = '';
							}
							else
							{
								$class = 'class="alt"';
							}
							?>
                            <tr <?php echo $class;?>><td><?php echo $primaryrow->week_no; ?></td><td><?php echo $primaryrow->week_year; ?></td><td> 
                
                                                                  <a href="<?php echo base_url() ?>index.php/bulletins/nationalbulletin/<?php echo $primaryrow->id; ?>" class="tooltip-success" data-rel="tooltip" title="Bulletin" target="_blank">
																	<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																</a>
</td>
                                                               </tr>
                            <?php endforeach; ?>
                            </table> 
                            </p>
                                <?php
							}							
							?>
                            <p>
                            
							<table id="listtable">
                            <tr><th colspan="3"><strong>Latest 5 <?php echo $title;?> Weekly Reports</strong></th></tr>
                            <tr><th>Week No.</th><th>Week Year</th><th>Download</th></tr>
                            <?php 
							$class = 'class="alt"';
							foreach ($rows->result() as $row): 
							if($class == 'class="alt"')
							{
								$class = '';
							}
							else
							{
								$class = 'class="alt"';
							}
							?>
                            <tr <?php echo $class;?>><td><?php echo $row->week_no; ?></td><td><?php echo $row->week_year; ?></td><td> 
                            <!--<a href="<?php echo base_url() ?>index.php/bulletins/national_bulettin_pdf/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Bulletin" target="_blank">
																	<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																</a>-->
                                                                  <a href="<?php echo base_url() ?>index.php/bulletins/nationalbulletin/<?php echo $row->id; ?>" class="tooltip-success" data-rel="tooltip" title="Bulletin" target="_blank">
																	<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																</a>
</td>
                                                                </tr>
                            <?php endforeach; ?>
                            </table> 
                            </p>
                             <?php
							if($level==3 || $level==2 || $level==1)
							{
							?>
                               <p>
                            <table id="listtable">
                            <tr><th colspan="3"><strong>Latest 5 National Information Resources</strong></th></tr>
                            <tr><th>Document Title</th><th>Download</th></tr>
                            <?php 
							$class = 'class="alt"';
							foreach ($primarydocs->result() as $primarydoc): 
							if($class == 'class="alt"')
							{
								$class = '';
							}
							else
							{
								$class = 'class="alt"';
							}
							?>
                            <tr <?php echo $class;?>><td><?php echo $primarydoc->title; ?></td><td> <a href="<?php echo base_url() ?>documents/<?php echo $primarydoc->docname; ?>" class="tooltip-info" data-rel="tooltip" title="View" target="_blank">
																		<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																	</a></td></tr>
                            <?php endforeach; ?>
                            </table>
                            </p> 
                                
                            <?php
							}
							?>
                            <p>
                            <table id="listtable">
                            <tr><th colspan="3"><strong>Latest 5 <?php echo $title;?> Information Resources</strong></th></tr>
                            <tr><th>Document Title</th><th>Download</th></tr>
                            <?php 
							$class = 'class="alt"';
							foreach ($documents->result() as $document): 
							if($class == 'class="alt"')
							{
								$class = '';
							}
							else
							{
								$class = 'class="alt"';
							}
							?>
                            <tr <?php echo $class;?>><td><?php echo $document->title; ?></td><td> <a href="<?php echo base_url() ?>documents/<?php echo $document->docname; ?>" class="tooltip-info" data-rel="tooltip" title="View" target="_blank">
																		<span class="blue">
																		<i class="icon-book bigger-120"></i>
																	</span>
																	</a></td></tr>
                            <?php endforeach; ?>
                            </table>
                            </p>
                            </center>
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
