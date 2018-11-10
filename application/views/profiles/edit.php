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

						<li class="active">Profile</li>
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
								<?php echo $user->fname;?> <?php echo $user->lname;?>
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
<?php 

if(empty($row->id))
{
	$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data'); 
	echo form_open('profiles/add_validate',$attributes);
}
else
{
	$attributes = array('name' => 'frm', 'id' => 'frm', 'enctype' => 'multipart/form-data'); 
	echo form_open('profiles/edit_validate/'.$row->id.'',$attributes);
}?>
	
									<div class="widget-box">
										<div class="widget-header">
											<h5 class="smaller">&nbsp;</h5>
    <div class="widget-toolbar no-border">
												<ul class="nav nav-tabs" id="myTab">
													<li class="active">
														<a data-toggle="tab" href="#home"><i class="green icon-edit bigger-125"></i>
															Basic Info</a>
                                                        
													</li>

													<li>
														<a data-toggle="tab" href="#profile">
                                                        <i class="purple icon-user bigger-125"></i>
                                                        About Me</a>
													</li>

													<li>
														<a data-toggle="tab" href="#info"><i class="blue icon-key bigger-125"></i>
															Password</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="widget-body">
											<div class="widget-main padding-6">
												<div class="tab-content">
													<div id="home" class="tab-pane in active">
														
                                                        <h4 class="header blue bolder smaller">General</h4>

														<div class="row-fluid">
															<div class="span4">
                                                            <span class="profile-picture">
                                                         <?php
														 if(!empty($row->photo))
														 {
														 ?>
												<img id="avatar" class="editable" alt="Alex's Avatar" src="<?php echo base_url(); ?>profilepics/<?php echo $row->photo;?>" />
                                                <?php
														 }
														 else
														 {
															 ?>
                                                   						<img id="avatar" class="editable" alt="Alex's Avatar" src="<?php echo base_url(); ?>profilepics/one22.jpg" />
                                                                        <?php
														 }
														 ?>
											</span>
															<br>Change profile picture:<input type="file" name="userfile" id="userfile" />
															</div>

															<div class="vspace"></div>

															<div class="span8">
																<div class="control-group">
																	<label class="control-label" for="form-field-username">Username</label>

																	<div class="controls">
																		<input type="text" placeholder="Username" value="<?php echo $user->username;?>" name="username" id="username" />
																	</div>
																</div>

																<div class="control-group">
																	<label class="control-label" for="form-field-first">Name</label>

																	<div class="controls">
																		<input class="input-small" type="text" id="form-field-first" placeholder="First Name" name="fname" value="<?php echo $user->fname;?>" />
																		<input class="input-small" type="text" id="form-field-last" placeholder="Last Name" name="lname" value="<?php echo $user->lname;?>" />
                                                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id;?>">
																	</div>
																</div>
															</div>
														</div>

														<hr />
														<div class="control-group">
															<label class="control-label" for="form-field-date">Birth Date</label>

															<div class="controls">
																<div class="input-append">
                                                                
                                                                <?php
																if(empty($row->date_of_birth))
																{
																	?>
                                                                   <input name="date_of_birth" class="input-small date-picker" id="form-field-date" type="text" value="" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" /> 
                                                                    <?php
																}
																else
																{
																?>
																	<input name="date_of_birth" class="input-small date-picker" id="form-field-date" type="text" value="<?php echo $row->date_of_birth;?>" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" />
                                                                    <?php
																}
																?>
																	<span class="add-on">
																		<i class="icon-calendar"></i>
																	</span>
																</div>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label">Gender</label>

															<div class="controls">
																<div class="space-2"></div>
                                                                <?php
																if(empty($row->date_of_birth))
																{
																	?>
                                                                   <label class="inline">
																	<input name="gender" type="radio" value="M" />
																	<span class="lbl"> Male</span>
																</label>

																&nbsp; &nbsp; &nbsp;
																<label class="inline">
																	<input name="gender" type="radio" value="F" />
																	<span class="lbl"> Female</span>
																</label> 
                                                                    <?php
																}
																else
																{
																?>

																<label class="inline">
																	<input name="gender" type="radio" value="M" <?php if($row->gender=='M'){ echo 'checked="checked"';}?> />
																	<span class="lbl"> Male</span>
																</label>

																&nbsp; &nbsp; &nbsp;
																<label class="inline">
																	<input name="gender" type="radio" value="F" <?php if($row->gender=='F'){ echo 'checked="checked"';}?> />
																	<span class="lbl"> Female</span>
																</label>
                                                                <?php
																}
																?>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="form-field-comment">Address</label>

															<div class="controls">
                                                             <?php
																if(empty($row->address))
																{
																	 $data = array('id' => 'address', 'name' => 'address'); echo form_input($data, set_value('address')); 
                                                                    
																}
																else
																{
																	 $data = array('id' => 'address', 'name' => 'address', 'value' => $row->address); echo form_input($data, set_value('address')); 
                                                                
                                                                
																}
																?>
															</div>
														</div>
                                                        <div class="control-group"><label>Post code: </label><div class="controls"><?php 
														if(empty($row->post_code))
														{
															$data = array('id' => 'post_code', 'name' => 'post_code'); echo form_input($data, set_value('post_code')); 
														}
														else
														{
															$data = array('id' => 'post_code', 'name' => 'post_code', 'value' => $row->post_code); echo form_input($data, set_value('post_code')); 
														}?></div>
</div>
<div class="control-group"><label>City: </label><div class="controls"><?php 
if(empty($row->city))
{
	$data = array('id' => 'city', 'name' => 'city'); echo form_input($data, set_value('city'));
}
else
{
	$data = array('id' => 'city', 'name' => 'city', 'value' => $row->city); echo form_input($data, set_value('city'));
}?></div>
</div><div class="control-group"><label>Country: </label><div class="controls"><?php 
if(empty($row->country))
{
	$data = array('id' => 'country', 'name' => 'country'); echo form_input($data, set_value('country'));
}
else
{
	$data = array('id' => 'country', 'name' => 'country', 'value' => $row->country); echo form_input($data, set_value('country'));
}?></div>
</div>

														<div class="space"></div>
														<h4 class="header blue bolder smaller">Contact</h4>

														<div class="control-group">
															<label class="control-label" for="form-field-email">Official Email</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
																	<?php 
if(empty($row->official_email))
{
	$data = array('id' => 'official_email', 'name' => 'official_email'); echo form_input($data, set_value('official_email'));
}
else
{
	$data = array('id' => 'official_email', 'name' => 'official_email', 'value' => $row->official_email); echo form_input($data, set_value('official_email'));
}
?>
																	<i class="icon-envelope"></i>
																</span>
															</div>
														</div>
                                                        <div class="control-group">
															<label class="control-label" for="form-field-email">Personal Email</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
																	<?php 
if(empty($row->personal_email))
{
	$data = array('id' => 'personal_email', 'name' => 'personal_email'); echo form_input($data, set_value('personal_email')); 
}
else
{
	$data = array('id' => 'personal_email', 'name' => 'personal_email', 'value' => $row->personal_email); echo form_input($data, set_value('personal_email')); 
}
?>
																	<i class="icon-envelope"></i>
																</span>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="form-field-phone">Phone</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
                                                                <?php 
if(empty($row->telephone))
{
	$data = array('id' => 'telephone', 'name' => 'telephone'); echo form_input($data, set_value('telephone'));
}
else
{
	$data = array('id' => 'telephone', 'name' => 'telephone', 'value' => $row->telephone); echo form_input($data, set_value('telephone'));
}
?>
																	
																	<i class="icon-phone icon-flip-horizontal"></i>
																</span>
															</div>
														</div>
                                                        <div class="control-group">
															<label class="control-label" for="form-field-phone">Extension</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
                                                                <?php 
if(empty($row->extension))
{
	$data = array('id' => 'extension', 'name' => 'extension'); echo form_input($data, set_value('extension')); 
}
else
{
	$data = array('id' => 'extension', 'name' => 'extension', 'value' => $row->extension); echo form_input($data, set_value('extension')); 
}
?>
																	
																	
																</span>
															</div>
														</div>
                                                          <div class="control-group">
															<label class="control-label" for="form-field-phone">Mobile</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
                                                                <?php 
if(empty($row->mobile))
{
	$data = array('id' => 'mobile', 'name' => 'mobile'); echo form_input($data, set_value('mobile'));
}
else
{
	$data = array('id' => 'mobile', 'name' => 'mobile', 'value' => $row->mobile); echo form_input($data, set_value('mobile'));
}
?>
																	
																	<i class="icon-phone icon-flip-horizontal"></i>
																</span>
															</div>
														</div>
                                                        <div class="control-group">
															<label class="control-label" for="form-field-phone">Residential Address</label>

															<div class="controls">
																<span class="input-icon input-icon-right">
                                                               <?php 
if(empty($row->residential_address))
{
	$data = array('id' => 'residential_address', 'name' => 'residential_address'); echo form_input($data, set_value('residential_address'));
}
else
{
	$data = array('id' => 'residential_address', 'name' => 'residential_address', 'value' => $row->residential_address); echo form_input($data, set_value('residential_address'));
}
?>	
																	<i class="icon-home icon-flip-horizontal"></i>
																</span>
															</div>
														</div>

														<div class="space"></div>

														<h4 class="header blue bolder smaller">Social</h4>

														<div class="control-group">
															<label class="control-label" for="form-field-facebook">Facebook</label>

															<div class="controls">
																<span class="input-icon">
																	<?php 
if(empty($row->facebook))
{
	$data = array('id' => 'facebook', 'name' => 'facebook'); echo form_input($data, set_value('facebook'));
}
else
{
	$data = array('id' => 'facebook', 'name' => 'facebook', 'value' => $row->facebook); echo form_input($data, set_value('facebook'));
}
?>
																	<i class="icon-facebook"></i>
																</span>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="form-field-twitter">Twitter</label>

															<div class="controls">
																<span class="input-icon">
																	<?php 
if(empty($row->twitter))
{
	$data = array('id' => 'twitter', 'name' => 'twitter'); echo form_input($data, set_value('twitter'));
}
else
{
	$data = array('id' => 'twitter', 'name' => 'twitter', 'value' => $row->twitter); echo form_input($data, set_value('twitter'));
}
?>
																	<i class="icon-twitter"></i>
																</span>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="form-field-gplus">Google+</label>

															<div class="controls">
																<span class="input-icon">
																	<?php 
if(empty($row->google_plus))
{
	$data = array('id' => 'google_plus', 'name' => 'google_plus'); echo form_input($data, set_value('google_plus'));
}
else
{
	$data = array('id' => 'google_plus', 'name' => 'google_plus', 'value' => $row->google_plus); echo form_input($data, set_value('google_plus'));
}
?>
																	<i class="icon-google-plus"></i>
																</span>
															</div>
														</div>
												
                                                        
                                                        
                                                        
                                                        
													</div>

													<div id="profile" class="tab-pane">
														<?php 
if(empty($row->about_me))
{
	$data = array('id' => 'about_me', 'name' => 'about_me'); echo form_textarea($data, set_value('about_me'));
}
else
{
	$data = array('id' => 'about_me', 'name' => 'about_me', 'value' => $row->about_me); echo form_textarea($data, set_value('about_me'));
}
?>
                                                        <script>
var glob3 = '';
$(document).ready(function()
{
 var editorpunt = CKEDITOR.replace('about_me');
 glob3 = editorpunt;
 
});

	
</script> 
													</div>

													<div id="info" class="tab-pane">
														<div class="control-group">
															<label class="control-label" for="form-field-pass1">New Password (If changing)</label>

															<div class="controls">
																<?php $data = array('id' => 'password', 'name' => 'password', 'type' => 'password'); echo form_input($data, set_value('password')); ?>
                                                                <input type="hidden" name="oldpassword" id="oldpassword" value="<?php echo $user->password;?>" />
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="form-field-pass2">Confirm Password</label>

															<div class="controls">
																<input type="password" id="form-field-pass2" name="confirmpassword"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
						
<div class="form-actions"><?php echo form_submit('submit', 'Update Profile', 'class="btn btn-info "'); ?></div>
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

