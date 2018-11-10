<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//http://www.9lessons.info/2012/05/create-restful-services-api-in-php.html
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new User($db);
 
// set ID property of product to be edited
$product->username = isset($_GET['username']) ? $_GET['username'] : die();
$product->password = isset($_GET['password']) ? $_GET['password'] : die();
 
// read the details of product to be edited
$product->loginUser();
 
// create array
$product_arr = array(
    "id" => $product->id,
    "fnmae" => $product->fname,
    'lname' => $product->lname,
	'healthfacility_id' => $product->healthfacility_id,
	'organization' => $product->organization,
	'email' => $product->email,
	'contact_number' => $product->contact_number,
	'username' => $product->username,
	'password' => $product->password,
	'role_id' => $product->role_id,
	'active' => $product->active,
	'level' => $product->level,
	'zone_id' => $product->zone_id,
	'region_id' => $product->region_id,
	'district_id' => $product->district_id, 
	'country_id' => $product->country_id 
);
 
// make it json format
print_r(json_encode($product_arr));
?>