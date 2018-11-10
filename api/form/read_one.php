<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/reportingform.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Reportingform($db);
 
// set ID property of product to be edited
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$product->readOne();
 
// create array
$product_arr = array(
    "id" => $product->id,
    "week_no" => $product->week_no,
    'reporting_year' => $product->reporting_year,
	'reporting_date' => $product->reporting_date,
	'epdcalendar_id' => $product->epdcalendar_id,
	'user_id' => $product->user_id,
	'healthfacility_id' => $product->healthfacility_id,
	'contact_number' => $product->contact_number,
	'health_facility_code' => $product->health_facility_code,
	'supporting_ngo' => $product->supporting_ngo,
	'region_id' => $product->region_id,
	'sariufivemale' => $product->sariufivemale,
	'sariufivefemale' => $product->sariufivefemale,
	'sariofivemale' => $product->sariofivemale,
	'sariofivefemale' => $product->sariofivefemale,
	'iliufivemale' => $product->iliufivemale,
	'iliufivefemale' => $product->iliufivefemale,
	'iliofivemale' => $product->iliofivemale,
	'iliofivefemale' => $product->iliofivefemale,
	'awdufivemale' => $product->awdufivemale,
	'awdufivefemale' => $product->awdufivefemale,
	'awdofivemale' => $product->awdofivemale,
	'awdofivefemale' => $product->awdofivefemale,
	'bdufivemale' => $product->bdufivemale,
	'bdufivefemale' => $product->bdufivefemale,
	'bdofivemale' => $product->bdofivemale,
	'bdofivefemale' => $product->bdofivefemale,
	'oadufivemale' => $product->oadufivemale,
	'oadufivefemale' => $product->oadufivefemale,
	'oadofivemale' => $product->oadofivemale,
	'oadofivefemale' => $product->oadofivefemale,
	'diphmale' => $product->diphmale,
	'diphfemale' => $product->diphfemale,
	'wcmale' => $product->wcmale,
	'wcfemale' => $product->wcfemale,
	'measmale' => $product->measmale,
	'measfemale' => $product->measfemale,
	'nntmale' => $product->nntmale,
	'nntfemale' => $product->nntfemale,
	'afpmale' => $product->afpmale,
	'afpfemale' => $product->afpfemale,
	'ajsmale' => $product->ajsmale,
	'ajsfemale' => $product->ajsfemale,
	'vhfmale' => $product->vhfmale,
	'vhffemale' => $product->vhffemale,
	'malufivemale' => $product->malufivemale,
	'malufivefemale' => $product->malufivefemale,
	'malofivemale' => $product->malofivemale,
	'malofivefemale' => $product->malofivefemale,
	'suspectedmenegitismale' => $product->suspectedmenegitismale,
	'suspectedmenegitisfemale' => $product->suspectedmenegitisfemale,
	'undisonedesc' => $product->undisonedesc,
	'undismale' => $product->undismale,
	'undisfemale' => $product->undisfemale,
	'undissecdesc' => $product->undissecdesc,
	'undismaletwo' => $product->undismaletwo,
	'undisfemaletwo' => $product->undisfemaletwo,
	'ocmale' => $product->ocmale,
	'ocfemale' => $product->ocfemale,
	'total_consultations' => $product->total_consultations,
	'sre' => $product->sre,
	'pf' => $product->pf,
	'pv' => $product->pv,
	'pmix' => $product->pmix,
	'totalnegative' => $product->totalnegative,
	'total_positive' => $product->total_positive,
	'approved_hf' => $product->approved_hf,
	'approved_regional' => $product->approved_regional,
	'approved_zone' => $product->approved_zone,
	'draft' => $product->draft,
	'alert_sent' => $product->alert_sent,
	'entry_date' => $product->entry_date,
	'entry_time' => $product->entry_time,
	'edit_date' => $product->edit_date,
	'edit_time' => $product->edit_time,
	'diphofivemale' => $product->diphofivemale,
	'diphofivefemale' => $product->diphofivefemale,
	'wcofivemale' => $product->wcofivemale,
	'wcofivefemale' => $product->wcofivefemale,
	'measofivemale' => $product->measofivemale,
	'measofivefemale' => $product->measofivefemale,
	'afpofivemale' => $product->afpofivemale,
	'afpofivefemale' => $product->afpofivefemale,
	'suspectedmenegitisofivemale' => $product->suspectedmenegitisofivemale,
	'suspectedmenegitisofivefemale' => $product->suspectedmenegitisofivefemale
 
);
 
// make it json format
print_r(json_encode($product_arr));
?>