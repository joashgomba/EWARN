<?php 
//Include the database class
require("classes/db.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>jQuery</title>
<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="css/css.css" />
<script type="text/javascript">
var count = 0;
$(function(){
	$('p#add_field').click(function(){
		count += 1;
		$('#container').append(
				'<strong>Link #' + count + '</strong><br />' 
				+ '<input id="field_' + count + '" name="fields[]' + '" type="text" /> <input id="myfield_' + count + '" name="myfield[]' + '" type="text" /><br />' );
	
	});
});
</script> 

<body>

<?php
//If form was submitted
if (isset($_POST['btnSubmit'])) {
	
	
	if(!empty($_POST['fields']))
		  {
			  foreach ($_POST['fields'] as $key=>$value)
			  {
				
				$fields = $value;
				$myfield = $_POST['myfield'][$key];
				
				echo $fields.''.$myfield.'<br>';
				
			  }
		  }
/**
	//create instance of database class
	$db = new mysqldb();
	$db->select_db();
	
	//Insert static values into users table
	$sql_user = sprintf("INSERT INTO users (Username, Password) VALUES ('%s','%s')",
						mysql_real_escape_string($_POST['name']),
						mysql_real_escape_string($_POST['password']) );  
	$result_user = $db->query($sql_user);


	//Check if user has actually added additional fields to prevent a php error
	if ($_POST['fields']) {
		
		//get last inserted userid
		$inserted_user_id = $db->last_insert_id();
		
		//Loop through added fields
		foreach ( $_POST['fields'] as $key=>$value ) {
			
			//Insert into websites table
			$sql_website = sprintf("INSERT INTO websites (Website_URL) VALUES ('%s')",
						    	   mysql_real_escape_string($value) );  
			$result_website = $db->query($sql_website);
			$inserted_website_id = $db->last_insert_id();
			
			
			//Insert into users_websites_link table
			$sql_users_website = sprintf("INSERT INTO users_websites_link (UserID, WebsiteID) VALUES ('%s','%s')",
						    	   mysql_real_escape_string($inserted_user_id),
								   mysql_real_escape_string($inserted_website_id) );  
			$result_users_website = $db->query($sql_users_website);
			
		}
		
	} else {
	
		//No additional fields added by user
		
	}
	echo "<h1>User Added, <strong>" . count($_POST['fields']) . "</strong> website(s) added for this user!</h1>";
	
	//disconnect mysql connection
	$db->kill();
	**/
}
?>

<?php if (!isset($_POST['btnSubmit'])) { ?>
    <h1>New User Signup</h1>
    <form name="test" method="post" action="">
        <label for="name">Username:</label>
        <input type="text" name="name" id="name" />
        
        <div class="spacer"></div>
        
        <label for="name">Password:</label>
        <input type="text" name="password" id="password" /> 
        
        <div class="spacer"></div>
    
        <div id="container">
            <p id="add_field"><a href="#"><span>&raquo; Add your favourite links.....</span></a></p>
        </div>
        
        <div class="spacer"></div>
        <input id="go" name="btnSubmit" type="submit" value="Signup" class="btn" />
    </form>
<?php } ?>

</body>
</html>
