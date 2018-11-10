<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/audittrail.css" />
</head>
<br />
<h3>Add a Record</h3><br />
<?php echo form_open('audittrail/add_validate'); ?>
<div class="control-group"><label class="control-label" for="form-field-1">User id: </label><div class="controls"><?php $data = array('id' => 'user_id', 'name' => 'user_id'); echo form_input($data, set_value('user_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Reportingform id: </label><div class="controls"><?php $data = array('id' => 'reportingform_id', 'name' => 'reportingform_id'); echo form_input($data, set_value('reportingform_id')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Date of action: </label><div class="controls"><?php $data = array('id' => 'date_of_action', 'name' => 'date_of_action'); echo form_input($data, set_value('date_of_action')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Action: </label><div class="controls"><?php $data = array('id' => 'action', 'name' => 'action'); echo form_input($data, set_value('action')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/audittrail.js"></script>
