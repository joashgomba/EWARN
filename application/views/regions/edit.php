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

						<li class="active"><?php echo $user_country->second_admin_level_label;?></li>
					</ul><!--.breadcrumb-->

					
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
								<?php echo $user_country->second_admin_level_label;?>
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
                       <?php echo form_open('regions/edit_validate/'.$row->id); ?>
<div class="control-group"><label><?php echo $user_country->second_admin_level_label;?>: </label><div class="controls"><?php $data = array('id' => 'region', 'name' => 'region', 'value' => $row->region); echo form_input($data, set_value('region')); ?></div>
</div><div class="control-group"><label>Regional code: </label><div class="controls"><?php $data = array('id' => 'regional_code', 'name' => 'regional_code', 'value' => $row->regional_code); echo form_input($data, set_value('regional_code')); ?></div>
</div><div class="control-group"><label><?php echo $user_country->first_admin_level_label;?>: </label><div class="controls">
<select name="zone_id" id="zone_id">
<?php
foreach($zones as $key => $zone)
{
	?>
    <option value="<?php echo $zone['id'];?>" <?php if($zone['id']==$row->zone_id){ echo 'selected="selected"';}?> ><?php echo $zone['zone'];?></option>
    <?php
}
?>
</select>
</div>
</div>


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
