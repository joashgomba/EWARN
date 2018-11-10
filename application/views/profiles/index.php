<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/profiles.css" />
</head>
<br />
<h3>Profiles Records</h3><br />
<h4><a href="<?php echo base_url() ?>index.php/profiles/add">Add a Record</a></h4><br />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead>
<tr>
<th>Id</th>
<th>User id</th>
<th>Date of birth</th>
<th>Address</th>
<th>Post code</th>
<th>City</th>
<th>Country</th>
<th>Telephone</th>
<th>Extension</th>
<th>Mobile</th>
<th>Official email</th>
<th>Personal email</th>
<th>Facebook</th>
<th>Twitter</th>
<th>Google plus</th>
<th>Residential address</th>
<th>Photo</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows->result() as $row): ?>
<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->user_id; ?></td>
<td><?php echo $row->date_of_birth; ?></td>
<td><?php echo $row->address; ?></td>
<td><?php echo $row->post_code; ?></td>
<td><?php echo $row->city; ?></td>
<td><?php echo $row->country; ?></td>
<td><?php echo $row->telephone; ?></td>
<td><?php echo $row->extension; ?></td>
<td><?php echo $row->mobile; ?></td>
<td><?php echo $row->official_email; ?></td>
<td><?php echo $row->personal_email; ?></td>
<td><?php echo $row->facebook; ?></td>
<td><?php echo $row->twitter; ?></td>
<td><?php echo $row->google_plus; ?></td>
<td><?php echo $row->residential_address; ?></td>
<td><?php echo $row->photo; ?></td>
<td><a href="<?php echo base_url() ?>index.php/profiles/edit/<?php echo $row->id; ?>">Edit</a> <a href="<?php echo base_url() ?>index.php/profiles/delete/<?php echo $row->id; ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
