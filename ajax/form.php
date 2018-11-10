<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
$(document).on("submit",".save",function(e){
e.preventDefault();
$.post($(this).attr("action"),$(this).serialize(),function(r){
//result
alert(r);
});
});
</script>
</head>

<body>
<form method="POST" class="save" action="add_room.php">
<input type="text" name="itemName[]"/>
<input type="text" name="itemName[]"/>
<button type="submit">Save</button>
</form>
</body>
</html>