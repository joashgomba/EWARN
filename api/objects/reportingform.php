<?php
class Reportingform{
 
    // database connection and table name
    private $conn;
    private $table_name = "reportingforms";
 
    // object properties
    public $id;
	public $week_no;
	public $reporting_year;
	public $reporting_date;
	public $epdcalendar_id;
	public $user_id;
	public $healthfacility_id;
	public $contact_number;
	public $health_facility_code;
	public $supporting_ngo;
	public $region_id;
	public $sariufivemale;
	public $sariufivefemale;
	public $sariofivemale;
	public $sariofivefemale;
	public $iliufivemale;
	public $iliufivefemale;
	public $iliofivemale;
	public $iliofivefemale;
	public $awdufivemale;
	public $awdufivefemale;
	public $awdofivemale;
	public $awdofivefemale;
	public $bdufivemale;
	public $bdufivefemale;
	public $bdofivemale;
	public $bdofivefemale;
	public $oadufivemale;
	public $oadufivefemale;
	public $oadofivemale;
	public $oadofivefemale;
	public $diphmale;
	public $diphfemale;
	public $wcmale;
	public $wcfemale;
	public $measmale;
	public $measfemale;
	public $nntmale;
	public $nntfemale;
	public $afpmale;
	public $afpfemale;
	public $ajsmale;
	public $ajsfemale;
	public $vhfmale;
	public $vhffemale;
	public $malufivemale;
	public $malufivefemale;
	public $malofivemale;
	public $malofivefemale;
	public $suspectedmenegitismale;
	public $suspectedmenegitisfemale;
	public $undisonedesc;
	public $undismale;
	public $undisfemale;
	public $undissecdesc;
	public $undismaletwo;
	public $undisfemaletwo;
	public $ocmale;
	public $ocfemale;
	public $total_consultations;
	public $sre;
	public $pf;
	public $pv;
	public $pmix;
	public $totalnegative;
	public $total_positive;
	public $approved_hf;
	public $approved_regional;
	public $approved_zone;
	public $draft;
	public $alert_sent;
	public $entry_date;
	public $entry_time;
	public $edit_date;
	public $edit_time;
	public $diphofivemale;
	public $diphofivefemale;
	public $wcofivemale;
	public $wcofivefemale;
	public $measofivemale;
	public $measofivefemale;
	public $afpofivemale;
	public $afpofivefemale;
	public $suspectedmenegitisofivemale;
	public $suspectedmenegitisofivefemale;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	
	function read(){
 
    // select all query
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
                
            ORDER BY
                p.id DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
	}
	
	function readOne(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->week_no= $row['week_no'];
	$this->reporting_year= $row['reporting_year'];
	$this->reporting_date= $row['reporting_date'];
	$this->epdcalendar_id= $row['epdcalendar_id'];
	$this->user_id= $row['user_id'];
	$this->healthfacility_id= $row['healthfacility_id'];
	$this->contact_number= $row['contact_number'];
	$this->health_facility_code= $row['health_facility_code'];
	$this->supporting_ngo= $row['supporting_ngo'];
	$this->region_id= $row['region_id'];
	$this->sariufivemale= $row['sariufivemale'];
	$this->sariufivefemale= $row['sariufivefemale'];
	$this->sariofivemale= $row['sariofivemale'];
	$this->sariofivefemale= $row['sariofivefemale'];
	$this->iliufivemale= $row['iliufivemale'];
	$this->iliufivefemale= $row['iliufivefemale'];
	$this->iliofivemale= $row['iliofivemale'];
	$this->iliofivefemale= $row['iliofivefemale'];
	$this->awdufivemale= $row['awdufivemale'];
	$this->awdufivefemale= $row['awdufivefemale'];
	$this->awdofivemale= $row['awdofivemale'];
	$this->awdofivefemale= $row['awdofivefemale'];
	$this->bdufivemale= $row['bdufivemale'];
	$this->bdufivefemale= $row['bdufivefemale'];
	$this->bdofivemale= $row['bdofivemale'];
	$this->bdofivefemale= $row['bdofivefemale'];
	$this->oadufivemale= $row['oadufivemale'];
	$this->oadufivefemale= $row['oadufivefemale'];
	$this->oadofivemale= $row['oadofivemale'];
	$this->oadofivefemale= $row['oadofivefemale'];
	$this->diphmale= $row['diphmale'];
	$this->diphfemale= $row['diphfemale'];
	$this->wcmale= $row['wcmale'];
	$this->wcfemale= $row['wcfemale'];
	$this->measmale= $row['measmale'];
	$this->measfemale= $row['measfemale'];
	$this->nntmale= $row['nntmale'];
	$this->nntfemale= $row['nntfemale'];
	$this->afpmale= $row['afpmale'];
	$this->afpfemale= $row['afpfemale'];
	$this->ajsmale= $row['ajsmale'];
	$this->ajsfemale= $row['ajsfemale'];
	$this->vhfmale= $row['vhfmale'];
	$this->vhffemale= $row['vhffemale'];
	$this->malufivemale= $row['malufivemale'];
	$this->malufivefemale= $row['malufivefemale'];
	$this->malofivemale= $row['malofivemale'];
	$this->malofivefemale= $row['malofivefemale'];
	$this->suspectedmenegitismale= $row['suspectedmenegitismale'];
	$this->suspectedmenegitisfemale= $row['suspectedmenegitisfemale'];
	$this->undisonedesc= $row['undisonedesc'];
	$this->undismale= $row['undismale'];
	$this->undisfemale= $row['undisfemale'];
	$this->undissecdesc= $row['undissecdesc'];
	$this->undismaletwo= $row['undismaletwo'];
	$this->undisfemaletwo= $row['undisfemaletwo'];
	$this->ocmale= $row['ocmale'];
	$this->ocfemale= $row['ocfemale'];
	$this->total_consultations= $row['total_consultations'];
	$this->sre= $row['sre'];
	$this->pf= $row['pf'];
	$this->pv= $row['pv'];
	$this->pmix= $row['pmix'];
	$this->totalnegative= $row['totalnegative'];
	$this->total_positive= $row['total_positive'];
	$this->approved_hf= $row['approved_hf'];
	$this->approved_regional= $row['approved_regional'];
	$this->approved_zone= $row['approved_zone'];
	$this->draft= $row['draft'];
	$this->alert_sent= $row['alert_sent'];
	$this->entry_date= $row['entry_date'];
	$this->entry_time= $row['entry_time'];
	$this->edit_date= $row['edit_date'];
	$this->edit_time= $row['edit_time'];
	$this->diphofivemale= $row['diphofivemale'];
	$this->diphofivefemale= $row['diphofivefemale'];
	$this->wcofivemale= $row['wcofivemale'];
	$this->wcofivefemale= $row['wcofivefemale'];
	$this->measofivemale= $row['measofivemale'];
	$this->measofivefemale= $row['measofivefemale'];
	$this->afpofivemale= $row['afpofivemale'];
	$this->afpofivefemale= $row['afpofivefemale'];
	$this->suspectedmenegitisofivemale= $row['suspectedmenegitisofivemale'];
	$this->suspectedmenegitisofivefemale= $row['suspectedmenegitisofivefemale'];
  }
  
  function create_old(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET                week_no=:week_no,reporting_year=:reporting_year,reporting_date=:reporting_date,epdcalendar_id=:epdcalendar_id,user_id=:user_id,healthfacility_id=:healthfacility_id,contact_number=:contact_number,health_facility_code=:health_facility_code,supporting_ngo=:supporting_ngo,region_id=:region_id,sariufivemale=:sariufivemale,sariufivefemale=:sariufivefemale,sariofivemale=:sariofivemale,sariofivefemale=:sariofivefemale,iliufivemale=:iliufivemale,iliufivefemale=:iliufivefemale,iliofivemale=:iliofivemale,iliofivefemale=:iliofivefemale,awdufivemale=:awdufivemale,awdufivefemale=:awdufivefemale,awdofivemale=:awdofivemale,awdofivefemale=:awdofivefemale,bdufivemale=:bdufivemale,bdufivefemale=:bdufivefemale,bdofivemale=:bdofivemale,bdofivefemale=:bdofivefemale,oadufivemale=:oadufivemale,oadufivefemale=:oadufivefemale,oadofivemale=:oadofivemale,oadofivefemale=:oadofivefemale,diphmale=:diphmale,diphfemale=:diphfemale,wcmale=:wcmale,wcfemale=:wcfemale,measmale=:measmale,measfemale=:measfemale,nntmale=:nntmale,nntfemale=:nntfemale,afpmale=:afpmale,afpfemale=:afpfemale,ajsmale=:ajsmale,ajsfemale=:ajsfemale,vhfmale=:vhfmale,vhffemale=:vhffemale,malufivemale=:malufivemale,malufivefemale=:malufivefemale,malofivemale=:malofivemale,malofivefemale=:malofivefemale,suspectedmenegitismale=:suspectedmenegitismale,suspectedmenegitisfemale=:suspectedmenegitisfemale,undisonedesc=:undisonedesc,undismale=:undismale,undisfemale=:undisfemale,undissecdesc=:undissecdesc,undismaletwo=:undismaletwo,undisfemaletwoocmale=:undisfemaletwoocmale,ocfemale=:ocfemale,total_consultations=:total_consultations,sre=:sre,pf=pf:,pv=pv:,pmix=:pmix,totalnegative=:totalnegative,total_positive=:total_positive,approved_hf=:approved_hf,approved_regional=:approved_regional,approved_zone=:approved_zone,draft=:draft,alert_sent=:alert_sent,entry_date=:entry_date,entry_time=:entry_time,edit_date=:edit_date,edit_time=:edit_time,diphofivemale=:diphofivemale,diphofivefemale=:diphofivefemale,wcofivemale=:wcofivemale,wcofivefemale=:wcofivefemale,measofivemale=:measofivemale,measofivefemale=:measofivefemale,afpofivemale=:afpofivemale,afpofivefemale=:afpofivefemale,suspectedmenegitisofivemale=:suspectedmenegitisofivemale,suspectedmenegitisofivefemale=:suspectedmenegitisofivefemale";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->week_no  = htmlspecialchars(strip_tags($this->week_no));
	$this->reporting_year = htmlspecialchars(strip_tags($this->reporting_year));
	$this->reporting_date = htmlspecialchars(strip_tags($this->reporting_date));
	$this->epdcalendar_id = htmlspecialchars(strip_tags($this->epdcalendar_id));
	$this->user_id = htmlspecialchars(strip_tags($this->user_id));
	$this->healthfacility_id = htmlspecialchars(strip_tags($this->healthfacility_id));
	$this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
	$this->health_facility_code = htmlspecialchars(strip_tags($this->health_facility_code));
	$this->supporting_ngo = htmlspecialchars(strip_tags($this->supporting_ngo));
	$this->region_id = htmlspecialchars(strip_tags($this->region_id));
	$this->sariufivemale = htmlspecialchars(strip_tags($this->sariufivemale));
	$this->sariufivefemale = htmlspecialchars(strip_tags($this->sariufivefemale));
	$this->sariofivemale = htmlspecialchars(strip_tags($this->sariofivemale));
	$this->sariofivefemale = htmlspecialchars(strip_tags($this->sariofivefemale));
	$this->iliufivemale = htmlspecialchars(strip_tags($this->iliufivemale));
	$this->iliufivefemale = htmlspecialchars(strip_tags($this->iliufivefemale));
	$this->iliofivemale = htmlspecialchars(strip_tags($this->iliofivemale));
	$this->iliofivefemale = htmlspecialchars(strip_tags($this->iliofivefemale));
	$this->awdufivemale = htmlspecialchars(strip_tags($this->awdufivemale));
	$this->awdufivefemale = htmlspecialchars(strip_tags($this->awdufivefemale));
	$this->awdofivemale = htmlspecialchars(strip_tags($this->awdofivemale));
	$this->awdofivefemale = htmlspecialchars(strip_tags($this->awdofivefemale));
	$this->bdufivemale = htmlspecialchars(strip_tags($this->bdufivemale));
	$this->bdufivefemale = htmlspecialchars(strip_tags($this->bdufivefemale));
	$this->bdofivemale = htmlspecialchars(strip_tags($this->bdofivemale));
	$this->bdofivefemale = htmlspecialchars(strip_tags($this->bdofivefemale));
	$this->oadufivemale = htmlspecialchars(strip_tags($this->oadufivemale));
	$this->oadufivefemale = htmlspecialchars(strip_tags($this->oadufivefemale));
	$this->oadofivemale = htmlspecialchars(strip_tags($this->oadofivemale));
	$this->oadofivefemale = htmlspecialchars(strip_tags($this->oadofivefemale));
	$this->diphmale = htmlspecialchars(strip_tags($this->diphmale));
	$this->diphfemale = htmlspecialchars(strip_tags($this->diphfemale));
	$this->wcmale = htmlspecialchars(strip_tags($this->wcmale));
	$this->wcfemale = htmlspecialchars(strip_tags($this->wcfemale));
	$this->measmale = htmlspecialchars(strip_tags($this->measmale));
	$this->measfemale = htmlspecialchars(strip_tags($this->measfemale));
	$this->nntmale = htmlspecialchars(strip_tags($this->nntmale));
	$this->nntfemale = htmlspecialchars(strip_tags($this->nntfemale));
	$this->afpmale = htmlspecialchars(strip_tags($this->afpmale));
	$this->afpfemale = htmlspecialchars(strip_tags($this->afpfemale));
	$this->ajsmale = htmlspecialchars(strip_tags($this->ajsmale));
	$this->ajsfemale = htmlspecialchars(strip_tags($this->ajsfemale));
	$this->vhfmale = htmlspecialchars(strip_tags($this->vhfmale));
	$this->vhffemale = htmlspecialchars(strip_tags($this->vhffemale));
	$this->malufivemale = htmlspecialchars(strip_tags($this->malufivemale));
	$this->malufivefemale = htmlspecialchars(strip_tags($this->malufivefemale));
	$this->malofivemale = htmlspecialchars(strip_tags($this->malofivemale));
	$this->malofivefemale = htmlspecialchars(strip_tags($this->malofivefemale));
	$this->suspectedmenegitismale = htmlspecialchars(strip_tags($this->suspectedmenegitismale));
	$this->suspectedmenegitisfemale = htmlspecialchars(strip_tags($this->suspectedmenegitisfemale));
	$this->undisonedesc = htmlspecialchars(strip_tags($this->undisonedesc));
	$this->undismale = htmlspecialchars(strip_tags($this->undismale));
	$this->undisfemale = htmlspecialchars(strip_tags($this->undisfemale));
	$this->undissecdesc = htmlspecialchars(strip_tags($this->undissecdesc));
	$this->undismaletwo = htmlspecialchars(strip_tags($this->undismaletwo));
	$this->undisfemaletwo = htmlspecialchars(strip_tags($this->undisfemaletwo));
	$this->ocmale = htmlspecialchars(strip_tags($this->ocmale));
	$this->ocfemale = htmlspecialchars(strip_tags($this->ocfemale));
	$this->total_consultations = htmlspecialchars(strip_tags($this->total_consultations));
	$this->sre = htmlspecialchars(strip_tags($this->sre));
	$this->pf = htmlspecialchars(strip_tags($this->pf));
	$this->pv = htmlspecialchars(strip_tags($this->pv));
	$this->pmix = htmlspecialchars(strip_tags($this->pmix));
	$this->totalnegative = htmlspecialchars(strip_tags($this->totalnegative));
	$this->total_positive = htmlspecialchars(strip_tags($this->total_positive));
	$this->approved_hf = htmlspecialchars(strip_tags($this->approved_hf));
	$this->approved_regional = htmlspecialchars(strip_tags($this->approved_regional));
	$this->approved_zone = htmlspecialchars(strip_tags($this->approved_zone));
	$this->draft = htmlspecialchars(strip_tags($this->draft));
	$this->alert_sent = htmlspecialchars(strip_tags($this->alert_sent));
	$this->entry_date = htmlspecialchars(strip_tags($this->entry_date));
	$this->entry_time = htmlspecialchars(strip_tags($this->entry_time));
	$this->edit_date = htmlspecialchars(strip_tags($this->edit_date));
	$this->edit_time = htmlspecialchars(strip_tags($this->edit_time));
	$this->diphofivemale = htmlspecialchars(strip_tags($this->diphofivemale));
	$this->diphofivefemale = htmlspecialchars(strip_tags($this->diphofivefemale));
	$this->wcofivemale = htmlspecialchars(strip_tags($this->wcofivemale));
	$this->wcofivefemale = htmlspecialchars(strip_tags($this->wcofivefemale));
	$this->measofivemale = htmlspecialchars(strip_tags($this->measofivemale));
	$this->measofivefemale = htmlspecialchars(strip_tags($this->measofivefemale));
	$this->afpofivemale = htmlspecialchars(strip_tags($this->afpofivemale));
	$this->afpofivefemale = htmlspecialchars(strip_tags($this->afpofivefemale));
	$this->suspectedmenegitisofivemale = htmlspecialchars(strip_tags($this->suspectedmenegitisofivemale));
	$this->suspectedmenegitisofivefemale = htmlspecialchars(strip_tags($this->suspectedmenegitisofivefemale));
 
    // bind values
    $stmt->bindParam(":week_no", $this->week_no);
	$stmt->bindParam(":reporting_year", $this->reporting_year);
	$stmt->bindParam(":reporting_date", $this->reporting_date);
	$stmt->bindParam(":epdcalendar_id", $this->epdcalendar_id);
	$stmt->bindParam(":user_id", $this->user_id);
	$stmt->bindParam(":healthfacility_id", $this->healthfacility_id);
	$stmt->bindParam(":contact_number", $this->contact_number);
	$stmt->bindParam(":health_facility_code", $this->health_facility_code);
	$stmt->bindParam(":supporting_ngo", $this->supporting_ngo);
	$stmt->bindParam(":region_id", $this->region_id);
	$stmt->bindParam(":sariufivemale", $this->sariufivemale);
	$stmt->bindParam(":sariufivefemale", $this->sariufivefemale);
	$stmt->bindParam(":sariofivemale", $this->sariofivemale);
	$stmt->bindParam(":sariofivefemale", $this->sariofivefemale);
	$stmt->bindParam(":iliufivemale", $this->iliufivemale);
	$stmt->bindParam(":iliufivefemale", $this->iliufivefemale);
	$stmt->bindParam(":iliofivemale", $this->iliofivemale);
	$stmt->bindParam(":iliofivefemale", $this->iliofivefemale);
	$stmt->bindParam(":awdufivemale", $this->awdufivemale);
	$stmt->bindParam(":awdufivefemale", $this->awdufivefemale);
	$stmt->bindParam(":awdofivemale", $this->awdofivemale);
	$stmt->bindParam(":awdofivefemale", $this->awdofivefemale);
	$stmt->bindParam(":bdufivemale", $this->bdufivemale);
	$stmt->bindParam(":bdufivefemale", $this->bdufivefemale);
	$stmt->bindParam(":bdofivemale", $this->bdofivemale);
	$stmt->bindParam(":bdofivefemale", $this->bdofivefemale);
	$stmt->bindParam(":oadufivemale", $this->oadufivemale);
	$stmt->bindParam(":oadufivefemale", $this->oadufivefemale);
	$stmt->bindParam(":oadofivemale", $this->oadofivemale);
	$stmt->bindParam(":oadofivefemale", $this->oadofivefemale);
	$stmt->bindParam(":diphmale", $this->diphmale);
	$stmt->bindParam(":diphfemale", $this->diphfemale);
	$stmt->bindParam(":wcmale", $this->wcmale);
	$stmt->bindParam(":wcfemale", $this->wcfemale);
	$stmt->bindParam(":measmale", $this->measmale);
	$stmt->bindParam(":measfemale", $this->measfemale);
	$stmt->bindParam(":nntmale", $this->nntmale);
	$stmt->bindParam(":nntfemale", $this->nntfemale);
	$stmt->bindParam(":afpmale", $this->afpmale);
	$stmt->bindParam(":afpfemale", $this->afpfemale);
	$stmt->bindParam(":ajsmale", $this->ajsmale);
	$stmt->bindParam(":ajsfemale", $this->ajsfemale);
	$stmt->bindParam(":vhfmale", $this->vhfmale);
	$stmt->bindParam(":vhffemale", $this->vhffemale);
	$stmt->bindParam(":malufivemale", $this->malufivemale);
	$stmt->bindParam(":malufivefemale", $this->malufivefemale);
	$stmt->bindParam(":malofivemale", $this->malofivemale);
	$stmt->bindParam(":malofivefemale", $this->malofivefemale);
	$stmt->bindParam(":suspectedmenegitismale", $this->suspectedmenegitismale);
	$stmt->bindParam(":suspectedmenegitisfemale", $this->suspectedmenegitisfemale);
	$stmt->bindParam(":undisonedesc", $this->undisonedesc);
	$stmt->bindParam(":undismale", $this->undismale);
	$stmt->bindParam(":undisfemale", $this->undisfemale);
	$stmt->bindParam(":undissecdesc", $this->undissecdesc);
	$stmt->bindParam(":undismaletwo", $this->undismaletwo);
	$stmt->bindParam(":undisfemaletwo", $this->undisfemaletwo);
	$stmt->bindParam(":ocmale", $this->ocmale);
	$stmt->bindParam(":ocfemale", $this->ocfemale);
	$stmt->bindParam(":total_consultations", $this->total_consultations);
	$stmt->bindParam(":sre", $this->sre);
	$stmt->bindParam(":pf", $this->pf);
	$stmt->bindParam(":pv", $this->pv);
	$stmt->bindParam(":pmix", $this->pmix);
	$stmt->bindParam(":totalnegative", $this->totalnegative);
	$stmt->bindParam(":total_positive", $this->total_positive);
	$stmt->bindParam(":approved_hf", $this->approved_hf);
	$stmt->bindParam(":approved_regional", $this->approved_regional);
	$stmt->bindParam(":approved_zone", $this->approved_zone);
	$stmt->bindParam(":draft", $this->draft);
	$stmt->bindParam(":alert_sent", $this->alert_sent);
	$stmt->bindParam(":entry_date", $this->entry_date);
	$stmt->bindParam(":entry_time", $this->entry_time);
	$stmt->bindParam(":edit_date", $this->edit_date);
	$stmt->bindParam(":edit_time", $this->edit_time);
	$stmt->bindParam(":diphofivemale", $this->diphofivemale);
	$stmt->bindParam(":diphofivefemale", $this->diphofivefemale);
	$stmt->bindParam(":wcofivemale", $this->wcofivemale);
	$stmt->bindParam(":wcofivefemale", $this->wcofivefemale);
	$stmt->bindParam(":measofivemale", $this->measofivemale);
	$stmt->bindParam(":measofivefemale", $this->measofivefemale);
	$stmt->bindParam(":afpofivemale", $this->afpofivemale);
	$stmt->bindParam(":afpofivefemale", $this->afpofivefemale);
	$stmt->bindParam(":suspectedmenegitisofivemale", $this->suspectedmenegitisofivemale);
	$stmt->bindParam(":suspectedmenegitisofivefemale", $this->suspectedmenegitisofivefemale);
 
    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
  }
  
  
  function create()
  {
	  $sql = 'INSERT INTO `' . $this->table_name . '` '
            . '(`week_no`, `reporting_year`, `reporting_date`, `epdcalendar_id`, `user_id`, `healthfacility_id`, `contact_number`, `health_facility_code`, `supporting_ngo`, `region_id`, `sariufivemale`, `sariufivefemale`, `sariofivemale`, `sariofivefemale`, `iliufivemale`, `iliufivefemale`, `iliofivemale`, `iliofivefemale`, `awdufivemale`, `awdufivefemale`, `awdofivemale`, `awdofivefemale`, `bdufivemale`, `bdufivefemale`, `bdofivemale`, `bdofivefemale`, `oadufivemale`, `oadufivefemale`, `oadofivemale`, `oadofivefemale`, `diphmale`, `diphfemale`, `wcmale`, `wcfemale`, `measmale`, `measfemale`, `nntmale`, `nntfemale`, `afpmale`, `afpfemale`, `ajsmale`, `ajsfemale`, `vhfmale`, `vhffemale`, `malufivemale`, `malufivefemale`, `malofivemale`, `malofivefemale`, `suspectedmenegitismale`, `suspectedmenegitisfemale`, `undisonedesc`, `undismale`, `undisfemale`, `undissecdesc`, `undismaletwo`, `undisfemaletwo`, `ocmale`, `ocfemale`, `total_consultations`, `sre`, `pf`, `pv`, `pmix`, `totalnegative`, `total_positive`, `approved_hf`, `approved_regional`, `approved_zone`, `draft`, `alert_sent`, `entry_date`, `entry_time`, `edit_date`, `edit_time`, `diphofivemale`, `diphofivefemale`, `wcofivemale`, `wcofivefemale`, `measofivemale`, `measofivefemale`, `afpofivemale`, `afpofivefemale`, `suspectedmenegitisofivemale`, `suspectedmenegitisofivefemale`) VALUES '
            . '(:week_no, :reporting_year, :reporting_date, :epdcalendar_id, :user_id, :healthfacility_id, :contact_number, :health_facility_code, :supporting_ngo, :region_id, :sariufivemale, :sariufivefemale, :sariofivemale, :sariofivefemale, :iliufivemale, :iliufivefemale, :iliofivemale, :iliofivefemale, :awdufivemale, :awdufivefemale, :awdofivemale, :awdofivefemale, :bdufivemale, :bdufivefemale, :bdofivemale, :bdofivefemale, :oadufivemale, :oadufivefemale, :oadofivemale, :oadofivefemale, :diphmale, :diphfemale, :wcmale, :wcfemale, :measmale, :measfemale, :nntmale, :nntfemale, :afpmale, :afpfemale, :ajsmale, :ajsfemale, :vhfmale, :vhffemale, :malufivemale, :malufivefemale, :malofivemale, :malofivefemale, :suspectedmenegitismale, :suspectedmenegitisfemale, :undisonedesc, :undismale, :undisfemale, :undissecdesc, :undismaletwo, :undisfemaletwo, :ocmale, :ocfemale, :total_consultations, :sre, :pf, :pv, :pmix, :totalnegative, :total_positive, :approved_hf, :approved_regional, :approved_zone, :draft, :alert_sent, :entry_date, :entry_time, :edit_date, :edit_time, :diphofivemale, :diphofivefemale, :wcofivemale, :wcofivefemale, :measofivemale, :measofivefemale, :afpofivemale, :afpofivefemale, :suspectedmenegitisofivemale, :suspectedmenegitisofivefemale)';
			
		$stmt = $this->conn->prepare($sql); 
		
		$bound =   array(
					
					":week_no" => $this->week_no,
					":reporting_year" => $this->reporting_year,
					":reporting_date" => $this->reporting_date,
					":epdcalendar_id" => $this->epdcalendar_id,
					":user_id" => $this->user_id,
					":healthfacility_id" => $this->healthfacility_id,
					":contact_number" => $this->contact_number,
					":health_facility_code" => $this->health_facility_code,
					":supporting_ngo" => $this->supporting_ngo,
					":region_id" => $this->region_id,
					":sariufivemale" => $this->sariufivemale,
					":sariufivefemale" => $this->sariufivefemale,
					":sariofivemale" => $this->sariofivemale,
					":sariofivefemale" => $this->sariofivefemale,
					":iliufivemale" => $this->iliufivemale,
					":iliufivefemale" => $this->iliufivefemale,
					":iliofivemale" => $this->iliofivemale,
					":iliofivefemale" => $this->iliofivefemale,
					":awdufivemale" => $this->awdufivemale,
					":awdufivefemale" => $this->awdufivefemale,
					":awdofivemale" => $this->awdofivemale,
					":awdofivefemale" => $this->awdofivefemale,
					":bdufivemale" => $this->bdufivemale,
					":bdufivefemale" => $this->bdufivefemale,
					":bdofivemale" => $this->bdofivemale,
					":bdofivefemale" => $this->bdofivefemale,
					":oadufivemale" => $this->oadufivemale,
					":oadufivefemale" => $this->oadufivefemale,
					":oadofivemale" => $this->oadofivemale,
					":oadofivefemale" => $this->oadofivefemale,
					":diphmale" => $this->diphmale,
					":diphfemale" => $this->diphfemale,
					":wcmale" => $this->wcmale,
					":wcfemale" => $this->wcfemale,
					":measmale" => $this->measmale,
					":measfemale" => $this->measfemale,
					":nntmale" => $this->nntmale,
					":nntfemale" => $this->nntfemale,
					":afpmale" => $this->afpmale,
					":afpfemale" => $this->afpfemale,
					":ajsmale" => $this->ajsmale,
					":ajsfemale" => $this->ajsfemale,
					":vhfmale" => $this->vhfmale,
					":vhffemale" => $this->vhffemale,
					":malufivemale" => $this->malufivemale,
					":malufivefemale" => $this->malufivefemale,
					":malofivemale" => $this->malofivemale,
					":malofivefemale" => $this->malofivefemale,
					":suspectedmenegitismale" => $this->suspectedmenegitismale,
					":suspectedmenegitisfemale" => $this->suspectedmenegitisfemale,
					":undisonedesc" => $this->undisonedesc,
					":undismale" => $this->undismale,
					":undisfemale" => $this->undisfemale,
					":undissecdesc" => $this->undissecdesc,
					":undismaletwo" => $this->undismaletwo,
					":undisfemaletwo" => $this->undisfemaletwo,
					":ocmale" => $this->ocmale,
					":ocfemale" => $this->ocfemale,
					":total_consultations" => $this->total_consultations,
					":sre" => $this->sre,
					":pf" => $this->pf,
					":pv" => $this->pv,
					":pmix" => $this->pmix,
					":totalnegative" => $this->totalnegative,
					":total_positive" => $this->total_positive,
					":approved_hf" => $this->approved_hf,
					":approved_regional" => $this->approved_regional,
					":approved_zone" => $this->approved_zone,
					":draft" => $this->draft,
					":alert_sent" => $this->alert_sent,
					":entry_date" => $this->entry_date,
					":entry_time" => $this->entry_time,
					":edit_date" => $this->edit_date,
					":edit_time" => $this->edit_time,
					":diphofivemale" => $this->diphofivemale,
					":diphofivefemale" => $this->diphofivefemale,
					":wcofivemale" => $this->wcofivemale,
					":wcofivefemale" => $this->wcofivefemale,
					":measofivemale" => $this->measofivemale,
					":measofivefemale" => $this->measofivefemale,
					":afpofivemale" => $this->afpofivemale,
					":afpofivefemale" => $this->afpofivefemale,
					":suspectedmenegitisofivemale" => $this->suspectedmenegitisofivemale,
					":suspectedmenegitisofivefemale" => $this->suspectedmenegitisofivefemale
		);
		 
		// execute query
		if($stmt->execute($bound)){
			return true;
		}else{
			return false;
		}
  }
  
  
  function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                week_no=:week_no=:,reporting_year=:reporting_year,reporting_date=:reporting_date,epdcalendar_id=:epdcalendar_id,user_id=:user_id,healthfacility_id=:healthfacility_id,contact_number=:contact_number,health_facility_code=:health_facility_code,supporting_ngo=:supporting_ngo,region_id=:region_id,sariufivemale=:sariufivemale,sariufivefemale=:sariufivefemale,sariofivemale=:sariofivemale,sariofivefemale=:sariofivefemale,iliufivemale=:iliufivemale,iliufivefemale=:iliufivefemale,iliofivemale=:iliofivemale,iliofivefemale=:iliofivefemale,awdufivemale=:awdufivemale,awdufivefemale=:awdufivefemale,awdofivemale=:awdofivemale,awdofivefemale=:awdofivefemale,bdufivemale=:bdufivemale,bdufivefemale=:bdufivefemale,bdofivemale=:bdofivemale,bdofivefemale=:bdofivefemale,oadufivemale=:oadufivemale,oadufivefemale=:oadufivefemale,oadofivemale=:oadofivemale,oadofivefemale=:oadofivefemale,diphmale=:diphmale,diphfemale=:diphfemale,wcmale=:wcmale,wcfemale=:wcfemale,measmale=:measmale,measfemale=:measfemale,nntmale=:nntmale,nntfemale=:nntfemale,afpmale=:afpmale,afpfemale=:afpfemale,ajsmale=:ajsmale,ajsfemale=:ajsfemale,vhfmale=:vhfmale,vhffemale=:vhffemale,malufivemale=:malufivemale,malufivefemale=:malufivefemale,malofivemale=:malofivemale,malofivefemale=:malofivefemale,suspectedmenegitismale=:suspectedmenegitismale,suspectedmenegitisfemale=:suspectedmenegitisfemale,undisonedesc=:undisonedesc,undismale=:undismale,undisfemale=:undisfemale,undissecdesc=:undissecdesc,undismaletwo=:undismaletwo,undisfemaletwoocmale=:undisfemaletwoocmale,ocfemale=:ocfemale,total_consultations=:total_consultations,sre=:sre,pf=pf:,pv=pv:,pmix=:pmix,totalnegative=:totalnegative,total_positive=:total_positive,approved_hf=:approved_hf,approved_regional=:approved_regional,approved_zone=:approved_zone,draft=:draft,alert_sent=:alert_sent,entry_date=:entry_date,entry_time=:entry_time,edit_date=:edit_date,edit_time=:edit_time,diphofivemale=:diphofivemale,diphofivefemale=:diphofivefemale,wcofivemale=:wcofivemale,wcofivefemale=:wcofivefemale,measofivemale=:measofivemale,measofivefemale=:measofivefemale,afpofivemale=:afpofivemale,afpofivefemale=:afpofivefemale,suspectedmenegitisofivemale=:suspectedmenegitisofivemale,suspectedmenegitisofivefemale=:suspectedmenegitisofivefemale
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->week_no  = htmlspecialchars(strip_tags($this->week_no));
	$this->reporting_year = htmlspecialchars(strip_tags($this->reporting_year));
	$this->reporting_date = htmlspecialchars(strip_tags($this->reporting_date));
	$this->epdcalendar_id = htmlspecialchars(strip_tags($this->epdcalendar_id));
	$this->user_id = htmlspecialchars(strip_tags($this->user_id));
	$this->healthfacility_id = htmlspecialchars(strip_tags($this->healthfacility_id));
	$this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
	$this->health_facility_code = htmlspecialchars(strip_tags($this->health_facility_code));
	$this->supporting_ngo = htmlspecialchars(strip_tags($this->supporting_ngo));
	$this->region_id = htmlspecialchars(strip_tags($this->region_id));
	$this->sariufivemale = htmlspecialchars(strip_tags($this->sariufivemale));
	$this->sariufivefemale = htmlspecialchars(strip_tags($this->sariufivefemale));
	$this->sariofivemale = htmlspecialchars(strip_tags($this->sariofivemale));
	$this->sariofivefemale = htmlspecialchars(strip_tags($this->sariofivefemale));
	$this->iliufivemale = htmlspecialchars(strip_tags($this->iliufivemale));
	$this->iliufivefemale = htmlspecialchars(strip_tags($this->iliufivefemale));
	$this->iliofivemale = htmlspecialchars(strip_tags($this->iliofivemale));
	$this->iliofivefemale = htmlspecialchars(strip_tags($this->iliofivefemale));
	$this->awdufivemale = htmlspecialchars(strip_tags($this->awdufivemale));
	$this->awdufivefemale = htmlspecialchars(strip_tags($this->awdufivefemale));
	$this->awdofivemale = htmlspecialchars(strip_tags($this->awdofivemale));
	$this->awdofivefemale = htmlspecialchars(strip_tags($this->awdofivefemale));
	$this->bdufivemale = htmlspecialchars(strip_tags($this->bdufivemale));
	$this->bdufivefemale = htmlspecialchars(strip_tags($this->bdufivefemale));
	$this->bdofivemale = htmlspecialchars(strip_tags($this->bdofivemale));
	$this->bdofivefemale = htmlspecialchars(strip_tags($this->bdofivefemale));
	$this->oadufivemale = htmlspecialchars(strip_tags($this->oadufivemale));
	$this->oadufivefemale = htmlspecialchars(strip_tags($this->oadufivefemale));
	$this->oadofivemale = htmlspecialchars(strip_tags($this->oadofivemale));
	$this->oadofivefemale = htmlspecialchars(strip_tags($this->oadofivefemale));
	$this->diphmale = htmlspecialchars(strip_tags($this->diphmale));
	$this->diphfemale = htmlspecialchars(strip_tags($this->diphfemale));
	$this->wcmale = htmlspecialchars(strip_tags($this->wcmale));
	$this->wcfemale = htmlspecialchars(strip_tags($this->wcfemale));
	$this->measmale = htmlspecialchars(strip_tags($this->measmale));
	$this->measfemale = htmlspecialchars(strip_tags($this->measfemale));
	$this->nntmale = htmlspecialchars(strip_tags($this->nntmale));
	$this->nntfemale = htmlspecialchars(strip_tags($this->nntfemale));
	$this->afpmale = htmlspecialchars(strip_tags($this->afpmale));
	$this->afpfemale = htmlspecialchars(strip_tags($this->afpfemale));
	$this->ajsmale = htmlspecialchars(strip_tags($this->ajsmale));
	$this->ajsfemale = htmlspecialchars(strip_tags($this->ajsfemale));
	$this->vhfmale = htmlspecialchars(strip_tags($this->vhfmale));
	$this->vhffemale = htmlspecialchars(strip_tags($this->vhffemale));
	$this->malufivemale = htmlspecialchars(strip_tags($this->malufivemale));
	$this->malufivefemale = htmlspecialchars(strip_tags($this->malufivefemale));
	$this->malofivemale = htmlspecialchars(strip_tags($this->malofivemale));
	$this->malofivefemale = htmlspecialchars(strip_tags($this->malofivefemale));
	$this->suspectedmenegitismale = htmlspecialchars(strip_tags($this->suspectedmenegitismale));
	$this->suspectedmenegitisfemale = htmlspecialchars(strip_tags($this->suspectedmenegitisfemale));
	$this->undisonedesc = htmlspecialchars(strip_tags($this->undisonedesc));
	$this->undismale = htmlspecialchars(strip_tags($this->undismale));
	$this->undisfemale = htmlspecialchars(strip_tags($this->undisfemale));
	$this->undissecdesc = htmlspecialchars(strip_tags($this->undissecdesc));
	$this->undismaletwo = htmlspecialchars(strip_tags($this->undismaletwo));
	$this->undisfemaletwo = htmlspecialchars(strip_tags($this->undisfemaletwo));
	$this->ocmale = htmlspecialchars(strip_tags($this->ocmale));
	$this->ocfemale = htmlspecialchars(strip_tags($this->ocfemale));
	$this->total_consultations = htmlspecialchars(strip_tags($this->total_consultations));
	$this->sre = htmlspecialchars(strip_tags($this->sre));
	$this->pf = htmlspecialchars(strip_tags($this->pf));
	$this->pv = htmlspecialchars(strip_tags($this->pv));
	$this->pmix = htmlspecialchars(strip_tags($this->pmix));
	$this->totalnegative = htmlspecialchars(strip_tags($this->totalnegative));
	$this->total_positive = htmlspecialchars(strip_tags($this->total_positive));
	$this->approved_hf = htmlspecialchars(strip_tags($this->approved_hf));
	$this->approved_regional = htmlspecialchars(strip_tags($this->approved_regional));
	$this->approved_zone = htmlspecialchars(strip_tags($this->approved_zone));
	$this->draft = htmlspecialchars(strip_tags($this->draft));
	$this->alert_sent = htmlspecialchars(strip_tags($this->alert_sent));
	$this->entry_date = htmlspecialchars(strip_tags($this->entry_date));
	$this->entry_time = htmlspecialchars(strip_tags($this->entry_time));
	$this->edit_date = htmlspecialchars(strip_tags($this->edit_date));
	$this->edit_time = htmlspecialchars(strip_tags($this->edit_time));
	$this->diphofivemale = htmlspecialchars(strip_tags($this->diphofivemale));
	$this->diphofivefemale = htmlspecialchars(strip_tags($this->diphofivefemale));
	$this->wcofivemale = htmlspecialchars(strip_tags($this->wcofivemale));
	$this->wcofivefemale = htmlspecialchars(strip_tags($this->wcofivefemale));
	$this->measofivemale = htmlspecialchars(strip_tags($this->measofivemale));
	$this->measofivefemale = htmlspecialchars(strip_tags($this->measofivefemale));
	$this->afpofivemale = htmlspecialchars(strip_tags($this->afpofivemale));
	$this->afpofivefemale = htmlspecialchars(strip_tags($this->afpofivefemale));
	$this->suspectedmenegitisofivemale = htmlspecialchars(strip_tags($this->suspectedmenegitisofivemale));
	$this->suspectedmenegitisofivefemale = htmlspecialchars(strip_tags($this->suspectedmenegitisofivefemale));
 
    // bind new values
    $stmt->bindParam(":week_no", $this->week_no);
	$stmt->bindParam(":reporting_year", $this->reporting_year);
	$stmt->bindParam(":reporting_date", $this->reporting_date);
	$stmt->bindParam(":epdcalendar_id", $this->epdcalendar_id);
	$stmt->bindParam(":user_id", $this->user_id);
	$stmt->bindParam(":healthfacility_id", $this->healthfacility_id);
	$stmt->bindParam(":contact_number", $this->contact_number);
	$stmt->bindParam(":health_facility_code", $this->health_facility_code);
	$stmt->bindParam(":supporting_ngo", $this->supporting_ngo);
	$stmt->bindParam(":region_id", $this->region_id);
	$stmt->bindParam(":sariufivemale", $this->sariufivemale);
	$stmt->bindParam(":sariufivefemale", $this->sariufivefemale);
	$stmt->bindParam(":sariofivemale", $this->sariofivemale);
	$stmt->bindParam(":sariofivefemale", $this->sariofivefemale);
	$stmt->bindParam(":iliufivemale", $this->iliufivemale);
	$stmt->bindParam(":iliufivefemale", $this->iliufivefemale);
	$stmt->bindParam(":iliofivemale", $this->iliofivemale);
	$stmt->bindParam(":iliofivefemale", $this->iliofivefemale);
	$stmt->bindParam(":awdufivemale", $this->awdufivemale);
	$stmt->bindParam(":awdufivefemale", $this->awdufivefemale);
	$stmt->bindParam(":awdofivemale", $this->awdofivemale);
	$stmt->bindParam(":awdofivefemale", $this->awdofivefemale);
	$stmt->bindParam(":bdufivemale", $this->bdufivemale);
	$stmt->bindParam(":bdufivefemale", $this->bdufivefemale);
	$stmt->bindParam(":bdofivemale", $this->bdofivemale);
	$stmt->bindParam(":bdofivefemale", $this->bdofivefemale);
	$stmt->bindParam(":oadufivemale", $this->oadufivemale);
	$stmt->bindParam(":oadufivefemale", $this->oadufivefemale);
	$stmt->bindParam(":oadofivemale", $this->oadofivemale);
	$stmt->bindParam(":oadofivefemale", $this->oadofivefemale);
	$stmt->bindParam(":diphmale", $this->diphmale);
	$stmt->bindParam(":diphfemale", $this->diphfemale);
	$stmt->bindParam(":wcmale", $this->wcmale);
	$stmt->bindParam(":wcfemale", $this->wcfemale);
	$stmt->bindParam(":measmale", $this->measmale);
	$stmt->bindParam(":measfemale", $this->measfemale);
	$stmt->bindParam(":nntmale", $this->nntmale);
	$stmt->bindParam(":nntfemale", $this->nntfemale);
	$stmt->bindParam(":afpmale", $this->afpmale);
	$stmt->bindParam(":afpfemale", $this->afpfemale);
	$stmt->bindParam(":ajsmale", $this->ajsmale);
	$stmt->bindParam(":ajsfemale", $this->ajsfemale);
	$stmt->bindParam(":vhfmale", $this->vhfmale);
	$stmt->bindParam(":vhffemale", $this->vhffemale);
	$stmt->bindParam(":malufivemale", $this->malufivemale);
	$stmt->bindParam(":malufivefemale", $this->malufivefemale);
	$stmt->bindParam(":malofivemale", $this->malofivemale);
	$stmt->bindParam(":malofivefemale", $this->malofivefemale);
	$stmt->bindParam(":suspectedmenegitismale", $this->suspectedmenegitismale);
	$stmt->bindParam(":suspectedmenegitisfemale", $this->suspectedmenegitisfemale);
	$stmt->bindParam(":undisonedesc", $this->undisonedesc);
	$stmt->bindParam(":undismale", $this->undismale);
	$stmt->bindParam(":undisfemale", $this->undisfemale);
	$stmt->bindParam(":undissecdesc", $this->undissecdesc);
	$stmt->bindParam(":undismaletwo", $this->undismaletwo);
	$stmt->bindParam(":undisfemaletwo", $this->undisfemaletwo);
	$stmt->bindParam(":ocmale", $this->ocmale);
	$stmt->bindParam(":ocfemale", $this->ocfemale);
	$stmt->bindParam(":total_consultations", $this->total_consultations);
	$stmt->bindParam(":sre", $this->sre);
	$stmt->bindParam(":pf", $this->pf);
	$stmt->bindParam(":pv", $this->pv);
	$stmt->bindParam(":pmix", $this->pmix);
	$stmt->bindParam(":totalnegative", $this->totalnegative);
	$stmt->bindParam(":total_positive", $this->total_positive);
	$stmt->bindParam(":approved_hf", $this->approved_hf);
	$stmt->bindParam(":approved_regional", $this->approved_regional);
	$stmt->bindParam(":approved_zone", $this->approved_zone);
	$stmt->bindParam(":draft", $this->draft);
	$stmt->bindParam(":alert_sent", $this->alert_sent);
	$stmt->bindParam(":entry_date", $this->entry_date);
	$stmt->bindParam(":entry_time", $this->entry_time);
	$stmt->bindParam(":edit_date", $this->edit_date);
	$stmt->bindParam(":edit_time", $this->edit_time);
	$stmt->bindParam(":diphofivemale", $this->diphofivemale);
	$stmt->bindParam(":diphofivefemale", $this->diphofivefemale);
	$stmt->bindParam(":wcofivemale", $this->wcofivemale);
	$stmt->bindParam(":wcofivefemale", $this->wcofivefemale);
	$stmt->bindParam(":measofivemale", $this->measofivemale);
	$stmt->bindParam(":measofivefemale", $this->measofivefemale);
	$stmt->bindParam(":afpofivemale", $this->afpofivemale);
	$stmt->bindParam(":afpofivefemale", $this->afpofivefemale);
	$stmt->bindParam(":suspectedmenegitisofivemale", $this->suspectedmenegitisofivemale);
	$stmt->bindParam(":suspectedmenegitisofivefemale", $this->suspectedmenegitisofivefemale);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
  }
}