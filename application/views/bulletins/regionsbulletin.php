<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Weekly Regions bulletin - <?php echo $row->issue_no;?> Epi Week <?php echo $row->week_no;?></title>
<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:70%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
                
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
        border:2px  solid #fff;
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

<body>

<table id="listtable">
<tr><td><img src="<?php echo base_url(); ?>images/Header_title.png"></td></tr>
<tr><th>Issue <?php echo $row->issue_no;?> Epi Week <?php echo $row->week_no;?>, <?php echo date("d F Y", strtotime($row->period_from)); ?> - <?php echo date("d F Y", strtotime($row->period_to)); ?></th></tr>
<tr><td>
<table id="customers">
<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Highlights</strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
<tr><td valign="top"><?php echo $row->highlight;?></td><td valign="top">&nbsp;</td></tr>
<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong><?php echo $row->title;?></strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
<tr><td valign="top"><?php echo $row->narrative;?></td><td valign="top">&nbsp;</td></tr>
<tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF"><strong>Alerts/Outbreaks Reported in Epi Week <?php echo $row->week_no;?>, <?php echo $row->week_year;?></strong></font></td></tr>
<tr ><td colspan="2">
<?php echo $alertstable; ?>
</td></tr>
</table>
</td></tr>

</table>
</body>
</html>