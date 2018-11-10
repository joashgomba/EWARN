<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/audittrail.css" />
</head>
<br />
<h3>Audittrail Records</h3><br />
<h4><a href="<?php echo base_url() ?>audittrail/add">Add a Record</a></h4><br />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>User id</th>
<th>Reportingform id</th>
<th>Date of action</th>
<th>Action</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->user_id; ?></td>
<td><?php echo $row->reportingform_id; ?></td>
<td><?php echo $row->date_of_action; ?></td>
<td><?php echo $row->action; ?></td>
<td><a href="<?php echo base_url() ?>audittrail/edit/<?php echo $row->id; ?>">Edit</a> <a href="<?php echo base_url() ?>audittrail/delete/<?php echo $row->id; ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
