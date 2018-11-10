<head>
<style>
        #customers
        {
        font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
        width:100%;
        border-collapse:collapse;
        }
        #customers td, #customers th 
        {
        font-size:1.0em;
        border:1px  #999999;
        padding:3px 7px 2px 7px;
        }
        #customers th 
        {
        font-size:1.0em;
        text-align:left;
        padding-top:5px;
        padding-bottom:4px;
        background-color:#cccccc;
        color:#fff;
        }
        #customers tr.alt td 
        {
        color:#000;
        background-color:#cccfff;
        }
        </style>
</head>
<table id="customers">
<thead>
<tr>
<th>User</th>
<th>Form</th>
<th>Date of action</th>
<th>Action</th>

</tr>
</thead>
<tbody>
<?php 
$class = 'class="alt"';
foreach ($rows->result() as $row): 

if($class == 'class="alt"')
{
	$class = '';
}
else
{
	$class = 'class="alt"';
}
?>
<tr <?php echo $class;?>>
<td><?php echo $row->fname; ?> <?php echo $row->lname; ?></td>
<td>Week <?php echo $row->week_no; ?>, <?php echo $row->reporting_year; ?></td>
<td><?php echo $row->date_of_action; ?></td>
<td><?php echo $row->action; ?></td>

</tr>
<?php endforeach; ?>
</tbody>
</table>
