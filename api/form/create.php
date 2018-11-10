<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/reportingform.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Reportingform($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$product->week_no  = $data->week_no;
$product->reporting_year = $data->reporting_year;
$product->reporting_date = $data->reporting_date;
$product->epdcalendar_id = $data->epdcalendar_id;
$product->user_id = $data->user_id;
$product->healthfacility_id = $data->healthfacility_id;
$product->contact_number = $data->contact_number;
$product->health_facility_code = $data->health_facility_code;
$product->supporting_ngo = $data->supporting_ngo;
$product->region_id = $data->region_id;
$product->sariufivemale = $data->sariufivemale;
$product->sariufivefemale = $data->sariufivefemale;
$product->sariofivemale = $data->sariofivemale;
$product->sariofivefemale = $data->sariofivefemale;
$product->iliufivemale = $data->iliufivemale;
$product->iliufivefemale = $data->iliufivefemale;
$product->iliofivemale = $data->iliofivemale;
$product->iliofivefemale = $data->iliofivefemale;
$product->awdufivemale = $data->awdufivemale;
$product->awdufivefemale = $data->awdufivefemale;
$product->awdofivemale = $data->awdofivemale;
$product->awdofivefemale = $data->awdofivefemale;
$product->bdufivemale = $data->bdufivemale;
$product->bdufivefemale = $data->bdufivefemale;
$product->bdofivemale = $data->bdofivemale;
$product->bdofivefemale = $data->bdofivefemale;
$product->oadufivemale = $data->oadufivemale;
$product->oadufivefemale = $data->oadufivefemale;
$product->oadofivemale = $data->oadofivemale;
$product->oadofivefemale = $data->oadofivefemale;
$product->diphmale = $data->diphmale;
$product->diphfemale = $data->diphfemale;
$product->wcmale = $data->wcmale;
$product->wcfemale = $data->wcfemale;
$product->measmale = $data->measmale;
$product->measfemale = $data->measfemale;
$product->nntmale = $data->nntmale;
$product->nntfemale = $data->nntfemale;
$product->afpmale = $data->afpmale;
$product->afpfemale = $data->afpfemale;
$product->ajsmale = $data->ajsmale;
$product->ajsfemale = $data->ajsfemale;
$product->vhfmale = $data->vhfmale;
$product->vhffemale = $data->vhffemale;
$product->malufivemale = $data->malufivemale;
$product->malufivefemale = $data->malufivefemale;
$product->malofivemale = $data->malofivemale;
$product->malofivefemale = $data->malofivefemale;
$product->suspectedmenegitismale = $data->suspectedmenegitismale;
$product->suspectedmenegitisfemale = $data->suspectedmenegitisfemale;
$product->undisonedesc = $data->undisonedesc;
$product->undismale = $data->undismale;
$product->undisfemale = $data->undisfemale;
$product->undissecdesc = $data->undissecdesc;
$product->undismaletwo = $data->undismaletwo;
$product->undisfemaletwo = $data->undisfemaletwo;
$product->ocmale = $data->ocmale;
$product->ocfemale = $data->ocfemale;
$product->total_consultations = $data->total_consultations;
$product->sre = $data->sre;
$product->pf = $data->pf;
$product->pv = $data->pv;
$product->pmix = $data->pmix;
$product->totalnegative = $data->totalnegative;
$product->total_positive = $data->total_positive;
$product->approved_hf = $data->approved_hf;
$product->approved_regional = $data->approved_regional;
$product->approved_zone = $data->approved_zone;
$product->draft = $data->draft;
$product->alert_sent = $data->alert_sent;
$product->entry_date = $data->entry_date;
$product->entry_time = $data->entry_time;
$product->edit_date = $data->edit_date;
$product->edit_time = $data->edit_time;
$product->diphofivemale = $data->diphofivemale;
$product->diphofivefemale = $data->diphofivefemale;
$product->wcofivemale = $data->wcofivemale;
$product->wcofivefemale = $data->wcofivefemale;
$product->measofivemale = $data->measofivemale;
$product->measofivefemale = $data->measofivefemale;
$product->afpofivemale = $data->afpofivemale;
$product->afpofivefemale = $data->afpofivefemale;
$product->suspectedmenegitisofivemale = $data->suspectedmenegitisofivemale;
$product->suspectedmenegitisofivefemale = $data->suspectedmenegitisofivefemale;
 
// create the product
if($product->create()){
    echo '{';
        echo '"message": "Record was created."';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create record."';
    echo '}';
}
?>