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
							Staff Portal
							<small>
								<i class="icon-double-angle-right"></i>
								Profile
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
<?php echo form_open('profiles/edit_validate/'.$row->id); ?>
<div class="control-group"><label>User id: </label><div class="controls"><?php $data = array('id' => 'user_id', 'name' => 'user_id', 'value' => $row->user_id); echo form_input($data, set_value('user_id')); ?></div>
</div><div class="control-group"><label>Date of birth: </label><div class="controls"><?php $data = array('id' => 'date_of_birth', 'name' => 'date_of_birth', 'value' => $row->date_of_birth); echo form_input($data, set_value('date_of_birth')); ?></div>
</div><div class="control-group"><label>Address: </label><div class="controls"><?php $data = array('id' => 'address', 'name' => 'address', 'value' => $row->address); echo form_input($data, set_value('address')); ?></div>
</div><div class="control-group"><label>Post code: </label><div class="controls"><?php $data = array('id' => 'post_code', 'name' => 'post_code', 'value' => $row->post_code); echo form_input($data, set_value('post_code')); ?></div>
</div><div class="control-group"><label>City: </label><div class="controls"><?php $data = array('id' => 'city', 'name' => 'city', 'value' => $row->city); echo form_input($data, set_value('city')); ?></div>
</div><div class="control-group"><label>Country: </label><div class="controls"><?php $data = array('id' => 'country', 'name' => 'country', 'value' => $row->country); echo form_input($data, set_value('country')); ?></div>
</div><div class="control-group"><label>Telephone: </label><div class="controls"><?php $data = array('id' => 'telephone', 'name' => 'telephone', 'value' => $row->telephone); echo form_input($data, set_value('telephone')); ?></div>
</div><div class="control-group"><label>Extension: </label><div class="controls"><?php $data = array('id' => 'extension', 'name' => 'extension', 'value' => $row->extension); echo form_input($data, set_value('extension')); ?></div>
</div><div class="control-group"><label>Mobile: </label><div class="controls"><?php $data = array('id' => 'mobile', 'name' => 'mobile', 'value' => $row->mobile); echo form_input($data, set_value('mobile')); ?></div>
</div><div class="control-group"><label>Official email: </label><div class="controls"><?php $data = array('id' => 'official_email', 'name' => 'official_email', 'value' => $row->official_email); echo form_input($data, set_value('official_email')); ?></div>
</div><div class="control-group"><label>Personal email: </label><div class="controls"><?php $data = array('id' => 'personal_email', 'name' => 'personal_email', 'value' => $row->personal_email); echo form_input($data, set_value('personal_email')); ?></div>
</div><div class="control-group"><label>Facebook: </label><div class="controls"><?php $data = array('id' => 'facebook', 'name' => 'facebook', 'value' => $row->facebook); echo form_input($data, set_value('facebook')); ?></div>
</div><div class="control-group"><label>Twitter: </label><div class="controls"><?php $data = array('id' => 'twitter', 'name' => 'twitter', 'value' => $row->twitter); echo form_input($data, set_value('twitter')); ?></div>
</div><div class="control-group"><label>Google plus: </label><div class="controls"><?php $data = array('id' => 'google_plus', 'name' => 'google_plus', 'value' => $row->google_plus); echo form_input($data, set_value('google_plus')); ?></div>
</div><div class="control-group"><label>Residential address: </label><div class="controls"><?php $data = array('id' => 'residential_address', 'name' => 'residential_address', 'value' => $row->residential_address); echo form_input($data, set_value('residential_address')); ?></div>
</div><div class="control-group"><label>Photo: </label><div class="controls"><?php $data = array('id' => 'photo', 'name' => 'photo', 'value' => $row->photo); echo form_input($data, set_value('photo')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
		</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php include(APPPATH . 'views/common/settingscontainer.php'); ?>
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<?php include(APPPATH . 'views/common/footer.php'); ?>
	</body>
</html>

