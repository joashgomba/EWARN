
<form action="upload_file.php" method="post" enctype="multipart/form-data">
<table border="1">
<tr><td>File</td><td><input type="file" name="file" id="file" /></td></tr>
<tr><td>Location</td><td>
<select name="path" id="path">
<option value="controllers">controllers</option>
<option value="models">models</option>
<option value="views/analytics">views/analytics</option>
<option value="views/forms">views/forms</option>
<option value="views/formalerts">views/formalerts</option>
<option value="views/reportingforms">views/reportingforms</option>
<option value="views/profiles">views/profiles</option>
<option value="views/districts">views/districts</option>
<option value="views/documents">views/documents</option>
<option value="views/reports">views/reports</option>
<option value="views/maps">views/maps</option>
<option value="views/regions">views/regions</option>
<option value="views/mobile">views/mobile</option>
<option value="views/home">views/home</option>
<option value="views/healthfacilities">views/healthfacilities</option>
<option value="views/zones">views/zones</option>
<option value="views/mobilenumbers">views/mobilenumbers</option>
<option value="views/epdcalendar">views/epdcalendar</option>
<option value="views/bulletins">views/bulletins</option>
<option value="views/common">views/common</option>
<option value="views/users">views/users</option>
<option value="views/epdcalendar">views/epdcalendar</option>
<option value="views/alerts">views/alerts</option>
</select>
</td></tr>
<tr><td colspan="2"><input type="submit" value="Submit" /></td></tr>
</table>
</form>