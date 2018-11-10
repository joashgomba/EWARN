<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/smsreports.css" />
</head>
<br />
<h3>Edit a Record</h3><br />
<?php echo form_open('smsreports/edit_validate/'.$row->id); ?>
<div class="control-group"><label class="control-label" for="form-field-1">Text: </label><div class="controls"><?php $data = array('id' => 'text', 'name' => 'text', 'value' => $row->text); echo form_textarea($data, set_value('text')); ?></div>
</div><div class="control-group"><label>Number sent: </label><div class="controls"><?php $data = array('id' => 'number_sent', 'name' => 'number_sent', 'value' => $row->number_sent); echo form_input($data, set_value('number_sent')); ?></div>
</div><div class="control-group"><label>Amount spent: </label><div class="controls"><?php $data = array('id' => 'amount_spent', 'name' => 'amount_spent', 'value' => $row->amount_spent); echo form_input($data, set_value('amount_spent')); ?></div>
</div><div class="control-group"><label>Date sent: </label><div class="controls"><?php $data = array('id' => 'date_sent', 'name' => 'date_sent', 'value' => $row->date_sent); echo form_input($data, set_value('date_sent')); ?></div>
</div><div class="control-group"><label>Date time sent: </label><div class="controls"><?php $data = array('id' => 'date_time_sent', 'name' => 'date_time_sent', 'value' => $row->date_time_sent); echo form_input($data, set_value('date_time_sent')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/smsreports.js"></script>
