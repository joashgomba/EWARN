<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/profiles.css" />
</head>
<br />
<h3>Add a Record</h3><br />
<?php echo form_open('profiles/add_validate'); ?>
<div class="control-group"><label class="control-label" for="form-field-1">User id: </label><div class="controls"><?php $data = array('id' => 'user_id', 'name' => 'user_id'); echo form_input($data, set_value('user_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Date of birth: </label><div class="controls"><?php $data = array('id' => 'date_of_birth', 'name' => 'date_of_birth'); echo form_input($data, set_value('date_of_birth')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Address: </label><div class="controls"><?php $data = array('id' => 'address', 'name' => 'address'); echo form_input($data, set_value('address')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Post code: </label><div class="controls"><?php $data = array('id' => 'post_code', 'name' => 'post_code'); echo form_input($data, set_value('post_code')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">City: </label><div class="controls"><?php $data = array('id' => 'city', 'name' => 'city'); echo form_input($data, set_value('city')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Country: </label><div class="controls"><?php $data = array('id' => 'country', 'name' => 'country'); echo form_input($data, set_value('country')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Telephone: </label><div class="controls"><?php $data = array('id' => 'telephone', 'name' => 'telephone'); echo form_input($data, set_value('telephone')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Extension: </label><div class="controls"><?php $data = array('id' => 'extension', 'name' => 'extension'); echo form_input($data, set_value('extension')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Mobile: </label><div class="controls"><?php $data = array('id' => 'mobile', 'name' => 'mobile'); echo form_input($data, set_value('mobile')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Official email: </label><div class="controls"><?php $data = array('id' => 'official_email', 'name' => 'official_email'); echo form_input($data, set_value('official_email')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Personal email: </label><div class="controls"><?php $data = array('id' => 'personal_email', 'name' => 'personal_email'); echo form_input($data, set_value('personal_email')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Facebook: </label><div class="controls"><?php $data = array('id' => 'facebook', 'name' => 'facebook'); echo form_input($data, set_value('facebook')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Twitter: </label><div class="controls"><?php $data = array('id' => 'twitter', 'name' => 'twitter'); echo form_input($data, set_value('twitter')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Google plus: </label><div class="controls"><?php $data = array('id' => 'google_plus', 'name' => 'google_plus'); echo form_input($data, set_value('google_plus')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Residential address: </label><div class="controls"><?php $data = array('id' => 'residential_address', 'name' => 'residential_address'); echo form_input($data, set_value('residential_address')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Photo: </label><div class="controls"><?php $data = array('id' => 'photo', 'name' => 'photo'); echo form_input($data, set_value('photo')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/profiles.js"></script>
