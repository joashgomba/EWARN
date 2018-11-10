<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/epdcalendar.css" />
</head>
<br />
<h3>Epdcalendar Records</h3><br />
<h4><a href="<?php echo base_url() ?>epdcalendar/add">Add a Record</a></h4><br />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>Epdyear</th>
<th>Week no</th>
<th>From</th>
<th>To</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->epdyear; ?></td>
<td><?php echo $row->week_no; ?></td>
<td><?php echo $row->from; ?></td>
<td><?php echo $row->to; ?></td>
<td><a href="<?php echo base_url() ?>epdcalendar/edit/<?php echo $row->id; ?>">Edit</a> <a href="<?php echo base_url() ?>epdcalendar/delete/<?php echo $row->id; ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
