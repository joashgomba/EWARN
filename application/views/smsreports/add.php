<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/smsreports.css" />
</head>
<br />
<h3>Add a Record</h3><br />
<?php echo form_open('smsreports/add_validate'); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Text: </label><div class="controls"><?php $data = array('id' => 'text', 'name' => 'text'); echo form_textarea($data, set_value('text')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Number sent: </label><div class="controls"><?php $data = array('id' => 'number_sent', 'name' => 'number_sent'); echo form_input($data, set_value('number_sent')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Amount spent: </label><div class="controls"><?php $data = array('id' => 'amount_spent', 'name' => 'amount_spent'); echo form_input($data, set_value('amount_spent')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Date sent: </label><div class="controls"><?php $data = array('id' => 'date_sent', 'name' => 'date_sent'); echo form_input($data, set_value('date_sent')); ?></div>
</div><div class="control-group"><label class="control-label" for="form-field-1">Date time sent: </label><div class="controls"><?php $data = array('id' => 'date_time_sent', 'name' => 'date_time_sent'); echo form_input($data, set_value('date_time_sent')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Add', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/smsreports.js"></script>
