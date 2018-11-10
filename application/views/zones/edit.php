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

						<li class="active">Zones</li>
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
								Zones
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
                         <?php echo form_open('zones/edit_validate/'.$row->id); ?>
<div class="control-group"><label>Zone: </label><div class="controls"><?php $data = array('id' => 'zone', 'name' => 'zone', 'value' => $row->zone); echo form_input($data, set_value('zone')); ?></div>
</div><div class="control-group"><label>Zonal code: </label><div class="controls"><?php $data = array('id' => 'zonal_code', 'name' => 'zonal_code', 'value' => $row->zonal_code); echo form_input($data, set_value('zonal_code')); ?></div>
</div>
<div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls">
<?php

if (getRole() == 'Admin')
{
	
	?>
     <select name="country_id" id="country_id" onChange="GetZones(this)" required="required">
    <option value=""> - Select Country - </option>
     <option value="<?php echo $country->id;?>"  <?php if($country->id==$row->country_id){ echo 'selected="selected"';}?>> <?php echo $country->country_name;?> </option>
    
     </select>
    <?php
}
else
{
	?>
   
<select name="country_id" id="country_id" onChange="GetZones(this)" required="required">
    <option value=""> - Select Country - </option>
    <?php
	foreach($countries as $key=>$country)
	{
		?>
        <option value="<?php echo $country['id'];?>"  <?php if($country['id']==$row->country_id){ echo 'selected="selected"';}?>> <?php echo $country['country_name'];?> </option>
        <?php
	}
	?>
    </select>
    <?php
}
?>


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
