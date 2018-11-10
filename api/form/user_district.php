<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/district.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new District($db);
 
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$stmt = $product->readOne();
 
    // create array
$product_arr = array(
     "id" => $product->id,
     "district" => $product->district,
     'region_id' => $product->region_id
);
 
// make it json format
print_r(json_encode($product_arr));
?>