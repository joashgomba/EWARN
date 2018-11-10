<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/smsreports.css" />
</head>
<br />
<h3>Smsreports Records</h3><br />
<h4><a href="<?php echo base_url() ?>smsreports/add">Add a Record</a></h4><br />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Text</th>
<th>Number sent</th>
<th>Amount spent</th>
<th>Date sent</th>
<th>Date time sent</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->text; ?></td>
<td><?php echo $row->number_sent; ?></td>
<td><?php echo $row->amount_spent; ?></td>
<td><?php echo $row->date_sent; ?></td>
<td><?php echo $row->date_time_sent; ?></td>
<td><a href="<?php echo base_url() ?>smsreports/edit/<?php echo $row->id; ?>">Edit</a> <a href="<?php echo base_url() ?>smsreports/delete/<?php echo $row->id; ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
