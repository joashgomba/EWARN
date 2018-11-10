<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/country.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Country($db);
 
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$stmt = $product->readOne();
 
    // create array
$product_arr = array(
     "id" => $product->id,
     "country_name" => $product->country_name,
     'first_admin_level_label' => $product->first_admin_level_label,
	 'second_admin_level_label' => $product->second_admin_level_label,
	 'third_admin_level_label' => $product->third_admin_level_label
);
 
// make it json format
print_r(json_encode($product_arr));
?>