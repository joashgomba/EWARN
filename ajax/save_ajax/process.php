<?php

// Retrieve form data
$name = $_POST['name'];
$age_range = $_POST['age_range'];
$sports = $_POST['sports'];
if (!$name || !$age_range || !$sports) {
	echo "save_failed";
	return;
}

// Convert sports array to a serialized string
$sports_list = serialize($sports);

$db = array(
	'host' => 'localhost',
	'login' => 'root',
	'password' => '',
	'database' => 'test',
);
$link = @mysql_connect($db['host'], $db['login'], $db['password']);
if (!$link) {
	echo "save_failed";
	return;	
}
mysql_select_db($db['database']);

// Clean variables before performing insert
$clean_name = mysql_real_escape_string($name);
$clean_age_range = mysql_real_escape_string($age_range);
$clean_sports_list = mysql_real_escape_string($sports_list);

// Perform insert
$sql = "INSERT INTO details (name, age_range_ID, sports) VALUES ('{$clean_name}', {$clean_age_range}, '{$clean_sports_list}')";
if (@mysql_query($sql, $link)) {
	echo "success";
	@mysql_close($link);
	return;
} else {
	echo "save_failed";
	@mysql_close($link);
	return;
}

?>