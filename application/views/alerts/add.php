<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/alerts.css" />
</head>
<br />
<h3>Add a Record</h3><br />
<?php echo form_open('alerts/add_validate'); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Reportingform id: </label><div class="controls"><?php $data = array('id' => 'reportingform_id', 'name' => 'reportingform_id'); echo form_input($data, set_value('reportingform_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Disease name: </label><div class="controls"><?php $data = array('id' => 'disease_name', 'name' => 'disease_name'); echo form_input($data, set_value('disease_name')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Healthfacility id: </label><div class="controls"><?php $data = array('id' => 'healthfacility_id', 'name' => 'healthfacility_id'); echo form_input($data, set_value('healthfacility_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">District id: </label><div class="controls"><?php $data = array('id' => 'district_id', 'name' => 'district_id'); echo form_input($data, set_value('district_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Region id: </label><div class="controls"><?php $data = array('id' => 'region_id', 'name' => 'region_id'); echo form_input($data, set_value('region_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Zone id: </label><div class="controls"><?php $data = array('id' => 'zone_id', 'name' => 'zone_id'); echo form_input($data, set_value('zone_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Cases: </label><div class="controls"><?php $data = array('id' => 'cases', 'name' => 'cases'); echo form_input($data, set_value('cases')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Deaths: </label><div class="controls"><?php $data = array('id' => 'deaths', 'name' => 'deaths'); echo form_input($data, set_value('deaths')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Notes: </label><div class="controls"><?php $data = array('id' => 'notes', 'name' => 'notes'); echo form_textarea($data, set_value('notes')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Verification status: </label><div class="controls"><?php $data = array('id' => 'verification_status', 'name' => 'verification_status'); echo form_input($data, set_value('verification_status')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Include bulletin: </label><div class="controls"><?php $data = array('id' => 'include_bulletin', 'name' => 'include_bulletin'); echo form_input($data, set_value('include_bulletin')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/alerts.js"></script>
