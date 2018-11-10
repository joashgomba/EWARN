<?php 
$attributes = array('name' => 'validate', 'id' => 'validate', 'enctype' => 'multipart/form-data','class' => 'form');
echo form_open('importfacilities/importcoords',$attributes); ?>
<table>

<tr><td>FIle</td><td><input type="file" name="userfile" id="userfile" /></td></tr>
<tr><td colspan="2"><input type="submit" value="submit" /></td></tr>
</table>
<?php echo form_close(); ?> 