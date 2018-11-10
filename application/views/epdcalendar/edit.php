<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/epdcalendar.css" />
</head>
<br />
<h3>Edit a Record</h3><br />
<?php echo form_open('epdcalendar/edit_validate/'.$row->id); ?>
<div class="control-group"><label>Epdyear: </label><div class="controls"><?php $data = array('id' => 'epdyear', 'name' => 'epdyear', 'value' => $row->epdyear); echo form_input($data, set_value('epdyear')); ?></div>
</div><div class="control-group"><label>Week no: </label><div class="controls"><?php $data = array('id' => 'week_no', 'name' => 'week_no', 'value' => $row->week_no); echo form_input($data, set_value('week_no')); ?></div>
</div><div class="control-group"><label>From: </label><div class="controls"><?php $data = array('id' => 'from', 'name' => 'from', 'value' => $row->from); echo form_input($data, set_value('from')); ?></div>
</div><div class="control-group"><label>To: </label><div class="controls"><?php $data = array('id' => 'to', 'name' => 'to', 'value' => $row->to); echo form_input($data, set_value('to')); ?></div>
</div><div class="form-actions"><?php echo form_submit('submit', 'Update', 'class="btn btn-info "'); ?></div>
<?php echo form_close(); ?>
<?php echo validation_errors(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/epdcalendar.js"></script>
