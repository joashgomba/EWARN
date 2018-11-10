<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/reportingform.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Reportingform($db);
 
// query products
$stmt = $product->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "id" => $id,
            "week_no" => $week_no,
            'reporting_year' => $reporting_year,
			'reporting_date' => $reporting_date,
			'epdcalendar_id' => $epdcalendar_id,
			'user_id' => $user_id,
			'healthfacility_id' => $healthfacility_id,
			'contact_number' => $contact_number,
			'health_facility_code' => $health_facility_code,
			'supporting_ngo' => $supporting_ngo,
			'region_id' => $region_id,
			'sariufivemale' => $sariufivemale,
			'sariufivefemale' => $sariufivefemale,
			'sariofivemale' => $sariofivemale,
			'sariofivefemale' => $sariofivefemale,
			'iliufivemale' => $iliufivemale,
			'iliufivefemale' => $iliufivefemale,
			'iliofivemale' => $iliofivemale,
			'iliofivefemale' => $iliofivefemale,
			'awdufivemale' => $awdufivemale,
			'awdufivefemale' => $awdufivefemale,
			'awdofivemale' => $awdofivemale,
			'awdofivefemale' => $awdofivefemale,
			'bdufivemale' => $bdufivemale,
			'bdufivefemale' => $bdufivefemale,
			'bdofivemale' => $bdofivemale,
			'bdofivefemale' => $bdofivefemale,
			'oadufivemale' => $oadufivemale,
			'oadufivefemale' => $oadufivefemale,
			'oadofivemale' => $oadofivemale,
			'oadofivefemale' => $oadofivefemale,
			'diphmale' => $diphmale,
			'diphfemale' => $diphfemale,
			'wcmale' => $wcmale,
			'wcfemale' => $wcfemale,
			'measmale' => $measmale,
			'measfemale' => $measfemale,
			'nntmale' => $nntmale,
			'nntfemale' => $nntfemale,
			'afpmale' => $afpmale,
			'afpfemale' => $afpfemale,
			'ajsmale' => $ajsmale,
			'ajsfemale' => $ajsfemale,
			'vhfmale' => $vhfmale,
			'vhffemale' => $vhffemale,
			'malufivemale' => $malufivemale,
			'malufivefemale' => $malufivefemale,
			'malofivemale' => $malofivemale,
			'malofivefemale' => $malofivefemale,
			'suspectedmenegitismale' => $suspectedmenegitismale,
			'suspectedmenegitisfemale' => $suspectedmenegitisfemale,
			'undisonedesc' => $undisonedesc,
			'undismale' => $undismale,
			'undisfemale' => $undisfemale,
			'undissecdesc' => $undissecdesc,
			'undismaletwo' => $undismaletwo,
			'undisfemaletwo' => $undisfemaletwo,
			'ocmale' => $ocmale,
			'ocfemale' => $ocfemale,
			'total_consultations' => $total_consultations,
			'sre' => $sre,
			'pf' => $pf,
			'pv' => $pv,
			'pmix' => $pmix,
			'totalnegative' => $totalnegative,
			'total_positive' => $total_positive,
			'approved_hf' => $approved_hf,
			'approved_regional' => $approved_regional,
			'approved_zone' => $approved_zone,
			'draft' => $draft,
			'alert_sent' => $alert_sent,
			'entry_date' => $entry_date,
			'entry_time' => $entry_time,
			'edit_date' => $edit_date,
			'edit_time' => $edit_time,
			'diphofivemale' => $diphofivemale,
			'diphofivefemale' => $diphofivefemale,
			'wcofivemale' => $wcofivemale,
			'wcofivefemale' => $wcofivefemale,
			'measofivemale' => $measofivemale,
			'measofivefemale' => $measofivefemale,
			'afpofivemale' => $afpofivemale,
			'afpofivefemale' => $afpofivefemale,
			'suspectedmenegitisofivemale' => $suspectedmenegitisofivemale,
			'suspectedmenegitisofivefemale' => $suspectedmenegitisofivefemale
        );
 
        array_push($products_arr["records"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>