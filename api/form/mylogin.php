<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//connect to the database
mysql_connect("localhost", "root", "") or die(mysql_error()); 
mysql_select_db("edews") or die(mysql_error()); 
 
$username = isset($_GET['username']) ? $_GET['username'] : die();
$password = isset($_GET['password']) ? $_GET['password'] : die();

$sql = mysql_query("SELECT * FROM users WHERE username = '".$username."'")or die(mysql_error());

$row = mysql_fetch_row($sql);

$encrypted = md5($password);

if ($encrypted != $row[8]) 
{

	$user_arr = array(
		"id" => "",
		"fnmae" => "",
		'lname' => "",
		'healthfacility_id' => "",
		'organization' => "",
		'email' => "",
		'contact_number' => "",
		'username' => "",
		'password' => "",
		'role_id' => "",
		'active' => "",
		'level' => "",
		'zone_id' => "",
		'region_id' => "",
		'district_id' => "", 
		'country_id' => "" 
	);

	

}
else
{
	if($row[10]==0)
	{
		$user_arr = array(
		"id" => "",
		"fnmae" => "",
		'lname' => "",
		'healthfacility_id' => "",
		'organization' => "",
		'email' => "",
		'contact_number' => "",
		'username' => "",
		'password' => "",
		'role_id' => "",
		'active' => "",
		'level' => "",
		'zone_id' => "",
		'region_id' => "",
		'district_id' => "", 
		'country_id' => "" 
		);
	}
	else
	{
		// create array
		$user_arr = array(
			"id" => $row[0],
			"fnmae" => $row[1],
			'lname' => $row[2],
			'healthfacility_id' => $row[3],
			'organization' => $row[4],
			'email' => $row[5],
			'contact_number' => $row[6],
			'username' => $row[7],
			'password' => $row[8],
			'role_id' => $row[9],
			'active' => $row[10],
			'level' => $row[11],
			'zone_id' => $row[12],
			'region_id' => $row[13],
			'district_id' => $row[14], 
			'country_id' => $row[15] 
		);
	}

}


// make it json format
print_r(json_encode($user_arr));

?>