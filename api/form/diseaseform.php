<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/disease.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Disease($db);
 
// set ID property of product to be edited
$product->country_id = isset($_GET['country_id']) ? $_GET['country_id'] : die();

$stmt = $product->getByCountry();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["fields"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
	
	$i=1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$i++;
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 		/**
        $product_item=array(
            "id" => $id,
            "country_id" => $country_id,
            'diseasecategory_id' => $diseasecategory_id,
			'disease_code' => $disease_code,
			'disease_name' => $disease_name,
			'case_definition' => $case_definition,
			'alert_type' => $alert_type,
			'alert_threshold' => $alert_threshold,
			'no_of_times' => $no_of_times,
			'weeks' => $weeks
        );
		
		**/
		$field_options_one = array(
		'size'=>'medium',
		'description'=>$disease_code.' < 5 male',
		'minlength' => '1',
		'maxlength' => '2',
		'name' => $disease_code.'_u_five_male'
		
		);
		
		$field_options_two = array(
		'size'=>'medium',
		'description'=>$disease_code.' < 5 female',
		'minlength' => '1',
		'maxlength' => '2',
		'name' => $disease_code.'_u_five_female'
		
		);
		
		$field_options_three = array(
		'size'=>'medium',
		'description'=>$disease_code.' > 5 male',
		'minlength' => '1',
		'maxlength' => '2',
		'name' => $disease_code.'_o_five_male'
		
		);
		
		$field_options_four = array(
		'size'=>'medium',
		'description'=>$disease_code.' > 5 female',
		'minlength' => '1',
		'maxlength' => '2',
		'name' => $disease_code.'_o_five_female'
		
		);
		
		 $product_item=array(
        	'label' => $disease_code.' < 5 Male',
			'field_type' => 'text',
			'required' => 'true',
			'field_options' => $field_options_one,
			'cid' => $id.'_u_f_m'
        );
		
		$product_item_two=array(
        	'label' => $disease_code.' < 5 Female',
			'field_type' => 'text',
			'required' => 'true',
			'field_options' => $field_options_two,
			'cid' => $id.'_u_f_f'
        );
		
		$product_item_three=array(
        	'label' => $disease_code.' > 5 Male',
			'field_type' => 'text',
			'required' => 'true',
			'field_options' => $field_options_three,
			'cid' => $id.'_o_f_m'
        );
		
		$product_item_four=array(
        	'label' => $disease_code.' > 5 Female',
			'field_type' => 'text',
			'required' => 'true',
			'field_options' => $field_options_four,
			'cid' => $id.'_o_f_f'
        );
		
 
        array_push($products_arr["fields"], $product_item,$product_item_two,$product_item_three,$product_item_four);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No records found.")
    );
}
 

?>