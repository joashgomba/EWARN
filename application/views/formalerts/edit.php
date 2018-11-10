<?php include(APPPATH . 'views/common/header.php'); ?>
<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:50%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#0000CC;
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

						<li class="active">Alerts</li>
					</ul><!--.breadcrumb-->

					
				</div>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->
                            <div class="page-header position-relative">
						<h1>
							EWARN
							<small>
								<i class="icon-double-angle-right"></i>
								Alerts
							</small>
						</h1>
					</div><!--/.page-header-->
                    
                         	<?php
				if(validation_errors())
				{
					?>
					<p><div class="alert alert-danger"> <?php echo validation_errors(); ?></div></p>
					<?php
				}
				?>
                           <?php echo form_open('formalerts/edit_validate/'.$row->id); ?>
                           
                           <table id="listtable">
                           <tbody>
                           <tr><td>Week No.:</td><td><?php echo $reportingperiod->week_no;?>/<?php echo $reportingperiod->epdyear;?>
                           <input type="hidden" name="week_no" value="<?php echo $reportingperiod->week_no;?>">
                           <input type="hidden" name="year_no" value="<?php echo $reportingperiod->epdyear;?>">
                           </td></tr>
                            <tr><td>Disease name: </td><td><?php echo $row->disease_name; ?><?php $data = array('type'=> 'hidden','id' => 'disease_name', 'name' => 'disease_name', 'value' => $row->disease_name); echo form_input($data, set_value('disease_name')); ?></td></tr>
                            <tr><td>District:</td><td><?php echo $district->district;?></td></tr>
                            <tr><td>Region:</td><td><?php echo $region->region;?></td></tr>
                            <tr><td>Zone:</td><td><?php echo $zone->zone;?></td></tr>
                            <tr><td>Cases:</td><td><?php $data = array('id' => 'cases', 'name' => 'cases', 'value' => $row->cases); echo form_input($data, set_value('cases')); ?></td></tr>
                            <tr><td>Deaths:</td><td><?php $data = array('id' => 'deaths', 'name' => 'deaths', 'value' => $row->deaths); echo form_input($data, set_value('deaths')); ?></td></tr>
                            <tr><td valign="top">Notes:</td><td><?php $data = array('id' => 'notes', 'name' => 'notes', 'value' => $row->notes); echo form_textarea($data, set_value('notes')); ?></td></tr>
                            <tr><td valign="top">Verification Status:</td><td>
							<select name="verification_status" id="verification_status">
                            	<option value="1" <?php if($row->verification_status==1){ echo 'selected="selected"';}?>>TRUE</option>
                                <option value="0"  <?php if($row->verification_status==0){ echo 'selected="selected"';}?>>FALSE</option>
                            </select>
                            </td></tr>
                            <tr><td valign="top">Bulletin include:</td><td>
							<select name="include_bulletin" id="include_bulletin">
                            <option value="1" <?php if($row->include_bulletin==1){ echo 'selected="selected"';}?>>TRUE</option>
                                <option value="0"  <?php if($row->include_bulletin==0){ echo 'selected="selected"';}?>>FALSE</option>
                            </select>
                            </td></tr>
                            <tr><td valign="top">Outcome:</td><td>
							<select name="outcome" id="outcome">
                            <option value="1" <?php if($row->outcome==1){ echo 'selected="selected"';}?>>Alert</option>
                                <option value="2"  <?php if($row->outcome==2){ echo 'selected="selected"';}?>>Outbreak</option>
                                <option value="3"  <?php if($row->outcome==3){ echo 'selected="selected"';}?>>Investigation Underway</option>
                            </select>
                            </td></tr>
                           </tbody>
                           </table>

<div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
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
